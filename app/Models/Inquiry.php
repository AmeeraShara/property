<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'email', 
        'phone',
        'message',
        'ip_address'
    ];

    
    /**
     * Relationship with property
     */
    public function property()
    {
        return $this->belongsTo(Post::class, 'property_id');
    }
}