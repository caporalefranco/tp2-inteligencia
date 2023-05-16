<?php

/**
 * Función que implementa el algoritmo de búsqueda en anchura en un grafo.
 * @param {nodo_actual, nodo_destino}
 */
function busqueda_anchura($grafo, $nodo_inicial, $nodo_destino)
{
    $queue = [];
    //Añado a la cola la posición inicial
    array_push($queue, [$nodo_inicial]);
    //Marco la posición inicial como visitada
    $visitados = [$nodo_inicial];

    if ($nodo_inicial == $nodo_destino) {
        return [$nodo_inicial];
    }
    //Mientras haya elementos en la cola
    while (!empty($queue) > 0) {

        //Agrego el nodo actual al camino y lo quito de la cola
        $camino = array_shift($queue);

        //Obtengo el último nodo del camino y verifico si es el mismo que el punto de montaje
        $node = end($camino);

        foreach ($grafo[$node] as $vecino) {
            //Si el vecino del nodo actual no fue visitado
            if (!in_array($vecino, $visitados)) {

                if ($vecino == $nodo_destino) {
                    $camino[] = $vecino;
                    return $camino;
                }

                //Agrego el nodo vecino a los visitados
                array_push($visitados, $vecino);
                //Se crea un nuevo camino anexando al nodo vecino
                $nuevoCamino = $camino;
                array_push($nuevoCamino, $vecino);
                //Agrego el nuevo vecino a la cola
                array_push($queue, $nuevoCamino);
            }
        };
    }
    return false;
}

/**
 * Función heurística utilizada para calcular la distancia entre los nodos.
 * @param {nodo_actual, nodo_destino}
 */
function manhattan($nodo_actual, $nodo_destino)
{
    //Obtenemos las coordenadas de los nodos
    $coordenadas_actual = obtener_coordenadas($nodo_actual);
    $coordenadas_destino = obtener_coordenadas($nodo_destino);

    //Calculamos la función heurística y retornamos la distancia entre nodos
    $distancia = abs($coordenadas_actual['x'] - $coordenadas_destino['x']) + abs($coordenadas_actual['y'] - $coordenadas_destino['y']);

    return $distancia;
}

/**
 * Función que devuelve las coordenadas asociadas a un nodo
 * @param {nodo}
 */

function obtener_coordenadas($nodo)
{
    //Coordenadas definidas de forma harcodeada
    $coordenadas = [
        'A' => ['x' => 3, 'y' => 0],
        'B' => ['x' => 0, 'y' => 0],
        'B1' => ['x' => 1, 'y' => 0],
        'B2' => ['x' => 2, 'y' => 0],
        'B3' => ['x' => 4, 'y' => 0],
        'B4' => ['x' => 5, 'y' => 0],
        'B5' => ['x' => 6, 'y' => 0],
    ];

    return $coordenadas[$nodo];
}


/**
 * Función que implementa el algoritmo de búsqueda primero el mejor en un grafo.
 * @param {grafo, nodo_inicial, nodo_destino}
 */

function busqueda_primero_mejor($grafo, $nodo_inicial, $nodo_destino)
{
    //Array con los  nodos visitados
    $visitados = [];
    //Cola de nodos a explorar
    $queue = [];

    //Se agrega el nodo inicial con su heurística y su camino
    array_push($queue, [
        'nodo' => $nodo_inicial,
        'heuristica' => manhattan($nodo_inicial, $nodo_destino),
        'camino' => [$nodo_inicial]
    ]);

    while (!empty($queue)) {
        //Se ordena la cola de nodos a explorar en función de la heurística en orden de menor a mayor
        usort($queue, function ($a, $b) {
            return $a['heuristica'] - $b['heuristica'];
        });
        //Se obtiene el nodo actual y se lo elimina de la cola
        $nodoActual = $queue[0];
        array_shift($queue);
        //Si el nodo actual es el destino, se retorna el camino actual
        if ($nodoActual['nodo'] == $nodo_destino) {
            return $nodoActual['camino'];
        }
        //Si el nodo actual no fue visitado
        if (!in_array($nodoActual['nodo'], $visitados)) {
            //Setear el nodo actual como visitado
            $visitados[] = $nodoActual['nodo'];
            //Explorar los vecinos del nodo actual
            foreach ($grafo[$nodoActual['nodo']] as $vecino) {
                //Se crea un nuevo camino agregando el vecino al camino actual
                $nuevoCamino = array_merge($nodoActual['camino'], [$vecino]);

                // Si el vecino no fue visitado, ase lo agrega a la cola
                if (!in_array($vecino, $visitados)) {
                    array_push($queue, [
                        'nodo' => $vecino,
                        'heuristica' => manhattan($vecino, $nodo_destino),
                        'camino' => $nuevoCamino
                    ]);
                }
            }
        }
    }
    // No se encontró un camino hacia el punto de montaje
    return null;
}
