<?php

function solver_input_write_initial($filename, $problem) {
  $fee = fopen($filename, "w");
  if ($problem == "mechanical") {
    fprintf($fee, "PROBLEM mechanical\n");
    fprintf($fee, "READ_MESH meshes/%s-2.msh\n", md5_file("mesh.geo"));
    fprintf($fee, "\n");
    fprintf($fee, "E(x,y,z) = (200)*1e3\n");
    fprintf($fee, "nu = 0.3\n");
  } else if ($problem == "heat_conduction") {
    fprintf($fee, "PROBLEM thermal\n");
    fprintf($fee, "READ_MESH meshes/%s.msh\n", md5_file("mesh.geo"));
    fprintf($fee, "\n");
    fprintf($fee, "k(x,y,z) = (1)*1e-3\n");
    fprintf($fee, "q(x,y,z) = 0\n");
  }
  
  fprintf($fee, "\n");
  fprintf($fee, "SOLVE_PROBLEM\n");
  fprintf($fee, "WRITE_RESULTS FORMAT vtk all\n");
    
  fclose($fee);
}
