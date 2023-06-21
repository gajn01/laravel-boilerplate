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
        'base_assembly_points',
        'assembly_points',
        'tat',
        'base_tat_points',
        'tat_points',
        'fst',
        'base_fst_points',
        'fst_points',
        'remarks',
        'serving_time'
    ];

}
