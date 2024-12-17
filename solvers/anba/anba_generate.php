<?php
// Recupera i dati dal form
$id = $_POST['id'] ?? '';
$real_chord = $_POST['real_chord'] ?? '';
$composite_thickness = $_POST['composite_thickness'] ?? '';
$trailing_edge = $_POST['trailing_edge'] ?? '';

// Controllo dei file caricati
$upper_curve = $_FILES['upper_curve']['tmp_name'] ?? '';
$lower_curve = $_FILES['lower_curve']['tmp_name'] ?? '';

// Verifica che tutti i parametri siano stati forniti
if (empty($id) || empty($real_chord) || empty($composite_thickness) || empty($trailing_edge) || empty($upper_curve) || empty($lower_curve)) {
    echo "Errore: Tutti i campi sono obbligatori.";
    exit();
}

// Crea la cartella di lavoro per questo caso
$case_dir = "../../data/{$id}";
if (!file_exists($case_dir)) {
    mkdir($case_dir, 0755, true);
}

// Salva le coordinate caricate
move_uploaded_file($upper_curve, "{$case_dir}/upper_curve.txt");
move_uploaded_file($lower_curve, "{$case_dir}/lower_curve.txt");

// Percorso per salvare lo script Python
$script_path = "{$case_dir}/generate_bdf.py";

// Contenuto dello script Python per generare il file BDF
$script_content = <<<PYTHON
# Script generato automaticamente per creare file BDF

real_chord = $real_chord
composite_thickness = $composite_thickness
trailing_edge = $trailing_edge

upper_curve_file = "upper_curve.txt"
lower_curve_file = "lower_curve.txt"

# Qui integriamo il codice Python per Salome
import sys
print("Generazione file BDF...")
print(f"Corda reale: {real_chord}, Spessore: {composite_thickness}, Trailing edge: {trailing_edge}")
print(f"Caricando curve da {upper_curve_file} e {lower_curve_file}")
PYTHON;

// Salva il file Python
file_put_contents($script_path, $script_content);

// Lancia Salome per generare il file BDF
$salome_command = "salome -t {$script_path}";
exec($salome_command, $output, $return_code);

if ($return_code === 0) {
    echo "File BDF generato con successo!";
} else {
    echo "Errore nell'esecuzione di Salome.";
}

// Reindirizza alla pagina principale
echo "<br><a href='../?id={$id}'>Torna al caso</a>";
?>