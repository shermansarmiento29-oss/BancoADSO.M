<?php

namespace App\Nucleo;

class Router
{
    private array $rutas = [];

    public function registrar(string $ruta, string $controlador, string $metodo, string $http = 'GET'): void
    {
        $this->rutas[$ruta] = [
            'controlador' => $controlador,
            'metodo'      => $metodo,
            'http'        => $http,
        ];
    }

    public function despachar(string $url): void
    {
        $url = trim($url, '/');

        if (array_key_exists($url, $this->rutas)) {
            $info = $this->rutas[$url];

            if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== $info['http']) {
                self::redirigir('panel');
            }

            $nombreControlador = $info['controlador'];
            $metodo = $info['metodo'];

            if (class_exists($nombreControlador)) {
                $instancia = new $nombreControlador();
                if (method_exists($instancia, $metodo)) {
                    $instancia->$metodo();
                    return;
                }
            }
        }

        self::redirigir('login');
    }

    public static function redirigir(string $ruta): never
    {
        header('Location: index.php?ruta=' . urlencode($ruta));
        exit;
    }
}
