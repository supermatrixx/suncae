<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.


// TODO: check if gmsh is ok with gmshcheck.py (print version?)
$file_content = file_get_contents('php://input');

// check for gz
// https://stackoverflow.com/questions/10975775/how-to-determine-if-a-string-was-compressed
// if (mb_strpos($file_content, "\x1f" . "\x8b" . "\x08") === 0) {
//   $file_content = gzdecode($file_content);
// }

$response["cad_hash"] = md5($file_content);
// assume there is no error and that we can show the preview
$response["status"] = "ok";
$response["show_preview"] = true;

$cad_dir = "../../data/{$username}/cads/{$response["cad_hash"]}";

// upload it only if it does not exist
// TODO: first just send the md5 to check if this exists intead of the whole file
if (file_exists($cad_dir) === false) {
  // TODO: check error
  mkdir($cad_dir, $permissions, true);
}

// TODO: check error
chdir($cad_dir);

if (file_exists("original.step") === false) {
  file_put_contents("original.step", $file_content);
}  

if (file_exists("original.json") === false) {
  exec("../../../../cadimporters/upload/cadcheck.py", $output, $error_level);
  
  // TODO: keep output
  if ($error_level != 0) {
    $response["status"] = "error";
    $response["show_preview"] = false;
    if ($error_level == 1) {
      $response["error"] = "Invalid STEP file.";
    } else if ($error_level == 2) {
      $response["error"] = "Invalid CAD file.";
    } else {
      $response["error"] = "Unknown error {$error_level} when checking CAD.";
    }
    for ($i = 0; $i < count($output); $i++) {
      $response["error"] .= $output[$i];
    }
    return_back_json($response);
  }
}

if (file_exists("original.json")) {
  $original = json_decode(file_get_contents("original.json"), true);
  if ($original != null) {
    if ($original["solids"] == 0) {
      $response["status"] = "error";
      $response["error"] = "No solid found in CAD file.";
    } else if ($original["solids"] > 1) {
      $response["status"] = "error";
      $response["error"] = "CAD file has {$original["solids"]} solids and this PoC works with single-solid CADs only.";
    }
  } else {
    $response["status"] = "error";
    $response["show_preview"] = false;
    $response["error"] = "Cannot decode original json.";
  }
      
} else {
  $response["status"] = "error";
  $response["show_preview"] = false;
  $response["error"] = "Cannot create original json.";
}

return_back_json($response);

