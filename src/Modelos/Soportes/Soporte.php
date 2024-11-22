<?php

namespace Videoclub\Modelos\Soportes;

abstract class Soporte implements Resumible{
    //---- ATRIBUTOS ----
    protected int $id; //Guardará el numSoporte 

    private static float $iva = 0.21;
    protected static int $numSoportes = 1; //Cuenta incremental por cada Soporte creado 

    //---- CONSTRUCTOR ----
    public function __construct(
        public string $titulo,
        private float $precio,
        public bool $alquilado = false,
    ) {
        $this->id = self::$numSoportes++; //Asignamos el id al soporte y aumentamos en uno el número de Soportes creados.
    }

    //---- GETTERS Y SETTERS ----
    public function getPrecio(): float {
        return $this->precio;
    }

    public function getId(): int {
        return $this->id;
    }

    //---- METODOS ----
    public function getPrecioConIva(): float {
        return self::$iva * 1 * $this->precio + $this->precio;
    }

    public function muestraResumen(): string {
        return "$this->titulo , Precio: " . $this->getPrecio() . ", Precio IVA incluido: " . $this->getPrecioConIva() . ", Numero: $this->id";
    }
}
