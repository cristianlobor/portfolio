<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Agregar Font Awesome desde el CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Usuarios</h2>

        <!-- Botones para agregar usuario y escanear -->
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#agregarModal"><i class="fas fa-plus"></i> Agregar Usuario</button>
            <button id="startScanButton" class="btn btn-success" onclick="startScan()"><i class="fas fa-camera"></i> Escanear</button>
            <!-- Botón para cancelar el escáner -->
            <button id="cancelScanButton" class="btn btn-danger" onclick="cancelScan()" style="display:none;"><i class="fas fa-times"></i> Cancelar Escaneo</button>
        </div>

        <!-- Tabla de usuarios -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Visitas</th>
                    <th>QR</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="usuarioList">
                <!-- Los usuarios se cargarán aquí mediante JS -->
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar nuevo usuario -->
    <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarModalLabel">Agregar Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="agregarUsuarioForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contenedor para la cámara -->
    <video id="scanner-video" width="100%" height="350mx" style="display:none;"></video>

    <!-- Modal para ver información del usuario -->
    <div class="modal fade" id="verInfoModal" tabindex="-1" role="dialog" aria-labelledby="verInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verInfoModalLabel">Ver Información del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="usuarioInfo"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Información del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editarUsuarioForm">
                <div class="modal-body">
                    <input type="hidden" id="editarId" name="id"> <!-- Para pasar el ID del usuario -->
                    <div class="form-group">
                        <label for="editarNombre">Nombre</label>
                        <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editarEmail">Email</label>
                        <input type="email" class="form-control" id="editarEmail" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Archivos JavaScript de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="module">
    import QrScanner from './qr-scanner/qr-scanner.min.js';

    let qrScanner;
    let scannerVideo = document.getElementById('scanner-video');
    let scanning = false;

    // Función para iniciar el escáner
    window.startScan = function() {
        if (scanning) return; // Evitar que el escaneo inicie múltiples veces
        scanning = true;

        // Mostrar el video del escáner y ocultar el botón de inicio
        scannerVideo.style.display = 'block';
        document.getElementById('startScanButton').style.display = 'none'; // Ocultar el botón de iniciar escaneo
        document.getElementById('cancelScanButton').style.display = 'block'; // Mostrar el botón de cancelar escaneo

        // Agregar un pequeño retardo para dar tiempo a que la cámara se estabilice
        setTimeout(() => {
            // Iniciar el escáner de QR
            qrScanner = new QrScanner(scannerVideo, result => {
                if (result) {
                    console.log('QR detectado:', result);
                    registrarVisita(result.data); // Usar el resultado del QR para registrar la visita

                    // Detener el escáner después de leer el QR
                    qrScanner.stop();
                    scannerVideo.style.display = 'none'; // Ocultar el video
                    scanning = false;
                    document.getElementById('startScanButton').style.display = 'block'; // Mostrar el botón de inicio
                    document.getElementById('cancelScanButton').style.display = 'none'; // Ocultar el botón de cancelar
                }
            }, {
                video: {
                    facingMode: 'environment', // Esto selecciona la cámara trasera en dispositivos móviles
                    width: 1280, // Puedes establecer la resolución de la cámara
                    height: 720 // Puedes establecer la resolución de la cámara
                },
                highlightScanRegion: true, // Resalta la región de escaneo
                maxDecodeRate: 30, // Máxima cantidad de intentos de decodificación por segundo
                showRegion: true, // Mostrar la región de escaneo
                onDecodeError: error => console.log('Error al decodificar QR:', error)
            });

            qrScanner.start(); // Iniciar escáner después del retardo
        }, 1000); // Establecer el tiempo de retardo en milisegundos (1 segundo)
    };

    // Función para cancelar el escaneo
    window.cancelScan = function() {
        if (qrScanner) {
            qrScanner.stop(); // Detener el escáner
        }
        scannerVideo.style.display = 'none'; // Ocultar el video
        document.getElementById('startScanButton').style.display = 'block'; // Mostrar el botón de iniciar escaneo
        document.getElementById('cancelScanButton').style.display = 'none'; // Ocultar el botón de cancelar
    };
</script>


