<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Services\BookService;
use App\Http\Requests\BookRequest\StoreRequest;
use App\Http\Requests\BookRequest\UpdateRequest;
use App\Http\Requests\BookRequest\BookFilterRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{
    protected $bookService ;
    public function __construct(){

       $this->bookService = new BookService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BookFilterRequest $request)
{
    $books = $this->bookService->filterBooks($request->validated());

    if ($books->isEmpty()) {
        return response()->json(['message' => 'No Books Found'], 404);
    }

    $result = $books->map(function($book) {
        $ratings = $book->ratings()->with('user')->get();
        return [
            'title' => $book->title,
            'author' => $book->author,
            'description' => $book->description,
            'published_at' => $book->published_at,
            'average_rating' => $book->averageRating(),
            'ratings' => $ratings->map(function($rating) {
                return [
                    'user_name' => $rating->user->name,
                    'rating' => $rating->rating,
                    'review' => $rating->review,
                ];
            })
        ];
    });

    return response()->json($result, 200);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();
            $book = $this->bookService->createBook($data);
            return response()->json($book, 201);
        } catch (\Illuminate\Auth\AuthenticationException $e) {

            return response()->json(['error' => 'Unauthenticated.'], 401);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            $averageRating = $book->averageRating();
            $ratings = $book->ratings()->with('user')->get();

            return response()->json([
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description,
                'published_at' => $book->published_at,
                'average_rating' => $averageRating,
                'ratings' => $ratings->map(function($rating) {
                    return [
                        'user_name' => $rating->user->name,
                        'rating' => $rating->rating,
                        'review' => $rating->review,
                    ];
                })
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Book not found'
            ], 404);
        } catch (\Illuminate\Auth\AuthenticationException $e) {

            return response()->json(['error' => 'Unauthenticated.'], 401);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Book $book)
    {
        try{
        $data = $request->validated();
        $this->bookService->updateBook( $data , $book);
        return response()->json($book,200);
    }
     catch (\Illuminate\Auth\AuthenticationException $e) {

        return response()->json(['error' => 'Unauthenticated.'], 401);
    } catch (\Exception $e) {

        return response()->json(['error' => 'An error occurred.'], 500);
    }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try{
        $this->bookService->deleteBook($book);
        return response()->json(['message' => 'Book deleted'], 200);
        }catch (\Illuminate\Auth\AuthenticationException $e) {

            return response()->json(['error' => 'Unauthenticated.'], 401);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
