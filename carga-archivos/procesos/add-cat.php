<?php
 
        include "../modulos/conexion.php";

        $nom_cat =utf8_encode( $_POST['addcat']);
 
        $consulta = "INSERT INTO categoria (nombre_cat) VALUES ('$nom_cat')";
        $resultado = mysqli_query($conexion,$consulta);
        if($resultado){
            echo "<script language='JavaScript'>location.href='../add-documento.php'</script>";
        }
 ?>