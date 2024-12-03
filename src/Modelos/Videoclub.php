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

class Videoclub {
    //---- ATRIBUTOS ----
    private array $productos = [];
    private int $numProductos = 0;
    private array $socios = [];
    private int $numSocios = 0;

    public int $numProductosAlquilados = 0; // Count de productos alquilados    / alquilados = true 
    public int $numTotalAlquileres = 0; // Count de productos por alquilar      / alquilados = false 

    //---- CONSTRUCTOR ----
    public function __construct(
        private string $nombre,
    ) {
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
        return  array_push($this->productos, $producto);
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
        array_push($this->socios, $socio);
    }


    public function listarProductos(): void {
        foreach ($this->productos as $key => $producto) {
            echo $producto->muestraResumen() . "<br>";
        }
        echo "<br>";
    }

    public function listarSocios(): void {
        foreach ($this->socios as $key => $socio) {
            echo $socio->muestraResumen() . "<br>";
        }
        echo "<br>";
    }


    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte) {

        /* Si existe el numero del socio */
        foreach ($this->socios as $key => $socio) {
            if ($socio->getId() === $numeroCliente) {

                /* Si existe el numero del producto */
                foreach ($this->productos as $key => $producto) {
                    if ($producto->getId() === $numeroSoporte) {

                        /* El socio intenta alquilar el producto */
                        try {
                            $socio->alquilar($producto);
                            /* echo $socio->nombre . " ha alquilado " . $producto->titulo . " exitosamente."; */
                        } catch (SoporteYaAlquiladoException $e) {
                            echo  $e->getMessage();
                        } catch (CupoSuperadoException $e) {
                            echo  $e->getMessage();
                        } catch (Exception $e) {
                            echo  $e->getMessage();
                        }
                        $this->actualizarNumAlquilados();
                        return $this; /* Permite el encadenamiento de metodos */
                    }
                }
            }
        }
    }

    public function devolverSocioProducto(int $numeroCliente, int $numeroSoporte) {

        /* Si existe el numero del socio */
        foreach ($this->socios as $key => $socio) {
            if ($socio->getId() === $numeroCliente) {

                /* Si existe el numero del producto */
                foreach ($this->productos as $key => $producto) {
                    if ($producto->getId() === $numeroSoporte) {

                        /* El socio intenta alquilar el producto */
                        try {
                            $socio->devolver($producto->getId());
                            /* echo $socio->nombre . " ha devuelto " . $producto->titulo . " exitosamente."; */
                        } catch (SoporteNoEncontradoException $e) {
                            echo  $e->getMessage();
                        } catch (Exception $e) {
                            echo  $e->getMessage();
                        }
                        $this->actualizarNumAlquilados();
                        return $this; /* Permite el encadenamiento de metodos */
                    }
                }
            }
        }
    }

    public function actualizarNumAlquilados(): void {
        // Para buscar elementos en un array es mas recomendado usar array_filter que recorrerlo con un foreach
        //Count de productos alquilados    / alquilados = true 
        $this->numProductosAlquilados = count(array_filter($this->productos, fn($producto) => $producto->alquilado));
        //Count de productos poralquilar    / alquilados = false 
        $this->numTotalAlquileres = count(array_filter($this->productos, fn($producto) => !$producto->alquilado));
    }

    public function eliminarSocio(int $id): void {
        $this->socios = array_filter($this->socios, fn($socio) => $socio != $id);
    }
    public function editarSocio(int $id, string $user, string $pass, string $maxAlquileres): void {
        foreach ($this->socios as $usuario) {
            if ($usuario->getId() == $id) {
                $usuario->setUser($user);
                $usuario->setPassword($pass);
                $usuario->setMaxAlquilerConcurrente($maxAlquileres);
            }
        }
    }
}
