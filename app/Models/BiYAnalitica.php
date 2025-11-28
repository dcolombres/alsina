<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiYAnalitica extends Model
{
    use HasFactory;

    protected $table = 'bi_y_analitica';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
