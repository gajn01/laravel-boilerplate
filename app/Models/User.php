<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departments(){
        return $this->belongsToMany(Department::class);
    }

    public function getUserLevelAttribute()
    {
        $levels = array("Super User", "Administrator", "User");
        return $levels[$this->user_type];
    }

    public function getUserAccessArrayAttribute()
    {
        $ua = json_decode($this->user_access, true);
        return $ua;
    }
}
