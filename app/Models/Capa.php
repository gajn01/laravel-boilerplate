<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capa extends Model
{
    use HasFactory;
    protected $table = 'capa_lists';
    protected $fillable = ['form_id','status', 'deadline'];

    public function form(){
        return $this->belongsTo(AuditForm::class,'form_id','id');
    }
    public function getStatusStringAttribute()
    {
        $status_label = array("Pending", "In-progess", "Completed");

        return $status_label[$this->status];
    }
    public function getStatusBadgeAttribute()
    {
        $status_badge = array("bg-warning", "bg-primary", "bg-success");
        return $status_badge[$this->status];
    }
}