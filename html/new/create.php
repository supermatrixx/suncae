<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("../../conf.php");
include("../../auths/{$auth}/auth.php");
include("../common.php");

if (file_exists("../../data/{$username}/cases") ==  false) {
  if (mkdir("../../data/{$username}/cases", $permissions, true) == false) {
    echo "error: cannot create cases directory";
    exit();
  }
}
if (chdir("../../data/{$username}/cases") == false) {
  echo "error: cannot chdir to cases";
  exit();
}

$cad = $_POST["cad_hash"];
$id = md5((`which uuidgen`) ? shell_exec("uuidgen") : uniqid());

// TODO: 2024-09-14
// if (file_exists("../cads/{$cad}/default.geo") === false) {
//   echo "error: cad {$cad} does not have default.geo";
//   exit();
// }





mkdir($id, $permissions, true);
chdir($id);

// TODO: per mesher
copy("../../cads/{$cad}/default.geo", "mesh.geo");

$case["id"] = $id;
$case["owner"] = $username;
$case["date"] = time();
$case["cad"] = $cad;
// TODO: choose
$case["problem"] = "mechanical";
$case["mesher"] = "gmsh";
$case["solver"] = "feenox";
$case["name"] = isset($_POST["name"]) ? $_POST["name"] : "Unnamed";
$case["visibility"] = "public";
yaml_emit_file("case.yaml", $case);

// TODO: per problem!
$fee = fopen("case.fee", "w");
fprintf($fee, "PROBLEM %s\n", $case["problem"]);
fprintf($fee, "READ_MESH meshes/%s-2.msh\n", md5_file("mesh.geo"));
fprintf($fee, "\n");
fprintf($fee, "E(x,y,z) = (200)*1e3\n");
fprintf($fee, "nu = 0.3\n");
fprintf($fee, "\n");
fprintf($fee, "SOLVE_PROBLEM\n");
fprintf($fee, "WRITE_RESULTS FORMAT vtk all\n");
fclose($fee);

$gitignore = fopen(".gitignore", "w");
fprintf($gitignore, "run");
fclose($gitignore);

# TODO: create a local user
// exec("git init --initial-branch=main", $output, $result);
exec("git init", $output, $result);
if ($result != 0) {
  suncae_log("cannot git init {$case["problem"]} {$id}");
  echo "cannot git init {$case["problem"]} {$id}";
  exit(1);
}

exec("git config user.name '{$username}'", $output, $result);
if ($result != 0) {
  suncae_log("cannot set user.name {$case["problem"]} {$id}");
  echo "cannot set user.name {$case["problem"]} {$id}";
  exit(1);
}

exec("git config user.email '{$username}@suncae'", $output, $result);
if ($result != 0) {
  suncae_log("cannot set user.email {$case["problem"]} {$id}");
  echo "cannot set user.email {$case["problem"]} {$id}";
  exit(1);
}

exec("git add .", $output, $result);
if ($result != 0) {
  suncae_log("cannot git add {$case["problem"]} {$id}");
  echo "cannot git add {$case["problem"]} {$id}";
  exit(1);
}
exec("git commit -m 'initial commit'", $output, $result);
if ($result != 0) {
  suncae_log("cannot git commit {$case["problem"]} {$id}");
  echo "cannot git commit {$case["problem"]} {$id}";
  exit(1);
}

suncae_log("created problem {$case["problem"]} {$id}");

header("Location: ../?id={$id}");
