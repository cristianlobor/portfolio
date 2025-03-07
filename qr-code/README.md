# Proyecto de Gestión de Usuarios y Visitas

Este proyecto tiene como objetivo gestionar usuarios y sus visitas a través de un sistema que incluye autenticación, almacenamiento de información de los usuarios, generación de códigos QR personalizados y el uso de un escáner QR para registrar visitas.

## Funcionalidades

- **Gestión de Usuarios**: Permite agregar, editar y eliminar usuarios.
- **Generación de Códigos QR**: Genera un código QR único para cada usuario, que permite registrar visitas al ser escaneado.
- **Registro de Visitas**: Los usuarios pueden registrar visitas mediante el escaneo de su código QR único.
- **API Restful**: El proyecto ofrece una API para interactuar con las bases de datos, facilitando las operaciones CRUD.

## Tecnologías Utilizadas

- **PHP**: Para la lógica del backend y la interacción con la base de datos.
- **MySQL**: Base de datos relacional para almacenar los datos de usuarios y visitas.
- **Endroid QR Code**: Biblioteca PHP para la generación de códigos QR.
- **Bootstrap**: Framework CSS para el diseño y estructura de las vistas.
- **JavaScript Vanilla**: Para hacer solicitudes AJAX y mejorar la interactividad del sitio.
- **QR-Scanner**: Herramienta que permite escanear los códigos QR generados para registrar visitas.

## Estructura del Proyecto

El proyecto está dividido en las siguientes partes:

1. **API**: El backend está compuesto por una serie de endpoints que permiten la creación, edición y eliminación de usuarios, así como el registro de visitas. Los endpoints disponibles son:
   - `GET /api.php?action=get_users`: Obtener todos los usuarios.
   - `GET /api.php?action=get_user&id=<user_id>`: Obtener detalles de un usuario específico.
   - `POST /api.php?action=edit_user`: Editar los datos de un usuario.
   - `POST /api.php?action=add_user`: Agregar un nuevo usuario.
   - `GET /api.php?action=delete_user&id=<user_id>`: Eliminar un usuario.
   - `GET /api.php?action=register_visit&id=<user_id>`: Registrar una visita asociada a un usuario.
   - `GET /api.php?action=generate_qr&id=<user_id>`: Generar un código QR para un usuario.

2. **Base de Datos**: La base de datos contiene dos tablas principales:
   - **usuarios**: Información del usuario (ID, nombre, email, cantidad de visitas, ruta del código QR).
   - **visitas**: Registro de las visitas, asociadas a un usuario específico.

Para la creación de las tablas viene en el archivo config bd.txt
