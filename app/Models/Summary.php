<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;
    protected $table = 'summary';
    protected $fillable = [
        'store_id',
        'form_id',
        'name',
        'code',
        'type',
        'conducted_by',
        'received_by',
        'date_of_visit',
        'time_of_audit',
        'wave',
        'strength',
        'improvement',
    ];



    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function audit_form()
    {
        return $this->belongsTo(AuditForm::class,'form_id','id');
    }



}
