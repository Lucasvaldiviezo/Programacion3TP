<?php
require_once './models/empleado.php';
require_once './pdf/fpdf.php';
require_once 'changelogApi.php';
require_once "./MWClases/AutentificadorJWT.php";

use \App\Models\Pedido as Pedido;
use \App\Models\Empleado as Empleado;
use \App\Models\Cliente as Cliente;
use \App\Models\Mesa as Mesa;
use \App\Models\Producto as Producto;
use \App\Models\Changelog as Changelog;

class ManejoArchivos
{

    public function GuardarDatos($request, $response, $next)
    {
        $parametros = $request->getParsedBody();
        $tipo=$parametros['tipo'];
        $formato=$parametros['formato'];
        if($formato == 'csv')
        {
            $bool = $this->GuardarCSV($request,$response,$next,$tipo);
        }else if($formato == 'pdf')
        {
            $bool = $this->GuardarPDF($request,$response,$next,$tipo);
        }
        
        //Obtengo el empleado
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $data = AutentificadorJWT::ObtenerData($token);
        $empleado = Empleado::where('mail', '=', $data->usuario)->first();
        //Log
        ChangelogApi::CrearLog($tipo,0,$empleado->id,"Guardar Archivo","Se descargaron los datos de la DB en formato $formato");
        return $bool;
    }

