<?php 

class Vehiculos{

    private $consultas;
	private $template;
	private $ruta;
	private $id;
	private $fecha_hoy;
	private $yo;

    function __construct( $id = null ){
        
        $this->id               = $id;
        $this->yo               = $_SESSION['yo'];
        $oConf                  = new config();
        $cfg                    = $oConf->getConfig();
        $db                     = new mysqldb(  $cfg['base']['dbhost'],
                                                $cfg['base']['dbuser'],
                                                $cfg['base']['dbpass'],
                                                $cfg['base']['dbdata'] );
        
        $this->consultas        = 	new querys( $db );
        $this->template  	    = 	new template();
        $this->ruta      	    = 	$cfg['base']['template'];        
        $this->error 		    = 	"<strong>{$this->id}</strong> no definido";
        $this->fecha_hoy 	    =  date("Y-m-d");
        $this->year 	        =  date("Y");
        $this->mes 			    =  date("m");
    
        $this->fecha_hora_hoy	=  date("Y-m-d H:i:s");
    }

    private function control()
    {
        switch ($this->id) {

            case 'inicio':
            case 'listarSolicitudes':
            
                # code...
                return $this::listarSolicitud();
                break;
            
            case 'crearSolicitud':    
                return $this::crearSolicitud();
                break;   

            case 'listarVehiculos':
                return $this::listarVehiculos();
                break;

            case 'crearVehiculo':
                return $this::crearVehiculo();
                break;

            case 'ingresaVehiculoData':
                # code...
                return $this::ingresaVehiculoData();
                break;    

            case 'eliminaVehiculo':
                # code...
                return $this::eliminaVehiculo();
                break;    

            case 'editaVehiculo':
                # code...
                return $this::editaVehiculo();
                break;    

            case 'editaVehiculoData':
                return $this::editaVehiculoData();
                # code...
                break;    


            default:
                # code...
                return $this->error;
                break;
        }
    }

    private function editaVehiculoData(){


        if( $this->consultas->procesaVehiculo(  htmlentities( $_POST['marca'] ),
                                                htmlentities( $_POST['modelo'] ),
                                                htmlentities( $_POST['year'] ),
                                                htmlentities( $_POST['patente'] ),
                                                htmlentities( $_POST['tipo_vehiculo'] ),
                                                htmlentities( $_POST['tipo_transmision'] ),
                                                htmlentities( $_POST['id_vehiculo'] ) ) ){

            return "<hr/><h3><strong>Todo Ok:</strong> Registro Actualizado</h3>";
        
        }else{

            return "<hr/><h3><strong>Error:</strong> No se ha podido actualizar informaci??n</h3>";
        }
    }

    private function editaVehiculo(){
       // print_r( $_POST );

        $code = "";
        $i=0;
    
        $arr = $this->consultas->vehiculo( $_POST['id_vehiculo'] );
    
        foreach ($arr['process'] as $key => $value) {
            
            $arr_vehiculo = $this->consultas->tipoVehiculo();
            $sel_vehiculo = new Select($arr_vehiculo['process'],'id','descripcion',
                                     'tipo_vehiculo','Seleccione Tipo Veh??culo',$value['tipo_vehiculo'],'x');
    
            $arr_trans = $this->consultas->tipoTransmision();
            $sel_trans = new Select($arr_trans['process'],'id','descripcion',
                                     'tipo_transmision','Seleccione Tipo Transmision',$value['transmision'],'x');
    
            $hidden = "<input type='hidden' id='id_vehiculo' value='".$value['id']."'>";                         
    
            $data = ['###select-tipo-vehiculo###' => $sel_vehiculo->getCode(), 
                     '###select-transmision###'   => $sel_trans->getCode(),
                     '###tipo-form###'            => 'Edici??n',
                     '###marca###'                => $value['marca'],
                     '###modelo###'               => $value['modelo'],
                     '###patente###'              => $value['patente'],
                     '###year###'                 => $value['year'],
                     '###button-id###'            => 'update',
                     '###hidden###'               => $hidden  
                    ];
            
            $code .= $this::despliegueTemplate( $data, "vehiculos/formulario.html" );
            
        }

       return $code; 
    }



    private function eliminaVehiculo()
    {
        
        if( $this->consultas->elimina( 'vehiculo', $_POST['id_vehiculo'] ) )
             $msg = "Registro Eliminado";
        else $msg = "Error AL ELIMINAR";   
        
        return $this::notificaciones('danger',null,$msg).$this::tablaVehiculos();
    }

