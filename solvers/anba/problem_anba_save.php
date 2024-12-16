<?php
// suncae/solvers/anba/problem_anba_save.php

// Imposta la directory del caso
chdir("../data/{$username}/cases/{$id}");

// Leggi i parametri
$corda = $_POST["corda_reale"];
// aggiungi altri parametri se necessari

// Esegui script Python per creare case.bdf
exec("python3 /percorso/al/script_salome.py --corda $corda", $output, $result);

$response = array();
if ($result == 0 && file_exists("case.bdf")) {
  $response["status"] = "ok";
  $response["error"] = "";
} else {
  $response["status"] = "error";
  $response["error"] = "Cannot generate case.bdf";
}

return_back_json($response);