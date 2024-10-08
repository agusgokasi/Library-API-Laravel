<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'publish_date',
        'author_id',
    ];

    public function author(): BelongsTo
    {
        return $this->BelongsTo(Author::class);
    }
}
