<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropdownMenu extends Model
{
    use HasFactory;

    protected $table = 'dropdown_menu';

    protected $fillable = [
        'id',
        'name',
        'dropdown_id'
    ];


    public function dropdown()
    {
        return $this->belongsTo(Dropdown::class);
    }
}
