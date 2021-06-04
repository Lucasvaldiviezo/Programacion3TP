<?php
require_once './models/empleado.php';
require_once 'IApiUsable.php';

use \App\Models\Empleado as Empleado;

class EmpleadoApi implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $emp=$args['id'];
        $empleado = Empleado::where('id', $emp)->first();
        $payload = json_encode($empleado);
        $response->getBody()->write($payload);
        
        return $response
         ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $lista = Empleado::all();
        $payload = json_encode(array("listaEmpleado" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $clave = $parametros['clave'];
        $mail = $parametros['mail'];

        if($parametros['puesto'] == 'mozo' || $parametros['puesto'] == 'cocinero' || $parametros['puesto'] == 'bartender' ||
        $parametros['puesto'] == 'candybar' || $parametros['puesto'] == 'admin')
        {
            $puesto = $parametros['puesto'];
        }else
        {
            $puesto = 'mozo';
        }
        // Creamos el usuario
        $emp = new Empleado();
        $emp->nombre = $nombre;
        $emp->apellido = $apellido;
        $emp->mail = $mail;
        $emp->clave = $clave;
        $emp->puesto = $puesto;
        $emp->save();

        $payload = json_encode(array("mensaje" => "Empleado creado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args) {
        $empleadoId = $args['id'];
        $empleado = Empleado::find($empleadoId);
        $empleado->delete();
        $payload = json_encode(array("mensaje" => "Empleado borrado con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

   public function ModificarUno($request, $response, $args) {
    $parametros = $request->getParsedBody();
    $nombreModificado = $parametros['nombre'];
    $apellidoModificado = $parametros['apellido'];
    $mailModificado = $parametros['mail'];
    $claveModificada = $parametros['clave'];
    $puestoModificado = $parametros['puesto'];
    $empId = $parametros['id'];

    // Conseguimos el objeto
    $emp = Empleado::where('id', '=', $empId)->first();

    // Si existe
    if ($emp !== null) {
        $emp->nombre = $nombreModificado;
        $emp->apellido = $apellidoModificado;
        $emp->mail = $mailModificado;
        $emp->clave = $claveModificada;
        $emp->puesto = $puestoModificado;
        $emp->save();
        $payload = json_encode(array("mensaje" => "Empleado modificado con exito"));
        
    } else {
      $payload = json_encode(array("mensaje" => "Empleado no encontrado"));
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');	
    }
}

?>