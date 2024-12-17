<?php
// Recupera i dati dal form
$id = $_POST['id'] ?? '';
$mesh_size = $_POST['mesh_size'] ?? '';
$material = $_POST['material'] ?? '';
$boundary_conditions = $_POST['boundary_conditions'] ?? '';

if (empty($id) || empty($mesh_size) || empty($material) || empty($boundary_conditions)) {
    echo "Errore: Tutti i campi sono obbligatori.";
    exit();
}

// Percorso per salvare lo script Python
$script_path = "../../data/{$id}/generate_bdf.py";

// Crea lo script Python
$script_content = <<<PYTHON
# Script per generare file BDF per ANBA
mesh_size = $mesh_size
material = "$material"
boundary_conditions = """$boundary_conditions"""

# Logica per generare il file BDF
print(f"Generazione del file BDF con dimensione mesh: {mesh_size}, materiale: {material}")
PYTHON;

file_put_contents($script_path, $script_content);

// Reindirizza o conferma la generazione
echo "Script Python generato con successo! <a href='../?id={$id}'>Torna al caso</a>";
?>
