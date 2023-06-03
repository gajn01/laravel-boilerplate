<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryResult extends Model
{
    use HasFactory;
    protected $table = 'summary_results';
    protected $fillable = [
        'summary_id',
        'store_id',
        'category',
        'score',
        'percentage',
        'remarks',
    ];
}
