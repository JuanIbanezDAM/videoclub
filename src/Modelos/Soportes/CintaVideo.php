<?php

class CintaVideo extends Soporte {
    //---- ATRIBUTOS ----
    private int $duracion;

    //---- CONSTRUCTOR ----
    public function __construct(string $titulo, float $precio, int $duracion) {
        parent::__construct($titulo, $precio);
        $this->duracion = $duracion;
    }

    //---- GETTERS Y SETTERS ----

    //---- METODOS ----
    public function muestraResumen(): string {
        parent::muestraResumen();
        return "$this->titulo , Precio: " . $this->getPrecio() . ", Precio IVA incluido: " . $this->getPrecioConIva() . ", Duración: $this->duracion";
    }
}
