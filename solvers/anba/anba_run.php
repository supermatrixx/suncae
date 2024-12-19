<?php
$id = $_POST['id'] ?? '';
if (empty($id)) {
    echo "Errore: ID mancante.";
    exit();
}

// Define paths
$case_dir = "../../data/{$username}/cases/{$id}";
$bdf_file = "case.bdf";

// Change to case directory
if (!chdir($case_dir)) {
    echo "Errore: impossibile accedere alla directory del caso.";
    exit();
}

// Esegui Salome per generare il .bdf
exec("salome -t script.py -- generate_bdf", $salome_output, $salome_return_code);
if ($salome_return_code !== 0) {
    echo "Errore nell'esecuzione di Salome.";
    exit();
}

// Verifica che il file .bdf sia stato creato
if (!file_exists($bdf_file)) {
    echo "Errore: il file .bdf non è stato generato.";
    exit();
}

// Lancia ANBA per il calcolo delle proprietà
exec("anba {$bdf_file}", $anba_output, $anba_return_code);

if ($anba_return_code === 0) {
    echo "Proprietà di rigidezza calcolate con successo:";
    echo "<pre>" . implode("\n", $anba_output) . "</pre>";
} else {
    echo "Errore nell'esecuzione di ANBA.";
}


$id = basename($_POST['id'] ?? ''); // Removes any path information
if (empty($id) || !preg_match('/^[a-f0-9]{32}$/', $id)) { // Assuming MD5 hash
    echo "Errore: ID del caso non valido.";
    exit();
}


?>