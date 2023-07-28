<?php

namespace App\Models\NonDBModel;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $primaryKey = 'module';
    protected $keyType = 'string';
    protected $fillable =[
        'enabled',
        'access_level',
        'access_type',     
    ];

    public $incrementing = false;
    public $timestamps = false;
}