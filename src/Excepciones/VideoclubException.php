<?php

namespace Videoclub\Excepciones;

use Exception;

class VideoclubException extends Exception {

    public function __construct(
        protected $mensaje,
        protected $codigo = 0,
        Exception $e = null
    ) {
        parent::__construct($mensaje, $codigo, $e);
    }

    public function __toString(): string {
        return __CLASS__ . "[{$this->codigo}] : {$this->mensaje}\n";
    }
}
