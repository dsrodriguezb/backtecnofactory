<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UsuarioRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $UsuarioRepository;

    public function __construct(UsuarioRepository $UsuarioRepository)
    {
        $this->UsuarioRepository = $UsuarioRepository;
    }

    /**
     * Inicio de sesión del usuario
     * @OA\Post (
     *     path="/api/auth/signin",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="correo",
     *                 type="string",
     *                 example="davidsebas995@gmail.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="eyJ0eXAiOiJKV1QiLCJh..."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="invalid credentials"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=400
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Not create token",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not create token"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=500
     *             )
     *         )
     *     )
     * )
     */
    public function signIn(Request $request)
    {
        $credentials = $request->only('correo', 'password');
        $result = $this->UsuarioRepository->signIn($credentials);

        if ($result['status'] == 200) {
            return response()->json(['token' => $result['token']], 200);
        } else {
            return response()->json($result, $result['status']);
        }
    }

    /**
     * Registro de un nuevo usuario
     * @OA\Post (
     *     path="/api/auth/signup",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="login",
     *                 type="string",
     *                 example="johndoe12"
     *             ),
     *             @OA\Property(
     *                     property="correo",
     *                     type="string",
     *                     example="johndoe12@gmail.com"
     *                 ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password123"
     *             ),
     *             @OA\Property(
     *                 property="password_confirmation",
     *                 type="string",
     *                 example="password123"
     *             ),
     *             @OA\Property(
     *                 property="nombre",
     *                 type="string",
     *                 example="John Doe"
     *             ),
     *             @OA\Property(
     *                 property="telefono",
     *                 type="string",
     *                 example="1010202030"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="login",
     *                     type="string",
     *                     example="johndoe12"
     *                 ),
     *                  @OA\Property(
     *                     property="correo",
     *                     type="string",
     *                     example="johndoe12@gmail.com"
     *                 ),
     *                  @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="passsword"
     *                 ),
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="telefono",
     *                     type="string",
     *                     example="1010202030"
     *                  ),
     *             ),
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="eyJ0eXAiOiJKV1QiLCJh..."
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=201
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in validation of data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error in validation of data"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=400
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creating the user",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Error creating the user"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=500
     *             )
     *         )
     *     )
     * )
     */
    public function signUp(Request $request)
    {
        $data = $request->all();
        $result = $this->UsuarioRepository->signUp($data);

        return response()->json([$result], $result['status']);
    }

    /**
     * Cierre de sesión del usuario
     * @OA\Post (
     *     path="/api/auth/logout",
     *     tags={"Authentication"},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvc2lnbmluIiwiaWF0IjoxNzE2NTgwMTg4LCJleHAiOjE3MTY1ODM3ODgsIm5iZiI6MTcxNjU4MDE4OCwianRpIjoiVXNEaEpXRHNzYnlaNllWTSIsInN1YiI6IjI2OSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token invalidated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Token invalidated successfully"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to invalidate token",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Failed to invalidate token"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=500
     *             )
     *         )
     *     )
     * )
     */
    public function logOut(Request $request)
    {
        $result = $this->UsuarioRepository->logOut();

        return response()->json($result, $result['status']);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/profile/{login}",
     *     tags={"Authentication"},
     *     summary="Obtiene un usuario por login",
     *     description="Retorna un usuario basado en su login. Requiere un token de autenticación Bearer.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="login",
     *         in="path",
     *         description="Login del usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="johndoe@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="3112112111"
     *                 ),
     *                 @OA\Property(
     *                     property="language",
     *                     type="string",
     *                     example="Spanish"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2024-02-23T00:09:16.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2024-02-23T12:33:45.000000Z"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No data found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No data found"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=404
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthorized"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=401
     *             )
     *         )
     *     )
     * )
     */
    public function show($login)
    {
        $result = $this->UsuarioRepository->getByLogin($login);

        return response()->json($result, $result['status']);
    }
}
