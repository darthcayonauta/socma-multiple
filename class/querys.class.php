<?php
/**
* @author  Claudio Guzman Herrera
* @version 1.0
*/
class querys
{
	private $fecha_hoy;
	private $fecha_hora_hoy;
	private $error;

	function __construct($sql=null)
	{
		# code...
		if ( !is_null( $sql ) ){
			$this->sql   = $sql;
			$this->error = "Modulo no definido";
		}

		else{

			$oConf     = new config();
		  $cfg       = $oConf->getConfig();
		  $this->sql = new mysqldb( $cfg['base']['dbhost'],
				 					$cfg['base']['dbuser'],
									$cfg['base']['dbpass'],
									$cfg['base']['dbdata'] );

		$this->error = $cfg['base']['error'];
		}

		$this->fecha_hoy 		=  date("Y-m-d");
		$this->fecha_hora_hoy 	=  date("Y-m-d H:i:s");

	}

public function login($email = null, $clave = null)
{
	$ssql = "SELECT * FROM usuario WHERE email='{$email}' AND
					clave=password('{$clave}') and id_estado=1"  ;

	$arr['sql'] 	= $ssql;
	$arr['process'] = $this->sql->select( $ssql );
	$arr['total-recs'] = count( $arr['process'] );

	return $arr;
	}

	public function menu( $tipo_usuario = null )
	{
		$ssql = "SELECT * FROM menu WHERE tipo_usuario = {$tipo_usuario} ORDER BY orden";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function sub_menu( $id_menu = null )
	{
		$ssql = "SELECT * FROM sub_menu WHERE id_menu = {$id_menu}";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function ingresaAccesos( $id_usuario   = null,
									$sesion       = null,
									$ip           = null )
	{

		$INSERT = "INSERT INTO accesos( id_usuario,fecha, sesion ,ip ) VALUES
				 ('{$id_usuario}' ,'$this->fecha_hora_hoy' ,'{$sesion}' ,'{$ip}' )";

		if( $this->sql->insert( $INSERT ) )
				return true;
		else 	return false;
	}


	public function afirmacion( $id = null )
	{
		$resto = null;
		if($id)
			$resto = " WHERE id={$id}";

		$ssql = "SELECT * FROM afirmacion {$resto}";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function tipoVehiculo( $id = null )
	{
		$resto = null;
		if($id)
			$resto = " WHERE id={$id}";

		$ssql = "SELECT * FROM tipo_vehiculo {$resto}";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function tipoTransmision( $id = null )
	{
		$resto = null;
		if($id)
			$resto = " WHERE id={$id}";

		$ssql = "SELECT * FROM tipo_transmision {$resto}";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function procesaVehiculo( $marca         = null,
									 $modelo        = null,
									 $year          = null,
									 $patente       = null,
									 $tipo_vehiculo = null,
									 $transmision   = null,									 
									 $id            = null )
	{
		if( $id ){
			$update = "";
			if( $this->sql->update( $update ) )
					return true;
			else 	return false;			
		}else{
			$insert = "INSERT INTO vehiculo(marca,modelo,year,patente,tipo_vehiculo,transmision,id_estado) VALUES 
			          ('{$marca}','{$modelo}',{$year},'{$patente}',{$tipo_vehiculo},{$transmision},1)
			";
			if( $this->sql->insert( $insert ) )
					return true;
			else 	return false;	
		}
	}
	
	public function vehiculo( $id = null )
	{
		$resto = null;
		if($id)
			$resto = " AND vehiculo.id={$id}";

		$ssql = "SELECT
						vehiculo.id            ,
						vehiculo.marca         ,
						vehiculo.modelo        ,
						vehiculo.year          ,
						vehiculo.patente       ,
						vehiculo.tipo_vehiculo ,
						vehiculo.transmision   ,
						vehiculo.id_estado     ,
						estado.descripcion AS estadoVehiculo,
						tipo_transmision.descripcion AS nombreTransmision,
						tipo_vehiculo.descripcion as nombreTipoVehiculo
				FROM 
					vehiculo
					INNER JOIN estado ON (estado.id = vehiculo.id_estado)
					INNER JOIN tipo_transmision ON (tipo_transmision.id=vehiculo.transmision)
					INNER JOIN tipo_vehiculo ON (tipo_vehiculo.id=vehiculo.tipo_vehiculo)
					WHERE vehiculo.id_estado = 1	
			{$resto}";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function elimina( $tabla = null, $id=null ){
		$update = "UPDATE {$tabla} SET id_estado=2 WHERE id={$id}";

		if( $this->sql->update( $update) )
				return true;
		else 	return false;

	}
}//fin de clase
?>
