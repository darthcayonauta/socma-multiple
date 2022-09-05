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
			$update = "UPDATE vehiculo SET marca='{$marca}', modelo='{$modelo}', year='{$year}',patente='{$patente}',
					  tipo_vehiculo='{$tipo_vehiculo}',transmision='{$transmision}' WHERE id={$id}";
			
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

	public function ingresaRecepcion( 	$id_vehiculo 	= null, 
										$kilometraje	= null, 
										$observacion 	= null,
										$id_user 		= null,
										$token 			= null ){
		
		$insert = "INSERT INTO recepcion(id_vehiculo,fecha,kilometraje,observacion,id_user,token) VALUES
				({$id_vehiculo},'{$this->fecha_hoy}','{$kilometraje}','{$observacion}',{$id_user},'{$token}')";

		if( $this->sql->insert( $insert) )
				return true;
		else 	return false;
		
		//return $insert;
	}

	public function ingresaCuerpoRecepcion($col_izq = null,$col_der=null,$id_item =null,$token )
	{
		$insert = "INSERT INTO cuerpo_repecion(col_izq,col_der,id_item,token) VALUES 
				   ('{$col_izq}','{$col_der}',{$id_item},'{$token}')		
		";

		if( $this->sql->insert( $insert) )
				return true;
		else 	return false;
	}

	public function maxIdRecepcion(){
		return $this->sql->select("SELECT max(id) AS maxId from recepcion");
	}

	public function listaRecepciones( $id_user = null)
	{
		$resto = null;
		if($id_user)
			$resto = " WHERE recepcion.id_user={$id_user}";
			
		$ssql = "SELECT 
					recepcion.id,
					recepcion.fecha,
					recepcion.id_vehiculo,
					recepcion.kilometraje,
					recepcion.token,
					vehiculo.patente,
					recepcion.observacion, 
					usuario.nombres,
					usuario.apaterno
				FROM recepcion 
				INNER JOIN vehiculo ON (vehiculo.id = recepcion.id_vehiculo)
				INNER JOIN usuario ON (usuario.id = recepcion.id_user)
				{$resto}
				
				";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function detalleRecepcion( $token = null ){
		
		$ssql = "SELECT 
			   		cuerpo_repecion.id_item,
				   	cuerpo_repecion.col_izq,
				   	cuerpo_repecion.col_der,
					item.descripcion AS nombreItem
			    FROM  
				cuerpo_repecion
				INNER JOIN item ON (item.id = cuerpo_repecion.id_item)
				WHERE cuerpo_repecion.token = '{$token}'
		";	
		
		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function usersListado( $id  = null , $rut = null, $no_todos = null )
	{
		$resto = null;

		if( $id )
			$resto = " AND id = {$id}";

		if( $rut )
			$resto = " AND rut = '{$rut}'";	

		if( $no_todos )
			$resto = " AND id_estado = 1";	

		$ssql = "SELECT * FROM usuario WHERE tipo_usuario = 4 {$resto} ORDER BY apaterno";
	
		$arr['sql']= $ssql;
		$arr['process']= $this->sql->select( $ssql );
		$arr['total-recs']= count( $arr['process'] );
	
		return $arr;

	}	


	public function ingresaNewUsuario( $nombres  = null, 
									   $apaterno = null,
									   $amaterno = null,
									   $rut 	 = null,
									   $clave    = null,
									   $email 	 = null

	)
	{
	$arr = $this::usersListado( null, $rut );	

	$insert = "INSERT INTO usuario(nombres,apaterno,amaterno,rut,email,clave,tipo_usuario,id_estado) VALUES 
	('{$nombres}','{$apaterno}','{$amaterno}','{$rut}','{$email}',PASSWORD('{$clave}'),4,1)	
	";

	if( $arr['total-recs'] > 0 )
		return false;
	else{
			if( $this->sql->insert( $insert ) )
					return true;
			else 	return false;
		}
	}

	public function eliminaUsuario( $id_user = null )
	{
		$update = "UPDATE usuario SET id_estado=2 WHERE id={$id_user}";

		if( $this->sql->update( $update ) )
				return true;
		else 	return false;
	}

	public function actualizaUsuario( 	$nombres = null,
										$apaterno = null,
										$amaterno = null,
										$id_user  = null,
										$rut 	  = null	   )
	{
		$update = "UPDATE usuario SET nombres = '{$nombres}', 
									  apaterno='{$apaterno}',
									  amaterno='{$amaterno}',
									  rut     ='{$rut}'
		     	   WHERE id={$id_user}";

		if( $this->sql->update( $update ) )
				return true;
		else 	return false;
	}

	public function listaAccesos()
	{
		$ssql = "SELECT 
					accesos.id,
					accesos.fecha,
					accesos.ip,
					accesos.sesion,
					accesos.id_usuario,
					usuario.apaterno,
					usuario.amaterno,
					usuario.nombres
				FROM 
				accesos
				INNER JOIN usuario ON (accesos.id_usuario = usuario.id)
				ORDER BY accesos.fecha DESC
				";

		$arr['sql'] 	= $ssql;
		$arr['process'] = $this->sql->select( $ssql );
		$arr['total-recs'] = count( $arr['process'] );

		return $arr;
	}

	public function cambiaPassword(  $clave = null, $id_usuario = null )
	{
		$update = "UPDATE usuario SET clave = PASSWORD('{$clave}') WHERE id={$id_usuario}";
	
		if( $this->sql->update( $update ) )
				return true;
		else 	return false;
	}
}//fin de clase
?>
