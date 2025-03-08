import React, { useEffect, useState, useRef } from 'react';
import axios from 'axios';
import { Modal, Button, Form } from 'react-bootstrap';

const apiBaseUrl = 'http://localhost/api-react-laravel/back/back/public/api'; // Dirección de la API

const UsersTable = () => {
  const [users, setUsers] = useState([]);
  const [filteredUsers, setFilteredUsers] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [formData, setFormData] = useState({
    name: '',
    email: ''
  });
  const [mode, setMode] = useState('');
  const [searchTerm, setSearchTerm] = useState('');

  // Función para obtener usuarios desde la API
  const getUsers = async () => {
    try {
      const response = await axios.get(`${apiBaseUrl}/users`);
      setUsers(response.data);
      setFilteredUsers(response.data); // Inicializamos filteredUsers con los usuarios completos
      setLoading(false);
    } catch (error) {
      console.error('Error al obtener los usuarios', error);
    }
  };

  useEffect(() => {
    getUsers();
  }, []);

  // Filtrar usuarios en tiempo real según el término de búsqueda
  useEffect(() => {
    if (searchTerm) {
      const lowercasedFilter = searchTerm.toLowerCase();
      const filtered = users.filter(user => 
        user.name.toLowerCase().includes(lowercasedFilter) ||
        user.email.toLowerCase().includes(lowercasedFilter)
      );
      setFilteredUsers(filtered);
    } else {
      setFilteredUsers(users); // Si no hay búsqueda, mostramos todos los usuarios
    }
  }, [searchTerm, users]);

  // Función para abrir el modal para agregar un usuario
  const handleShowAddUser = () => {
    setSelectedUser(null);
    setFormData({ name: '', email: '' });
    setMode('add');
    setShowModal(true);
  };

  // Función para ver un usuario
  const viewUser = (user) => {
    setSelectedUser(user);
    setFormData({ name: user.name, email: user.email });
    setMode('view');
    setShowModal(true);
  };

  // Función para editar un usuario
  const editUser = (user) => {
    setSelectedUser(user);
    setFormData({ name: user.name, email: user.email });
    setMode('edit');
    setShowModal(true);
  };

  // Función para cerrar el modal
  const handleCloseModal = () => {
    setShowModal(false);
    setSelectedUser(null);
  };

  // Función para manejar cambios en los inputs del formulario
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  // Función para guardar un usuario
  const handleSaveUser = async () => {
    const { name, email } = formData;
    if (!name || !email) {
      alert('Por favor ingresa un nombre y un correo.');
      return;
    }

    try {
      if (mode === 'edit') {
        await axios.put(`${apiBaseUrl}/users/${selectedUser.id}`, formData);
      } else if (mode === 'add') {
        await axios.post(`${apiBaseUrl}/users`, formData);
      }
      getUsers(); // Recargar la lista de usuarios
      handleCloseModal();
    } catch (error) {
      console.error('Error al guardar el usuario', error);
    }
  };

  // Función para eliminar usuario
  const deleteUser = async (id) => {
    if (window.confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
      try {
        await axios.delete(`${apiBaseUrl}/users/${id}`);
        getUsers(); // Recargar la lista de usuarios
      } catch (error) {
        console.error('Error al eliminar el usuario', error);
      }
    }
  };

  // Función para exportar usuarios a Excel
  const exportToExcel = () => {
    const ws = XLSX.utils.json_to_sheet(users);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Usuarios");
    XLSX.writeFile(wb, "usuarios.xlsx");
  };

  return (
    <>
      <div className="container mt-4">
        <h2 className="mb-4">Usuarios</h2>

        <div className="mb-3 d-flex justify-content-between">
          <Button variant="primary" onClick={handleShowAddUser}>
            <i className="fas fa-user-plus"></i> Agregar Usuario
          </Button>
          <Button variant="success" onClick={exportToExcel}>
            <i className="fas fa-file-excel"></i> Exportar a Excel
          </Button>
        </div>

        {/* Input de búsqueda con icono */}
        <div className="mb-3 d-flex justify-content-end">
          <div className="input-group" style={{ width: '40%' }}>
            <input
              type="text"
              className="form-control"
              placeholder="Buscar"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
            <span className="input-group-text">
              <i className="fas fa-search"></i> {/* Icono de búsqueda */}
            </span>
          </div>
        </div>

        {/* Tabla de usuarios con contenedor fijo */}
        <div className="table-container">
          <table className="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {loading ? (
                <tr>
                  <td colSpan="3" className="text-center">
                    Cargando...
                  </td>
                </tr>
              ) : (
                filteredUsers.map(user => (
                  <tr key={user.id}>
                    <td>{user.name}</td>
                    <td>{user.email}</td>
                    <td>
                      <Button variant="secondary" onClick={() => viewUser(user)}>
                        <i className="fas fa-eye"></i>
                      </Button>
                      <Button variant="warning" onClick={() => editUser(user)} className="mx-2">
                        <i className="fas fa-edit"></i>
                      </Button>
                      <Button variant="danger" onClick={() => deleteUser(user.id)}>
                        <i className="fas fa-trash"></i>
                      </Button>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
      </div>

      {/* Modales para ver, editar y agregar usuarios */}
      {mode === 'view' && (
        <Modal show={showModal} onHide={handleCloseModal}>
          <Modal.Header closeButton>
            <Modal.Title>Ver Usuario</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <Form>
              <Form.Group className="mb-3">
                <Form.Label>Nombre</Form.Label>
                <Form.Control type="text" value={formData.name} readOnly />
              </Form.Group>
              <Form.Group className="mb-3">
                <Form.Label>Email</Form.Label>
                <Form.Control type="email" value={formData.email} readOnly />
              </Form.Group>
            </Form>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="secondary" onClick={handleCloseModal}>Cerrar</Button>
          </Modal.Footer>
        </Modal>
      )}

      {mode === 'edit' && (
        <Modal show={showModal} onHide={handleCloseModal}>
          <Modal.Header closeButton>
            <Modal.Title>Editar Usuario</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <Form>
              <Form.Group className="mb-3">
                <Form.Label>Nombre</Form.Label>
                <Form.Control
                  type="text"
                  name="name"
                  value={formData.name}
                  onChange={handleInputChange}
                />
              </Form.Group>
              <Form.Group className="mb-3">
                <Form.Label>Email</Form.Label>
                <Form.Control
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                />
              </Form.Group>
            </Form>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="secondary" onClick={handleCloseModal}>Cerrar</Button>
            <Button variant="warning" onClick={handleSaveUser}>Actualizar Usuario</Button>
          </Modal.Footer>
        </Modal>
      )}

      {mode === 'add' && (
        <Modal show={showModal} onHide={handleCloseModal}>
          <Modal.Header closeButton>
            <Modal.Title>Agregar Usuario</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <Form>
              <Form.Group className="mb-3">
                <Form.Label>Nombre</Form.Label>
                <Form.Control
                  type="text"
                  name="name"
                  value={formData.name}
                  onChange={handleInputChange}
                />
              </Form.Group>
              <Form.Group className="mb-3">
                <Form.Label>Email</Form.Label>
                <Form.Control
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                />
              </Form.Group>
            </Form>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="secondary" onClick={handleCloseModal}>Cerrar</Button>
            <Button variant="primary" onClick={handleSaveUser}>Agregar Usuario</Button>
          </Modal.Footer>
        </Modal>
      )}
    </>
  );
};

export default UsersTable;
