<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("../conf.php");
include("../auths/{$auth}/auth.php");
include("common.php");
include("case.php");

$response["mesh_hash"] = $mesh_hash;
$response["problem_hash"] = $problem_hash;
$response["error"] = "";
$response["warning"] = "";
$response["content_id"] = array();
$response["content_html"] = array();
$response["block"] = array();
$response["inline"] = array();
$response["hide"] = array();

$update_yaml = false;
$field = $_GET["field"];
$value = $_GET["value"];

if (chdir("../data/{$username}/cases/{$id}") === false) {
  return_error_json("cannot chdir to user dir {$id}");
}


// ---- case properties ----------------------------
// TODO: validate fields
if ($field == "name" ||
    $field == "visibility") {

  if ($field == "name") {
    array_push($response["content_id"], "span_name");
    array_push($response["content_html"], $value);
  }
  if ($field == "visibility") {
    if ($value == "public") {
      array_push($response["inline"], "i_public");
    } else {
      array_push($response["hide"], "i_public");
    }
  }

  $case[$field] = $value;
  $update_yaml = true;
}
if ($update_yaml) {
  file_put_contents("case.yaml", yaml_emit($case));
}

// ---- mesh.geo --------------------------------------------
/*
if (strncmp($field, "mesh_", 5) == 0) {
  $mesh_n = 1;
  $mesh_exploded = explode("_", $field);
  $mesh_n = intval($mesh_exploded[1]);
  $mesh_field = $mesh_exploded[2];


  // TODO: lock
  $current = fopen("mesh.geo", "r");
  $new = fopen("new.geo", "w");
  $mesh_i = 1;
  $validate = true;
  $written = false;
  $remove = ($value == "remove");
  if ($current && $new) {
    while (($line = fgets($current)) !== false) {
      if (strncmp("Merge ", $line, 6) == 0) {
        fprintf($new, "Merge \"../../cads/%s/cad.xao\";\n", $case["cad"]);

      } else if (strncmp("Mesh.", $line, 5) == 0) {
        if ($mesh_n == $mesh_i++) {
          if ($remove == false) {
            // TODO: regex digit,digit
            if (strpos($value, ",") !== false) {
              $response["warning"] = "Note that the decimal separator is dot, not comma.";
            }

            preg_match('/Mesh.(.*) = (.*);/', $line, $matches);
            if ($mesh_field == "variable") {
              fprintf($new, "%s = %s;\n", $value, $matches[2]);
            } else {
              fprintf($new, "Mesh.%s = %s;\n", $matches[1], $value);
            }
            $written = true;
          } else {
            // "remove" means do not write the line
            $written = true;
          }
        } else {
          fwrite($new, $line);
        }
      } else {
        fwrite($new, $line);
      }
    }
    
    // if it was a new addition, put it at the end
    if ($written == false && $remove == false) {
      if ($mesh_field == "variable" && $value != "") {
        fprintf($new, "Mesh.%s = 0;\n", $value);
      } else if ($mesh_field == "value" && $value != "") {
        fprintf($new, "Mesh.dummy = %s;\n", $value);
      }
      $validate = false;
    }
    
    fclose($current);
    fclose($new);

    if (rename("new.geo", "mesh.geo") !== true) {
      return_error_json("Cannot update geo");
    }

    // TODO: mesher-dependent
    // validate .geo with gmsh
    if ($validate) {
      exec("../../../../bin/gmsh -check mesh.geo 2>&1", $output, $result);
      if ($result != 0) {
        for ($i = 0; $i < count($output); $i++) {
          if (strncmp("Error", $output[$i], 5) == 0) {
            $output_exploded = explode(":", $output[$i]);
            for ($j = 2; $j < count($output_exploded); $j++) {
              $response["error"] .= $output_exploded[$j] ;
            }
            $response["error"] .= "<br>";
          } 
        }
      }
    }

  } else {
    return_error_json("cannot open mesh.geo");
  }
}
$mesh_hash = mesh_hash();
*/



// TODO: git commit
return_back_json($response);
