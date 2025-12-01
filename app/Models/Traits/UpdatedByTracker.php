<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait UpdatedByTracker
{
    public static function bootUpdatedByTracker()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function updatedByUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
