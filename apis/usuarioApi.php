<?php
require_once './clases/usuario.php';
require_once 'IApiUsable.php';

class UsuarioApi extends Usuario implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $puesto=$args['puesto'];
        $todosLosUsuarios=Usuario::TraerUsuariosPuesto($puesto);
        $newResponse = $response->withJson($todosLosUsuarios, 200);  
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosUsuarios=Usuario::TraerTodoLosUsuarios();
        $newResponse = $response->withJson($todosLosUsuarios, 200);  
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
       
        $miUsuario = new Usuario();
        $miUsuario->__construct1($nombre,$apellido,$clave,$mail,$puesto);
        $miUsuario->InsertarUsuarioParametros();
        //$archivos = $request->getUploadedFiles();
        //$destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
        //$nombreAnterior=$archivos['foto']->getClientFilename();
        //$extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
        //$extension=array_reverse($extension);
        //$archivos['foto']->moveTo($destino.$nombre.$mail.".".$extension[0]);
        
        $response->getBody()->write("se guardo el usuario" . "\n");

        return $response;
    }

    public function BorrarUno($request, $response, $args) {
        //$ArrayDeParametros = $request->getParsedBody();
        $id=$args['id'];
        $miUsuario= new Usuario();
        $miUsuario->id=$id;
        $cantidadDeBorrados=$miUsuario->BorrarUsuario();
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
        $miUsuario = new Usuario();
        $nombre = $ArrayDeParametros['nombre'];
        $apellido = $ArrayDeParametros['apellido'];
        $clave = $ArrayDeParametros['clave'];
        $mail = $ArrayDeParametros['mail'];
        $puesto = $ArrayDeParametros['puesto'];
        $miUsuario->__construct1($nombre,$apellido,$clave,$mail,$puesto);
        $miUsuario->id=$ArrayDeParametros['id'];
        
        $resultado =$miUsuario->ModificarUsuarioParametros();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);		
    }
}

?>