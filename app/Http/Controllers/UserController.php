<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mostrar tots els usuaris
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $request->validate([
            'usuari' => 'required|unique:users,usuari',
            'nom' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'rol' => 'required|in:client,vendedor,admin',
        ]);

        // Crear un nou usuari
        $user = new User();
        $user->usuari = $request->usuari;
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Encriptar la contrasenya
        $user->rol = $request->rol;
        $user->img = 'images/users/default.png'; // Imatge per defecte
        $user->password_confirmation = Hash::make($request->password_confirmation); // Encriptar la confirmació de contrasenya

        // Guardar el usuari
        if($user->save()) {
            return response()->json($user, 200);
        }

        // Retornar error si no s'ha pogut crear l'usuari
        return response()->json(['error' => 'Error en crear l\'usuari'], 500);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Comprovar que l'usuari existeix
        $user = User::where('email', $request->email)->first();

        // Comprovar que la contrasenya és correcta
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credencials no vàlides'], 401);
        }

        // Crear token d'autenticació
        $token = $user->createToken('authToken')->plainTextToken;

        // Retornar l'usuari i el token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Tancar la sessió de l'usuari
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Sessió tancada correctament']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // Obtenir l'usuari autenticat
        $user = Auth::user();

        // Mostrar el usuari
        if($user) {
            return response()->json($user, 200);
        }

        // Retornar error si no s'ha trobat l'usuari
        return response()->json(['error' => 'Usuari no trobat'], 404);
    }

    public function getUserByUsername(Request $request)
    {
        // Obtenir el nom d'usuari de la URL
        $username = $request->query('username');

        // Comprovar que s'ha enviat el nom d'usuari
        if(!$username) {
            return response()->json(['error' => 'El nom d\'usuari és obligatori'], 400);
        }

        // Buscar l'usuari per nom d'usuari
        $user = User::where('usuari', $username)->first();

        // Mostrar l'usuari
        if($user) {
            return response()->json($user, 200);
        }

        // Retornar error si no s'ha trobat l'usuari
        return response()->json(['error' => 'Usuari no trobat'], 404);
    }

    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'usuari' => 'required|unique:users,usuari,' . $id,
            'nom' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'rol' => 'required|in:client,vendedor,admin',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'direccio' => 'nullable|string',
            'comarca' => 'nullable|string',
            'municipi' => 'nullable|string',
            'provincia' => 'nullable|in:Barcelona,Tarragona,Lleida,Girona',
        ]);

        // Buscar l'usuari per id
        $user = User::find($id);

        // Retornar error si no s'ha trobat l'usuari
        if(!$user) {
            return response()->json(['error' => 'Usuari no trobat'], 404);
        }

        // Actualitzar l'usuari
        $user->usuari = $request->usuari;
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->password_confirmation = Hash::make($request->password_confirmation); // Add password confirmation
        $user->rol = $request->rol;

        // Actualitzar la direccio si s'ha enviat
        if($request->has('direccio')) {
            $user->direccio = $request->direccio;
        }

        // Actualitzar la comarca si s'ha enviat
        if($request->has('comarca')) {
            $user->comarca = $request->comarca;
        }

        // Actualitzar el municipi si s'ha enviat
        if($request->has('municipi')) {
            $user->municipi = $request->municipi;
        }

        // Actualitzar la provincia si s'ha enviat
        if($request->has('provincia')) {
            $user->provincia = $request->provincia;
        }

        // Actualitzar la imatge si s'ha enviat
        if($request->hasFile('img')) {
            // Eliminar la imatge anterior
            if($user->img !== 'images/users/default.png' && file_exists(public_path($user->img))) {
                unlink(public_path($user->img));
            }

            $imagePath = 'images/users/' . Str::random(32) . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('images/users'), $imagePath);
            $user->img = $imagePath;
        }

        // Guardar l'usuari
        if($user->save()) {
            return response()->json(['message' => 'Usuari actualitzat correctament', 'user' => $user], 200);
        }

        // Retornar error si no s'ha pogut actualitzar l'usuari
        return response()->json(['error' => 'Error en actualitzar l\'usuari'], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable|same:password',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'direccio' => 'nullable|string',
            'comarca' => 'nullable|string',
            'municipi' => 'nullable|string',
            'provincia' => 'nullable|in:Barcelona,Tarragona,Lleida,Girona',
        ]);

        // Obtenir l'usuari autenticat
        $user = User::find(Auth::user()->id);

        // Retornar error si no s'ha trobat l'usuari
        if(!$user) {
            return response()->json(['error' => 'Usuari no trobat'], 404);
        }

        // Actualitzar la contrasenya del usuari
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->password_confirmation = Hash::make($request->password_confirmation); // Add password confirmation
        }

        // Actualitzar la direccio si s'ha enviat
        if($request->has('direccio')) {
            $user->direccio = $request->direccio;
        }

        // Actualitzar la comarca si s'ha enviat
        if($request->has('comarca')) {
            $user->comarca = $request->comarca;
        }

        // Actualitzar el municipi si s'ha enviat
        if($request->has('municipi')) {
            $user->municipi = $request->municipi;
        }

        // Actualitzar la provincia si s'ha enviat
        if($request->has('provincia')) {
            $user->provincia = $request->provincia;
        }

        // Actualitzar la imatge del usuari si s'ha enviat
        if($request->hasFile('img')) {
            // Eliminar la imatge anterior
            if($user->img !== 'images/users/default.png' && file_exists(public_path($user->img))) {
                unlink(public_path($user->img));
            }

            $imagePath = 'images/users/' . Str::random(32) . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('images/users'), $imagePath);
            $user->img = $imagePath;
        }

        // Guardar l'usuari
        if($user->save()) {
            return response()->json(['message' => 'Usuari actualitzat correctament', 'user' => $user], 200);
        }

        // Retornar error si no s'ha pogut actualitzar l'usuari
        return response()->json(['error' => 'Error en actualitzar l\'usuari'], 500);
    }

    /**
     * Update the password of the user.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Obtenir l'email de la URL
        $email = $request->query('email');

        // Comprovar que s'ha enviat l'email
        if(!$email) {
            return response()->json(['error' => 'El correu electrònic és obligatori'], 400);
        }

        // Buscar l'usuari per email
        $user = User::where('email', $email)->first();

        // Retornar error si no s'ha trobat l'usuari
        if(!$user) {
            return response()->json(['error' => 'Usuari no trobat'], 404);
        }

        // Actualitzar la contrasenya de l'usuari
        $user->password = Hash::make($request->new_password);
        $user->password_confirmation = Hash::make($request->new_password_confirmation); // Add password confirmation
        if($user->save()) {
            return response()->json(['message' => 'Contrasenya actualitzada correctament'], 200);
        }

        return response()->json(['error' => 'Error en actualitzar la contrasenya'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // Obtenir l'usuari autenticat
        $user = User::find(Auth::user()->id);

        // Retornar error si no s'ha trobat l'usuari
        if(!$user) {
            return response()->json(['error' => 'Usuari no trobat'], 404);
        }

        // Eliminar la imatge del usuari
        if($user->img !== 'images/users/default.png' && file_exists(public_path($user->img))) {
            unlink(public_path($user->img));
        }

        // Eliminar l'usuari
        if($user->delete()) {
            return response()->json(['message' => 'Usuari eliminat correctament'], 200);
        }

        // Retornar error si no s'ha pogut eliminar l'usuari
        return response()->json(['error' => 'Error en eliminar l\'usuari'], 500);
    }

    public function adminDestroy($id)
    {
        // Buscar l'usuari per id
        $user = User::find($id);

        // Retornar error si no s'ha trobat l'usuari
        if(!$user) {
            return response()->json(['error' => 'Usuari no trobat'], 404);
        }

        // Eliminar la imatge de l'usuari
        if($user->img !== 'images/users/default.png' && file_exists(public_path($user->img))) {
            unlink(public_path($user->img));
        }

        // Eliminar l'usuari
        if($user->delete()) {
            return response()->json(['message' => 'Usuari eliminat correctament'], 200);
        }

        // Retornar error si no s'ha pogut eliminar l'usuari
        return response()->json(['error' => 'Error en eliminar l\'usuari'], 500);
    }
}
