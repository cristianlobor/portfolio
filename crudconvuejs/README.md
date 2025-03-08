# Proyecto CRUD con Vue.js y PHP

Este proyecto implementa una aplicación CRUD utilizando Vue.js en el frontend y PHP en el backend, con interacción mediante JSON.

## Descripción

- **Frontend**: Vue.js se encarga de la interacción del usuario y la presentación de los datos.
- **Backend**: PHP se encarga de la lógica del servidor y la interacción con la base de datos.
- **Comunicación**: Los datos se intercambian en formato JSON entre el cliente y el servidor.

## Estructura del Proyecto

### 1. Frontend (Vue.js)
- La carpeta `src/client` contiene el código del cliente, donde encontrarás los componentes de Vue y las vistas necesarias para gestionar los datos.

### 2. Backend (PHP)
- La carpeta `src/server` contiene el backend, donde encontrarás los controladores y modelos PHP que gestionan la lógica CRUD. Además, el archivo `config/bd.txt` contiene la configuración de la base de datos.

## Requisitos

- **PHP 7.4+**: Para ejecutar el servidor PHP.
- **Node.js**: Para ejecutar el frontend de Vue.js.
- **Base de Datos**: MySQL o MariaDB (configuración en `config bd.txt`).
