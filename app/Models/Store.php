<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'type',
        'area',
        'audit_status'
    ];

    protected $dates = ['created_at'];



    public function getTypeStringAttribute()
    {
        $type_label = array("Kiosk", "Cafe");

        return $type_label[$this->type];
    }

}
