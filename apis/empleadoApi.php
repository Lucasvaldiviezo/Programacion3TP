<?php
require_once './bdClases/empleado.php';
require_once 'IApiUsable.php';

use \Programacion3TP\bdClases\Empleado as Empleado;

class EmpleadoApi extends Empleado implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $puesto=$args['id'];
        $empleado = Empleado::where('id', $emp)->first();
        $payload = json_encode($empleado);
        $response->getBody()->write($payload);
        
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosEmpleados=Empleado::TraerTodoLosEmpleados();
        $newResponse = $response->withJson($todosLosEmpleados, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre = $ArrayDeParametros['nombre'];
        $apellido = $ArrayDeParametros['apellido'];
        $clave = $ArrayDeParametros['clave'];
        $mail = $ArrayDeParametros['mail'];
        $puesto = $ArrayDeParametros['puesto'];
       
        $miEmpleado = new Empleado();
        $miEmpleado->__construct1($nombre,$apellido,$clave,$mail,$puesto);
        $miEmpleado->InsertarEmpleadoParametros();
        //$archivos = $request->getUploadedFiles();
        //$destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
        //$nombreAnterior=$archivos['foto']->getClientFilename();
        //$extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
        //$extension=array_reverse($extension);
        //$archivos['foto']->moveTo($destino.$nombre.$mail.".".$extension[0]);
        
        $response->getBody()->write("se guardo el empleado" . "\n");

        return $response;
    }

    public function BorrarUno($request, $response, $args) {
        //$ArrayDeParametros = $request->getParsedBody();
        $id=$args['id'];
        $miEmpleado= new Empleado();
        $miEmpleado->id=$id;
        $cantidadDeBorrados=$miEmpleado->BorrarEmpleado();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        if($cantidadDeBorrados>0)
        {
            $objDelaRespuesta->resultado="Se borro el usuario";
        }
        else
        {
            $objDelaRespuesta->resultado="No se borro el usuario";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);  
        return $newResponse;
    }

   public function ModificarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();	
        $miEmpleado = new Empleado();
        $nombre = $ArrayDeParametros['nombre'];
        $apellido = $ArrayDeParametros['apellido'];
        $clave = $ArrayDeParametros['clave'];
        $mail = $ArrayDeParametros['mail'];
        $puesto = $ArrayDeParametros['puesto'];
        $miEmpleado->__construct1($nombre,$apellido,$clave,$mail,$puesto);
        $miEmpleado->id=$ArrayDeParametros['id'];
        
        $resultado =$miEmpleado->ModificarEmpleadoParametros();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);		
    }
}

?>