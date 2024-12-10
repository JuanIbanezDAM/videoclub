<?php

namespace Videoclub\Modelos;

use Videoclub\Modelos\Soportes\Soporte;

use Videoclub\Excepciones\SoporteYaAlquiladoException;
use Videoclub\Excepciones\CupoSuperadoException;
use Videoclub\Excepciones\SoporteNoEncontradoException;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;

class Cliente {
    //---- ATRIBUTOS ----
    protected int $id; // Guarda el numero del cliente
    protected int $numSoportesAlquilados = 0; // Guarda el numero de soportes que ha alquilado
    protected array $soportesAlquilados = []; // Guarda los soportes que ha alquilado
    public string $user; // Nombre usuario
    private Logger $miLog;

    protected static int $numClientes = 1; // Guarda el numero del cliente que se han creado

    //---- CONSTRUCTOR ----
    public function __construct(
        public string $nombre,
        protected string $pass, // Contraseña usuario
        protected int $maxAlquilerConcurrente = 3,  // Guarda el numero maximo de soportes que puede alquilar
        string $canal = "VideoclubLogger"
    ) {
        $this->miLog = new Logger($canal);

        // Manejador que escribe en un archivo
        $this->miLog->pushHandler(new RotatingFileHandler("../../logs/videoclub.log", 0, Logger::DEBUG));

        $this->user = $this->nombre;
        $this->id = self::$numClientes++;
    }

    //---- GETTERS Y SETTERS ----
    public function getId(): int {
        return $this->id;
    }

    public function getUser(): string {
        return $this->user;
    }

    public function getPassword(): string {
        return $this->pass;
    }

    public function getSoportesAlquilados(): array {
        return $this->soportesAlquilados;
    }

    public function getNumSoportesAlquilados(): int {
        return $this->id;
    }

    public function getMaxAlquilerConcurrente(): int {
        return $this->maxAlquilerConcurrente;
    }

    public function setUser(string $user): void {
        $this->user = $user;
    }

    public function setMaxAlquilerConcurrente(int $maxAlquileres): void {
        $this->maxAlquilerConcurrente = $maxAlquileres;
    }

    public function setPassword(string $pass): void {
        $this->pass = $pass;
    }


    //---- METODOS ----
    public function muestraResumen(): string {
        return  "ID: " . $this->getId() . ", " . $this->getUser() . ", " . $this->getPassword() . ", Alquileres máximos: " . $this->getMaxAlquilerConcurrente() .  ", Cantidad de alquileres: " . count($this->soportesAlquilados);
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        return isset($this->soportesAlquilado[$soporte]);
    }


    public function alquilar(Soporte $soporte) {
        // Verifica si el soporte ya está alquilado
        if ($this->tieneAlquilado($soporte)) {
            $this->miLog->warning("Exception. El soporte ya está alquilado.");
            throw new SoporteYaAlquiladoException("Exception. El soporte ya está alquilado.", 4);
        }
        // Verifica si se ha superado el cupo de alquileres
        else if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            $this->miLog->warning("Exception. Se ha superado el límite de alquileres concurrentes.");
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
            if ($soporte->getId() === $numSoporte) {
                unset($this->soportesAlquilados[$key]); //Elimina el elemento que coincide en la clave (indice) del array;
                $this->numSoportesAlquilados--; // Disminuye el contador de soportes alquilados
                $soporte->alquilado = false;
                return $this; /* Permite el encadenamiento de metodos */
            }
        }
        $this->miLog->warning("Exception. Soporte no alquilado por el cliente.");
        ///Si no coincide el numero del soporte dado con algún soporte alquilado.
        throw new SoporteNoEncontradoException("Exception. Soporte no alquilado por el cliente.", 3);
    }

    public function listaAlquileres(): void {
        foreach ($this->soportesAlquilados as $elemento) {
            echo "id: " . $elemento->getId() . " | " . $elemento->muestraResumen();
            echo "<br>";
        }
    }
}
