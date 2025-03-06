<?php
       include "../modulos/conexion.php";
     
        $cod_archivo = $_GET['cod_archivo'];
         
        $consulta = "DELETE FROM archivo WHERE cod_archivo='$cod_archivo'";
        $resultado = mysqli_query($conexion,$consulta);
        if($resultado){
            echo "<script language='JavaScript'>location.href='../inicio.php'</script>";
        }  

    
?>