<?php

namespace App\Repositories;

use App\Models\Favorito;
use Illuminate\Support\Facades\Http;

class FavoritosRepository
{
    protected $model;

    public function __construct(Favorito $model)
    {
        $this->model = $model;
    }

    public function toggleFavorite($usuarioId, $comicId)
    {
        $favorito = $this->model->where('usuario_id', $usuarioId)->where('comic_id', $comicId)->first();

        if ($favorito) {
            $favorito->delete();
            return [
                'message' => 'Removed from favorites',
                'status' => 200
            ];
        } else {
            $this->model->create(['usuario_id' => $usuarioId, 'comic_id' => $comicId]);
            return [
                'message' => 'Added to favorites',
                'status' => 201
            ];
        }
    }

    public function getFavorites($usuarioId)
    {
        return $this->model->where('usuario_id', $usuarioId)->pluck('comic_id');
    }

    public function fetchComicsDetails($favoritos)
    {
        $url = "https://gateway.marvel.com/v1/public/comics";
        $key = "ea5c51f46f53cf102ddbfda4929b1672";
        $hash = "c5e2f5faa725913a3a049eb2616d36c5";
        $comicsDetails = [];

        foreach ($favoritos as $comicId) {
            $response = Http::get("{$url}/{$comicId}?ts=1&apikey={$key}&hash={$hash}");
            if ($response->successful()) {
                $comicsDetails[] = $response->json()['data']['results'][0];
            }
        }

        return $comicsDetails;
    }
}
