<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Services\RatingService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RatingRequest\RatingRequest;
use App\Http\Requests\RatingRequest\UpdateRatingRequest;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Display a listing of ratings for a book.
     *
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Book $book)
    {
        $averageRatings = $this->ratingService->getRatings($book);
        return response()->json( [
            'Book' => $book,
            'Average Ratings' => $averageRatings,
        ], 200);
    }

    /**
     * Display a specific rating.
     *
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Rating $rating)
    {
        try {
            $rating = $this->ratingService->getRating($rating);

            return response()->json($rating, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Rating not found'], 404);
        }
    }
    /**
     * Store a newly created rating in storage.
     *
     * @param RatingRequest $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RatingRequest $request, Book $book)
    {
        try{
        $rating = $this->ratingService->createRating($request->validated(), $book);

        return response()->json([
            'message' => 'Rating created successfully',
            'rating' => $rating
        ], 201);
    }catch (\Illuminate\Auth\AuthenticationException $e) {

        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
    // catch (\Exception $e) {

    //     return response()->json(['error' => 'An error occurred.'], 500);
    // }
    }

    /**
     * Update the specified rating.
     *
     * @param RatingRequest $request
     * @param int $ratingId
     * @return \Illuminate\Http\JsonResponse
     */

     public function update(UpdateRatingRequest $request, Book $book)
     {
        try {
         $data = $request->validated();

         $updatedRating = $this->ratingService->updateRating($book, $data);

         if ($updatedRating != null) {
             return response()->json($updatedRating, 200);
         }
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(['error' => 'Rating not found'], 404);

        } catch (\Illuminate\Auth\AuthenticationException $e) {

            return response()->json(['error' => 'Unauthenticated.'], 401);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {

            return response()->json(['error' => 'Forbidden.'], 403);

        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }

     }

    /**
     * Summary of get Books Rated By You the user login
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function favourate()
    {
        try{
        $userId = Auth::id();
        return Book::whereHas('ratings', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }catch (\Illuminate\Auth\AuthenticationException $e) {

        return response()->json(['error' => 'Unauthenticated.'], 401);
    } catch (\Exception $e) {

        return response()->json(['error' => 'An error occurred.'], 500);
    }
    }



    /**
     * Remove the specified rating from storage.
     *
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Rating $rating)
    {
        try {
            $rating = $this->ratingService->getRating($rating);
            $this->ratingService->deleteRating($rating);

            return response()->json(['message' => 'Rating deleted successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Rating not found'], 404);
        }catch (\Illuminate\Auth\AuthenticationException $e) {

            return response()->json(['error' => 'Unauthenticated.'], 401);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

}
