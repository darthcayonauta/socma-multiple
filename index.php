<?php

  require_once( "class/mysqldb.class.php" );
  require_once( "class/querys.class.php" );
  require_once( "class/template.class.php" );
  require_once( "class/index.class.php" );
  require_once("config.php");

  //print_r( $_SESSION );


  $ob_index = new Index();
  echo $ob_index->getCode();

 ?>
