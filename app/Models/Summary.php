<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;
    protected $table = 'summary';
    protected $fillable = [
        'name',
        'code',
        'type',
        'with',
        'conducted_by',
        'received_by',
        'date_of_visit',
        'time_of_audit',
        'wave',
        'overall_score',
        'strength',
        'improvement',
    ];

}