    public static function LeerCSV($request, $response, $args)
    {
        $tipo=$args['tipo'];
        $bool = false;
        //Obtengo el empleado
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $data = AutentificadorJWT::ObtenerData($token);
        $empleado = Empleado::where('mail', '=', $data->usuario)->first();
        switch($tipo)
        {
            case 'empleados':
                $ruta = "./archivos/empleados.csv";
                $archivo = fopen($ruta,"r");
                while(!feof($archivo))
                {
                    $linea = fgets($archivo);
                    if(!empty($linea))
                    {
                        $datos = preg_split("/({|,|})/",$linea,-1, PREG_SPLIT_NO_EMPTY);
                        $nombre = $datos[1];
                        $apellido = $datos[2];
                        $mail = $datos[3];
                        $clave = $datos[4];
                        $puesto = $datos[5];
                        $empleado = new Empleado();
                        $empleado->nombre = $nombre;
                        $empleado->apellido = $apellido;
                        $empleado->mail = $mail;
                        $empleado->clave = $clave;
                        $empleado->puesto = $puesto;
                        $empleado->save();
                    }
                }
                $payload = json_encode(array("mensaje" => "Se cargo los datos de empleados en la DB"));  
            break;
            case 'clientes':
                $ruta = "./archivos/clientes.csv";
                $archivo = fopen($ruta,"r");
                while(!feof($archivo))
                {
                    $linea = fgets($archivo);
                    if(!empty($linea))
                    {
                        $datos = preg_split("/({|,|})/",$linea,-1, PREG_SPLIT_NO_EMPTY);
                        $nombre = $datos[1];
                        $apellido = $datos[2];
                        $mail = $datos[3];
                        $dni = $dni[4];
                        $cliente = new Cliente();
                        $cliente->nombre = $nombre;
                        $cliente->apellido = $apellido;
                        $cliente->mail = $mail;
                        $cliente->dni = $dni;
                        $cliente->save();
                    }
                }
                $payload = json_encode(array("mensaje" => "Se cargo los datos de clientes en la DB"));  
            break;
            case 'mesas':
                $ruta = "./archivos/mesas.csv";
                $archivo = fopen($ruta,"r");
                while(!feof($archivo))
                {
                    $linea = fgets($archivo);
                    if(!empty($linea))
                    {
                        $datos = preg_split("/({|,|})/",$linea,-1, PREG_SPLIT_NO_EMPTY);
                        $numero = $datos[1];
                        $estado = $datos[2];
                        $mesa = new Mesa();
                        $mesa->numero = $numero;
                        $mesa->estado = $estado;
                        $mesa->save();
                    }
                }
                $payload = json_encode(array("mensaje" => "Se cargo los datos de mesas en la DB"));  
            break;
            case 'pedidos':
                $ruta = "./archivos/pedidos.csv";
                $archivo = fopen($ruta,"r");
                while(!feof($archivo))
                {
                    $linea = fgets($archivo);
                    if(!empty($linea))
                    {
                        $datos = preg_split("/({|,|})/",$linea,-1, PREG_SPLIT_NO_EMPTY);
                        $codigo = $datos[1];
                        $idCliente = $datos[2];
                        $idMesa = $datos[3];
                        $datosProductos = $datos[4];
                        $idEmpleado = $datos[5];
                        $estado = $datos[6];
                        $total = $datos[7];
                        $puesto = $datos[8];
                        $fechaHora = $datos[9];
                        $ultimaModificacion = $datos[10];
                        $pedido = new Pedido();
                        $pedido->codigo = $codigo;
                        $pedido->id_cliente = $idCliente;
                        $pedido->id_mesa = $idMesa;
                        $pedido->datos_productos = $datosProductos;
                        $pedido->id_empleado = $idEmpleado;
                        $pedido->estado = $estado;
                        $pedido->total = $total;
                        $pedido->puesto = $puesto;
                        $pedido->fecha_hora_creacion = $fechaHora;
                        $pedido->ultima_modificacion = $ultimaModificacion;
                        $pedido->save();
                    }
                }
                $payload = json_encode(array("mensaje" => "Se cargo los datos de pedidos en la DB"));  
            break;
            case 'productos':
                $ruta = "./archivos/productos.csv";
                $archivo = fopen($ruta,"r");
                while(!feof($archivo))
                {
                    $linea = fgets($archivo);
                    if(!empty($linea))
                    {
                        $datos = preg_split("/({|,|})/",$linea,-1, PREG_SPLIT_NO_EMPTY);
                        $nombre = $datos[1];
                        $precio = $datos[2];
                        $stock = $datos[3];
                        $tipo = $datos[4];
                        $producto = new Producto();
                        $producto->nombre = $nombre;
                        $producto->precio = $precio;
                        $producto->stock = $stock;
                        $producto->tipo = $tipo;
                        $producto->save();
                    }
                }
            break;
            default:
                $ruta = "./archivos/changeLog.csv";
                $archivo = fopen($ruta,"r");
                while(!feof($archivo))
                {
                    $linea = fgets($archivo);
                    if(!empty($linea))
                    {
                        $datos = preg_split("/({|,|})/",$linea,-1, PREG_SPLIT_NO_EMPTY);
                        $tablaAfectada = $datos[1];
                        $idAfectado = $datos[2];
                        $idEmpleado = $datos[3];
                        $accion = $datos[4];
                        $descripcion = $datos[5];
                        $fechaHora = $datos[6];
                        $changeLog = new Changelog();
                        $changeLog->taba_afectada = $tablaAfectada;
                        $changeLog->id_afectado = $idAfectado;
                        $changeLog->id_emplado = $idEmpleado;
                        $changeLog->accion = $accion;
                        $changeLog->descripcion = $descripcion;
                        $changeLog->fecha_hora = $fechaHora;
                        $changeLog->save();
                    }
                }        
        }
        fclose($archivo);
        //Log
        ChangelogApi::CrearLog($tipo,0,$empleado->id,"Carga Archivo","Se cargo en la DB los datos de un archivo CSV");
        $response->getBody()->write($payload);
        return $bool;
    }

