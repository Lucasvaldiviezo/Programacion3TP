<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './apis/usuarioApi.php';
require_once './apis/productoApi.php';
require_once './apis/mesaApi.php';
require_once './apis/pedidoApi.php';
require './MWClases/MWparaAutentificar.php';
require './MWClases/MWparaCORS.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/usuario', function () {
 
  $this->get('/', \usuarioApi::class . ':TraerTodos');
 
  $this->get('/{puesto}', \usuarioApi::class . ':TraerUno');

  $this->post('/', \usuarioApi::class . ':CargarUno');

  $this->delete('/{id}', \usuarioApi::class . ':BorrarUno');

  $this->put('/', \usuarioApi::class . ':ModificarUno');
     
})/*->add(\MWparaAutentificar::class . ':VerificarUsuario')*/;

$app->group('/producto', function () {
 
  $this->get('/', \productoApi::class . ':TraerTodos');
 
  $this->get('/{tipo}', \productoApi::class . ':TraerUno');

  $this->post('/', \productoApi::class . ':CargarUno');

  $this->delete('/{id}', \productoApi::class . ':BorrarUno');

  $this->put('/', \productoApi::class . ':ModificarUno');
     
})/*->add(\MWparaAutentificar::class . ':VerificarUsuario')*/;

$app->group('/mesa', function () {
 
  $this->get('/', \mesaApi::class . ':TraerTodos');
 
  $this->get('/{numero}', \mesaApi::class . ':TraerUno');

  $this->post('/', \mesaApi::class . ':CargarUno');

  $this->delete('/{id}', \mesaApi::class . ':BorrarUno');

  $this->put('/', \mesaApi::class . ':ModificarUno');
     
})/*->add(\MWparaAutentificar::class . ':VerificarUsuario')*/;

$app->group('/pedido', function () {
 
  $this->get('/', \pedidoApi::class . ':TraerTodos');
 
  $this->get('/{numero}', \pedidoApi::class . ':TraerUno');

  $this->post('/', \pedidoApi::class . ':CargarUno');

  $this->delete('/{id}', \pedidoApi::class . ':BorrarUno');

  $this->put('/', \pedidoApi::class . ':ModificarUno');
     
})/*->add(\MWparaAutentificar::class . ':VerificarUsuario')*/;
$app->run();

?>