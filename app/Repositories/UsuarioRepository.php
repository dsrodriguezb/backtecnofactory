<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioRepository
{
    protected $model;

    public function __construct(Usuario $model)
    {
        $this->model = $model;
    }

    public function signIn($credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return [
                    'error' => 'invalid credentials',
                    'status' => 400
                ];
            }
            $user = auth()->user();
            $customClaims = [ 'id' => $user->id, 'login' => $user->login];
            $token = JWTAuth::claims($customClaims)->attempt($credentials);

            return [
                'token' => $token,
                'status' => 200
            ];
        } catch (JWTException $e) {
            return [
                'error' => 'An error occurred while validating session',
                'status' => 500
            ];
        }
    }

    public function signUp($data)
    {
        try {
            $validator = Validator::make($data, [
                'login' => 'required|max:50',
                'password' => 'required|min:6|max:50|confirmed',
                'correo' => 'required|email|max:100',
                'nombre' => 'required|max:100',
                'telefono' => 'required|max:20'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $status = 422;
                if ($errors->hasAny(['login', 'correo', 'password', 'nombre', 'telefono'])) {
                    $status = 400;
                }
                return [
                    'message' => 'Error in validation of data',
                    'errors' => $errors,
                    'status' => $status
                ];
            }

            $user = Usuario::create([
                'login' => $data['login'],
                'password' => Hash::make($data['password']),
                'nombre' => $data['nombre'],
                'habilitado' => 1,
                'correo' => $data['correo'],
                'telefono' => $data['telefono'],
            ]);

            if (!$user) {
                return [
                    'message' => 'Error creating the user',
                    'status' => 500
                ];
            }

            $customClaims = [
                'usuario' => $user->login
            ];

            $token = JWTAuth::claims($customClaims)->fromUser($user);

            return [
                'message' => 'user created successfully',
                'user' => $user,
                'token' => $token,
                'status' => 201
            ];
        } catch (QueryException $e) {
            if ($e->getCode() == '22001') {
                return [
                    'message' => 'Data too long for one or more columns',
                    'status' => 422
                ];
            }
            return [
                'message' => 'Error creating user',
                'status' => 500
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'An unexpected error occurred',
                'status' => 500
            ];
        }
    }

    public function logOut()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            return [
                'message' => 'Token invalidated successfully',
                'status' => 200
            ];
        } catch (JWTException $e) {
            return [
                'message' => 'Failed to invalidate token',
                'status' => 500
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'An unexpected error occurred',
                'status' => 500
            ];
        }
    }

    public function getByLogin($login)
    {
        try {
            $usuario = $this->model->select('id', 'login', 'nombre', 'correo', 'telefono')->where('login', $login)->first();

            if (!$usuario) {
                return [
                    'message' => 'No data found',
                    'status' => 404
                ];
            }

            unset($usuario['password']);

            return [
                'user' => $usuario,
                'status' => 200
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'An unexpected error occurred',
                'status' => 500
            ];
        }
    }
}
