<?php

namespace App\Http\Controllers\Comics;

use App\Http\Controllers\Controller;
use App\Repositories\FavoritosRepository;
// use App\Models\Favorito;
// use App\Repositories\FavoritoRepository;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Http;

class FavoritoController extends Controller
{
    protected $favoritoRepository;

    public function __construct(FavoritosRepository $favoritoRepository)
    {
        $this->favoritoRepository = $favoritoRepository;
    }

    public function toggleFavorite(Request $request, $comicId, $usuarioId)
    {
        $result = $this->favoritoRepository->toggleFavorite($usuarioId, $comicId);
        return response()->json($result['message'], $result['status']);
    }


    /**
     * @OA\Get(
     *     path="/api/favorites/{id}",
     *     tags={"Comics"},
     *     summary="Obtener favoritos de usuario",
     *     description="Retorna los comics favoritos del usuario. Requiere un token de autenticación Bearer.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id del usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
    public function getFavorites($usuarioId)
    {
        $favoritos = $this->favoritoRepository->getFavorites($usuarioId);
        $comicsDetails = $this->favoritoRepository->fetchComicsDetails($favoritos);

        return response()->json($comicsDetails);
    }
}
