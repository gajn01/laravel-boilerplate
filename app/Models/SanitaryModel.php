<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryModel extends Model
{
    use HasFactory;

    protected $table = 'sanitary_defect';

    protected $fillable = [
        'id',
        'title',
        'code'
    ];
}
