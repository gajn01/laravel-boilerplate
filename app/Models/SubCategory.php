<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'is_sub', 'category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategoryLabels()
    {
        return $this->hasMany(SubCategoryLabel::class, 'sub_category_id');
    }
    public function sub_sub_category()
    {
        return $this->hasMany(SubCategoryLabel::class);
    }
    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}
