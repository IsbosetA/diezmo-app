<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Offering extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_envelope',
        'id_offering_type',
        'amount'
    ];

    public function envelope(): BelongsTo
    {
        return $this->belongsTo(Envelope::class, 'id', 'id_envelope');
    }

    public function type(): HasOne
    {
        return $this->hasOne(OfferingType::class, 'id', 'id_offering_type');
    }
}
