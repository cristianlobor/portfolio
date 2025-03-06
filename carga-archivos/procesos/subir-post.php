<?php
$documento = $_FILES['file'];
$templocation = $documento['tmp_name'];
$name = $documento['name'];

if(!$templocation){
    die("No se seleccionó ningún archivo");
}

$directorioDestino = "../documentos/"; // Ruta del directorio donde se guarda el archivo
$rutaArchivo = $directorioDestino . $name;

// Mover el archivo al directorio de destino
if(move_uploaded_file($templocation, $rutaArchivo)){
    echo "Archivo guardado correctamente";

    // Generar la URL completa para acceder al archivo
    $urlArchivo = 'http://localhost/carga-archivos/documentos/' . $name;
    echo "<br>Accede al archivo en: <a href='$urlArchivo' target='_blank'>$urlArchivo</a>";
}else{
    echo "Ha ocurrido un error";
}
?>
