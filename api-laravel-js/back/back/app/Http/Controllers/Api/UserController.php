<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        try {
            $users = User::all(); // Obtener todos los usuarios
            return response()->json($users, 200); // Retornar los usuarios en formato JSON
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al obtener los usuarios.'], 500);
        }
    }

    // Crear un nuevo usuario
    public function store(Request $request)
{

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    try {
        // Intentar crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Respuesta exitosa
        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);

    } catch (\Exception $e) {
        // Log del error con detalles
        Log::error('Error al crear usuario: '.$e->getMessage());
        
        return response()->json(['message' => 'Error al crear el usuario'], 500);
    }
}


    // Obtener un solo usuario por su ID
    public function show($id)
    {
        try {
            $user = User::findOrFail($id); // Buscar el usuario por ID
            return response()->json($user, 200); // Retornar el usuario en formato JSON
        } catch (\Exception $e) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {

      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',  // La regla correcta para validar email
      ]);

        try {
            $user = User::findOrFail($id); // Buscar el usuario por ID

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id); // Buscar el usuario por ID
            $user->delete(); // Eliminar el usuario

            return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el usuario'], 500);
        }
    }
}
?>