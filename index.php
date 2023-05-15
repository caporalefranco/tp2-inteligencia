<?php
require('Busquedas.php');

$blockExhaustiva = [
    'A' => ['B2', 'B5'],
    'B' => ['B1', 'B6'],
    'B1' => ['B', 'B2'],
    'B2' => ['B1', 'A'],
    'B3' => ['A', 'B4',],
    'B4' => ['B3', 'B5'],
    'B5' => ['B4'],
    'B6' => ['B']
];

$blockHeuristica = [
    'A' => ['B2' => 5, 'B5' => 3],
    'B' => ['B1' => 2, 'B6' => 6],
    'B1' => ['B' => 4, 'B2' => 5],
    'B2' => ['B1' => 6, 'A' => 7],
    'B3' => ['A' => 2, 'B4' => 4],
    'B4' => ['B3' => 8, 'B5' => 7],
    'B5' => ['B4' => 10],
    'B6' => ['B' => 3],
];

$posicion_inicial = 'B2';
$punto_monatje = 'A';
$busquedaExhaustiva = busqueda_exhaustiva($blockExhaustiva, $posicion_inicial, $punto_monatje);
$busquedaHeuristica = busqueda_heuristica($blockHeuristica, $posicion_inicial, $punto_monatje);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP N°2 Caporale Franco</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="section-header">
        <h1>Búsqueda exhaustiva - BFS (Búsqueda en anchura)</h1>
    </div>
    <div class="graph">
        <?php
        if ($busquedaExhaustiva) {
            echo "Se encontró un camino desde $posicion_inicial hasta $punto_monatje:";
            echo "<div class='node-container'>";
            foreach ($busquedaExhaustiva as $key => $value) {
                echo "<div class='node'>";
                echo $value;
                echo "</div>";
                if ($key != count($busquedaExhaustiva) - 1) {
        ?>
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" fill="#00b2ec" clip-rule="evenodd">
                        <path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z" />
                    </svg>
        <?php
                }
            }
            echo "</div>";
        } else {
            echo "No se encontró un camino desde $posicion_inicial hasta $punto_monatje.";
        }
        ?>
    </div>

    <div class="section-header">
        <h1>Búsqueda heurística - Busqueda primero el mejor</h1>
    </div>

    <div class="graph">
        <?php
        if ($busquedaHeuristica) {
            echo "Se encontró un camino desde $posicion_inicial hasta $punto_monatje:";
            echo "<div class='node-container'>";
            foreach ($busquedaHeuristica as $key => $value) {
                echo "<div class='node'>";
                echo $value;
                echo "</div>";
                if ($key != count($busquedaHeuristica) - 1) {
        ?>
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" fill="#00b2ec" clip-rule="evenodd">
                        <path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z" />
                    </svg>
        <?php
                }
            }
            echo "</div>";
        } else {
            echo "No se encontró un camino desde $posicion_inicial hasta $punto_monatje.";
        }
        ?>
    </div>
</body>

</html>