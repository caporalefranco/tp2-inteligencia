<?php
function busqueda_exhaustiva($grafo, $posicion_inicial, $punto_montaje)
{
    $queue = [];
    //Añado a la cola la posición inicial
    array_push($queue, [$posicion_inicial]);
    //Marco la posición inicial como visitada
    $visitados = [$posicion_inicial];

    if ($posicion_inicial == $punto_montaje) {
        return [$posicion_inicial];
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

                if ($vecino == $punto_montaje) {
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

function busqueda_heuristica($grafo, $posicion_inicial, $punto_montaje)
{
    $visitados = [];
    $queue = [];
    //Se agrega el nodo inicial a la cola
    array_push($queue, [
        'nodo' => $posicion_inicial,
        'heuristica' => 0,
        'camino' => array($posicion_inicial)
    ]);

    while (!empty($queue)) {
        // Se ordena la cola en orden ascendente según la heuristica
        usort($queue, function ($a, $b) {
            return $a['heuristica'] - $b['heuristica'];
        });

        //Se establece el nodo actual
        $nodoActual = $queue[0];
        //Se quita el nodo actual de la cola
        array_shift($queue);

        //Si el nodo actual es el punto de montaje
        if ($nodoActual['nodo'] == $punto_montaje) {
            return $nodoActual['camino'];
        }

        //Si el nodo actual aún no ha sido visitado, etonces
        if (!in_array($nodoActual['nodo'], $visitados)) {
            //Agrego el nodo actual al listao de nodos visitados
            $visitados[] = $nodoActual['nodo'];

            //Recorro los vecinos del nodo actual y los agrego a la cola
            foreach ($grafo[$nodoActual['nodo']] as $vecino => $heuristica) {
                //Si el vecino no fue visitado, entonces
                if (!in_array($vecino, $visitados)) {
                    /*** 
                        Se mergean los arreglos:
                            - Uno contiene el camino actual desde el nodo de inicio hasta el nodo actual.
                            - El otro contiene al vecino que estamos expandiendo.
                     **/
                    $nuevoCamino = array_merge($nodoActual['camino'], array($vecino));

                    // Pusheamos a la cola el vecino actual junto con su heurística y el nuevo camino actualizado
                    array_push($queue, [
                        'nodo' => $vecino,
                        'heuristica' => $heuristica,
                        'camino' => $nuevoCamino
                    ]);
                }
            }
        }
    }

    // No se encontró un camino desde la posición inicial hasta el punto de montaje
    return null;
}
