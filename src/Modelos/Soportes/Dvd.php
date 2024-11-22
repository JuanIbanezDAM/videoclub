<?php

class Dvd extends Soporte {
    //---- ATRIBUTOS ----
    public string $idiomas;
    private string $formatPantalla;

    //---- CONSTRUCTOR ----
    public function __construct(string $titulo, float $precio, string $idiomas, string $formatPantalla) {
        parent::__construct($titulo, $precio);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $formatPantalla;
    }


    //---- GETTERS Y SETTERS ----

    //---- METODOS ----
    public function muestraResumen(): string {
        parent::muestraResumen();
        return "$this->titulo , Precio: " . $this->getPrecio() . ", Precio IVA incluido: " . $this->getPrecioConIva() . ", Idiomas: $this->idiomas , Formato de pantalla: $this->formatPantalla";
    }
}
