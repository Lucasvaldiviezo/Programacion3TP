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
        $puestos = explode(",",$parametros['puesto']);
        $puestoAux = "";
        foreach($puestos as $pues)
        {
            if($pues == 'cocina' || $pues == 'bar' || $pues == 'candybar')
            {
                $puestoAux .= "-" . $pues . "- ";
            }else
            {
                $puestoAux .= "-" . "cocina" . "- ";
            }
        } 
        //Checkeo
        $empleado = Empleado::where('id', '=', $idEmpleado)->first();
        $cliente = Cliente::where('id', '=', $idCliente)->first();
        $mesa = Mesa::where('id', '=', $idMesa)->first();
        if($empleado != null && $cliente != null && $mesa != null && $mesa->estado == "cerrada")
        {
            $total = 0;
            $datosProductos = "";
            $checkeoProducto = true;
            foreach($productos->Productos as $prod)
            {
                $auxProd = Producto::where('id', $prod->id)->first();
                if($auxProd != null && $auxProd->stock >= $prod->cantidad)
                {
                    $total += $auxProd->precio * $prod->cantidad;
                    $datosProductos = $datosProductos . "Id: " . $prod->id . " - Cantidad: " . $prod->cantidad . " / ";
                }else
                {
                    $checkeoProducto = false;
                    break;
                }
                
            }
            if($checkeoProducto)
            {
                $mesa->estado = "con cliente esperando pedido";
                $mesa->save();
                // Creamos el pedido
                $ped = new Pedido();
                $ped->codigo = $codigo;
                $ped->id_cliente = $idCliente;
                $ped->id_mesa = $idMesa;
                $ped->id_empleado = $idEmpleado;
                $ped->estado = $estado;
                $ped->puesto = $puestoAux;
                $ped->fecha_hora_creacion = date("y-m-d H:i:s");
                $ped->ultima_modificacion = date("H:i:s");
                $ped->total = "$" . $total;
                $ped->datos_productos = $datosProductos;
                $ped->save();
                $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

                //Descontamos el stock
                foreach($productos->Productos as $prod)
                {
                    $auxProd = Producto::where('id', $prod->id)->first();
                    if($auxProd != null)
                    {
                        $auxProd->stock = $auxProd->stock - $prod->cantidad;
                        $auxProd->save();
                    }
                
                }
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
        $pedido = Pedido::find($pedidoId);
        $pedido->delete();
        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $estado = $parametros['estado'];
        $pedidoId = $parametros['id'];   
        $pedido = Pedido::where('id', '=', $pedidoId)->first();
        //Checkeo
        if($pedido != null)
        {
            $mesa = Mesa::where('id',"=",$pedido->id_mesa)->first();
            if($estado == "listo para servir")
            {
                $pedido->puesto = "-mozo-";
                $pedido->estado = $estado;
                $pedido->ultima_modificacion = date("H:i:s");
                $pedido->save();
            }else if($estado == "servido")
            {
                $pedido->puesto = "-mesa-";
                $pedido->estado = $estado;
                $mesa->estado = "con cliente comiendo";
                $pedido->ultima_modificacion = date("H:i:s");
                $pedido->save();
                $mesa->save();
            }else if($estado == "pagando")
            {
                $pedido->puesto = "-mesa-";
                $pedido->estado = $estado;
                $mesa->estado = "con cliente pagando";
                $pedido->ultima_modificacion = date("H:i:s");
                $pedido->save();
                $mesa->save();
            }else if($estado == "pagado")
            {
                $pedido->puesto = "-mesa-";
                $pedido->estado = "pagado";
                $mesa->estado = "cerrada";
                $pedido->ultima_modificacion = date("H:i:s");
                $pedido->save();
                $mesa->save();
            }else
            {
                $pedido->puesto = "-mozo-";
                $pedido->estado = "por definir";
                $mesa->estado = "cerrada";
                $pedido->ultima_modificacion = date("H:i:s");
                $pedido->save();
                $mesa->save();
            }
            
            $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
            
        }else
        {
            $payload = json_encode(array("mensaje" => "No existe el pedido"));
        }
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');		
    }
    
}

?>
