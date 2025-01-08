<?php

namespace Videoclub\Tests;

require('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;

use Videoclub\Modelos\Soportes\Dvd;

class DvdTest extends TestCase {
    public function testConstructor() {
        $dvd = new Dvd("BeatleChus", 23, "español", "16:9");
        $this->assertSame($dvd->titulo, "BeatleChus");
    }
}
