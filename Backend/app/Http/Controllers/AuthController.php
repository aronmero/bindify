<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Commerce;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $datos)
    {
        $credenciales = $datos->only('email', 'password');
        if (Auth::attempt($credenciales)) {
            $user = User::where('email', $datos->email)->first();
            $token = $user->createtoken('my_app_token')->plainTextToken;

            $response = [
                'token' => $token
            ];

            return response($response, 201);
        }

        return response()->json(['error' => 'Ususario no encontrado'], 404);
    }

    public function register(RegisterRequest $datos)
    {
        $user = new User();
        $user->name = $datos->name;
        $user->email = $datos->email;
        $user->phone = $datos->phone;
        $user->password = Hash::make($datos->password);
        $user->save();
        $credentials = $datos->only('email', 'password');
        Auth::attempt($credentials);
        if ($datos->empresa) {
            $user->assignRole('commerce');
            $commerce = Commerce::create([
                'user_id' => $user->id,
            ]);
            $commerce->user()->associate($user->id);
        } else {
            $user->assignRole('customer');
            $customer = Customer::create([
                'user_id' => $user->id,
            ]);
            $customer->user()->associate($user->id);
        }


        $response = [
            'message' => 'Usuario credo correctamente',
            'user' => $user,
        ];


        return response($response, 201);
    }
}
