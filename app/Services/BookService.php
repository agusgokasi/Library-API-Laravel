<?php
namespace App\Services;

use App\Helpers\ApiResponseHelper;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookService
{
    /**
     * Get all books, cached for 60 minutes.
     */
    public function getAllBooks()
    {
        $data = Cache::remember('books', 60 * 60, function() {
            return Book::get();
        });
        return ApiResponseHelper::success($data, 'Books retrieved successfully');
    }

    /**
     * Get a specific book by ID, cached for 60 minutes.
     */
    public function getBookById($id)
    {
        $data = Cache::remember("book_{$id}", 60 * 60, function() use ($id) {
            return Book::findOrFail($id);
        });
        return ApiResponseHelper::success($data, 'Book retrieved successfully');
    }

    /**
     * Create a new author, invalidate authors cache after creation.
     */
    public function createBook(array $data)
    {
        DB::beginTransaction();
        Cache::forget('books');
        try {
            $book = Book::create($data);
            DB::commit();
            return ApiResponseHelper::success($book, 'Book created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::error('Error when creating Book: '. $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update an author, invalidate both authors and individual author cache after update.
     */
    public function updateBook($id, array $data)
    {
        DB::beginTransaction();
        Cache::forget("book_{$id}");
        Cache::forget('books');
        
        try {
            $book = Book::findOrFail($id);
            $book->update($data);
            DB::commit();

            return ApiResponseHelper::success($book, 'Book updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::error('Error when updating Book: '. $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Delete an author, invalidate both authors and individual author cache after deletion.
     */
    public function deleteBook($id)
    {
        DB::beginTransaction();
        Cache::forget("book_{$id}");
        Cache::forget('books');
        
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            DB::commit();

            return ApiResponseHelper::success(null, 'Book deleted successfully', 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::error('Error when deleting Book: '. $e->getMessage(), $e->getCode());
        }
    }
}
