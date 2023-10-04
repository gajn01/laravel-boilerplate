<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'capa_id',
        'complaint_details',
        'why_1',
        'why_2',
        'why_3',
        'why_4',
        'corrective_action',
        'responsible',
        'timeline',
        'preventive_action',
        'responsibe',
        'timeline'
    ];

    public function capa_details(){
        return $this->belongsTo(Capa::class,'capa_id','id');
    }
    
}
