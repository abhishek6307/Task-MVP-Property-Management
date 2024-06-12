<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'address',
        'price',
        'bedrooms',
        'bathrooms',
        'type',
        'user_id',
        'views',
        'likes',
        'shares',
        'latitude',
        'longitude',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function viewings()
    {
        return $this->hasMany(Viewing::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function isLikedBy(User $user)
    {
        return $this->likedUsers->contains($user);
    }

    public function incrementShares()
    {
        $this->increment('shares');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_favorites', 'property_id', 'user_id')->withTimestamps();
    }

}