    private function ingresaVehiculoData()
    {
      //  print_r( $_POST );

        if( $this->consultas->procesaVehiculo( htmlentities( strtoupper( $_POST['marca'] )), 
                                               htmlentities( strtoupper( $_POST['modelo'] )), 
                                               htmlentities( $_POST['year'] ), 
                                               htmlentities( strtoupper( $_POST['patente'] )),                                                
                                               htmlentities( $_POST['tipo_vehiculo'] ),
                                               htmlentities( $_POST['tipo_transmision'] )  )  )
        { 
            return "<p>VEHICULO INGRESADO</p>".$this::listarVehiculos();
         }else{
            return "Error al ingresar vehiculo";
         }

    }


    /** 
     * listarSolicitud(): listado de solicitudes de vehiculos
     * @return string
     */
    private function listarSolicitud(){
      
        
        require_once ("solicitud-vehiculos.class.php");
        $ob = new SolicitudVehiculos('listarSolicitudes');
        return $ob->getCode();

       } 

   /**
    * crearSolicitud(): generacion de formulario de solicitud de veh??culos
    *@return string
    */    
   private function crearSolicitud(){
            
        require_once("solicitud-vehiculos.class.php");
        $ob = new SolicitudVehiculos( $this->id );
        return $ob->getCode();
   }


   private function listarVehiculos(){

        $arr = $this::tablaVehiculos();


        $data = ['###listado###' => $this::tablaVehiculos() ];
        return $this::despliegueTemplate( $data, 'vehiculos/lista-vehiculos.html' );

   }


   private function tablaVehiculos(){

    $arr = $this::trVehiculos();

    if( $arr['total-recs'] > 0 )
    {
        $data = [ '###tr###' => $arr['code'], '###total-recs###' => $arr['total-recs'] ];
        return $this::despliegueTemplate( $data, 'vehiculos/tabla-vehiculos.html' );
    }else{

        return "<h2><strong>No existen</strong> vehiculos registrados en el sistema</h2>";
    }    
   }

   private function trVehiculos(){

    $code = "";
    $i=0;

    $arr = $this->consultas->vehiculo();

    foreach ($arr['process'] as $key => $value) {
        # code...
        $data = ['###num###'            => $i+1,
                 '###patente###'        => $value['patente'],
                 '###marca###'          => $value['marca'],   
                 '###modelo###'         => $value['modelo'],
                 '###year###'           => $value['year'],
                 '###tipo_vehiculo###'  => $value['nombreTipoVehiculo'],
                 '###transmision###'    => $value['nombreTransmision'] ,
                 '###id###'             => $value['id'] ];

        $code .= $this::despliegueTemplate( $data, 'vehiculos/tr-vehiculos.html' );
        $i++;
    }

    $out['code'] = $code;
    $out['total-recs'] = $arr['total-recs']; 

    return $out;

   }

    /**
    * crearVehiculo(): generacion de formulario de solicitud de veh??culos
    *@return string
    */    
    private function crearVehiculo(){

        //select tipo-vehiculo
        $arr_vehiculo = $this->consultas->tipoVehiculo();
        $sel_vehiculo = new Select($arr_vehiculo['process'],'id','descripcion',
                                 'tipo_vehiculo','Seleccione Tipo Veh??culo',null,'x');

        //select tipo-transmision
        $arr_trans = $this->consultas->tipoTransmision();
        $sel_trans = new Select($arr_trans['process'],'id','descripcion',
                                 'tipo_transmision','Seleccione Tipo Transmision',null,'x');


        $data = ['###select-tipo-vehiculo###' => $sel_vehiculo->getCode(), 
                 '###select-transmision###'   => $sel_trans->getCode(),
                 '###tipo-form###'            => 'Creaci??n',
                 '###marca###'                => null,
                 '###modelo###'               => null,
                 '###patente###'              => null,
                 '###year###'                 => null,
                 '###button-id###'            => 'send',
                 '###hidden###'               => null  
                ];
        return $this::despliegueTemplate( $data, "vehiculos/formulario.html" );
   }

 /**
   * modal(): extrae un modal desde una Clase
   *
   *@param string target
   *@param string img
   *@param string title
   *@param string content
   */
  private function modal( $target = null,$img = null, $title = null, $content = null )
  {
      require_once("modal.class.php");

      $ob_modal = new Modal($target ,$img , $title , $content );
      return $ob_modal->salida();
  }

  /**
   * notificaciones()
   * @param string tipo_alerta
   * @param string icon
   * @param string glosa
   * @return string
    */
   private function notificaciones( $tipo_alerta = null, $icon= null, $glosa = null )
   {
       return $this::despliegueTemplate( array( '@@@tipo-alert@@@' => $tipo_alerta,
                                                '@@@icon@@@'       => $icon,
                                                '@@@glosa'         => $glosa) , 'notificaciones.html' );
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
   * getCode(): salida p??blica de control()
   * @return string
   */
  public function getCode()
  {
    return $this::control();
  }

}
?>