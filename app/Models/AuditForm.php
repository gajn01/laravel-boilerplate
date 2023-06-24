<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditForm extends Model
{
    use HasFactory;

    protected $table = 'audit_forms';
    protected $fillable = ['store_id', 'audit_date_id','date_of_visit', 'conducted_by_id', 'time_of_audit', 'wave','audit_status', 'created_at', 'updated_at'];
}
