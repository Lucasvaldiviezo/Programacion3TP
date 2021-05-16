<?php
require_once './clases/mesa.php';
require_once 'IApiUsable.php';

class MesaApi extends Mesa implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $numero=$args['numero'];
        $laMesa=Mesa::TraerUnaMesaNumero($numero);
        //$response->getBody()->write("Por GET ->" . "\n"); 
        $newResponse = $response->withJson($laMesa, 200); 
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todasLasMesas=Mesa::TraerTodasLasMesas();
        $mensajes[] = array("mensaje"=>"API=>GET");
        $resultado = array_merge($mensajes,$todasLasMesas,);
        $newResponse = $response->withJson($resultado, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $numero = $ArrayDeParametros['numero'];
        $estado = $ArrayDeParametros['estado'];
        $miMesa = new Mesa();
        $miMesa->__construct1($numero,$estado);
        $miMesa->InsertarMesaParametros();
        $response->getBody()->write("se guardo la mesa" . "\n");
        $resultado = array("mensaje"=>"API=>POST");
        $newResponse = $response->withJson($resultado,200);
        return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
        $id=$args['id'];
        $miMesa= new Mesa();
        $miMesa->id=$id;
        $cantidadDeBorrados=$miMesa->BorrarMesa();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        if($cantidadDeBorrados>0)
        {
            $objDelaRespuesta->resultado="Se borro la mesa";
        }
        else
        {
            $objDelaRespuesta->resultado="No se borro la Mesa";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);  
        return $newResponse;
    }

   public function ModificarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();   	
        $miMesa = new Mesa();
        $numero = $ArrayDeParametros['numero'];
        $estado = $ArrayDeParametros['estado'];
        $miMesa->__construct1($numero,$estado);
        $miMesa->id=$ArrayDeParametros['id'];
        
        $resultado =$miMesa->ModificarMesaParametros();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);		
    }

}

?>