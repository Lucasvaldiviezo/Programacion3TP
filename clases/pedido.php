<?php

class Pedido{
    public $id;
    public $codigo;
    public $nombreCliente;
    public $numeroMesa;
    public $nombreProducto;
    public $cantidad;
    public $estado;
    
    public function __construct()
    {

    }

    public function __construct1($nombreCliente,$numeroMesa,$nombreProducto,$cantidad,$estado)
    {
        $this->nombreCliente = $nombreCliente;
        $this->numeroMesa = $numeroMesa;
        $this->nombreProducto = $nombreProducto;
        $this->cantidad = $cantidad;
        $this->codigo = rand(10000,99999);
        if($estado == "")
        {
            $this->estado = "solicitado";
        }else
        {
            $this->estado = $estado;
        } 
    }

    public static function TraerTodosLosPedidos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,codigo as codigo, nombre_cliente as nombreCliente,numero_mesa as numeroMesa, nombre_producto as nombreProducto,cantidad as cantidad,estado as estado from pedidos");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}

    public static function TraerUnPedidoNumeroMesa($numeroMesa) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,codigo as codigo, nombre_cliente as nombreCliente,numero_mesa as numeroMesa, nombre_producto as nombreProducto,cantidad as cantidad,estado as estado from pedidos where numero_mesa = $numeroMesa");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('Pedido');
			return $usuarioBuscado;	
	}

    public static function TraerPedidosEstado($estado) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $estadoAux = '"' . $estado . '"'; 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,codigo as codigo, nombre_cliente as nombreCliente,numero_mesa as numeroMesa, nombre_producto as nombreProducto,cantidad as cantidad,estado as estado from pedidos where estado = $estadoAux");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");	
	}

    public function InsertarPedidoParametros()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedidos (codigo,nombre_cliente,numero_mesa,nombre_producto,cantidad,estado)values(:codigo,:nombreCliente,:numeroMesa,:nombreProducto,:cantidad,:estado)");
            $consulta->bindValue(':codigo',$this->codigo, PDO::PARAM_STR);
            $consulta->bindValue(':nombreCliente',$this->nombreCliente, PDO::PARAM_STR);
            $consulta->bindValue(':numeroMesa',$this->numeroMesa, PDO::PARAM_INT);
            $consulta->bindValue(':nombreProducto',$this->nombreProducto, PDO::PARAM_STR);
            $consulta->bindValue(':cantidad',$this->cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            return $consulta->execute();
    }

    public function BorrarPedido()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
		delete 
		from pedidos 				
		WHERE id=:id");	
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

    public function ModificarPedidoParametros()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update pedidos 
            set codigo = :codigo,
            nombre_cliente = :nombreCliente, 
            numero_mesa=:numeroMesa,
            nombre_producto=:nombreProducto,
            cantidad=:cantidad,
            estado=:estado
            WHERE id=:id");
        $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
        $consulta->bindValue(':codigo',$this->codigo, PDO::PARAM_STR);
        $consulta->bindValue(':nombreCliente',$this->nombreCliente, PDO::PARAM_STR);
        $consulta->bindValue(':numeroMesa',$this->numeroMesa, PDO::PARAM_INT);
        $consulta->bindValue(':nombreProducto', $this->nombreProducto, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        return $consulta->execute();
    }
}


?>