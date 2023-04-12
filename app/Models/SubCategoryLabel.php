<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLabel extends Model
{
    use HasFactory;

    protected $table = 'sub_categories_label';
    protected $fillable = ['id', 'name', 'sub_category_id', 'bp', 'is_all_nothing'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subSubCategoryLabels()
    {
        return $this->hasMany(SubSubCategoryLabel::class);
    }
    public function labels()
    {
        return $this->hasMany(SubSubCategoryLabel::class);
    }
}
