<?php
// Recupera i dati dal form
$id = $_POST['id'] ?? '';
$real_chord = $_POST['real_chord'] ?? '';
$composite_thickness = $_POST['composite_thickness'] ?? '';
$trailing_edge = $_POST['trailing_edge'] ?? '';
$airfoil_file = $_FILES['airfoil_file']['tmp_name'] ?? '';

// Controllo dei campi
if (empty($id) || empty($real_chord) || empty($composite_thickness) || empty($trailing_edge) || empty($airfoil_file)) {
    echo "Errore: Tutti i campi sono obbligatori.";
    exit();
}

// Crea la directory del caso
$case_dir = "../../data/{$id}";
if (!file_exists($case_dir)) {
    mkdir($case_dir, 0755, true);
}

// Percorso per salvare il file caricato
$input_file_path = "{$case_dir}/airfoil_input.txt";
if (!move_uploaded_file($airfoil_file, $input_file_path)) {
    echo "Errore: Impossibile salvare il file di input.";
    exit();
}

// Parse del file per estrarre le coordinate
$upper_points = [];
$lower_points = [];
$reading_lower = false;

$file = fopen($input_file_path, "r");
if ($file) {
    while (($line = fgets($file)) !== false) {
        $line = trim($line);

        // Salta header e righe vuote
        if (empty($line) || str_contains($line, 'SOURCE') || str_contains($line, 'PROFILO')) {
            continue;
        }

        // Sezione trailing edge inferiore
        if (str_contains($line, '------------------------------------------------------------------------')) {
            $reading_lower = true;
            continue;
        }

        // Parso le coordinate
        $parts = preg_split('/\s+/', $line);
        if (count($parts) == 2) {
            $x = (float)$parts[0];
            $y = (float)$parts[1];
            if ($reading_lower) {
                $lower_points[] = [$x, $y];
            } else {
                $upper_points[] = [$x, $y];
            }
        }
    }
    fclose($file);
} else {
    echo "Errore: Impossibile leggere il file di input.";
    exit();
}

// Salva i punti in file separati
file_put_contents("{$case_dir}/upper_curve.txt", json_encode($upper_points));
file_put_contents("{$case_dir}/lower_curve.txt", json_encode($lower_points));

// Genera lo script Python
$script_path = "{$case_dir}/generate_bdf.py";
$script_content = <<<PYTHON
# Script Python per generare file BDF
real_chord = $real_chord
composite_thickness = $composite_thickness
trailing_edge = $trailing_edge

# Curve caricate
upper_points = {json_encode($upper_points)}
lower_points = {json_encode($lower_points)}

# Codice Python per Salome
print("Generazione file BDF...")
print(f"Corda reale: {real_chord}, Spessore: {composite_thickness}, Trailing edge: {trailing_edge}")
print(f"Punti superiori: {len(upper_points)}, Punti inferiori: {len(lower_points)}")
PYTHON;

file_put_contents($script_path, $script_content);

// Esecuzione di Salome
$salome_path = __DIR__ . "/../../bin/salome/salome";
exec("{$salome_path} -t {$script_path}", $output, $return_code);

if ($return_code === 0) {
    echo "File BDF generato con successo!";
} else {
    echo "Errore nell'esecuzione di Salome.";
    exit();
}

echo "<br><a href='../?id={$id}'>Torna al caso</a>";
?>