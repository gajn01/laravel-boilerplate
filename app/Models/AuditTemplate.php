<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTemplate extends Model
{
    use HasFactory;
    protected $table = 'audit_template';
    protected $fillable = [
        'type',
        'template',
        'created_at',
        'updated_at'
    ];

}