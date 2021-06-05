<?php
require_once './models/cliente.php';
require_once 'IApiUsable.php';

use \App\Models\Cliente as Cliente;

class ClienteApi implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $cli=$args['id'];
        $cliente = Cliente::where('id', $cli)->first();
        $payload = json_encode($cliente);
        $response->getBody()->write($payload);
        
        return $response
         ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $lista = Cliente::all();
        $payload = json_encode(array("listaCliente" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $dni = $parametros['dni'];
        $mail = $parametros['mail'];
        // Creamos el cliente
        $cli = new Cliente();
        $cli->nombre = $nombre;
        $cli->apellido = $apellido;
        $cli->mail = $mail;
        $cli->dni = $dni;
        $cli->save();

        $payload = json_encode(array("mensaje" => "Cliente creado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args) {
        $clienteId = $args['id'];
        $cliente = Cliente::find($clienteId);
        $cliente->delete();
        $payload = json_encode(array("mensaje" => "Cliente borrado con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $nombreModificado = $parametros['nombre'];
        $apellidoModificado = $parametros['apellido'];
        $mailModificado = $parametros['mail'];
        $dniModificado = $parametros['dni'];
        $cliId = $parametros['id'];

        // Conseguimos el objeto
        $cli = Cliente::where('id', '=', $cliId)->first();

        // Si existe
        if ($cli !== null) {
            $cli->nombre = $nombreModificado;
            $cli->apellido = $apellidoModificado;
            $cli->mail = $mailModificado;
            $cli->dni = $dniModificado;
            $cli->save();
            $payload = json_encode(array("mensaje" => "Cliente modificado con exito"));
            
        } else {
        $payload = json_encode(array("mensaje" => "Cliente no encontrado"));
        }

        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');	
    }
}

?>