<?php
 
        include "../modulos/conexion.php";

        $nom_archivo =utf8_encode( $_POST['namearch']);
        $nom_cat =utf8_encode( $_POST['namecat']);
        $fecha = date("Y-m-d");
 
        $consulta = "INSERT INTO archivo (nombre_archivo,nombre_cat,fecha) VALUES ('$nom_archivo','$nom_cat','$fecha')";
        $resultado = mysqli_query($conexion,$consulta);
        if($resultado){
            echo "<script language='JavaScript'>location.href='../reg-documento.php'</script>";
        }
 ?>