<?php

//Autoload
require_once realpath('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;

class HolaMonolog {

    //Atributos
    private int $hora;
    private Logger $miLog;

    //Constructor
    public function __construct(int $hora) {

        $this->miLog = new Logger("HolaMonolog");

        // Manejador que escribe en un archivo
        $this->miLog->pushHandler(new RotatingFileHandler("./holaMonolog.log", 300, Logger::DEBUG));

        // Manejador que escribe en la salida de error (log del servidor)
        $this->miLog->pushHandler(new StreamHandler("php://stderr", Logger::DEBUG));

        // Los procesadores permiten añadir información a los mensajes. Para ello, se apilan después de cada manejador mediante el método pushProcessor($procesador) 
        // Procesador de introspección
        $this->miLog->pushProcessor(new IntrospectionProcessor());

        $this->setHora($hora);
    }

    //Getters y Setters
    function getHora(): int {
        return  $this->hora;
    }

    function setHora(int $hora): void {
        //Validar si la hora es inferior a 0 o mayor de 24
        if ($hora < 0 || $hora > 24) {
            $this->miLog->warning("La hora proporcionada ($hora) no es válida. Debe estar entre 0 y 24.");
            $this->hora = 0; // Asignar una hora por defecto en caso de error
        } else {
            $this->hora = $hora;
        }
    }


    //Metodos
    public function saludar(): void {
        $this->miLog->info('Saludando:  ' .  $this->getSaludo());
    }

    public function despedir(): void {
        $this->miLog->info('Despidiéndose: ' .  $this->getDespedida());
    }

    private function getSaludo(): string {
        if ($this->hora < 12) {
            return "¡Buenos dias!";
        } elseif ($this->hora < 20) {
            return "¡Buenas tardes!";
        } else {
            return "¡Buenas noches!";
        }
    }

    private function getDespedida(): string {
        if ($this->hora < 20) {
            return "¡Hasta luego!";
        } else {
            return "¡Hasta mañana!";
        }
    }
}
