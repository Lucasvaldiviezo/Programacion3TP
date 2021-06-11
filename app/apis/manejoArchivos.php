<?php

use \App\Models\Pedido as Pedido;
use \App\Models\Empleado as Empleado;
use \App\Models\Cliente as Cliente;
use \App\Models\Mesa as Mesa;
use \App\Models\Producto as Producto;

class ManejoArchivos
{

    public function GuardarDatos($request, $response, $next)
    {
        $parametros = $request->getParsedBody();
        $tipo=$parametros['tipo'];
        switch($tipo)
        {
            case 'empleado':
                $empleados = Empleados::all();
                $archivo = fopen("empleados.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($empleados,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el archivo de empleados"));
            break;
            case 'cliente':
                $clientes = Cliente::all();
                $archivo = fopen("clientes.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($clientes,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el archivo de clientes"));
            break;
            case 'mesa':
                $mesas = Mesa::all();
                $archivo = fopen("mesas.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($mesas,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el archivo de mesas"));
            break;
            case 'producto':
                $productos = Producto::all();
                $archivo = fopen("productos.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($productos,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el archivo de productos"));
            break;
            default:
                $pedidos = Pedido::all();
                $archivo = fopen("pedidos.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($pedidos,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el archivo de pedidos"));
            break;
        }
        fclose($archivo);

        if($bool == false)
        {
            $payload = json_encode(array("mensaje" => "No se guardo el archivo"));
        }

        $response->getBody()->write($payload);
        return $bool;
    }

    public function DatosToCSV($datos,$tipo)
    {
        switch($tipo)
        {
            case 'empleado':
                $cadena =  $this->id . "," . $this->nombre . "," . $this->apellido . "," . $this->mail . "," . $this->clave . "," . $this->puesto . ",\n";
            break;
            case 'cliente':
                $cadena =  $this->id . "," . $this->nombre . "," . $this->apellido . "," . $this->mail . "," . $this->dni . ",\n";
            break;
            case 'mesa':
                $cadena =  $this->id . "," . $this->numero . "," . $this->estado . ",\n";
            break;
            case 'producto':
                $cadena =  $this->id . "," . $this->nombre . "," . $this->precio . "," . $this->stock . "," . $this->tipo . ",\n";
            break;
            default:
                $cadena =  $this->id . "," . $this->codigo . "," . $this->id_cliente . "," . $this->id_mesa . "," . $this->datos_productos . "," . $this->id_empleado . $this->estado . $this->total . ",";
                $cadena .= $this->puesto . "," . $this->fecha_hora_creacion . "," . $this->ultima_modificacion . ",\n";
            break;
        }

        return $cadena;  
    }

}
?>