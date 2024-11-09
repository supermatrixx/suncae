<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

$x3d_file = "../../data/{$username}/cads/{$_GET["id"]}/cad.x3d";

if (file_exists($x3d_file)) {

  header('Content-Type: model/x3d+xml');
  header('Content-Length: ' . filesize($x3d_file));

  ob_clean();
  flush();
  readfile($x3d_file);
  flush();
  
} else if (file_exists($x3d_file.".gz")) {

  $data = gzdecode(file_get_contents($x3d_file.".gz"));
  header('Content-Type: model/x3d+xml');
  header('Content-Length: ' . strlen($data));

  ob_clean();
  flush();
  echo $data;
  flush();

}
?>
