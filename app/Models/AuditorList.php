<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditorList extends Model
{
    use HasFactory;
    protected $table = 'auditor_list';
    protected $fillable = [
        'audit_date_id',
        'auditor_id',
        'auditor_name',
    ];
    public function auditDates()
    {
        return $this->belongsTo(AuditDate::class, 'audit_date_id', 'id')
            ->withTimestamps();
    }
}
