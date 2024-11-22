<?php

namespace Videoclub\Models;

use Videoclub\Modelos\Soportes\Soporte;
use Videoclub\Excepciones\SoporteYaAlquiladoException;
use Videoclub\Excepciones\CupoSuperadoException;
use Videoclub\Excepciones\SoporteNoEncontradoException;

class Cliente {
    //---- ATRIBUTOS ----
    protected int $id; // Guarda el numero del cliente
    protected int $numSoportesAlquilados = 0; // Guarda el numero de soportes que ha alquilado
    protected array $soportesAlquilados = []; // Guarda los soportes que ha alquilado

    protected static int $numClientes = 1; // Guarda el numero del cliente que se han creado

    //---- CONSTRUCTOR ----
    public function __construct(
        public string $nombre,
        protected int $maxAlquilerConcurrente = 3  // Guarda el numero maximo de soportes que puede alquilar
    ) {
        $this->id = self::$numClientes++;
    }

    //---- GETTERS Y SETTERS ----
    public function getId(): int {
        return $this->id;
    }

    public function getSoportesAlquilados(): array {
        return $this->soportesAlquilados;
    }

    public function getNumSoportesAlquilados(): int {
        return $this->id;
    }

    //---- METODOS ----
    public function muestraResumen(): string {
        return  "Nombre: $this->nombre Cantidad de alquileres: " . count($this->soportesAlquilados);
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        return isset($this->soportesAlquilado[$soporte]);
        return false;
    }


    public function alquilar(Soporte $soporte) {

        // Verifica si el soporte ya está alquilado
        if ($this->tieneAlquilado($soporte)) {
            throw new SoporteYaAlquiladoException("Exception. El soporte ya está alquilado.", 4);
        }
        // Verifica si se ha superado el cupo de alquileres
        else if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("Exception. Se ha superado el límite de alquileres concurrentes.", 2);
        }
        // Si no hay problemas, alquila el soporte
        else {
            array_push($this->soportesAlquilados, $soporte); // Añade el soporte al final del array
            $this->numSoportesAlquilados++; // Aumentamos el contador de soportes alquilados
            $soporte->alquilado = true;
            return $this; // Permite el encadenamiento de métodos
        }
    }


    public function devolver(int $numSoporte) {

        //Si coincide el numero del soporte dado con algún soporte alquilado.
            foreach ($this->soportesAlquilados as $key => $soporte) {
                if ($soporte->getNumero() === $numSoporte) {
                    unset($this->soportesAlquilados[$key]); //Elimina el elemento que coincide en la clave (indice) del array;
                    $this->numSoportesAlquilados--; // Disminuye el contador de soportes alquilados
                    $soporte->alquilado = false;
                    return $this; /* Permite el encadenamiento de metodos */
                }
            }
        ///Si no coincide el numero del soporte dado con algún soporte alquilado.
        throw new SoporteNoEncontradoException("Exception. Soporte no alquilado por el cliente.", 3);
    }

    /**
     * This PHP function iterates over rented items and displays their ID and a summary.
     */
    public function listaAlquileres(): void {
        foreach ($this->soportesAlquilados as $elemento) {
            echo "id: " . $elemento->getNumero() . " | " . $elemento->muestraResumen();
            echo "<br>";
        }
    }
}
