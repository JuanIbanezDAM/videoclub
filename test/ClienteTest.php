<?php

namespace Videoclub\Tests;

require('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Soportes\CintaVideo;

use Videoclub\Excepciones\CupoSuperadoException;


class ClienteTest extends TestCase {
    public function testConstructor() {
        $cliente = new Cliente("Luisa", "luisa123");
        $this->assertSame($cliente->getId(), 1);
    }

    public function testAlquilarCupoLleno() {
        $cliente = new Cliente("Luisa", "luisa123", 2);
        $cinta1 = new CintaVideo("Los cazafantasmas 1", 3.5, 107);
        $cinta2 = new CintaVideo("Los cazafantasmas 2", 5, 120);
        $cinta3 = new CintaVideo("Los cazafantasmas 3", 5.3, 87);

        $cliente->alquilar($cinta1)->alquilar($cinta2);

        $this->expectException(CupoSuperadoException::class);
        $cliente->alquilar($cinta3);
    }
}
