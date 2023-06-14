<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalDeviationResult extends Model
{
    use HasFactory;
    protected $table = 'critical_deviation_result';
    protected $fillable = [
        'form_id',
        'deviation_id',
        'category_id',
        'critical_deviation_id',
        'remarks',
        'score',
        'sd',
        'location',
        'product',
        'dropdown',
    ];

    public function form()
    {
        return $this->belongsTo('App\Models\AuditForm');
    }

    public function AuditFormResult(){
        return $this->belongsTo(AuditFormResult::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function CriticalDeviationMenu(){
        return $this->belongsTo(CriticalDeviationMenu::class, 'deviation_id','id');
    }
    public function deviation()
    {
        return $this->belongsTo('App\Models\CriticalDeviationMenu', 'critical_deviation_id');
    }
}
