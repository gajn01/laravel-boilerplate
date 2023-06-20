<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDate extends Model
{
    use HasFactory;
    protected $table = 'audit_date';
    protected $fillable = ['id', 'store_id', 'audit_date', 'wave', 'is_complete','created_at', 'updated_at'];

    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
    public function getStatusStringAttribute()
    {
        $status_label = array("Pending", "In-progess", "Completed");

        return $status_label[$this->is_complete];
    }
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function auditors()
    {
        return $this->hasMany(AuditorList::class,'audit_date_id', 'id');
    }

}
