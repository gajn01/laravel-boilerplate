<?php

use Illuminate\Database\Eloquent\Model;

class AuditFormResultModel extends Model
{
    protected $table = 'critical_deviation_result';

    protected $fillable = [
        'form_id',
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

    public function deviation()
    {
        return $this->belongsTo('App\Models\CriticalDeviationMenu', 'critical_deviation_id');
    }
}
