<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'website',
        'phone',
        'opening_hours',
    ];

    public function casts(): array
    {
        return [
            'opening_hours' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function beers(): BelongsToMany
    {
        return $this->belongsToMany(Beer::class)
            ->using(BeerStore::class)
            ->withPivot('price', 'promo_label', 'url')
            ->withTimestamps();
    }

    public function catalogItems(): HasMany
    {
        return $this->hasMany(CatalogItem::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function cover(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_cover', 1);
    }

    #[Scope]
    public function userScope(Builder $query)
    {
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }
}
