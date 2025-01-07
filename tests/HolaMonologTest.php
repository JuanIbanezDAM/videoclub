<?php

use Videoclub\Modelos\Videoclub;

use Videoclub\HolaMonolog;
use PHPUnit\Framework\TestCase;


class HolaMonologTest extends TestCase {
    public function testSaludarDevuelveSaludoCorrecto() {
        $hola = new HolaMonolog(10); // Hora por la mañana
        $this->assertEquals("¡Buenos dias!", $hola->saludar());
    }

    public function testDespedirDevuelveDespedidaCorrecta() {
        $hola = new HolaMonolog(21); // Hora por la noche
        $this->assertEquals("¡Hasta mañana!", $hola->despedir());
    }

    public function testUltimosSaludosAlmacenaCorrectamente() {
        $hola = new HolaMonolog(10);

        $hola->saludar(); // Buenos días
        $hola->saludar(); // Buenos días
        $hola->saludar(); // Buenos días
        $hola->saludar(); // Cuarto saludo (debería eliminar el primero)

        $this->assertCount(3, $hola->getUltimosSaludos());
    }

    /**
     * @dataProvider saludosProvider
     */
    public function testUltimosSaludosConProveedores(array $saludos, int $esperados) {
        $hola = new HolaMonolog(10);

        foreach ($saludos as $saludo) {
            $hola->saludar();
        }

        $this->assertCount($esperados, $hola->getUltimosSaludos());
    }

    public static function saludosProvider(): array {
        return [
            [["saludo1"], 1],
            [["saludo1", "saludo2", "saludo3"], 3],
            [["saludo1", "saludo2", "saludo3", "saludo4"], 3],
        ];
    }
    /* 
    public function testHoraInvalidaLanzaExcepcion() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("La hora proporcionada (-1) no es válida. Debe estar entre 0 y 24.");

        new HolaMonolog(-1); // Hora inválida
    }
     */
}
