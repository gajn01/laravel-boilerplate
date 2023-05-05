<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDate extends Model
{
    use HasFactory;

    protected $table = 'audit_date';
    protected $fillable = ['id', 'auditor', 'store', 'audit_date', 'created_at', 'updated_at'];
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
