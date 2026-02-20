<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

trait BaseAudit {
    protected static function bootBaseAudit(){
        static::creating(function ($model) {
            if(Auth::check()){
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model){
            if(Auth::check()){
                $model->updated_by = Auth::id();
            }
        });
    }

    public function creator():BelongsTo{
        return $this->belongsTo(USer::class, 'created_by');
    }

    public function updator():BelongsTo{
        return $this->belongsTo(USer::class, 'updated_by');
    }

}