    public function GuardarPDF($request,$response,$next,$tipo)
    {
        $bool = false;
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,15,ucfirst($tipo),"0","1","C");
        switch($tipo)
        {
            case 'empleados':
                $lista = Empleado::all();
                $empleados = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($empleados->listaCompleta as $emp)
                {
                    $pdf->SetFont('Arial','',10);
                    $datos = $this->DatosToPDF($emp,$tipo);
                    $datos = iconv('UTF-8', 'windows-1252', $datos);
                    $pdf->MultiCell(0,4,$datos,"0","L");
                    $pdf->Ln(1);
                }
                
                $payload = json_encode(array("mensaje" => "Se guardo el PDF de empleados"));
            break;
            case 'clientes':
                $lista = Cliente::all();
                $clientes = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($clientes->listaCompleta as $cli)
                {
                    $pdf->SetFont('Arial','',10);
                    $datos = $this->DatosToPDF($cli,$tipo);
                    $datos = iconv('UTF-8', 'windows-1252', $datos);
                    $pdf->MultiCell(0,4,$datos,"0","L");
                    $pdf->Ln(1);
                }
                $payload = json_encode(array("mensaje" => "Se guardo el PDF de clientes"));
            break;
            case 'mesas':
                $lista = Mesa::all();
                $mesas = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($mesas->listaCompleta as $mes)
                {
                    $pdf->SetFont('Arial','',10);
                    $datos = $this->DatosToPDF($mes,$tipo);
                    $datos = iconv('UTF-8', 'windows-1252', $datos);
                    $pdf->MultiCell(0,4,$datos,"0","L");
                    $pdf->Ln(1);
                }
                $payload = json_encode(array("mensaje" => "Se guardo el PDF de mesas"));
            break;
            case 'productos':
                $lista = Producto::all();
                $productos = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($productos->listaCompleta as $prod)
                {
                    $pdf->SetFont('Arial','',10);
                    $datos = $this->DatosToPDF($prod,$tipo);
                    $datos = iconv('UTF-8', 'windows-1252', $datos);
                    $pdf->MultiCell(0,6,$datos,"0","L");
                    $pdf->Ln(1);
                }
                $payload = json_encode(array("mensaje" => "Se guardo el PDF de productos"));
            break;
            case 'pedidos':
                $lista = Pedido::all();
                $pedidos = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($pedidos->listaCompleta as $ped)
                {
                    $pdf->SetFont('Arial','',10);
                    $datos = $this->DatosToPDF($ped,$tipo);
                    $datos = iconv('UTF-8', 'windows-1252', $datos);
                    $pdf->MultiCell(0,4,$datos,"0","L");
                    $pdf->Ln(1);
                }
                $payload = json_encode(array("mensaje" => "Se guardo el PDF de pedidos"));
            break;
            default:
                $lista = Changelog::all();
                $changeLogs = json_decode(json_encode(array("listaCompleta" => $lista)));
                foreach($changeLogs->listaCompleta as $change)
                {
                    $pdf->SetFont('Arial','',10);
                    $datos = $this->DatosToPDF($change,$tipo);
                    $datos = iconv('UTF-8', 'windows-1252', $datos);
                    $pdf->MultiCell(0,4,$datos,"0","L");
                    $pdf->Ln(1);
                }
                $payload = json_encode(array("mensaje" => "Se guardo el PDF de logs"));
        }
        if($datos != null)
        {
            $pdf->Output('F',"./archivos/" . $tipo.'.pdf',true);
            $bool = true;
        }else
        {
            $payload = json_encode(array("mensaje" => "No se guardo el PDF"));
        }
        
