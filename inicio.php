<?php
include("class/mysqldb.class.php");
include("class/querys.class.php");
include("class/template.class.php");
include("class/codifica.class.php");
include("class/myIp.class.php");
include("class/menu.class.php");
include("class/principal.class.php");
include("class/select.class.php");
include("class/seguridad.class.php");
include("class/utilesmodulo.class.php");
require_once("config.php");

function seguridad($arg){

  $seguridad = new seguridad($arg);
  return $seguridad->getCode();
}

function validaEmail( $email_a = null )
	{
		if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {

			return true;

		}else return true;
  }

$consultas = new querys();

$i                = 0;
$apaterno         = null;
$amaterno         = null;
$nombres          = null;
$id               = null;
$id_tipo_usuario  = null;
$id_estado        = null;
$rut              = null;
$email            = null;

if( $_POST[ 'email'] == '' || $_POST['clave'] == '' )
{
  header('location:index.php?ix=no_session');
  exit();
}elseif( !validaEmail( $_POST[ 'email'] ) )
{
  header('location:index.php?ix=no_session');
  exit();
}else{

  $arr = $consultas->login( $_POST['email'],$_POST['clave']  );

  foreach ($arr['process'] as $key => $value) {
    // code...
    $apaterno         = $value['apaterno'];
    $amaterno         = $value['amaterno'];
    $nombres          = $value['nombres'];
    $id               = $value['id'];
    $tipo_usuario     = $value['tipo_usuario'];
    $id_estado        = $value['id_estado'];
    $rut              = $value['rut'];
    $email            = $value['email'];

    $i++;
  }

  $ingresa = ($i > 0) ? true : false;

  if($ingresa){

    header('Cache-Control: no cache');
    //session_cache_limiter('public'); // works too session_start();
    session_cache_limiter('private, must-revalidate');
    session_cache_expire(60);
    define('DURACION_SESION','7200'); //2 horas
    ini_set("session.cookie_lifetime",DURACION_SESION);
    ini_set("session.gc_maxlifetime",DURACION_SESION);
    ini_set("session.save_path","/tmp");
    session_cache_expire(DURACION_SESION);

    @session_start();
    @session_regenerate_id(true);

    $_SESSION['autenticado']	   = 1;
    $_SESSION['yo']				       = $id;
    $_SESSION['rut']			       = $rut;
    $_SESSION['nombres'] 		     = $nombres;
    $_SESSION['apaterno'] 		   = $apaterno;
    $_SESSION['amaterno'] 		   = $amaterno;
    $_SESSION['tipo_usuario']    = $tipo_usuario;
    $_SESSION['email'] 	    	   = $email;

    //aun no ingresare a tabla accesos ... simplemente me logueare

    if( $_SESSION['autenticado'] == 1  ){
      //echo "BUENA!!, ESTAS LOGUEADO";

      $ip 		  = new MyIp();
      $obQuery 	= new querys();
  
      if( $obQuery->ingresaAccesos( $_SESSION['yo'], session_id(), $ip->getCode() ) )
      { $ok = true;  }else{ $ok = true; }


      $ob_principal = new Principal('logged');
      echo $ob_principal->getCode();

    }else{
      print_r($_SESSION);
    }
  }else{
    header('location:index.php?ix=error_auth');
		exit();
  }
}

  //print_r($_POST);
// y vendran cosas peores
?>
