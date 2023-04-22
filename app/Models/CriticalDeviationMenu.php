<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalDeviationMenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'critical_deviation_id',
        'label',
        'remarks',
        'score_dropdown_id',
        'is_sd',
        'is_dropdown',
        'dropdown_id',
    ];

    public function deviation()
    {
        return $this->belongsTo(CriticalDeviation::class, 'critical_deviation_id');
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
