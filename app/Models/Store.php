<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'type',
        'representative',
        'area',
        'created_at'
    ];

    protected $dates = ['created_at'];
}
