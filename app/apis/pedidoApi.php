<?php

require_once './models/pedido.php';
require_once 'IApiUsable.php';
/*require_once "./apis/empleadoApi.php";
require_once "./apis/clienteApi.php";
require_once "./apis/productoApi.php";
require_once "./apis/mesaApi.php";*/

use \App\Models\Pedido as Pedido;

class PedidoApi extends Pedido implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $ped=$args['id'];
        $pedido = Pedido::where('id', $ped)->first();
        $payload = json_encode($pedido);
        $response->getBody()->write($payload);
        
        return $response
         ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $lista = Pedido::all();
        $payload = json_encode(array("listaPedido" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $cadena = '0123456789abcdefghijklmnopqrstuvwxyz';
        $codigo = substr(str_shuffle($cadena),0,5);
        $idCliente == $parametros['id_cliente'];
        $idMesa == $parametros['id_mesa'];
        $idEmpleado == $parametros['id_empleado'];
        $estado == 'en preparacion';
        if($parametros['puesto'] == 'cocina' || $parametros['puesto'] == 'bar' || $parametros['puesto'] == 'candybar')
        {
            $puesto = $parametros['puesto'];
        }else
        {
            $puesto = 'cocina';
        }
        $empleado = Empleado::where('id', '=', $idEmpleado)->first();
        $cliente = Cliente::where('id', '=', $idCliente)->first();
        $mesa = Cliente::where('id', '=', $idMesa)->first();
        if($empleado != null && $cliente != null && $mesa != null)
        {
            // Creamos el pedido
            $ped = new Pedido();
            $ped->codigo = $codigo;
            $ped->id_cliente = $idCliente;
            $ped->id_mesa = $idMesa;
            $ped->id_empleado = $idEmpleado;
            $ped->estado = $estado;
            $ped->puesto = $puesto;
            $ped->fecha_hora_creacion = 
            $ped->save();
            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
        }else
        {
            $payload = json_encode(array("mensaje" => "Datos erroneos"));
        }
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
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
        $id = $ArrayDeParametros['id'];
        $estado = $ArrayDeParametros['estado'];   	
        $miPedido = new Pedido();
        $miPedido = Pedido::TraerUnPedidoId($id);
        $miPedido->id=$id;
        $miPedido->estado = $estado;
        
        $resultado =$miPedido->ModificarEstadoParametros();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);		
    }

    /*public function ModificarUno($request, $response, $args) {
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
    }*/
    
}

?>
