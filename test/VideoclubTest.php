<?php

namespace Videoclub\Tests;

require('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Videoclub;

class VideoclubTest extends TestCase {
    public function testConstructor() {
        $vc = new Videoclub("Mi videoclub");
        $this->assertSame($vc->getNombre(), "Mi videoclub");
    }

    public function testIncluirProductos() {
        $vc = new Videoclub("Mi videoclub");
        $vc->incluirJuego("Project Zomboid", 13, "pc", 1, 20);
        $this->assertSame($vc->getProductos()[0]->titulo, "Project Zomboid");
    }

    public function testIncluirSocio() {
        $vc = new Videoclub("Mi videoclub");
        $vc->incluirSocio("luisa", "luisa123");
        $this->assertSame($vc->getSocios()[0]->nombre, "luisa");
    }

    public function testEliminarSocio() {
        $vc = new Videoclub("Mi videoclub");
        $cliente = new Cliente("luisa", "luisa123");
        $vc->incluirSocio($cliente->getUser(), $cliente->getPassword());
        $vc->eliminarSocio($cliente);
        $this->assertNull($vc->getSocios()[0]);
    }

    public function testListarProductos() {
        $vc = new Videoclub("Mi videoclub");
        $vc->incluirJuego("Project Zomboid", 13, "pc", 1, 20);
        $vc->listarProductos();
        $this->expectOutputString("Project Zomboid , Precio: 13, Precio IVA incluido: 15.73, Consola: pc , Minimo jugadores: 1 , Maximo jugadores: 20<br><br>");
    }

    public function testListarSocios() {
        $vc = new Videoclub("Mi videoclub");
        $cliente = new Cliente("luisa", "luisa123");
        $vc->incluirSocio($cliente->getUser(), $cliente->getPassword());
        $vc->listarSocios();
        $this->expectOutputString("ID: 11, luisa, luisa123, Alquileres máximos: 3, Cantidad de alquileres: 0<br><br>");
    }

    public function testActualizarNumAlquilados(){
        $vc = new Videoclub("Mi videoclub");
        $vc->incluirJuego("Project Zomboid", 13, "pc", 1, 20);

        $vc->actualizarNumAlquilados();
        $this->assertSame($vc->getNumTotalAlquileres(), "1");
    }


}
