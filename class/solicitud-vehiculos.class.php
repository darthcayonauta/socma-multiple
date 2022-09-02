<?php

    class SolicitudVehiculos 
    {
        private $consultas;
        private $template;
        private $ruta;
        private $id;
        private $fecha_hoy;
        private $yo;
        private $token;
        private $tipo_usuario;


        function __construct( $id = null ){
            
            $this->id               = $id;
            $this->yo               = $_SESSION['yo'];
            $this->tipo_usuario     = $_SESSION['tipo_usuario'];

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
            $this->token	        =  date("YmdHis");

        }
     

        private function control(){
            switch ($this->id) {
                case 'crearSolicitud':
                    # code...
                    return $this::formulario();
                    break;
                
                 case 'ingresaRecepcion':
                    return $this::ingresaRecepcion();
                    break;

                 case 'listarSolicitudes':
                    return $this::listarSolicitudes();        

                  break;  

                 case 'tablaRecepcion':
                    return $this::tablaRecepcion();
                    break;                    
                  
                default:
                    # code...
                    return $this->error;
                    break;
            }
        }

         /** 
     * listarSolicitud(): listado de solicitudes de vehiculos
     * @return string
     */
    private function listarSolicitudes(){
      
        //return "<strong>{$this->id}</strong> esta en construccion!, aun no";

        $data = ['###listado-recepciones###' => $this::tablaRecepcion() ];
        return $this::despliegueTemplate($data, "solicitudes/recepciones.html");
       } 

       private function tablaRecepcion()
       {

        $arr = $this::trRecepcion();

        $data = ['###tr###'         => $arr['code'], 
                 '###total-recs###' => $arr['total-recs'],
                 '###nav-links###'  => $arr['nav-links']   
                ];
        return $this::despliegueTemplate($data, "solicitudes/tabla-recepciones.html");
       }

       //listaRecepciones
       private function trRecepcion(){
        $code = "";

        $arr = ( $this->tipo_usuario==1 ) ? $this->consultas->listaRecepciones() : $this->consultas->listaRecepciones($this->yo);
                
        $utils      = new utiles($arr['sql']);
        $rs_dd      = $utils->show();
        $nav_links  = $rs_dd['nav_links'];
        $param      = $rs_dd['result'] ;
        
        foreach ($param as $key => $value) {
            # code...

            $data = ['###id###'          => $value['id'],
                     '###fecha###'       => $this::arreglaFechas( $value['fecha'] ),
                     '###kilometraje###' => $this::separa_miles( $value['kilometraje'] ),
                     '###patente###'     => $value['patente'] , 
                     '###usuario###'     => strtoupper( $value['nombres']." ".$value['apaterno'] ),
                     '###modal###'       => $this::modal( 'detalle-recepcion-'.$value['id'],
                                                          '<i class="far fa-plus-square"></i>', 
                                                          'Detalle de Recepción de Vehículo', 
                                                          $this::detalleRecepcion( $value['id'],
                                                                                   $value['token'],
                                                                                   $value['fecha'],
                                                                                   $value['patente'],
                                                                                   $value['kilometraje'],
                                                                                   $value['observacion'] ) )      
        
        ];
            $code .= $this::despliegueTemplate( $data, 'solicitudes/tr-recepciones.html' );
        }

        $out['code'] = $code;
        $out['total-recs'] = $arr['total-recs'];
        $out['nav-links']  = $nav_links;

        return $out;
       }

       private function detalleRecepcion( $id = null,
                                         $token=null, 
                                         $fecha = null,
                                         $patente = null,
                                         $kilometraje = null,
                                         $observacion = null ){

            $data = [ '###fecha###'         => $this::arreglaFechas($fecha),
                      '###id###'            => $id,
                      '###patente###'       => $patente,
                      '###kilometraje###'   => $this::separa_miles( $kilometraje ),
                      '###observacion###'   => $observacion ,
                      '###detalle###'       => $this::cuerpoRecepcion($token )                          
                    ];


            return $this::despliegueTemplate( $data, 'solicitudes/detalle-formulario.html' );
       }

       private function CuerpoRecepcion($token = null ){

            $data = ['###tr###' => $this::trCuerpoRecepcion($token) ];
            return $this::despliegueTemplate($data, 'solicitudes/tabla-detalle.html'  );
       }


       private function trCuerpoRecepcion($token = null ){
        
        $arr = $this->consultas->detalleRecepcion( $token );
        
        $code = "";

        $num =0;
        foreach ($arr['process'] as $key => $value) {
            # code...

            switch ($value['col_izq']) {
                case '1':
                    # code...
                    $col_izq = "SI";
                    break;
                
                case '2':
                        # code...
                    $col_izq = "NO";
                    break;

                default:
                    # code...
                    $col_izq = strtoupper( $value['col_izq'] );
                    break;
            }

            $col_izq = ($col_izq=='') ? 'NO CONTESTADO': $col_izq;
            $col_der = ( $value['col_der'] =='') ? 'NO CONTESTADO': $value['col_der'];


            $data = [ '###item###'      => $value['nombreItem'],
                      '###col-izq###'   => $col_izq,
                      '###col-der###'   => $col_der,
                      '###num###'       => $num+1
                      ];
            $code .= $this::despliegueTemplate( $data, 'solicitudes/detalle-items.html' );

            $num++;
        }

        return $code;
       }



        private function ingresaRecepcion()
        {

         if( $this->consultas->ingresaRecepcion(    $_POST['patente_vehiculo'],
                                                    $_POST['kilometraje'],
                                                    $_POST['ob_general'],
                                                    $this->yo,
                                                    $this->token  ) ){
                $ingreso = true;
            }else{
                $ingreso = false;
            } 

            if($ingreso){

                    if($this::ingresaCuerpoRecepcion())
                         $ok = true;
                    else $ok = false;    

                    return "<strong>Todo Ok:</strong> Información ingresada Correctamente <br/>";
            }else   return "<strong>Error:</strong> No se ha podido ingresar los datos!<br/>";

        }

        private function ingresaCuerpoRecepcion(){
            
            $separa_item    = $this::separa( $_POST['item'], '&' );
            $separa_col_der = $this::separa( $_POST['col_der'], '&' );
            $separa_col_izq = $this::separa( $_POST['col_izq'], '&' );

            $k = 0;
            for ($i=0; $i < count($separa_item); $i++) { 
                
                $aux_item       = $this::separa( $separa_item[$i],'=' );
                $aux_col_izq    = $this::separa( $separa_col_izq[$i],'=' );
                $aux_col_der    = $this::separa( $separa_col_der[$i],'=' );

                //insert database
                if( $this->consultas->ingresaCuerpoRecepcion(   $aux_col_izq[1],
                                                                $aux_col_der[1], 
                                                                $aux_item[1],
                                                                $this->token ) ){
                    $k++;
                }
            }
           
            if( $k > 0 )
                return true;
            else return false;             
        }

        private function formulario(){

            $maxId = "";

            foreach ($this->consultas->maxIdRecepcion() as $key => $value) {
                
                $maxId = $value['maxId'];
            }

            $arr_vehiculo = $this->consultas->vehiculo();
            $sel_vehiculo = new Select($arr_vehiculo['process'],'id','patente',
                                     'patente_vehiculo','Seleccione Patente Vehículo',null,'x');

            $data = ['###fecha###'                  => $this::arreglaFechas( $this->fecha_hoy ),
                     '###select-patente###'         => $sel_vehiculo->getCode(),
                     '###select-vigencia-rt###'     => $this::afirmaciones( 'col-izq' ),
                     '###select-vigencia-pc###'     => $this::afirmaciones( 'col-izq' ),
                     '###select-vigencia-so###'     => $this::afirmaciones( 'col-izq' ),
                     '###select-ebem###'            => $this::afirmaciones( 'col-izq' ),
                     '###select-botiquin###'        => $this::afirmaciones( 'col-izq' ), 
                     '###select-eov###'             => $this::afirmaciones( 'col-izq' ), 
                     '###select-tl###'              => $this::afirmaciones( 'col-izq' ), 
                     '###select-llr###'             => $this::afirmaciones( 'col-izq' ), 
                     '###select-gata###'            => $this::afirmaciones( 'col-izq' ),
                     '###select-li###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-pu###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-chr###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-cpa###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-rdr###'             => $this::afirmaciones( 'col-izq' ), 
                     '###select-cargador-usb###'    => $this::afirmaciones( 'col-izq' ),     
                     '###select-lfa###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-lfb###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-lfb###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-intermitentes###'   => $this::afirmaciones( 'col-izq' ),
                     '###select-luz-patente###'     => $this::afirmaciones( 'col-izq' ),     
                     '###select-lf###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-lr###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-le###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-lem###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-er###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-el###'              => $this::afirmaciones( 'col-izq' ),
                     '###select-lpar###'            => $this::afirmaciones( 'col-izq' ),
                     '###select-par###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-rep###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-ere###'             => $this::afirmaciones( 'col-izq' ),
                     '###select-neumaticos###'      => $this::afirmaciones( 'col-izq' ),
                     '###select-vidrios###'         => $this::afirmaciones( 'col-izq' ),
                     '###num-recepcion###'          => $maxId +1
        
        ];
            return $this::despliegueTemplate( $data , 'solicitudes/formulario.html' );
        }


        private function afirmaciones( $id_afirmacion = null ){
            $arr = $this->consultas->afirmacion();
            $sel = new Select($arr['process'],'id','descripcion',
                              $id_afirmacion,'Seleccione Si o No',null,'x','col-izq'); 
            
            return $sel->getCode();                                     
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
         * getCode(): salida pública de control()
         * @return string
         */
        public function getCode()
        {
            return $this::control();
        }

    }    
?>