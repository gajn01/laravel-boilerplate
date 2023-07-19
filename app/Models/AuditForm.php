<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditForm extends Model
{
    use HasFactory;

    protected $table = 'audit_forms';
    protected $fillable = ['store_id', 'audit_date_id','date_of_visit', 'conducted_by_id', 'time_of_audit', 'wave','audit_status', 'created_at', 'updated_at'];

    public function getStatusLabelAttribute()
    {
        $status_label = array("Pending", "Completed");
        return $status_label[$this->audit_status];
    }
    public function getStatusBadgeAttribute()
    {
        $status_badge = array("bg-warning", "bg-success");
        return $status_badge[$this->audit_status];
    }
    public function stores(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
    public function date(){
        return $this->belongsTo(AuditDate::class,'audit_date_id','id');

    }
}
