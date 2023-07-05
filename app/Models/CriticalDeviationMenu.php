<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalDeviationMenu extends Model
{
    use HasFactory;
    protected $table = 'critical_deviation_menu';

    protected $fillable = [
        'critical_deviation_id',
        'label',
        'remarks',
        'score_dropdown_id',
        'is_sd',
        'is_location',
        'location_dropdown_id',
        'is_product',
        'product_dropdown_id',
        'is_dropdown',
        'dropdown_id',
    ];

    public function criticalDeviation()
    {
        return $this->belongsTo(CriticalDeviation::class, 'critical_deviation_id','id');
    }

    public function CriticalDeviationResult(){
        return $this->hasMany(CriticalDeviationResult::class, 'deviation_id');
    }

    public function scoreDropdown()
    {
        return $this->belongsTo(ScoreDropdown::class);
    }

    public function dropdown()
    {
        return $this->belongsTo(Dropdown::class);
    }
}
