<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'username', 
        'display_name', 'bio', 'profile_image', 
        'theme_color', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function links()
    {
        return $this->hasMany(Link::class)->orderBy('order');
    }

    public function activeLinks()
    {
        return $this->hasMany(Link::class)->where('is_active', true)->orderBy('order');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}