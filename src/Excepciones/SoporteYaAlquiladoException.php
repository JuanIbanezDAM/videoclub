<?php

namespace Util;

use Exception;

include_once("VideoclubException.php");

class SoporteYaAlquiladoException extends VideoclubException {

    public function __construct(
        protected $mensaje,
        protected $codigo = 0,
        Exception $e = null
    ) {
        parent::__construct($mensaje, $codigo, $e);
    }

    public function __toString(): string {
        return parent::__toString() . ". Soporte ya alquilado por el usuario";
    }
}
