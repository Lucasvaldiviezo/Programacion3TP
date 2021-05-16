<?php

require_once './clases/pedido.php';
require_once 'IApiUsable.php';

class PedidoApi extends Pedido implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $numero=$args['numero'];
        $elPedido=Pedido::TraerUnPedidoNumeroMesa($numero);
        $newResponse = $response->withJson($elPedido, 200);  
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosPedidos=Pedido::TraerTodosLosPedidos();
        $newResponse = $response->withJson($todosLosPedidos, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombreCliente = $ArrayDeParametros['nombreCliente'];
        $numeroMesa = $ArrayDeParametros['numeroMesa'];
        $nombreProducto = $ArrayDeParametros['nombreProducto'];
        $cantidad = $ArrayDeParametros['cantidad'];
        $estado = $ArrayDeParametros['estado'];
        $miPedido = new Pedido();
        $miPedido->__construct1($nombreCliente,$numeroMesa,$nombreProducto,$cantidad,$estado);
        $miPedido->InsertarPedidoParametros();
        
        $response->getBody()->write("se guardo el pedido" . "\n");

        return $response;
    }

    public function BorrarUno($request, $response, $args) {
        $id=$args['id'];
        $miPedido= new Pedido();
        $miPedido->id=$id;
        $cantidadDeBorrados=$miPedido->BorrarPedido();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        if($cantidadDeBorrados>0)
        {
            $objDelaRespuesta->resultado="Se borro el pedido";
        }
        else
        {
            $objDelaRespuesta->resultado="No se borro el pedido";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);  
        return $newResponse;
    }

    public function ModificarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();   	
        $miPedido = new Pedido();
        $nombreCliente = $ArrayDeParametros['nombreCliente'];
        $numeroMesa = $ArrayDeParametros['numeroMesa'];
        $nombreProducto = $ArrayDeParametros['nombreProducto'];
        $cantidad = $ArrayDeParametros['cantidad'];
        $estado = $ArrayDeParametros['estado'];
        $miPedido->__construct1($nombreCliente,$numeroMesa,$nombreProducto,$cantidad,$estado);
        $miPedido->id=$ArrayDeParametros['id'];
        
        $resultado =$miPedido->ModificarPedidoParametros();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);		
    }


    
}

?>
