<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{


    protected $fillable = [
        'name',
        'latitude',
        'logitude',
        'user_id'
    ];
    use HasFactory;


    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
