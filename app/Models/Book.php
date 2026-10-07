<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'isbn',
        'description',
        'price',
        'discount_price',
        'stock',
        'pages',
        'language',
        'publication_date',
        'cover_image',
        'sku',
        'publisher_id',
        'primary_author_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'publication_date' => 'date',
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function primaryAuthor(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'primary_author_id');
    }
}