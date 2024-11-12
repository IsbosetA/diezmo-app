<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'created_at'];

    // Definir la relación inversa con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
