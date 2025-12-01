<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UpdatedByTracker;

class Proyecto extends Model
{
    use HasFactory, UpdatedByTracker;

    protected $fillable = [
        'nombre', 'descripcion', 'origen', 'dependencia', 'tier', 'cliente_id', 'estado', 'categoria', 'subcategoria', 'responsable_id', 'observacion', 'urls', 'captura', 'nube', 'ticketera_interna', 'ticketera_externa', 'changelog', 'ano', 'usuarios_internos', 'usuarios_externos', 'versionado', 'vms', 'instrucciones_deploy', 'referente', 'notas_infraestructura',
        'lenguaje_principal_backend', 'version_backend', 'otro_lenguaje_backend', 'librerias_backend', 'framework_backend',
        'lenguaje_principal_frontend', 'version_frontend', 'otro_lenguaje_frontend', 'librerias_frontend', 'framework_frontend',
        'tecnologia_bd', 'version_bd', 'bd_2', 'tamaño_bd', 'servidor_bd', 'backup_bd',
        'repositorio', 'url_repositorio', 'instrucciones_stack',
        'alojamiento_productivo', 'alojamiento_hml', 'alojamiento_tst', 'contenedor'
    ];

    protected $casts = [
        'urls' => 'array',
        'backup_bd' => 'boolean',
        'instrucciones_stack' => 'boolean',
        'contenedor' => 'boolean',
    ];

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'proyecto_staff');
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_proyecto');
    }

    public function responsable()
    {
        return $this->belongsTo(Staff::class, 'responsable_id');
    }

    public function clientePrincipal()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}