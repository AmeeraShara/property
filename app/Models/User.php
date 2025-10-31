<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
    ];

  
    public function isTenant()
    {
        return $this->user_type === 'tenant';
    }


    public function isOwner()  
    {
    return $this->role === 'owner'; 
    }


    public function isLandlord()
    {
        return $this->user_type === 'landlord';
    }


    public function isAgent()
    {
        return $this->user_type === 'agent';
    }

    
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
   

    public function favoriteProperties()
    {
        return $this->belongsToMany(Post::class, 'user_favorites', 'user_id', 'property_id')
                    ->withTimestamps();
    }

   
    public function hasFavorited($propertyId)
    {
        return $this->favoriteProperties()->where('property_id', $propertyId)->exists();
}
}