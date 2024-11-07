<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_start',
        'period_end',
        'church_name',
        'city'
    ];
}
