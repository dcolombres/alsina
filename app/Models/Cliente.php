<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'apellido', 'area', 'dependencia', 'origen', 'email', 'celular', 'equipo_trabajo'
    ];

    protected $casts = [
        'equipo_trabajo' => 'array',
    ];

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'cliente_proyecto');
    }

    public function proyectosComoClientePrincipal()
    {
        return $this->hasMany(Proyecto::class, 'cliente_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}