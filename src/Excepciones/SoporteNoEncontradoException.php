<?php

namespace Util;

use Exception;

class SoporteNoEncontradoException extends VideoclubException {

    public function __construct(
        protected $mensaje,
        protected $codigo = 0,
        Exception $e = null
    ) {
        parent::__construct($mensaje, $codigo, $e);
    }

    public function __toString(): string {
        return parent::__toString() . ". Soporte no encontrado, pruebe otra vez.";
    }
}
