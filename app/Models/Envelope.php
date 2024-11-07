<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Carbon;

class Envelope extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_member',
        'envelope_number',
        'date',
        'description',
        'total'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'id_member', 'id');
    }

    public function tithe(): BelongsTo
    {
        return $this->belongsTo(Tithe::class, 'id', 'id_envelope');
    }

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class, 'id_envelope', 'id');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'id_envelope', 'id');
    }

    public static function getNextEnvelopeNumber($date)
    {
        $monthStart = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $monthEnd = Carbon::parse($date)->endOfMonth()->format('Y-m-d');

        $lastEnvelope = self::whereBetween('date', [$monthStart, $monthEnd])
            ->orderBy('envelope_number', 'desc')
            ->first();

        return $lastEnvelope ? $lastEnvelope->envelope_number + 1 : 1;
    }
}
