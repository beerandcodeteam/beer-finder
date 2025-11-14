<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeerEmbedding extends Model
{
    protected $fillable = [
        'beer_id',
        'text',
        'metadata',
        'embedding'
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'json',
            'embedding' => 'json'
        ];
    }

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }
}
