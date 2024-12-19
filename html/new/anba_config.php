Ecco il codice completo di anba_config.php, aggiornato per adattarsi ai nuovi requisiti e per accettare un unico file di input contenente sia le curve superiori che inferiori. L'interfaccia è ottimizzata e utilizza Bootstrap per un aspetto chiaro e moderno.
Codice: anba_config.php

<?php
// Recupera l'ID del caso
$id = $_GET['id'] ?? '';
if (empty($id)) {
    echo "Errore: ID del caso mancante.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configura Parametri Airfoil</title>
    <link href="../css/faster-than-quick/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Configura Parametri Airfoil</h1>
    <form id="airfoilForm" action="anba_generate.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <!-- Lunghezza della corda reale -->
        <div class="mb-3">
            <label for="real_chord" class="form-label">Lunghezza della Corda Reale (m)</label>
            <input type="number" step="0.001" name="real_chord" id="real_chord" class="form-control" required>
        </div>

        <!-- Spessore strato composito -->
        <div class="mb-3">
            <label for="composite_thickness" class="form-label">Spessore Strato Composito ±45° (m)</label>
            <input type="number" step="0.001" name="composite_thickness" id="composite_thickness" class="form-control" required>
        </div>

        <!-- Lunghezza trailing edge -->
        <div class="mb-3">
            <label for="trailing_edge" class="form-label">Lunghezza del Trailing Edge (m)</label>
            <input type="number" step="0.001" name="trailing_edge" id="trailing_edge" class="form-control" required>
        </div>

        <!-- Caricamento file con coordinate airfoil -->
        <div class="mb-3">
            <label for="airfoil_file" class="form-label">Carica File Airfoil (.txt)</label>
            <input type="file" name="airfoil_file" id="airfoil_file" class="form-control" accept=".txt" required>
            <small class="form-text text-muted">
                Il file deve contenere le coordinate del profilo superiore e inferiore, separate da una linea `------------------------------------------------------------------------`.
            </small>
        </div>

        <!-- Pulsante per generare geometria -->
        <button type="submit" class="btn btn-primary" name="generate_geometry">Genera Geometria</button>
    </form>

    <!-- Visualizzazione dinamica della sezione 2D -->
    <div class="mt-5" id="geometry_preview">
        <h3>Anteprima Geometria 2D</h3>
        <iframe id="geometry_frame" src="preview.php?id=<?= htmlspecialchars($id) ?>" style="width: 100%; height: 500px; border: none;"></iframe>
    </div>

    <!-- Pulsante per calcolare rigidezza -->
    <form action="anba_run.php" method="post" class="mt-3">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <button type="submit" class="btn btn-success">Calcola Rigidezza</button>
    </form>
</div>

<script>
// Script per aggiornare dinamicamente l'anteprima della geometria
document.getElementById('airfoilForm').addEventListener('submit', function(event) {
    const iframe = document.getElementById('geometry_frame');
    setTimeout(function() {
        iframe.src = iframe.src; // Ricarica l'iframe per mostrare l'anteprima aggiornata
    }, 2000);
});
</script>
</body>
</html>