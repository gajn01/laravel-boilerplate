<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditFormResult extends Model
{
    use HasFactory;
    protected $table = 'audit_results';

    protected $fillable = [
        'form_id',
        'category_id',
        'category_name',
        'sub_category_id',
        'sub_name',
        'sub_base_point',
        'sub_point',
        'sub_remarks',
        'sub_file',
        'sub_sub_category_id',
        'sub_sub_name',
        'sub_sub_base_point',
        'sub_sub_point',
        'sub_sub_remarks',
        'sub_sub_file',
        'is_na',
        'label_id',
        'label_name',
        'label_base_point',
        'label_point',
        'label_remarks',
        'label_file',
    ];

    public function criticaDeviation(){
        return $this->hasMany(CriticalDeviationResult::class, 'form_id', 'form_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    public function forms(){
        return $this->belongsTo(AuditForm::class, 'form_id','id');
    }
}
