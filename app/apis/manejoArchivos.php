<?php
require_once './models/empleado.php';
require_once './pdf/fpdf.php';

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
        
    }

    public function GuardarPDF($request,$response,$next,$tipo)
    {
        $bool = false;
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,15,ucfirst($tipo).'s',"0","1","C");
        switch($tipo)
        {
            case 'empleado':
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
            case 'cliente':
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
            case 'mesa':
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
            case 'producto':
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
            case 'pedido':
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
            case 'empleado':
                $lista = Empleado::all();
                $empleados = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/empleados.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($empleados,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de empleados"));
            break;
            case 'cliente':
                $lista = Cliente::all();
                $clientes = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/clientes.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($clientes,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de clientes"));
            break;
            case 'mesa':
                $lista = Mesa::all();
                $mesas = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/mesas.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($mesas,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de mesas"));
            break;
            case 'producto':
                $lista = Producto::all();
                $productos = json_encode(array("listaCompleta" => $lista));
                $archivo = fopen("./archivos/productos.csv","a");
                $bool = fwrite($archivo, $this->DatosToCSV($productos,$tipo));
                $payload = json_encode(array("mensaje" => "Se guardo el CSV de productos"));
            break;
            case 'pedido':
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
            case 'empleado':
                $cadena .= "- ID: " . $datos->id . ", Nombre: " . $datos->nombre . ", Apellido: " . $datos->apellido . ", Mail: " . $datos->mail . ", Clave: " . $datos->clave . ", Puesto: " . $datos->puesto;
            break;
            case 'cliente':
                    $cadena .= "- ID: " . $datos->id . ", Nombre: " . $datos->nombre . ", Apellido: " . $datos->apellido . ", Mail: " . $datos->mail . ", DNI: " . $datos->dni;
            break;
            case 'mesa':
                    $cadena .= "- ID: " . $datos->id . ", Numero: " . $datos->numero . ", Estado: " . $datos->estado;
            break;
            case 'producto':
                    $cadena .=  "- ID: " . $datos->id . ", Nombre: " . $datos->nombre . ", Precio: " . $datos->precio . "," . $datos->stock . ", Stock: " . $datos->tipo;
            break;
            case 'pedido':
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
            case 'empleado':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->nombre . "," . $dato->apellido . "," . $dato->mail . "," . $dato->clave . "," . $dato->puesto . "}" . ",\n";
                }
            break;
            case 'cliente':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->nombre . "," . $dato->apellido . "," . $dato->mail . "," . $dato->dni . "}" .",\n";
                }
            break;
            case 'mesa':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .= "{" . $dato->id . "," . $dato->numero . "," . $dato->estado . "}" . ",\n";
                }
            break;
            case 'producto':
                foreach($lista->listaCompleta as $dato)
                {
                    $cadena .=  "{" . $dato->id . "," . $dato->nombre . "," . $dato->precio . "," . $dato->stock . "," . $dato->tipo . "}" . ",\n";
                }
            break;
            case 'pedido':
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