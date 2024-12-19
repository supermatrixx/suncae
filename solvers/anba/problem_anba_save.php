<?php
// suncae/solvers/anba/problem_anba_save.php

session_start();

// Retrieve username from session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    echo "Errore: utente non autenticato.";
    exit();
}

// Retrieve case ID from POST
if (isset($_POST['id']) && preg_match('/^[a-f0-9]{32}$/', $_POST['id'])) { // Assuming MD5 hash
    $id = $_POST['id'];
} else {
    echo "Errore: ID del caso non valido.";
    exit();
}

// Imposta la directory del caso
$case_dir = "../data/{$username}/cases/{$id}";
if (!chdir($case_dir)) {
    echo "Errore: impossibile accedere alla directory del caso.";
    exit();
}

// Leggi i parametri
$corda = $_POST["corda_reale"] ?? '';
if (!is_numeric($corda) || $corda <= 0) {
    echo "Errore: Lunghezza della corda reale non valida.";
    exit();
}

// Esegui script Python per creare case.bdf
$corda_sanitized = escapeshellarg($corda);
$python_script = "/percorso/al/script_salome.py"; // Update with actual path

exec("python3 {$python_script} --corda {$corda_sanitized} 2>&1", $output, $result);

$response = array();
if ($result == 0 && file_exists("case.bdf")) {
  $response["status"] = "ok";
  $response["error"] = "";
} else {
  $response["status"] = "error";
  $response["error"] = "Cannot generate case.bdf: " . implode("\n", $output);
}

return_back_json($response);
?>