<?php

namespace Videoclub\Excepciones;

class CupoSuperadoException extends VideoclubException {

    public function __construct(
        protected $mensaje,
        protected $codigo = 0,
    ) {
        parent::__construct($mensaje, $codigo);
    }

    public function __toString(): string {
        return parent::__toString() . ". Cupo de alquileres superado, devuelva primero un soporte";
    }
}
