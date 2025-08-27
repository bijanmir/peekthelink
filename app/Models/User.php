<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'display_name',
        'bio',
        'profile_image',
        'theme_color',
        'is_active',
        'is_admin',
        'is_suspended',
        'suspended_at',
        'suspended_reason',
        'admin_notes',
        'last_login_at',
        'last_login_ip',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    /**
     * Get the user's links.
     */
    public function links()
    {
        return $this->hasMany(Link::class)->orderBy('order');
    }

    /**
     * Get the user's active links.
     */
    public function activeLinks()
    {
        return $this->hasMany(Link::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Get the user's profile views.
     */
    public function profileViews()
    {
        return $this->hasMany(ProfileView::class);
    }

    /**
     * Get all conversions for this user.
     */
    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }
}
