<?php

require_once './models/pedido.php';
require_once 'IApiUsable.php';
/*require_once "./apis/empleadoApi.php";
require_once "./apis/clienteApi.php";
require_once "./apis/productoApi.php";
require_once "./apis/mesaApi.php";*/

use \App\Models\Pedido as Pedido;
use \App\Models\Empleado as Empleado;
use \App\Models\Cliente as Cliente;
use \App\Models\Mesa as Mesa;
use \App\Models\Producto as Producto;

class PedidoApi implements IApiUsable
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
        $idCliente = $parametros['idCliente'];
        $idMesa = $parametros['idMesa'];
        $idEmpleado = $parametros['idEmpleado'];
        $estado = 'en preparacion';
        $productos = json_decode($parametros['json_productos']);
        //$listaProductos = json_decode($productos);
        //var_dump($productos->Productos);
        if($parametros['puesto'] == 'cocina' || $parametros['puesto'] == 'bar' || $parametros['puesto'] == 'candybar')
        {
            $puesto = $parametros['puesto'];
        }else
        {
            $puesto = 'cocina';
        }
        
        //Checkeo
        $empleado = Empleado::where('id', '=', $idEmpleado)->first();
        $cliente = Cliente::where('id', '=', $idCliente)->first();
        $mesa = Mesa::where('id', '=', $idMesa)->first();
        if($empleado != null && $cliente != null && $mesa != null)
        {
            $total = 0;
            $checkeoProducto = true;
            foreach($productos->Productos as $prod)
            {
                $auxProd = Producto::where('id', $prod->id)->first();
                if($auxProd == null)
                {
                    $checkeoProducto = false;
                    break;
                }
                $total += $auxProd->precio * $prod->cantidad;
            }
            if($checkeoProducto)
            {
                // Creamos el pedido
                $ped = new Pedido();
                $ped->codigo = $codigo;
                $ped->id_cliente = $idCliente;
                $ped->id_mesa = $idMesa;
                $ped->id_empleado = $idEmpleado;
                $ped->estado = $estado;
                $ped->puesto = $puesto;
                $ped->fecha_hora_creacion = date("y-m-d H:i:s");
                $ped->ultima_modificacion = date("H:i:s");
                $ped->total = $total;
                $ped->save();
                $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
            }else
            {
                $payload = json_encode(array("mensaje" => "No hay stock o no existe el producto"));
            }
            
        }else
        {
            $payload = json_encode(array("mensaje" => "Datos erroneos"));
        }
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args) {
        $pedidoId = $args['id'];
        $pedido = Empleado::find($pedidoId);
        $pedido->delete();
        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
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
    
}

?>
