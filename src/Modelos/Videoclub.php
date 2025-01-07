<?php

namespace Videoclub\Modelos;

use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Soportes\Soporte;
use Videoclub\Modelos\Soportes\CintaVideo;
use Videoclub\Modelos\Soportes\Dvd;
use Videoclub\Modelos\Soportes\Juego;
use Exception;
use Videoclub\Excepciones\SoporteYaAlquiladoException;
use Videoclub\Excepciones\CupoSuperadoException;
use Videoclub\Excepciones\SoporteNoEncontradoException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Videoclub {
    //---- ATRIBUTOS ----
    private array $productos = [];
    private int $numProductos = 0;
    private array $socios = [];
    private int $numSocios = 0;

    public int $numProductosAlquilados = 0; // Count de productos alquilados
    public int $numTotalAlquileres = 0; // Count de productos por alquilar

    private Logger $logger;

    //---- CONSTRUCTOR ----
    public function __construct(
        private string $nombre,
    ) {
        $this->logger = new Logger('VideoclubLogger');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/videoclub.log', Logger::DEBUG));
    }

    //---- GETTERS Y SETTERS ----
    public function getNombre(): string {
        return $this->nombre;
    }
    public function getNumProductosAlquilados(): string {
        return $this->numProductosAlquilados;
    }
    public function getNumTotalAlquileres(): string {
        return $this->numTotalAlquileres;
    }
    public function getProductos(): array {
        return $this->productos;
    }
    public function getSocios(): array {
        return $this->socios;
    }

    //---- METODOS ----
    private function incluirProducto(Soporte $producto): bool {
        $this->numProductos++;
        $this->logger->info('Producto incluido', ['producto' => $producto]);
        return array_push($this->productos, $producto);
    }

    public function incluirCintaVideo(string $titulo, float $precio, int $duracion): void {
        $soporte = new CintaVideo($titulo, $precio, $duracion);
        $this->incluirProducto($soporte);
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): void {
        $soporte =  new Dvd($titulo, $precio, $idiomas, $pantalla);
        $this->incluirProducto($soporte);
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): void {
        $soporte =  new Juego($titulo, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($soporte);
    }

    public function incluirSocio(string $nombre, string $pass, int $maxAlquileresConcurrentes = 3): void {
        $this->numSocios++;
        $socio = new Cliente($nombre, $pass, $maxAlquileresConcurrentes);
        $this->socios[] = $socio;
        $this->logger->info('Socio incluido', ['socio' => $socio]);
    }

    public function listarProductos(): void {
        foreach ($this->productos as $producto) {
            $this->logger->info('Listando producto', ['producto' => $producto]);
            echo $producto->muestraResumen() . "<br>";
        }
    }

    public function listarSocios(): void {
        foreach ($this->socios as $socio) {
            $this->logger->info('Listando socio', ['socio' => $socio]);
            echo $socio->muestraResumen() . "<br>";
        }
    }

    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte) {
        foreach ($this->socios as $socio) {
            if ($socio->getId() === $numeroCliente) {
                foreach ($this->productos as $producto) {
                    if ($producto->getId() === $numeroSoporte) {
                        try {
                            $socio->alquilar($producto);
                            $this->logger->info('Producto alquilado', ['socio' => $socio, 'producto' => $producto]);
                        } catch (SoporteYaAlquiladoException $e) {
                            $this->logger->warning($e->getMessage(), ['socio' => $socio, 'producto' => $producto]);
                            throw $e;
                        } catch (CupoSuperadoException $e) {
                            $this->logger->warning($e->getMessage(), ['socio' => $socio]);
                            throw $e;
                        } catch (Exception $e) {
                            $this->logger->warning($e->getMessage(), ['socio' => $socio, 'producto' => $producto]);
                            throw $e;
                        }
                        $this->actualizarNumAlquilados();
                        return;
                    }
                }
            }
        }
    }

    public function devolverSocioProducto(int $numeroCliente, int $numeroSoporte) {
        foreach ($this->socios as $socio) {
            if ($socio->getId() === $numeroCliente) {
                foreach ($this->productos as $producto) {
                    if ($producto->getId() === $numeroSoporte) {
                        try {
                            $socio->devolver($producto->getId());
                            $this->logger->info('Producto devuelto', ['socio' => $socio, 'producto' => $producto]);
                        } catch (SoporteNoEncontradoException $e) {
                            $this->logger->warning($e->getMessage(), ['socio' => $socio, 'producto' => $producto]);
                            throw $e;
                        } catch (Exception $e) {
                            $this->logger->warning($e->getMessage(), ['socio' => $socio, 'producto' => $producto]);
                            throw $e;
                        }
                        $this->actualizarNumAlquilados();
                        return;
                    }
                }
            }
        }
    }

    public function actualizarNumAlquilados(): void {
        $this->numProductosAlquilados = count(array_filter($this->productos, fn($producto) => $producto->alquilado));
        $this->numTotalAlquileres = count(array_filter($this->productos, fn($producto) => !$producto->alquilado));
        $this->logger->info('Números de alquileres actualizados', [
            'numProductosAlquilados' => $this->numProductosAlquilados,
            'numTotalAlquileres' => $this->numTotalAlquileres
        ]);
    }

    public function eliminarSocio(Cliente $currentUsuario): void {
        $this->socios = array_filter($this->socios, fn($usuario) => $usuario->getUser() != $currentUsuario->getUser() || $usuario->getPassword() != $currentUsuario->getPassword());
        $this->logger->info('Socio eliminado', ['socio' => $currentUsuario]);
    }

    public function editarSocio(Cliente $currentUsuario, string $nombre, string $pass, string $maxAlquileres): void {
        foreach ($this->socios as $usuario) {
            if ($usuario->getUser() == $currentUsuario->getUser() && $usuario->getPassword() == $currentUsuario->getPassword()) {
                $usuario->setUser($nombre);
                $usuario->setPassword($pass);
                $usuario->setMaxAlquilerConcurrente($maxAlquileres);
                $this->logger->info('Socio editado', ['socio' => $usuario]);
            }
        }
    }
}
