<?php

class Juego extends Soporte {
    //---- ATRIBUTOS ----
    public string $consola;
    private int $minNumJugadores;
    private int $maxNumJugadores;

    //---- CONSTRUCTOR ----
    public function __construct(string $titulo, float $precio, string $consola, int $minNumJugadores, int $maxNumJugadores) {
        parent::__construct($titulo, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    //---- GETTERS Y SETTERS ----
    public function muestraJugadoresPosibles(): string {
        if ($this->minNumJugadores === 1 && $this->maxNumJugadores === 1) {
            return "Para un jugador";
        } else if ($this->minNumJugadores === 1 && $this->maxNumJugadores !== 1) {
            return "Para $this->maxNumJugadores jugadores";
        } else {
            return "De $this->minNumJugadores a $this->maxNumJugadores jugadores";
        }
    }

    //---- METODOS ----
    public function muestraResumen(): string {
        parent::muestraResumen();
        return "$this->titulo , Precio: " . $this->getPrecio() . ", Precio IVA incluido: " . $this->getPrecioConIva() . ", Consola: $this->consola , Minimo jugadores: $this->minNumJugadores , Maximo jugadores: $this->maxNumJugadores";
    }
}
