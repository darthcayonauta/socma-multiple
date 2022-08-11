<?php

class Principal
{
	private $consultas;
	private $template;
	private $ruta;
	private $sesion;
	private $id;
	private $menu;
	private $contenido_sesion;
	private $usuario;
	private $clave;
	private $id_user;
	private $id_tipo_usuario;
	private $fecha_hoy;
	private $yo;
	private $apateno;
	private $mpateno;
	private $nombres;
	private $tipo_usuario;


	function __construct( $id = null,$yo = null )
	{

		if(is_null($yo))
			$this->yo = $_SESSION['yo'];
		else {
			$this->yo = $yo;
		}

		$oConf    				= new config();
	  	$cfg      				= $oConf->getConfig();
	  	$db       				= new mysqldb( $cfg['base']['dbhost'],
												 $cfg['base']['dbuser'],
												 $cfg['base']['dbpass'],
												 $cfg['base']['dbdata'] );

   		$this->consultas 		= 	new querys( $db );
   		$this->template  		= 	new template();
   		$this->ruta      		= 	$cfg['base']['template'];
		$this->id 				= 	$id;
		$this->error 			= 	$cfg['base']['error'];
		$this->fecha_hoy 		=  date("Y-m-d");
		$this->fecha_hora_hoy	=  date("Y-m-d H:i:s");
		$this->tipo_user 		=  $_SESSION['tipo_usuario'];
		$this->apaterno 		=  utf8_decode(  $_SESSION['apaterno'] );
		$this->amaterno 		=  $_SESSION['amaterno'];
		$this->nombres 			=  $_SESSION['nombres'];
		$this->menu  			=  new Menu( $this->yo , $this->tipo_user  );
		
	}

	private function control()
	{
		switch ($this->id)
		{
			case 'logged':
				return $this::logged();
				break;

			default:
					return $this->error;
			break;
		}
	}

	/**
	 * logged(): la primera funcion de inicio que da pie a la interfaz principal
	 * @return string
	 */
	private function logged()
	{
		$data = ['@@@TITLE'  	=> 'Sistema de SOCMA',
				 '@@@USER' 		=> utf8_encode( "{$this->nombres} {$this->apaterno} {$this->amaterno}"),
				 '@@@FECHA' 	=> $this::arreglaFechas(  $this->fecha_hoy ),
				 '@@@CONTENT'	=> $this::content(),
				 '@@@MENU'    	=> $this->menu->getCode()

					 ];
		return $this::despliegueTemplate($data,'inicio-principal.html');
	}

	private function content()
	{
		//return "TODOS LOS MODULOS EN CONSTRUCCION";

		
		try {

				require_once("vehiculos.class.php");
				$ob_base = new Vehiculos('inicio');
				return $ob_base->getCode();

			}
		catch (Exception $e){
			return "No se puede cargar la clase";
		}
	}

	/**
	 * arreglaFechas()
	 * @param string fecha
	 * @return string
	 */
	private function arreglaFechas( $fecha = null )
	{
			$div = $this::separa( $fecha , '-'  );

			if( count( $div ) > 0 )
					return "{$div[2]}-{$div[1]}-{$div[0]}";
			else return "Error de Formato";
	}


	private function separa($cadena=null,$simbolo=null)
	{
		if( is_null($cadena) )
			return "";
		else
			return explode($simbolo,$cadena);
	}

	/**
     * separa_miles(), coloca separador de miles en una cadena de caracteres
    *
    * @param  String num
    * @return String
    */
    private function separa_miles($num=null){

        return @number_format($num, 0, '', '.');
    }


	 /**
	  * despliegueTemplate(), metodo que sirve para procesar los templates
	  *
	  * @param  array   arrayData (array de datos)
	  * @param  array   tpl ( template )
	  * @return string
	  */
    private function despliegueTemplate($arrayData,$tpl){

     	  $tpl = $this->ruta.$tpl;

	      $this->template->setTemplate($tpl);
	      $this->template->llena($arrayData);

	      return $this->template->getCode();
	  }

	/**
	 * getCode(): salida pública de control()
	 * @return string
	 */
	public function getCode()
	{
		return $this::control();
	}
}
?>
