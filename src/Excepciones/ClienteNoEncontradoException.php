<?php

namespace Videoclub\Excepciones;

class ClienteNoEncontradoException extends VideoclubException {

    public function __construct(
        protected $mensaje,
        protected $codigo = 0,
    ) {
        parent::__construct($mensaje, $codigo);
    }

    public function __toString(): string {
        return parent::__toString() . ". El cliente no existe.";
    }
}
