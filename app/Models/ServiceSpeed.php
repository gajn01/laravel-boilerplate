<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSpeed extends Model
{
    use HasFactory;


    protected $table = 'service_speed';

    protected $fillable = [
        'form_id',
        'is_cashier',
        'name',
        'time',
        'product_ordered',
        'ot',
        'assembly',
        'assembly_points',
        'tat',
        'tat_points',
        'fst',
        'fst_points',
        'remarks',
        'serving_time'
    ];

}
