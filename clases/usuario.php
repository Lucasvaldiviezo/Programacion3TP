<?php

class Usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $puesto;

    public function __construct()
    {

    }

    public function __construct1($nombre,$apellido,$clave,$mail,$puesto)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->clave = $clave;
        $this->mail = $mail;
        $this->puesto = $puesto;
    }

    public static function TraerTodoLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as clave,mail as mail,puesto as puesto from usuarios");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

    public static function TraerUnUsuarioId($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as clave,mail as mail,puesto as puesto from usuarios where id = $id");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('Usuario');
			return $usuarioBuscado;	
	}

    public static function TraerUsuariosPuesto($puesto) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $puestoAux = '"' . $puesto . '"'; 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre as nombre, apellido as apellido,clave as clave,mail as mail,puesto as puesto from usuarios where puesto = $puestoAux");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");	
	}

    public function InsertarUsuarioParametros()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre,apellido,clave,mail,puesto)values(:nombre,:apellido,:clave,:mail,:puesto)");
            $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
            $consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_STR);
            return $consulta->execute();
    }

    public function BorrarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
		delete 
		from usuarios 				
		WHERE id=:id");	
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

    public function ModificarUsuarioParametros()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update usuarios 
            set nombre=:nombre,
            apellido=:apellido,
            clave=:clave,
            mail=:mail,
            puesto=:puesto
            WHERE id=:id");
        $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_STR);	
        return $consulta->execute();
    }
}


?>