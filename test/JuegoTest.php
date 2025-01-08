<?php

namespace Videoclub\Tests;

require('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;

use Videoclub\Modelos\Soportes\Juego;

class JuegoTest extends TestCase {
    public function testConstructor() {
        $juego = new Juego("Project Zomboid", 13, "pc", 1, 20);
        $this->assertSame($juego->titulo, "Project Zomboid");
    }

}
