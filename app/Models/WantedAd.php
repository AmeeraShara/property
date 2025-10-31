<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WantedAd extends Model
{
    use HasFactory;
protected $fillable = [
    'title',
    'description',
    'offer_type',
    'district',
    'property_type',
    'budget',
];
 // Mass-assignable fields for create/update
}