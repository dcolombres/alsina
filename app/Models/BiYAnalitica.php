<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UpdatedByTracker;

class BiYAnalitica extends Model
{
    use HasFactory, UpdatedByTracker;

    protected $table = 'bi_y_analitica';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
