<?php

namespace Modules\Settings\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Settings\Database\factories\SetLocationFactory;

class SetLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): SetLocationFactory
    {
        //return SetLocationFactory::new();
    }
}
