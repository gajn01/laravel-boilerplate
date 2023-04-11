<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategoryLabel extends Model
{
    use HasFactory;
    protected $table = 'sub_sub_categories';

    protected $fillable = ['id', 'name', 'sub_sub_category_id','bp','is_all_nothing'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategoryLabel::class);
    }

    public function labels()
    {
        return $this->hasMany(SubCategoryLabelModel::class, 'sub_sub_category_id');
    }

}
class SubSubCategoryLabelModel extends Model
{
    public function subCategoryLabel()
    {
        return $this->belongsTo(SubCategoryLabelModel::class, 'sub_sub_category_id');
    }
}

class SubCategoryLabelModel extends Model
{
    public function subSubCategoryLabels()
    {
        return $this->hasMany(SubSubCategoryLabelModel::class, 'sub_sub_category_id');
    }
}
