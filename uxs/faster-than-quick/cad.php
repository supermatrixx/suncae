<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

if (($case_yaml = file_get_contents("../data/{$username}/cases/{$id}/case.yaml")) == false) {
  echo "cannot find project {$id}";
  // TODO: devolver un x3d con el error
  exit();
}

if (($case = yaml_parse($case_yaml)) == null) {
  echo "cannot decode project {$id}";
  // TODO: devolver un x3d con el error
  exit();
}

// if (($cad_json = file_get_contents("../data/{$user}/cads/{$case["cad"]}/cad.json")) == false) {
//   echo "cannot find cad {$case["cad"]}";
//   exit();
// }
  // TODO: devolver un cubo

$cad_dir = "../data/{$username}/cads/{$case["cad"]}/";
if (file_exists($cad_dir."cad.x3d")) {

  header("Content-Type: model/x3d+xml");
  header("Content-Length: " . filesize($cad_dir."cad.x3d"));

  ob_clean();
  flush();
  readfile($cad_dir."cad.x3d");
  flush();
  
} else if (file_exists($cad_dir."cad.x3d.gz")) {

  $data = gzdecode(file_get_contents($cad_dir."cad.x3d.gz"));
  header("Content-Type: model/x3d+xml");
  header("Content-Length: " . strlen($data));

  ob_clean();
  flush();
  echo $data;
  flush();

} else {

  // TODO: devolver un cubo
  exit();
}
