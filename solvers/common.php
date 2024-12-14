<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

$physics_name["none"]                = "";
$physics_name["solid"]               = "Solid Mechanics";
$physics_name["fluid"]               = "Fluid Mechanics";
$physics_name["thermal"]             = "Heat Transfer";
$physics_name["electromagnetism"]    = "Electromagnetism";
$physics_name["acoustics"]           = "Acoustics";
$physics_name["neutron"]             = "Neutronics";
$physics_name["multiphysics"]        = "Multi-physics";

// TODO: structures?
$problem_name["mechanical"]          = "Mechanical elasticity";
$problem_physics["mechanical"]       = "solid";

$problem_name["modal"]               = "Modal analysis";
$problem_physics["modal"]            = "solid";

$problem_name["buckling"]            = "Buckling analysis";
$problem_physics["buckling"]         = "solid";

$problem_name["heat_conduction"]     = "Heat conduction";
$problem_physics["heat_conduction"]  = "thermal";

$problem_name["stiffness"] = "Stiffness Calculation";
$problem_physics["stiffness"] = "solid";

$solvers_names = array();
$problems = array();
$solvers = array();
$meshers = array();
function register_solver($solver, $name, $p, $m) {
  global $solvers_names;
  global $problems;
  global $solvers;
  global $meshers;
  global $problem_physics;

  $solvers_names[$solver] = $name;
  
  foreach ($p as $problem) {
    $physics = $problem_physics[$problem];
    if (isset($problems[$physics]) == false) {
      $problems[$physics] = array();
    }
    array_push($problems[$physics], $problem);
  
    if (isset($solvers[$problem]) == false) {
      $solvers[$problem] = array();
    }
    array_push($solvers[$problem], $solver);
  }
  
  $meshers[$solver] = array();
  foreach ($m as $mesher) {
    array_push($meshers[$solver], $mesher);
  }
}



// TODO: loop over subdirectories instead
include("feenox/problems.php");
include("ccx/problems.php");
include("sparselizard/problems.php");
include("anba/problems.php");

