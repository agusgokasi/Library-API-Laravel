<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Author;
use App\Models\Book;
use App\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $authorService;

    public function setUp(): void
    {
        parent::setUp();
        $this->authorService = new AuthorService();
    }

    public function test_can_create_author()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'A famous author',
            'birth_date' => '1970-01-01'
        ];

        $author = $this->authorService->createAuthor($data);

        $this->assertDatabaseHas('authors', $data);
    }

    public function test_can_retrieve_author()
    {
        $author = Author::factory()->create();

        $retrievedAuthor = $this->authorService->getAuthorById($author->id);

        $this->assertEquals($author->id, $retrievedAuthor->id);
        $this->assertEquals($author->name, $retrievedAuthor->name);
    }

    public function test_can_update_author()
    {
        $author = Author::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'bio' => 'Updated bio',
            'birth_date' => '1990-01-01'
        ];

        $updatedAuthor = $this->authorService->updateAuthor($author->id, $data);

        $this->assertDatabaseHas('authors', $data);
        $this->assertEquals($updatedAuthor->name, 'Updated Name');
    }

    public function test_can_delete_author()
    {
        $author = Author::factory()->create();

        $this->authorService->deleteAuthor($author->id);

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }

    public function test_can_retrieve_books_by_author()
    {
        $author = Author::factory()->create();
        $books = Book::factory()->count(3)->create(['author_id' => $author->id]);

        $retrievedBooks = $this->authorService->getBooksByAuthor($author->id);

        $this->assertCount(3, $retrievedBooks);
        $this->assertEquals($books[0]->title, $retrievedBooks[0]->title);
    }

}
