<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{

    protected $table = 'dropdown';
    protected $fillable = ['id', 'name'];

    public function dropdownMenus()
    {
        return $this->hasMany(DropdownMenu::class);
    }
}
