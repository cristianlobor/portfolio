<?php
include "../modulos/conexion.php";

if($_POST ['proceso']){
    $proceso = $_POST['proceso'];
    if($proceso=="Iniciar"){
        $cod_archivo=$_POST['codarch'];
        $nom_arch=utf8_encode($_POST['namearch']);
        $nom_cat=utf8_encode($_POST['namecat']);
        $fecha = date("y-m-d");
        $consulta = "UPDATE archivo SET nombre_archivo='$nom_arch', nombre_cat='$nom_cat', fecha='$fecha' WHERE cod_archivo='$cod_archivo'";
        $resultado = mysqli_query($conexion,$consulta);
        if($resultado){
            echo "<script language='JavaScript'>location.href='../inicio.php'</script>";
        }
    }
       
}
?>