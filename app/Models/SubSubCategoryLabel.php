<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategoryLabel extends Model
{
    use HasFactory;
    protected $table = 'sub_sub_categories';

    protected $fillable = ['id', 'name', 'sub_sub_category_id', 'bp', 'is_all_nothing','dropdown_id'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategoryLabel::class);
    }

    public function labels()
    {
        return $this->hasMany(SubCategoryLabelModel::class, 'sub_sub_category_id');
    }

    public function subCategoryLabel()
    {
        return $this->belongsTo(SubCategoryLabelModel::class, 'sub_sub_category_id');
    }

    public function subSubCategoryLabelModels()
    {
        return $this->hasMany(SubSubCategoryLabelModel::class, 'sub_sub_category_id');
    }
}
