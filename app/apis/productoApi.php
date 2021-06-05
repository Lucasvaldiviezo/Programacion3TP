<?php
require_once './clases/producto.php';
require_once 'IApiUsable.php';

use \App\Models\Producto as Producto;

class ProductoApi implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $prod=$args['id'];
        $producto = Producto::where('id', $prod)->first();
        $payload = json_encode($producto);
        $response->getBody()->write($payload);
        
        return $response
         ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args) {
        $lista = Producto::all();
        $payload = json_encode(array("listaProducto" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $stock = $parametros['stock'];
        $tipo = $parametros['tipo'];
        // Creamos el producto
        $prod = new Producto();
        $prod->nombre = $nombre;
        $prod->precio = $precio;
        $prod->tipo = $tipo;
        $prod->stock = $stock;
        $prod->save();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args) {
        $productoId = $args['id'];
        $producto = Producto::find($productoId);
        $producto->delete();
        $payload = json_encode(array("mensaje" => "Producto borrado con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

   public function ModificarUno($request, $response, $args) {
    $parametros = $request->getParsedBody();
    $nombreModificado = $parametros['nombre'];
    $tipoModificado = $parametros['tipo'];
    $precioModificado = $parametros['precio'];
    $stockModificado = $parametros['stock'];
    $prodId = $parametros['id'];

    // Conseguimos el objeto
    $producto = Producto::where('id', '=', $prodId)->first();

    // Si existe
    if ($producto !== null) {
        $producto->nombre = $nombreModificado;
        $producto->stock = $stockModificado;
        $producto->precio = $precioModificado;
        $producto->tipo = $tipoModificado;
        $producto->save();
        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
        
    } else {
    $payload = json_encode(array("mensaje" => "Producto no encontrado"));
    }

    $response->getBody()->write($payload);
    return $response
    ->withHeader('Content-Type', 'application/json');	
    }

    
}

?>