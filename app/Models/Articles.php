<?php

namespace App\Models;

use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Articles extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title', 
        'content',
        'user_id',
        'category_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
