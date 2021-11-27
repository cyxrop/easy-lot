<?php

namespace App\Models;

use App\Casts\LotMetaCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id',
        'buyer_id',
        'product_id',
        'meta',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'integer',
        'user_id' => 'integer',
        'buyer_id' => 'integer',
        'product_id' => 'integer',
        'meta' => LotMetaCast::class,
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isOpened(): bool
    {
        $now = Carbon::now();
        return $this->started_at <= $now && $now <= $this->finished_at;
    }

    public function getLockKey(string $prefix): string
    {
        return "{$prefix}_lot_{$this->id}";
    }
}
