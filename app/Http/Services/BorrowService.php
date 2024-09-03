<?php
namespace App\Http\Services;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;

class BorrowService
{
     /**
     * Borrows a book for the current authenticated user.
     *
     * @param Book $book
     * @return Borrow
     */

    public function borrowBook(Book $book)

    {
        return Borrow::create([
            'book_id' => $book->id,
            'user_id' => Auth::id(),
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), 
        ]);
    }
    public function returnBook(Book $book)
    {
        $borrowRecord = Borrow::where('book_id', $book->id)
                              ->where('user_id', Auth::id())
                              ->whereNull('returned_at')
                              ->first();

        if (!$borrowRecord) {
            return null;
        }
        $borrowRecord->update(['returned_at' => now()]);
        return $borrowRecord;
    }
}
