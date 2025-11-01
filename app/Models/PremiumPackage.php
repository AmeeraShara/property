<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPackage extends Model
{
    use HasFactory;

    protected $fillable = ['duration', 'price'];
}
