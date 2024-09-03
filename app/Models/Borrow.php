<?php

namespace App\Models;

use Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;
    protected $fillable = ['book_id', 'user_id', 'borrowed_at', 'due_date', 'returned_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsOverdueAttribute()
    {
        return now()->greaterThan($this->due_date);
    }
//     public function scopeBorrow($query, $bookId)
//     {
//        return $query->where('book_id', $bookId)
//                      ->where('user_id', Auth::id())
//                      ->whereNull('returned_at')
//                      ->first();
//     }
}
