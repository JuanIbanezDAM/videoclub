<?php

namespace Videoclub\Tests;

require('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Videoclub\Modelos\Soportes\CintaVideo;


class CintaVideoTest extends TestCase {
    public function testConstructor() {
        $cinta = new CintaVideo("Los cazafantasmas", 3.5, 107);
        $this->assertSame($cinta->getId(), 1);
    }
}
