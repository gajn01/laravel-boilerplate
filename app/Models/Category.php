<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id','name', 'type'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}

class SubCategory extends Model
{
    protected $fillable = ['id','name', 'base_point', 'point', 'remarks', 'is_subcategory', 'file', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}

class SubSubCategory extends Model
{
    protected $fillable = ['id','name', 'base_point', 'point', 'remarks', 'file', 'sub_category_id'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
