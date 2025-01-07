<?php

namespace Videoclub\Modelos;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Videoclub\Modelos\Soportes\Soporte;
use Videoclub\Excepciones\SoporteYaAlquiladoException;
use Videoclub\Excepciones\CupoSuperadoException;
use Videoclub\Excepciones\SoporteNoEncontradoException;

class Cliente {
    //---- ATRIBUTOS ----
    protected int $id; // Guarda el numero del cliente
    protected int $numSoportesAlquilados = 0; // Guarda el numero de soportes que ha alquilado
    protected array $soportesAlquilados = []; // Guarda los soportes que ha alquilado
    public string $user; // Nombre usuario

    protected static int $numClientes = 1; // Guarda el numero del cliente que se han creado
    protected Logger $logger; // Logger para registrar eventos

    //---- CONSTRUCTOR ----
    public function __construct(
        public string $nombre,
        protected string $pass, // Contraseña usuario
        protected int $maxAlquilerConcurrente = 3  // Guarda el numero maximo de soportes que puede alquilar
    ) {
        $this->user = $this->nombre;
        $this->id = self::$numClientes++;

        // Inicialización del logger
        $this->logger = new Logger('VideoclubLogger');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/videoclub.log', Logger::DEBUG));
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
        return "ID: " . $this->getId() . ", " . $this->getUser() . ", " . $this->getPassword() . ", Alquileres máximos: " . $this->getMaxAlquilerConcurrente() .  ", Cantidad de alquileres: " . count($this->soportesAlquilados);
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        foreach ($this->soportesAlquilados as $alquilado) {
            if ($alquilado->getId() === $soporte->getId()) {
                return true;
            }
        }
        return false;
    }

    public function alquilar(Soporte $soporte) {
        if ($this->tieneAlquilado($soporte)) {
            $this->logger->warning("Intento de alquilar un soporte ya alquilado: " . $soporte->getId());
            throw new SoporteYaAlquiladoException("Exception. El soporte ya está alquilado.", 4);
        } else if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            $this->logger->warning("Intento de superar el límite de alquileres concurrentes.");
            throw new CupoSuperadoException("Exception. Se ha superado el límite de alquileres concurrentes.", 2);
        } else {
            array_push($this->soportesAlquilados, $soporte);
            $this->numSoportesAlquilados++;
            $soporte->alquilado = true;
            $this->logger->info("Soporte alquilado correctamente: " . $soporte->getId());
            return $this;
        }
    }

    public function devolver(int $numSoporte) {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getId() === $numSoporte) {
                unset($this->soportesAlquilados[$key]);
                $this->numSoportesAlquilados--;
                $soporte->alquilado = false;
                $this->logger->info("Soporte devuelto correctamente: " . $numSoporte);
                return $this;
            }
        }
        $this->logger->warning("Intento de devolver un soporte no alquilado: " . $numSoporte);
        throw new SoporteNoEncontradoException("Exception. Soporte no alquilado por el cliente.", 3);
    }

    public function listaAlquileres(): void {
        foreach ($this->soportesAlquilados as $elemento) {
            $this->logger->info("Listado de soporte alquilado: " . $elemento->getId());
            echo "id: " . $elemento->getId() . " | " . $elemento->muestraResumen();
            echo "<br>";
        }
    }
}
