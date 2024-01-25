<?php

namespace Modules\Settings\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Settings\Database\factories\SetStateFactory;

class SetState extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): SetStateFactory
    {
        //return SetStateFactory::new();
    }
}
