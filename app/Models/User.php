<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorites()
    {
        return $this->belongsToMany(Property::class, 'user_favorites', 'user_id', 'property_id')->withTimestamps();
    }

    public function toggleFavorite(Property $property)
    {
        if ($this->favorites()->where('property_id', $property->id)->exists()) {
            $this->favorites()->detach($property);
            return false;
        } else {
            $this->favorites()->attach($property);
            return true;
        }
    }

    public function isFavorite(Property $property)
    {
        return $this->favorites()->where('property_id', $property->id)->exists();
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function viewings()
    {
        return $this->hasMany(Viewing::class);
    }

    public function likedProperties()
    {
        return $this->belongsToMany(Property::class, 'likes');
    }

    public function favoriteProperties()
    {
        return $this->belongsToMany(Property::class, 'user_favorites', 'user_id', 'property_id')->withTimestamps();
    }

    public function favoriteCount()
    {
        return $this->favoriteProperties()->count();
    }


}
