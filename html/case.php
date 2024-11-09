<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

$mesh_hash = (isset($_POST["mesh_hash"])) ? $_POST["mesh_hash"] : ((isset($_GET["mesh_hash"])) ? $_GET["mesh_hash"] : "");
$problem_hash = (isset($_POST["problem_hash"])) ? $_POST["problem_hash"] : ((isset($_GET["problem_hash"])) ? $_GET["problem_hash"] : "");

if ($id == "") {
  header("Location: new/");
  exit();
}

// TODO: per mesher
function mesh_hash() {
  global $username, $id;
  // there might have been a chdir to the case's dir
  if (file_exists("mesh.geo")) {
    return md5_file("mesh.geo");
  } else {
    return md5_file("../data/{$username}/cases/{$id}/mesh.geo");
  }
}

// TODO: per solver
function problem_hash() {
  global $username, $id;
  if (file_exists("case.fee")) {
    return md5_file("case.fee");
  } else {
    return md5_file("../data/{$username}/cases/{$id}/case.fee");
  }
}

// TODO: per solver
function update_mesh_in_fee() {
  global $username;
  global $id;
  global $mesh_hash;
  $real_mesh_hash = mesh_hash();
  if ($real_mesh_hash != $mesh_hash) {
    // TODO: lock
    $current = fopen("../data/{$username}/cases/{$id}/case.fee", "r");
    $new = fopen("../data/{$username}/cases/{$id}/new.fee", "w");
    if ($current && $new) {
      while (($line = fgets($current)) !== false) {
        if (strncmp("READ_MESH", $line, 9) == 0) {
          fprintf($new, "READ_MESH meshes/%s-2.msh\n", $real_mesh_hash);
        } else {
          fwrite($new, $line);
        }
      }
      fclose($current);
      fclose($new);

      if (rename("../data/{$username}/cases/{$id}/new.fee", "../data/{$username}/cases/{$id}/case.fee") !== true) {
        return_error_json("Cannot update fee");
      }
    } else {
      return_error_json("cannot open case.fee");
    }
  }
}


$case_dir = "../data/{$username}/cases/{$id}";
if (($case_yaml = file_get_contents("{$case_dir}/case.yaml")) == false) {
  echo "cannot find project {$id}";
  exit();
}

if (($case = yaml_parse($case_yaml)) == null) {
  echo "cannot decode project {$id}";
  exit();
}

$problem = $case["problem"];

$cad_dir = "../data/{$username}/cads/{$case["cad"]}";
if (is_dir("{$cad_dir}/meshes") == false) {
  mkdir("{$cad_dir}/meshes", $permissions, true);
}

if (is_dir("{$case_dir}/run") == false) {
  mkdir("{$case_dir}/run", $permissions, true);
}
if (file_exists("{$case_dir}/run/meshes") == false) {
  symlink("../../../cads/{$case["cad"]}/meshes", "../data/{$username}/cases/{$id}/run/meshes");
}

  
if ($mesh_hash == "") {
  update_mesh_in_fee();
  $mesh_hash = mesh_hash();
}
if ($problem_hash == "") {
  $problem_hash = problem_hash();
}

$mesh_path = "{$cad_dir}/meshes/{$mesh_hash}.msh";
$mesh_data_path = "{$cad_dir}/meshes/{$mesh_hash}-data.json";
$mesh_meta_path = "{$cad_dir}/meshes/{$mesh_hash}.json";

$has_mesh = file_exists($mesh_path);
$has_mesh_valid = false;
$has_mesh_attempt = file_exists($mesh_meta_path);
if ($has_mesh_attempt && ($mesh_meta = json_decode(file_get_contents($mesh_meta_path), true)) != null) {
  if ($mesh_meta["status"] == "success") {
    $has_mesh_valid = true;
  } else if ($mesh_meta["status"] == "running") {
    if (isset($mesh_meta["pid"]) == false || posix_getpgid($mesh_meta["pid"]) == false) {
      // TODO: mirar el .2
      $mesh_meta["status"] = "error";
      // TODO: update json
    } else {
      // TODO: calcular progress
    }
  }
}




$results_meta_path = "{$case_dir}/run/{$problem_hash}.json";

// TODO: non-mechanical
$displacements_data_path = "{$case_dir}/run/{$problem_hash}-displacements.dat";
$has_results = file_exists($displacements_data_path);
$has_results_attempt = file_exists($results_meta_path);
if ($has_results_attempt && ($results_meta = json_decode(file_get_contents($results_meta_path), true)) != null) {
  if ($results_meta["status"] == "success") {
    $has_results_valid = true;
  } else if ($results_meta["status"] == "running") {
    if (isset($results_meta["pid"]) && posix_getpgid($results_meta["pid"]) == false) {
      // TODO: mirar el .2
      $results_meta["status"] = "error";
      // TODO: update json
    } else {
      // TODO: calcular progress
    }
  }
}
?>
