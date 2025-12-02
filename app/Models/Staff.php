<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;

class Staff extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff';

    protected $fillable = [
        'nombres', 'apellidos', 'email', 'celular', 'rol', 'tipo', 'seniority',
        'tecnologia', 'contrato', 'remuneracion', 'ur', 'extras',
        'modalidad', 'activo', 'dias_presencial', 'dias_remoto'
    ];

    protected $casts = [
        'ur' => 'boolean',
        'extras' => 'boolean',
        'activo' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['nombre_apellido'];

    /**
     * Get the user's full name.
     */
    protected function nombreApellido(): Attribute
    {
        return Attribute::make(
            get: fn () => trim($this->nombres . ' ' . $this->apellidos),
        );
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_staff');
    }

    public function proyectosComoResponsable()
    {
        return $this->hasMany(Proyecto::class, 'responsable_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
