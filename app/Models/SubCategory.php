<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function labels()
    {
        return $this->hasMany(SubCategoryLabelModel::class, 'sub_category_id');
    }


}
