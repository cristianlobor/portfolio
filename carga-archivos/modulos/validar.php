<?php
 $xCodigo = $_SESSION['xCodigo'];
 $xUsuario = $_SESSION['xUsuario'];
 $xPrivilegios = $_SESSION['xPrivilegios'];
 if($xCodigo==""){
     echo "<script type='text/javascript'> window.location='seguridad/seguridad.php';</script>";
 }
?>