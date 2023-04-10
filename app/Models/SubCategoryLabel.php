<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLabel extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'sub_category_id','bp','is_all_nothing'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

}
