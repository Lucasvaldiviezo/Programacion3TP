<?php
require_once './clases/producto.php';
require_once 'IApiUsable.php';

class ProductoApi extends Producto implements IApiUsable
{
    public function TraerUno($request, $response, $args) {
        $tipo=$args['tipo'];
        $todosLosProductos=Producto::TraerProductosTipo($tipo);
        $newResponse = $response->withJson($todosLosProductos, 200);  
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosProductos=Producto::TraerTodosLosProductos();
        $newResponse = $response->withJson($todosLosProductos, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre = $ArrayDeParametros['nombre'];
        $precio = $ArrayDeParametros['precio'];
        $stock = $ArrayDeParametros['stock'];
        $tipo = $ArrayDeParametros['tipo'];
       
        $miProducto = new Producto();
        $miProducto->__construct1($nombre,$precio,$stock,$tipo);
        $miProducto->InsertarProductoParametros(); 
        $response->getBody()->write("se guardo el producto" . "\n");

        return $response;
    }

    public function BorrarUno($request, $response, $args) {
        $id=$args['id'];
        $miProducto= new Producto();
        $miProducto->id=$id;
        $cantidadDeBorrados=$miProducto->BorrarProducto();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        if($cantidadDeBorrados>0)
        {
            $objDelaRespuesta->resultado="Se borro el producto";
        }
        else
        {
            $objDelaRespuesta->resultado="No se borro el producto";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);  
        return $newResponse;
    }

   public function ModificarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();   	
        $miProducto = new Producto();
        $nombre = $ArrayDeParametros['nombre'];
        $precio = $ArrayDeParametros['precio'];
        $tipo = $ArrayDeParametros['tipo'];
        $stock = $ArrayDeParametros['stock'];
        $miProducto->__construct1($nombre,$precio,$stock,$tipo);
        $miProducto->id=$ArrayDeParametros['id'];
        
        $resultado =$miProducto->ModificarProductoParametros();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);		
    }

    
}

?>