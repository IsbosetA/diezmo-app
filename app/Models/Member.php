<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'address',
        'email'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_member', 'id');
    }
}
