<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("../../conf.php");
include("../../auths/{$auth}/auth.php");
include("../common.php");

// Recupera i parametri
$problem = $_POST["problem"];
$mesher = $_POST["mesher"];
$solver = $_POST["solver"];
$cad = $_POST["cad_hash"] ?? ''; // Aggiunto per evitare problemi di variabile non definita

// Include il file del solver specifico
include("../../solvers/{$solver}/input_initial_{$problem}.php");

// Verifica e crea la directory dei casi, se necessario
if (!file_exists("../../data/{$username}/cases")) {
    if (!mkdir("../../data/{$username}/cases", $permissions, true)) {
        echo "error: cannot create cases directory";
        exit();
    }
}
if (!chdir("../../data/{$username}/cases")) {
    echo "error: cannot chdir to cases";
    exit();
}

// Genera l'ID del caso
$id = md5((`which uuidgen`) ? shell_exec("uuidgen") : uniqid());

// Reindirizzamento specifico per ANBA
if ($solver == "anba") {
    header("Location: /new/anba_config.php?id={$id}");
    exit();
}

// Crea la directory per il caso specifico
mkdir($id, $permissions, true);
chdir($id);

// Gestione file .geo o .bdf in base al solver
if ($solver == "anba") {
    // ANBA richiede un file .bdf
    copy("../../cads/{$cad}/default.bdf", "case.bdf");
} else {
    // FeenoX e altri solver utilizzano .geo
    copy("../../cads/{$cad}/default.geo", "mesh.geo");
}

// Configura il caso
$case = [
    "id" => $id,
    "owner" => $username,
    "date" => time(),
    "cad" => $cad,
    "problem" => $problem,
    "mesher" => $mesher,
    "solver" => $solver,
    "name" => $_POST["name"] ?? "Unnamed",
    "visibility" => "public"
];
yaml_emit_file("case.yaml", $case);

// Genera il file di input iniziale in base al solver
if ($solver == "feenox") {
    solver_input_write_initial("case.fee", $case["problem"]);
} elseif ($solver == "anba") {
    solver_input_write_initial("case.bdf", $case["problem"]);
}

// Inizializzazione del repository Git
$gitignore = fopen(".gitignore", "w");
fprintf($gitignore, "run");
fclose($gitignore);

exec("git init", $output, $result);
if ($result != 0) return_error_json("cannot git init {$case["problem"]} {$id}");
exec("git config user.name '{$username}'", $output, $result);
if ($result != 0) return_error_json("cannot set user.name {$case["problem"]} {$id}");
exec("git config user.email '{$username}@suncae'", $output, $result);
if ($result != 0) return_error_json("cannot set user.email {$case["problem"]} {$id}");
exec("git add .", $output, $result);
if ($result != 0) return_error_json("cannot git add {$case["problem"]} {$id}");
exec("git commit -m 'initial commit'", $output, $result);
if ($result != 0) return_error_json("cannot git commit {$case["problem"]} {$id}");

// Registra nei log e reindirizza
suncae_log("created problem {$case["problem"]} {$id}");
header("Location: ../?id={$id}");
?>