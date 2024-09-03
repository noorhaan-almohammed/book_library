<?PHP

namespace App\Http\Services;

use App\Models\Book;

class BookService{
    public function filterBooks($filters)
    {
        $query = Book::query();

        if (isset($filters['author'])) {
            $query->where('author', $filters['author']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['available']) && $filters['available'] === 'true') {
            $query->whereDoesntHave('borrowRecords', function ($q) {
                $q->whereNull('returned_at');
            });
        }

        return $query->get();
    }

    function createBook(array $book){
       return Book::create($book);
    }

    public function updateBook(array $data , Book $book){
        return $book->update($data);
    }
    public function deleteBook(Book $book){
        $book->delete();
    }
}
