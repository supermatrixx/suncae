<?php
$id = $_POST['id'] ?? '';
if (empty($id)) {
    echo "Errore: ID mancante.";
    exit();
}

// Esegui Salome per generare il .bdf
exec("salome -t script.py -- generate_bdf");

// Lancia ANBA per il calcolo delle proprietà
exec("anba input.bdf", $output, $return_code);

if ($return_code === 0) {
    echo "Proprietà di rigidezza calcolate con successo:";
    echo "<pre>" . implode("\n", $output) . "</pre>";
} else {
    echo "Errore nell'esecuzione di ANBA.";
}
?>