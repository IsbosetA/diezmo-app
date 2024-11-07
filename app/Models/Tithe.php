<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Tithe extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_envelope',
        'amount'
    ];

    public function envelope(): BelongsTo
    {
        return $this->belongsTo(Envelope::class, 'id_envelope', 'id');
    }
}
