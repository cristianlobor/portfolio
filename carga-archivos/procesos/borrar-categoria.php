<?php
       include "../modulos/conexion.php";
     
        $cod_categoria= $_GET['cod_categoria'];
         
        $consulta = "DELETE FROM categoria WHERE cod_categoria='$cod_categoria'";
        $resultado = mysqli_query($conexion,$consulta);
        if($resultado){
            echo "<script language='JavaScript'>location.href='../add-documento.php'</script>";
        }  

    
?>