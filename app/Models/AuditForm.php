<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditForm extends Model
{
    use HasFactory;

    protected $table = 'audit_forms';
    protected $fillable = ['store_id', 'audit_date', 'date_of_visit','audit_result', 'conducted_by_id','received_by', 'time_of_audit', 'wave', 'audit_status','strength','improvement', 'created_at', 'updated_at'];

    public function getStatusStringAttribute()
    {
        $status_label = array("Pending", "In-progess", "Completed");

        return $status_label[$this->audit_status];
    }
    public function getStatusBadgeAttribute()
    {
        $status_badge = array("bg-warning", "bg-primary", "bg-success");
        return $status_badge[$this->audit_status];
    }
    public function stores()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function auditors()
    {
        return $this->hasMany(AuditorList::class, 'audit_form_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'conducted_by_id', 'id');
    }
    public function summary(){
        return $this->belongsTo(Summary::class, 'id', 'form_id');

    }
}