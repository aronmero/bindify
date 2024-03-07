<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Municipality;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            Municipality::where('id', $request->municipality_id)->firstOrFail();

            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'municipality_id' => $request->municipality_id,
                'avatar' => $request->avatar,
                'username' => $request->username,
                'nombre' => $request->nombre
            ]);

            Customer::create([
                'user_id' => $user->id,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
            ]);

            $data =  Customer::join('users', 'customers.user_id', '=', 'users.id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->select(
                'email',
                'phone',
                'municipalities.name AS municipality_name',
                'avatar',
                'username',
                'users.name',
                'gender',
                'birth_date'
            )
            ->where('users.id', '=', $user->id)
            ->firstOrFail();

            return response()->json([
                "status" => true,
                "message" => 'Customer creado.',
                "data" => $data
            ], 200);

        } catch (QueryException $e) {

            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    "status" => false,
                    "error" => "Error de entrada duplicada: " . $e->getMessage()
                ], 409);

            } else {
                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);
            }

        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Municipio con id: $request->municipality_id no encontrado",
            ], 404);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {

            $customer = Customer::where('user_id', $id)->firstOrFail();

            $customer = Customer::join('users', 'customers.user_id', '=', 'users.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->select(
                    'email',
                    'phone',
                    'municipalities.name AS municipality_name',
                    'avatar',
                    'username',
                    'users.name',
                    'gender',
                    'birth_date'
                )
                ->where('users.id', '=', $id)
                ->firstOrFail();

            return response()->json([
                "status" => true,
                "data" => $customer
            ], 200);

        } catch (QueryException $e) {

            // Verificar si la excepción es por entrada duplicada
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    "status" => false,
                    "error" => "Error de entrada duplicada: " . $e->getMessage()
                ], 409); // Código de estado HTTP 409: Conflict
            } else {
                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500); // Código de estado HTTP 500: Internal Server Error
            }
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {

            $user = User::find($id)->firstOrFail();
            $customer = Customer::where('user_id', $id)->firstOrFail();

            $user->email = $request->email;
            $user->password = $request->password;
            $user->phone = $request->phone;
            $user->municipality_id = $request->municipality_id;
            $user->avatar = $request->avatar;
            $user->username = $request->username;
            $user->nombre = $request->nombre;

            $customer->gender = $request->gender;
            $customer->birth_date = $request->birth_date;

            $user->save();
            $customer->save();

            $data =  Customer::join('users', 'customers.user_id', '=', 'users.id')
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->select(
                'email',
                'phone',
                'municipalities.name AS municipality_name',
                'avatar',
                'username',
                'users.name',
                'gender',
                'birth_date'
            )
            ->where('users.id', '=', $user->id)
            ->firstOrFail();

            return response()->json([
                "status" => true,
                "message" => 'Customer actualizado.',
                "data" => $data
            ], 200);

        } catch (QueryException $e) {

            // Verificar si la excepción es por entrada duplicada
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    "status" => false,
                    "error" => "Error de entrada duplicada: " . $e->getMessage()
                ], 409); // Código de estado HTTP 409: Conflict
            } else {
                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500); // Código de estado HTTP 500: Internal Server Error
            }
        } catch (ModelNotFoundException $e) {

            return response()->json([
                "status" => false,
                "error" => "Customer no encontrado",
            ], 404);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "error" => $e->getMessage()
            ], 404);
        }
    }
}
