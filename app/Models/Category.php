<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['id', 'name', 'type','order','ros','critical_deviation_id'];
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function getLabelAttribute()
    {
        $ros_label = array('Primary', 'Secondary');
        return $ros_label[$this->ros];
    }
    public function forms(){
        return $this->hasMany(AuditFormResult::class,'category_id','id');
    }
}
