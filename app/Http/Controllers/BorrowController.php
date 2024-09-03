<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use App\Http\Services\BorrowService;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->borrowService = $borrowService;
    }

    /**
     * Borrow a book.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function borrowBook(Book $book)
    {
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        if ($book->borrowRecord) {
            return response()->json(['error' => 'Book already borrowed'], 400);
        }
        try {
            $borrowRecord = $this->borrowService->borrowBook($book);
                return response()->json([
                'message' => 'Book borrowed successfully',
                'borrowRecord' => $borrowRecord
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function returnBook(Book $book)
    {
        $borrowRecord = $this->borrowService->returnBook($book);
        if (!$borrowRecord) {
            return response()->json(['error' => 'Borrow record not found or already returned'], 404);
        }
        return response()->json(['message' => 'Book returned successfully']);
    }

}
