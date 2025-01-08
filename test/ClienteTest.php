<?php

namespace Videoclub\Tests;

require('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Soportes\CintaVideo;

use Videoclub\Excepciones\CupoSuperadoException;
use Videoclub\Excepciones\SoporteNoEncontradoException;
use Videoclub\Excepciones\SoporteYaAlquiladoException;


class ClienteTest extends TestCase {
    public function testConstructor() {
        $cliente = new Cliente("Luisa", "luisa123");
        $this->assertSame($cliente->getId(), 1);
    }

    public function testAlquilar() {
        $cliente = new Cliente("Luisa", "luisa123");
        $cinta1 = new CintaVideo("Los cazafantasmas 1", 3.5, 107);
        $cliente->alquilar($cinta1);
        $this->assertSame($cliente->getSoportesAlquilados()[0]->titulo, "Los cazafantasmas 1");
    }

    public function testmuestraResumen() {
        $cliente = new Cliente("Luisa", "luisa123");
        $cliente->muestraResumen();
        $this->assertSame($cliente->muestraResumen(), 'ID: 3, Luisa, luisa123, Alquileres máximos: 3, Cantidad de alquileres: 0');
    }

    public function testlistarAlquileres() {
        $cliente = new Cliente("Luisa", "luisa123");
        $cinta1 = new CintaVideo("Los cazafantasmas 1", 3.5, 107);
        $cliente->alquilar($cinta1);
        $cliente->listaAlquileres();
        $this->expectOutputString("id: 3 | Los cazafantasmas 1 , Precio: 3.5, Precio IVA incluido: 4.235, Duración: 107<br>");
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

    public function testSoporteNoEncontradoException() {
        $cliente = new Cliente('Juan', 'password');
        $cinta1 = new CintaVideo("Los cazafantasmas 1", 3.5, 107);

        // Aseguramos que al intentar devolver el soporte sin haberlo alquilado, se lance la excepción
        $this->expectException(SoporteNoEncontradoException::class);

        // Intentamos devolver un soporte no alquilado
        $cliente->devolver(1);
    }
}