        $response->getBody()->write($payload);
        return $bool;
    }

    public function GuardarCSV($request,$response,$next,$tipo)
    {
        switch($tipo)
        {
            case 'empleados':
                $lista = Empleado::all();
                $empleados = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/empleados.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($empleados,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de empleados"));
            break;
            case 'clientes':
                $lista = Cliente::all();
                $clientes = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/clientes.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($clientes,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de clientes"));
            break;
            case 'mesas':
                $lista = Mesa::all();
                $mesas = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/mesas.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($mesas,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de mesas"));
            break;
            case 'productos':
                $lista = Producto::all();
                $productos = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/productos.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($productos,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de productos"));
            break;
            case 'pedidos':
                $lista = Pedido::all();
                $pedidos = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/pedidos.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($pedidos,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de pedidos"));
            break;
            default:
                $lista = Changelog::all();
                $changeLogs = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/changelogs.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($changeLogs,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de logs"));
        }
        fclose($archivo);

        if($bool == false)
        {
            $payload = json_encode(array("mensaje" => "No se guardo el archivo"));
        }

        $response->getBody()->write($payload);
        return $bool;
    }

    public function DatosToPDF($datos,$tipo)
    {
        $cadena = "";
        switch($tipo)
        {
            case 'empleados':
                $cadena .= "- ID: " . $datos->id . ", Nombre: " . $datos->nombre . ", Apellido: " . $datos->apellido . ", Mail: " . $datos->mail . ", Clave: " . $datos->clave . ", Puesto: " . $datos->puesto;
            break;
            case 'clientes':
                    $cadena .= "- ID: " . $datos->id . ", Nombre: " . $datos->nombre . ", Apellido: " . $datos->apellido . ", Mail: " . $datos->mail . ", DNI: " . $datos->dni;
            break;
            case 'mesas':
                    $cadena .= "- ID: " . $datos->id . ", Numero: " . $datos->numero . ", Estado: " . $datos->estado;
            break;
            case 'productos':
                    $cadena .=  "- ID: " . $datos->id . ", Nombre: " . $datos->nombre . ", Precio: " . $datos->precio . "," . $datos->stock . ", Stock: " . $datos->tipo;
            break;
            case 'pedidos':
                    $cadena .= "- ID: " . $datos->id . ", Codigo: " . $datos->codigo . ", ID Cliente: " . $datos->id_cliente . ", ID Mesa: " . $datos->id_mesa . ", Datos Productos: " . $datos->datos_productos . ", ID Empleado: " . $datos->id_empleado . ", Estado: " .$datos->estado . ", Total: " . $datos->total . ", Puesto: ";
                    $cadena .= $datos->puesto . ", Fecha y Hora: " . $datos->fecha_hora_creacion . ", Ultima Modificacion:" . $datos->ultima_modificacion;
            break;
            default:
                    $cadena .= "- ID: " . $datos->id . ", Tabla Afectada: " . $datos->tabla_afectada . ", ID Afectado: " . $datos->id_afectado . ", ID Empleado: " . $datos->id_empleado . ", Accion: " . $datos->accion . ", Descripcion: " . $datos->descripcion . ", Fecha y Hora: " . $datos->fecha_hora;
        }

        return $cadena;  
    }
    public function DatosToCSV($datos,$tipo)
    {
        $lista = json_decode($datos);
        $cadena = "";
        switch($tipo)
        {
            case 'empleados':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->nombre . "," . $dato->apellido . "," . $dato->mail . "," . $dato->clave . "," . $dato->puesto . "}" . ",\n";
                }
            break;
            case 'clientes':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->nombre . "," . $dato->apellido . "," . $dato->mail . "," . $dato->dni . "}" .",\n";
                }
            break;
            case 'mesas':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->numero . "," . $dato->estado . "}" . ",\n";
                }
            break;
            case 'productos':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .=  "{" . $dato->id . "," . $dato->nombre . "," . $dato->precio . "," . $dato->stock . "," . $dato->tipo . "}" . ",\n";
                }
            break;
            case 'pedidos':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->codigo . "," . $dato->id_cliente . "," . $dato->id_mesa . "," . $dato->datos_productos . "," . $dato->id_empleado . "," .$dato->estado . "," . $dato->total . ",";
                    $cadena .= $dato->puesto . "," . $dato->fecha_hora_creacion . "," . $dato->ultima_modificacion . "}" . ",\n";
                }
            break;
            default:
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->tabla_afectada . "," . $dato->id_afectado . "," . $dato->id_empleado . "," . $dato->accion . "," . $dato->descripcion . "," . $dato->fecha_hora . "}" . ",\n";
                }
        }

        return $cadena;  
    }

}
?>