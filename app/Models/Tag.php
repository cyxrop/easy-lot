<?php

namespace App\Models;

use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function lots()
    {
        return $this->morphedByMany(Lot::class, 'taggable');
    }
}
