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

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'municipality_id' => $request->municipality_id,
            'avatar' => $request->avatar,
            'username' => $request->username,
            'name' => $request->name
        ]);

        
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        if ($request->empresa) {
            if ($request->verificationToken != null) {
                $user->assignRole('ayuntamiento');
            } else {
                $user->assignRole('comercio');
            }

            $commerce = Commerce::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'description' => $request->description,
            'verification_token_id' => $request->verification_token_id,
            'category_id' => $request->category_id,
            'verificated'=> false,
            'schedule' => $request->schedule
        ]);
            $commerce->user()->attach($user->id);
        } else {
            $user->assignRole('cliente');
            $customer = Customer::create([
                'user_id' => $user->id,
            ]);
            $customer->user()->attach($user->id);
        }


        $response = [
            'message' => 'Usuario credo correctamente',
            'user' => $user,
        ];


        return response($response, 201);
    }
}
