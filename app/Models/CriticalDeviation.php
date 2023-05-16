<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalDeviation extends Model
{
    use HasFactory;
    protected $table = 'critical_deviations';

    protected $fillable = [
        'name',
    ];

    public function deviationMenu()
    {
        return $this->hasMany(CriticalDeviationMenu::class);
    }

}
