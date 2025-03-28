<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;

class AuthService
{
    // Inscription d'un utilisateur
    public function register(RegisterUserRequest $request)
    {
        // Validation des données d'inscription via le FormRequest
        $validated = $request->validated();

        // Créer l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Événement d'enregistrement
        // event(new Registered($user));

        return $user;
    }

    // Connexion d'un utilisateur
    public function login(LoginUserRequest $request)
    {
        // Validation des données de connexion via le FormRequest
        $validated = $request->validated();

        // Vérifier les identifiants
        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            // throw new \Exception('Email ou mot de passe invalide');
            return false ;
        }

        // Générer un token d'accès
        $token = $user->createToken($user->name)->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    // Déconnexion d'un utilisateur
    public function logout($user)
    {
        // Révoquer tous les tokens de l'utilisateur
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return ['message' => 'Déconnexion réussie'];
    }
}
