<?php
require_once "AutentificadorJWT.php";
require_once "./apis/empleadoApi.php";

use \App\Models\Empleado as Empleado;

class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
  public function VerificarLogin($request, $response, $next)
  {
	$respuesta = "Credenciales invalidas";
	$ArrayDeParametros = $request->getParsedBody();
	$mail=$ArrayDeParametros["mail"];
	$clave=$ArrayDeParametros["clave"];

	$lista = Empleado::all();
	foreach($lista as $emp)
	{
		if($emp->mail == $mail && $emp->clave == $clave)
		{
			$datos = array('usuario' => $mail,'perfil' => $emp->puesto, 'clave' => $clave);
			$token= AutentificadorJWT::CrearToken($datos);
			$respuesta = $token;
			break;
		}
	}
	
	echo $respuesta;
  }
  
  public function VerificarUsuario($request, $response, $next) {
	if($request->isGet())
	{
	   	$response = $next($request, $response);
		$response->getBody()->write('<p>No valido credenciales al ser por GET</p>' . "\n");
	}
	else
	{
	  $response->getBody()->write('<p>verifico credenciales</p>');
	  $ArrayDeParametros = $request->getParsedBody();
	  $usuario = json_decode($ArrayDeParametros["obj_json"]);
	  $nombre=$usuario->nombre;
	  $perfil=$usuario->perfil;
	  if($perfil=="administrador")
	  {
		//$response->getBody()->write("<h3>Bienvenido $nombre </h3>");
		$response = $next($request, $response);
		$response->getBody()->write("\n<h3>Bienvenido $nombre </h3> \n");
	  }
	  else
	  {
		$response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
	  }  
	}
	$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
	return $response;   
}
}