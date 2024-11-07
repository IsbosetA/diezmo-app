<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
}
