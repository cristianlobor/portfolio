# Proyecto de Subida de Archivos con PHP y JavaScript

Este proyecto permite a los usuarios registrados subir archivos al servidor utilizando un sistema basado en sesiones y un frontend interactivo. El backend está implementado en PHP, mientras que el frontend hace uso de JavaScript (principalmente la librería Dropzone.js) para manejar la interfaz de subida de archivos.

## Descripción

- **Frontend**: Utiliza HTML, CSS y JavaScript para proporcionar una interfaz interactiva. La librería **Dropzone.js** se usa para facilitar la carga de archivos de manera fácil y visual.
- **Backend**: Implementado en PHP para manejar las sesiones de usuario, la autenticación y la subida de archivos al servidor.
- **Seguridad**: Los usuarios deben estar registrados e iniciar sesión para poder acceder al sistema y subir archivos.
  
## Requisitos

- **PHP 7.4+**: Para ejecutar el backend en el servidor.
- **Node.js**: Opcional, si deseas ejecutar herramientas de desarrollo frontend.
- **Base de Datos**: MySQL o MariaDB (configuración en `config bd.txt`).
- **Servidor Web**: Apache o Nginx para servir el proyecto.