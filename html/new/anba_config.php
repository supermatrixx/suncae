<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License.

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
    <title>Configura ANBA</title>
    <link href="../css/faster-than-quick/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Configura ANBA</h1>
        <form action="anba_generate.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <!-- Input per configurare il solver -->
            <div class="mb-3">
                <label for="mesh_size" class="form-label">Dimensione della Mesh</label>
                <input type="number" step="0.01" name="mesh_size" id="mesh_size" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="material" class="form-label">Materiale</label>
                <input type="text" name="material" id="material" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="boundary_conditions" class="form-label">Condizioni al Contorno</label>
                <textarea name="boundary_conditions" id="boundary_conditions" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Aggiungi ulteriori input specifici per ANBA -->

            <button type="submit" class="btn btn-primary">Genera File BDF</button>
        </form>
    </div>
</body>
</html>