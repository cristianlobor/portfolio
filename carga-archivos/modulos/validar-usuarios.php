<?php
 session_start();
include "conexion.php";
if($_POST ['proceso']){
    $proceso = $_POST['proceso'];
    if($proceso=="Iniciar"){
        $usuario = $_POST['usuario'];
        $password = sha1($_POST['password']);
        $consulta = "SELECT * FROM usuarios WHERE nombre='$usuario' AND password='$password'";
        $resultado = mysqli_query($conexion,$consulta);
        $numusuario = mysqli_num_rows($resultado);
        $fila = mysqli_fetch_array($resultado);
        $xCodigo = $fila['cod_usuario'];
        $xPrivilegios = $fila['privilegios'];
        $xUsuario = utf8_encode($fila['nombre']);
        if($numusuario>=1){
            $_SESSION['xCodigo'] = $xCodigo;
            $_SESSION['xUsuario'] = $xUsuario;
            $_SESSION['xPrivilegios'] = $xPrivilegios;
            echo "<script language='JavaScript'>location.href='../inicio.php'</script>";
        }else{
            echo "<script language='JavaScript'>location.href='../seguridad/seguridad.php'</script>";
        }
    }
}else{
    echo "<script language='JavaScript'>location.href = '../seguridad/seguridad.php'</script>";
}
?>