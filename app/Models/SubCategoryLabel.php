<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLabel extends Model
{
    use HasFactory;
    protected $table = 'sub_categories_label';
    protected $fillable = ['id', 'name', 'sub_category_id', 'bp', 'is_all_nothing','dropdown_id'];
    public function subCategory()
    {
        return $this->belongsTo(subCategory::class,'sub_category_id','id');
    }
    public function sub_sub_sub_category()
    {
        return $this->hasMany(SubSubCategoryLabel::class,'sub_sub_category_id');
    }
    public function subSubCategoryLabel()
    {
        return $this->hasMany(SubSubCategoryLabel::class,'sub_sub_category_id','id');
    }
}