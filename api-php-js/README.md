# Proyecto de Gestión de Usuarios con Frontend en JavaScript y Backend en PHP

Este proyecto implementa un sistema de gestión de usuarios donde el frontend está desarrollado en JavaScript y el backend en PHP. La comunicación entre ambos se realiza a través de una API, lo que permite la flexibilidad de cambiar el frontend o el backend sin afectar la funcionalidad del sistema, solo es necesario adaptar el envío y recepción de datos.

## Descripción

- **Frontend**: Desarrollado en JavaScript, permite a los usuarios interactuar con el sistema a través de una interfaz de usuario.
- **Backend**: Implementado en PHP, maneja la lógica del sistema y las interacciones con la base de datos.
- **API**: El frontend y el backend se comunican mediante una API que facilita el intercambio de datos entre ambos.
- **Base de Datos**: MySQL se utiliza para almacenar la información de los usuarios, y la configuración de la base de datos está disponible en `config-bd.txt`.

## Requisitos

- **PHP 7.4+**: Para ejecutar el backend.
- **Node.js**: Si se desea usar herramientas de desarrollo frontend.
- **Base de Datos**: MySQL o MariaDB (configuración en `config/config-bd.txt`).
- **Servidor Web**: Apache o Nginx para servir el backend.

### Funcionalidades

- **Gestión de usuarios**: Los administradores pueden agregar, modificar, eliminar y consultar usuarios.
- **Autenticación**: Los usuarios pueden iniciar sesión para acceder a su información.
- **API**: La comunicación entre el frontend y el backend se realiza a través de una API RESTful.