<script>
        // Función para editar información del usuario
function editarInfo(userId) {
    // Hacer una solicitud fetch para obtener los detalles del usuario
    fetch(`api.php?action=get_user&id=${userId}`)
        .then(response => response.json())
        .then(data => {
            // Rellenamos el formulario con la información del usuario
            document.getElementById('editarId').value = data.id;
            document.getElementById('editarNombre').value = data.nombre;
            document.getElementById('editarEmail').value = data.email;

            // Mostrar el modal para editar
            $('#editarModal').modal('show');
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Función para manejar el envío del formulario de edición
document.getElementById('editarUsuarioForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('api.php?action=edit_user', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //alert('Usuario actualizado con éxito!');
            console.log("usuario actualizado");
            loadUsers(); // Recargar la lista de usuarios
            $('#editarModal').modal('hide'); // Cerrar el modal
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

        // Cargar los usuarios desde el backend
        function loadUsers() {
            fetch('api.php?action=get_users')
                .then(response => response.json())
                .then(data => {
                    const userList = document.getElementById('usuarioList');
                    userList.innerHTML = ''; // Limpiar la lista de usuarios

                    data.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.id}</td>
                            <td>${user.nombre}</td>
                            <td>${user.email}</td>
                            <td>${user.visitas}</td>
                            <td><img src="http://localhost/qr-code/${user.qr_code}" alt="QR" width="50"></td>
                            <td>
                                <button class="btn btn-info btn-sm" title="Ver info" onclick="verInfo(${user.id})"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning btn-sm" title="Editar info" onclick="editarInfo(${user.id})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" title="Eliminar usuario" onclick="eliminarUsuario(${user.id})"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        `;
                        userList.appendChild(row);
                    });
                });
        }

        // Mostrar la información del usuario en el modal
// Mostrar la información del usuario en el modal
function verInfo(id) {
    fetch(`api.php?action=get_user&id=${id}`)
        .then(response => response.json())
        .then(data => {
            const usuarioInfo = document.getElementById('usuarioInfo');
            usuarioInfo.innerHTML = `
                <p><strong>Nombre:</strong> ${data.nombre}</p>
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Visitas:</strong> <span id="visitas-count">${data.visitas}</span></p>
                <p><strong>QR:</strong></p>
                <img src="http://localhost/qr-code/${data.qr_code}" alt="QR" style="width: 100%; max-width: 400px;">
            `;
            $('#verInfoModal').modal('show');
        });
}

// Función para registrar la visita
function registrarVisita(url) {
    // Extraer el parámetro 'id' de la URL del QR
    const urlParams = new URLSearchParams(new URL(url).search);
    const id = urlParams.get('id'); // Extraer el valor del parámetro 'id'

    if (id) {
        console.log('ID extraído del QR:', id);

        // Hacer la petición AJAX para registrar la visita con el id extraído y la fecha
        fetch(`api.php?action=register_visit&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Visita registrada");
                    loadUsers(); // Actualiza la lista de usuarios
                    $('#verInfoModal').modal('hide'); // Cierra el modal si se abre
                } else {
                    console.log("Hubo un error al registrar la visita");
                }
            })
            .catch(error => {
                console.error('Error al registrar la visita:', error);
            });
    } else {
        console.log('No se encontró un ID válido en la URL del QR');
    }
}



        // Función para agregar usuario
        document.getElementById('agregarUsuarioForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('api.php?action=add_user', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    //alert('Usuario agregado con éxito!');
                    console.log("Usuario agregado correcto");
                    loadUsers(); // Recargar la lista de usuarios
                    $('#agregarModal').modal('hide'); // Cerrar el modal
                }
            });
        });


        // Función para eliminar usuario
        function eliminarUsuario(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                fetch(`api.php?action=delete_user&id=${id}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //alert('Usuario eliminado con éxito!');
                        console.log("Usuario eliminado correcto");
                        loadUsers();
                    } else {
                        //alert('Hubo un error al eliminar al usuario');
                        console.log("Error al eliminar");
                    }
                });
            }
        }

        // Cargar usuarios al cargar la página
        window.onload = loadUsers;
    </script>
</body>
</html>
