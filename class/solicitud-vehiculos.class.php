<?php

    class SolicitudVehiculos 
    {
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
     

        private function control(){
            switch ($this->id) {
                case 'crearSolicitud':
                    # code...
                    return $this::formulario();
                    break;
                
                default:
                    # code...
                    return $this->error;
                    break;
            }
        }

        private function formulario(){

            $arr_vehiculo = $this->consultas->vehiculo();
            $sel_vehiculo = new Select($arr_vehiculo['process'],'patente','patente',
                                     'patente_vehiculo','Seleccione Patente Vehículo',null,'x');

            $data = ['###fecha###'                  => $this::arreglaFechas( $this->fecha_hoy ),
                     '###select-patente###'         => $sel_vehiculo->getCode(),
                     '###select-vigencia-rt###'     => $this::afirmaciones( 'id_vigencia_rt' ),
                     '###select-vigencia-pc###'     => $this::afirmaciones( 'id_vigencia_pc' ),
                     '###select-vigencia-so###'     => $this::afirmaciones( 'id_vigencia_so' ),
                     '###select-ebem###'            => $this::afirmaciones( 'id_ebem' ),
                     '###select-botiquin###'        => $this::afirmaciones( 'id_botiquin' ), 
                     '###select-eov###'             => $this::afirmaciones( 'id_eov' ), 
                     '###select-tl###'              => $this::afirmaciones( 'id_tl' ), 
                     '###select-llr###'             => $this::afirmaciones( 'id_llr' ), 
                     '###select-gata###'            => $this::afirmaciones( 'id_gata' ),
                     '###select-li###'              => $this::afirmaciones( 'id_li' ),
                     '###select-pu###'              => $this::afirmaciones( 'id_pu' ),
                     '###select-chr###'             => $this::afirmaciones( 'id_chr' ),
                     '###select-cpa###'             => $this::afirmaciones( 'id_cpa' ),
                     '###select-rdr###'             => $this::afirmaciones( 'id_rdr' ), 
                     '###select-cargador-usb###'    => $this::afirmaciones( 'id_cargador-usb' ),     
                     '###select-lfa###'             => $this::afirmaciones( 'id_lfa' ),
                     '###select-lfb###'             => $this::afirmaciones( 'id_lfb' ),
                     '###select-lfb###'             => $this::afirmaciones( 'id_lfb' ),
                     '###select-intermitentes###'   => $this::afirmaciones( 'id_intermitentes' ),
                     '###select-luz-patente###'     => $this::afirmaciones( 'id_lp' ),     
                     '###select-lf###'              => $this::afirmaciones( 'id_lf' ),
                     '###select-lr###'              => $this::afirmaciones( 'id_lr' ),
                     '###select-le###'              => $this::afirmaciones( 'id_le' ),
                     '###select-lem###'             => $this::afirmaciones( 'id_lem' ),
                     '###select-er###'              => $this::afirmaciones( 'id_er' ),
                     '###select-el###'              => $this::afirmaciones( 'id_el' ),
                     '###select-lpar###'            => $this::afirmaciones( 'id_lpar' ),
                     '###select-par###'             => $this::afirmaciones( 'id_par' ),
                     '###select-rep###'             => $this::afirmaciones( 'id_rep' ),
                     '###select-ere###'             => $this::afirmaciones( 'id_ere' ),
                     '###select-neumaticos###'      => $this::afirmaciones( 'id_neumaticos' ),
                     '###select-vidrios###'         => $this::afirmaciones( 'id_vidrios' ),
        
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