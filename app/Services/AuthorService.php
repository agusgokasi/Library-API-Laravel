<?php
namespace App\Services;

use App\Helpers\ApiResponseHelper;
use App\Models\Author;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthorService
{
    /**
     * Get all authors with their books, cached for 60 minutes.
     */
    public function getAllAuthors()
    {
        $data = Cache::remember('authors', 60 * 60, function() {
            return Author::get();
        });
        return ApiResponseHelper::success($data, 'Authors retrieved successfully');
    }

    /**
     * Get a specific author by ID, cached for 60 minutes.
     */
    public function getAuthorById($id)
    {
        $data = Cache::remember("author_{$id}", 60 * 60, function() use ($id) {
            return Author::findOrFail($id);
        });
        return ApiResponseHelper::success($data, 'Author retrieved successfully');
    }

    /**
     * Create a new author, invalidate authors cache after creation.
     */
    public function createAuthor(array $data)
    {
        DB::beginTransaction();
        Cache::forget('authors');
        try {
            $author = Author::create($data);
            DB::commit();
            return ApiResponseHelper::success($author, 'Author created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::error('Error when creating Author: '. $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update an author, invalidate both authors and individual author cache after update.
     */
    public function updateAuthor($id, array $data)
    {
        DB::beginTransaction();
        Cache::forget('authors');
        Cache::forget("author_{$id}");
        Cache::forget("author_{$id}_books");

        try {
            $author = Author::findOrFail($id);
            $author->update($data);
            DB::commit();

            return ApiResponseHelper::success($author, 'Author updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::error('Error when updating Author: '. $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Delete an author, invalidate both authors and individual author cache after deletion.
     */
    public function deleteAuthor($id)
    {
        DB::beginTransaction();
        Cache::forget('authors');
        Cache::forget("author_{$id}");
        Cache::forget("author_{$id}_books");

        try {
            $author = Author::findOrFail($id);
            $author->delete();
            DB::commit();

            return ApiResponseHelper::success(null, 'Author deleted successfully', 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseHelper::error('Error when deleting Author: '. $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get all books for a specific author, cached for 60 minutes.
     */
    public function getBooksByAuthor($authorId)
    {
        $data = Cache::remember("author_{$authorId}_books", 60 * 60, function() use ($authorId) {
            $author = Author::with('books')->findOrFail($authorId);
            return $author->books;
        });

        return ApiResponseHelper::success($data, 'Books retrieved successfully');
    }
}
