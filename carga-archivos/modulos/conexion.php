<?php
  $usuario="root";
  $contrasena="";
  $servidor="localhost";
  $basededatos="jmas";

  $conexion=mysqli_connect($servidor,$usuario,$contrasena,$basededatos);

  if(mysqli_connect_error())
  {
      echo "Fallo la conexion a la base de datos".mysqli_connect_error();
  }
?>