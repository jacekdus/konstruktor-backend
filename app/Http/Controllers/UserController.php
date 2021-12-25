<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Lumen\Routing\Controller;


class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|min:8',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
            ]
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            User::insert([
                'login' => $request->input('login'),
                'password' => Hash::make($request->input('password'))
            ]);

            return response()->json(['message' => 'ok']);
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($user) {
            Project::where('user_id', $user->id)->delete();
            $user->delete();
        });
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $login = $request->input('login');
        $password = $request->input('password');

        /** @var User $user */
        $user = User::select()
            ->where('login', $login)
            ->first();

        if (Hash::check($password, $user->password)) {
            $token = bin2hex(random_bytes(16));

            User::where('id', $user->id)->update(['api_token' => $token]);

            return response()->json(['token' => $token]);
        } else
        {
            return response()->json(['login or password incorrect']);
        }
    }
}
