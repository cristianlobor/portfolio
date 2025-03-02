const apiBaseUrl = 'http://localhost/api-php-js/back';  // Dirección de la API

// Función para obtener todos los usuarios
async function getUsers() {
    try {
        const response = await axios.get(`${apiBaseUrl}/get_users.php`);
        const users = response.data;

        // Limpiar la tabla antes de agregar los usuarios
        const tableBody = document.getElementById('usersTableBody');
        tableBody.innerHTML = '';

        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>
                    <button class="btn btn-secondary" onclick="viewUser(${user.id})"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-warning" onclick="editUser(${user.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" onclick="deleteUser(${user.id})"><i class="fas fa-trash"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Inicializar DataTables para manejar la tabla
        $('#usersTable').DataTable();
    } catch (error) {
        console.error('Error al obtener los usuarios', error);
    }
}

// Función para exportar la tabla a Excel, excluyendo la columna de acciones
function exportToExcel() {
    const table = document.getElementById('usersTable');  // Obtener la tabla
    const rows = table.rows;
    
    // Filtrar las filas y columnas que no quieres incluir (solo nombre y email)
    const filteredRows = [];
    
    // Recorremos las filas de la tabla, excluyendo la última columna (acciones)
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const rowData = [];
        
        // Solo tomamos los valores de las dos primeras columnas (Nombre y Email)
        for (let j = 0; j < 2; j++) {
            rowData.push(row.cells[j].innerText);  // Agregar solo nombre y email
        }
        
        filteredRows.push(rowData);
    }

    // Crear una hoja de trabajo sin la columna de acciones
    const ws = XLSX.utils.aoa_to_sheet(filteredRows);
    
    // Crear un libro de trabajo
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Usuarios');  // Agregar la hoja
    XLSX.writeFile(wb, 'usuarios.xlsx');  // Descargar el archivo Excel
}

// Ver usuario
async function viewUser(id) {
    try {
        const response = await axios.get(`${apiBaseUrl}/get_user.php?id=${id}`);
        const user = response.data;
        document.getElementById('viewName').textContent = user.name;
        document.getElementById('viewEmail').textContent = user.email;
        
        // Usando Bootstrap 5 para abrir el modal
        const viewUserModal = new bootstrap.Modal(document.getElementById('viewUserModal'));
        viewUserModal.show();  // Mostrar el modal de ver usuario
    } catch (error) {
        console.error('Error al obtener el usuario', error);
    }
}

// Función para editar usuario
async function editUser(id) {
    try {
        const response = await axios.get(`${apiBaseUrl}/get_user.php?id=${id}`);
        const user = response.data;

        // Rellenamos los campos del formulario de edición con los datos del usuario
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editName').value = user.name;
        document.getElementById('editEmail').value = user.email;

        // Mostramos el modal de edición
        $('#editUserModal').modal('show'); // Asegúrate de que jQuery esté funcionando correctamente aquí
    } catch (error) {
        console.error('Error al obtener los datos del usuario', error);
    }
}

// Función para manejar el formulario de edición de usuario
document.getElementById('editUserForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    const id = document.getElementById('editUserId').value;  // Obtener el ID del usuario a editar
    const name = document.getElementById('editName').value;  // Obtener el nombre actualizado
    const email = document.getElementById('editEmail').value;  // Obtener el email actualizado

    try {
        // Enviar una solicitud PUT para actualizar el usuario
        const response = await axios.put(`${apiBaseUrl}/update_user.php?id=${id}`, {
            name,  // Nuevo nombre
            email  // Nuevo email
        });

        // Comprobar la respuesta del servidor
        if (response.data.message === "Usuario actualizado correctamente") {
            // Cerrar el modal de edición
            $('#editUserModal').modal('hide');
            // Volver a cargar la lista de usuarios
            getUsers();
        } else {
            console.error('Error al actualizar el usuario');
        }
    } catch (error) {
        console.error('Error al actualizar el usuario', error);
    }
});




// Eliminar usuario
async function deleteUser(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        try {
            await axios.delete(`${apiBaseUrl}/delete_user.php?id=${id}`);
            getUsers();
        } catch (error) {
            console.error('Error al eliminar el usuario', error);
        }
    }
}

// Agregar usuario
document.getElementById('addUserForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;

    try {
        await axios.post(`${apiBaseUrl}/create_user.php`, { name, email });
        
        // Cerrar el modal de agregar
        const addUserModal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        addUserModal.hide();  // Cerrar el modal de agregar

        // Recargar la lista de usuarios
        getUsers();
    } catch (error) {
        console.error('Error al agregar el usuario', error);
    }
});

// Inicializar la página cargando los usuarios
getUsers();
