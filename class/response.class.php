<?php
/**
* @author Claudio, cguzmanherr@gmail.com
*/
class response
{
	private $id;
	private $id_user;

	function __construct($id=null )
	{
		$this->id = $id;
		$this->yo = $_SESSION['yo'];
	}

	private function cargaModulos(){

		switch ($this->id)
		{
			case 'cambiaClaveData':
			case 'actualizaUsuario':
			case 'editarUsuario':
			case 'eliminaUsuario':
			case 'ingresaNewUsuario':
				# code...
				return $this::obtenerContenidoClaseOption('usuarios.class.php','Usuarios');
				break;


			case 'tablaRecepcion':
			case 'ingresaRecepcion':
			case 'despliegaFormSolicitud':
				# code...
				return $this::obtenerContenidoClaseOption('solicitud-vehiculos.class.php','SolicitudVehiculos');
				break;

			case 'editaVehiculoData':
			case 'editaVehiculo':
			case 'eliminaVehiculo':
			case 'ingresaVehiculoData':
				return $this::obtenerContenidoClaseOption('vehiculos.class.php','Vehiculos');
				break;

			default:
				# code...
				return "<div class='principal'>MODULO NO DEFINIDO / TIMEOUT DE CARGA</div>";
				break;
		}
	}

/**
 * obtenerContenidoClaseOption(), obtiene un despliegue de resultados de una clase cualquiera para el metodo anterior, Alex aprende a programar
 *
 * @param  string file_class
 * @param  string class
 * @return string
 */
	private function obtenerContenidoClaseOption($file_class=null,$class=null){

	   include($file_class);

	   $obj_class  = new $class( $this->id);
	   return $obj_class->getCode();

	}

	public function getCode(){

		return $this->cargaModulos();
	}
}
?>
