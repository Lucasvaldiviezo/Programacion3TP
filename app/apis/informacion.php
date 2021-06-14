<?php
require_once './vendor/autoload.php';
require_once './apis/empleadoApi.php';
require_once './apis/productoApi.php';
require_once './apis/mesaApi.php';
require_once './apis/pedidoApi.php';
require_once './apis/clienteApi.php';
require_once './apis/manejoArchivos.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use \App\Models\Pedido as Pedido;
use \App\Models\Empleado as Empleado;
use \App\Models\Cliente as Cliente;
use \App\Models\Mesa as Mesa;
use \App\Models\Producto as Producto;
use \App\Models\Changelog as Changelog;


class Informacion
{
    public function Estadisticas($request, $response, $args) {
        $tipo=$args['tipo'];

        switch($tipo)
        {
            case 'pedidos':
                $contadorTotalMes = 0;
                $contadorTotalAño = 0;
                $contadorEntregadoTardeAño = 0;
                $contadorEntregadoTardeMes = 0;
                $contadorServidoTardeAño = 0;
                $contadorServidoTardeMes = 0;
                $fechaMes = date("Y-m");
                $fechaAño = date("Y");
                $lista = Pedido::all();
                $pedidos = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($pedidos->listaCompleta as $ped)
                {
                    if(str_contains($ped->fecha_hora_creacion,$fechaMes) && $ped->estado == "pagado")
                    {
                        $contadorTotalMes++;
                    }
                    if(str_contains($ped->fecha_hora_creacion,$fechaAño) && $ped->estado == "pagado")
                    {
                        $contadorTotalAño++;
                    }
                }
                $lista = Changelog::all();
                $changelogs = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($changelogs->listaCompleta as $log)
                {
                    $bool = str_contains($log->descripcion,"Entregado tarde");
                    if($bool != false && str_contains($log->fecha_hora,$fechaMes))
                    {
                        $contadorEntregadoTardeMes++;
                    }
                    if($bool != false && str_contains($log->fecha_hora,$fechaAño))
                    {
                        $contadorEntregadoTardeAño++;
                    }
                    $bool2 = str_contains($log->descripcion,"Servido tarde");
                    if($bool2 != false && str_contains($log->fecha_hora,$fechaMes))
                    {
                        $contadorServidoTardeMes++;
                    }if($bool2 != false && str_contains($log->fecha_hora,$fechaAño))
                    {
                        $contadorServidoTardeAño++;
                    }
                }
                echo "Pedidos del Mes $fechaMes: \n";
                echo "-Cantidad de Pedidos completados este mes: " . $contadorTotalMes . "\n" . "-Cantidad de Pedidos preparados tarde este mes: " . $contadorEntregadoTardeMes . "\n" . "-Cantidad de pedidos servidos tarde este mes: " . $contadorServidoTardeMes; 
                echo "\n\nPedidos del Año $fechaAño: \n";
                echo "-Cantidad de Pedidos completados este año: " . $contadorTotalAño . "\n" . "-Cantidad de Pedidos preparados tarde este año: " . $contadorEntregadoTardeAño . "\n" . "-Cantidad de pedidos servidos tarde este año: " . $contadorServidoTardeAño; 
            break;
            case 'mesas':
                $noHayMesas = 0;
                $noHayMesas2 = 0;
                $todasLasMesasAño = [];
                $todasLasMesasMes = [];
                $fechaMes = date("Y-m");
                $fechaAño = date("Y");
                $lista = Pedido::all();
                $pedidos = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($pedidos->listaCompleta as $ped)
                {
                    $mesaAñoExists = str_contains($ped->fecha_hora_creacion,$fechaAño);
                    $mesaMesExists = str_contains($ped->fecha_hora_creacion,$fechaMes);
                    if($mesaAñoExists != false)
                    {
                        if(!array_key_exists($ped->id_mesa,$todasLasMesasAño))
                        {
                            $todasLasMesasAño[$ped->id_mesa] = 1;
                            $noHayMesas++;
                        }
                        else
                        {
                            $todasLasMesasAño[$ped->id_mesa]++;
                            $noHayMesas++;
                        }
                    }
                    if($mesaMesExists != false)
                    {
                        if(!array_key_exists($ped->id_mesa,$todasLasMesasMes))
                        {
                            $todasLasMesasMes[$ped->id_mesa] = 1;
                            $noHayMesas2++;
                        }
                        else
                        {
                            $todasLasMesasMes[$ped->id_mesa]++;
                            $noHayMesas2++;
                        }
                    }
                    
                }
                if($noHayMesas > 0)
                {
                    echo " -Mesas por Año: \n";
                    ksort($todasLasMesasAño);
                    foreach($todasLasMesasAño as $mesa => $cantMesa)
                    {
                        echo 'La Mesa ' . $mesa .' se uso ' . $cantMesa . " veces este año $fechaAño \n";
                    }
                }else
                {
                    echo "Este año $fechaAño no se uso ninguna mesa";
                }

                if($noHayMesas2 > 0)
                {
                    echo "\n -Mesas por Mes: \n";
                    ksort($todasLasMesasMes);
                    foreach($todasLasMesasMes as $mesa => $cantMesa)
                    {
                        echo 'La Mesa ' . $mesa .' se uso ' . $cantMesa . " veces este mes $fechaMes \n";
                    }
                }else
                {
                    echo "Este mes $fechaMes no se uso ninguna mesa";
                }
                
            break;
            case 'clientes':
                $fechaMes = date("Y-m");
                $fechaAño = date("Y");
                $noHayClientes = 0;
                $noHayClientes2 = 0;
                $clientesAño = [];
                $clientesMes = [];
                $lista = Pedido::all();
                $pedidos = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($pedidos->listaCompleta as $ped)
                {
                    $bool = str_contains($ped->estado,"pagado");
                    if($bool != false && str_contains($ped->fecha_hora_creacion,$fechaMes))
                    {
                        if(!array_key_exists($ped->id_cliente,$clientesMes))
                        {
                            $clientesMes[$ped->id_cliente] = 1;
                            $noHayClientes++;
                        }else
                        {
                            
                            $clientesMes[$ped->id_cliente]++;
                            $noHayClientes++;
                        }  
                    }
                    if($bool != false && str_contains($ped->fecha_hora_creacion,$fechaAño))
                    {
                        if(!array_key_exists($ped->id_cliente,$clientesAño))
                        {
                            $clientesAño[$ped->id_cliente] = 1;
                            $noHayClientes2++;
                        }
                        else
                        {
                            $clientesAño[$ped->id_cliente]++;
                            $noHayClientes2++;
                        }
                    }   
                }

                if($noHayClientes > 0)
                {
                    echo " -Clientes por Mes: \n";
                    ksort($clientesMes);
                    foreach($clientesMes as $cliente => $cantCliente)
                    {
                        echo 'El cliente ' . $cliente .' consumio en el local ' . $cantCliente . " veces este mes $fechaMes \n";
                    }
                }else
                {
                    echo "Este mes $fechaMes no consumio ningun cliente";
                }

                if($noHayClientes2 > 0)
                {
                    echo "\n -Clientes por Año: \n";
                    ksort($clientesAño);
                    foreach($clientesAño as $cliente => $cantCliente)
                    {
                        echo 'El cliente ' . $cliente .' consumio en el local ' . $cantCliente . " veces este año $fechaAño \n";
                    }
                }else
                {
                    echo "Este año $fechaAño no consumio ningun cliente";
                }
            break;
            case 'productos':
            break;
        }
    }

}

?>