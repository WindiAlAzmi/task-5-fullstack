<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;


class Categories extends Model
{
    use HasFactory;


     
     protected $fillable = [
        'name',  
        'user_id',
    ];

   /**
     * Get the user that owns the Categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   
}
