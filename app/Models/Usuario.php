<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'usuario';

    protected $fillable = [
        'login',
        'password',
        'nombre',
        'habilitado',
        'cambiar_password',
        'correo',
        'fecha_creacion',
        'fecha_desactivado',
        'fecha_ultima_modificacion',
        'fecha_ultima_ingreso',
        'telefono'

    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function  getJWTCustomClaims()
    {
        return [];
    }
}
