<?php
namespace App\Http\Services;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * Create a new rating for a book.
     *
     * @param array $data
     * @param Book $book
     * @return Rating
     */
    public function createRating(array $data, Book $book)
    {
        return Rating::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $data['rating'],
            'review' => $data['review'],
        ]);
    }

    /**
     * Calculate the average rating for a book.
     *
     * @param Book $book
     * @return float
     */
    public function averageRating(Book $book)
    {
        return $book->averageRating() ?? 0;
    }
    /**
     * Get all ratings for a book.
     *
     * @param Book $book
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRatings(Book $book)
    {
        return $book->averageRating();
    }

    /**
     * Get a single rating.
     *
     * @param int $ratingId
     * @return Rating
     */
    public function getRating(Rating $rating)
    {
        return $rating;
    }

    /**
     * Update an existing rating.
     *
     * @param Rating $rating
     * @param array $data
     * @return Rating
     */
    public function updateRating(Book $book, $ratingData)
    {
        $user = Auth::user();
        $rating = Rating::where('book_id', $book->id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($rating) {
            $rating->update([
                'rating' => $ratingData['rating'],
            ]);
            return $rating;
        }

        return null;
    }

    /**
     * Delete a rating.
     *
     * @param Rating $rating
     * @return bool
     */
    public function deleteRating(Rating $rating)
    {
        return $rating->delete();
    }
}
