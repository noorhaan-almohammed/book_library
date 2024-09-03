<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
         'title', 'author' , 'description' , 'category' , 'published_at'
    ];
    /**
     * Define a one-to-many relationship with the Rating model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    public function ratings()
     {
        // A User can have many ratings.
    return $this->hasMany(Rating::class);
     }
    public function borrowRecord()
    {
        return $this->hasOne(Borrow::class)->whereNull('returned_at');
    }
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
