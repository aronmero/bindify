<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(string $username)
    {

        $user = User::where("username", $username)->firstOrFail();

        if ($user->getRoleNames() == "customer") {

            try {

                $customer = Customer::join('users', 'customers.user_id', '=', 'users.id')
                    ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                    ->select(
                        'email',
                        'phone',
                        'municipalities.name AS municipality_name',
                        'avatar',
                        //'banner',
                        'username',
                        'users.name',
                        'gender',
                        'birth_date'
                    )
                    ->where('users.username', '=', $username)
                    ->firstOrFail();

                return response()->json([
                    "status" => true,
                    "data" => $customer
                ], 200);

            } catch (QueryException $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);

            } catch (Exception $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 404);
            }

        } else {

            try {

                $commerce = Commerce::join('users', 'commerces.user_id', '=', 'users.id')
                ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
                ->join('categories', 'commerces.category_id', '=', 'categories.id')
                ->select(
                    'email',
                    'phone',
                    'municipalities.name AS municipality_name',
                    'avatar',
                    //'banner',
                    'username',
                    'users.name',
                    'address',
                    'commerces.description',
                    'categories.name AS categories_name',
                    'schedule',
                    'commerces.active'
                )
                ->where('users.username', '=', $username)
                ->firstOrFail();


                return response()->json([
                    "status" => true,
                    "data" => $commerce
                ], 200);

            } catch (QueryException $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 500);

            } catch (Exception $e) {

                return response()->json([
                    "status" => false,
                    "error" => $e->getMessage()
                ], 404);
            }

        }

    }
}
