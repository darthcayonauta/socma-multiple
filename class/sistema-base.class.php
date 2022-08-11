<?php

class SistemaBase{

  private $consultas;
	private $template;
	private $ruta;
	private $sesion;
	private $id;
	private $fecha_hoy;
	private $yo;

  function __construct( $id = null )
  {
      $this->yo = $_SESSION['yo'];
  
    $oConf    = new config();
      $cfg      = $oConf->getConfig();
      $db       = new mysqldb(  $cfg['base']['dbhost'],
                                $cfg['base']['dbuser'],
                                $cfg['base']['dbpass'],
                                $cfg['base']['dbdata'] );

    $this->consultas 			= 	new querys( $db );
    $this->template  			= 	new template();
    $this->ruta      			= 	$cfg['base']['template'];
    $this->id 						= 	$id;
    $this->error 					= 	" <strong>{$this->id}</strong> no definido";
    $this->fecha_hoy 			=  date("Y-m-d");
    $this->fecha_hora_hoy	=  date("Y-m-d H:i:s");

  }

  private function control()
  {
    switch( $this->id ){
      case 'inicio':
      case 'base':
        return $this::base();
      break;

      default:
        return $this->error;
      break;
    }
  }

  private function base()
  {
    require_once( "proyectos.class.php");
    $ob_proyectos = new Proyectos("lista-proyectos");
    return $ob_proyectos->getCode();
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
