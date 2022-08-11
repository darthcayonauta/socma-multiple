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



}
?>
