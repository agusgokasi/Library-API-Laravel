<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $bookService;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookService = new BookService();
    }

    public function test_can_create_book()
    {
        $author = Author::factory()->create();

        $data = [
            'title' => 'The Great Book',
            'description' => 'A very interesting book',
            'publish_date' => '2020-01-01',
            'author_id' => $author->id,
        ];

        $this->bookService->createBook($data);

        $this->assertDatabaseHas('books', $data);
    }

    public function test_can_retrieve_book()
    {
        $book = Book::factory()->create();

        $response = $this->bookService->getBookById($book->id);
        $retrievedBook = $response->getData()->data;

        $this->assertEquals($book->id, $retrievedBook->id);
        $this->assertEquals($book->title, $retrievedBook->title);
    }

    public function test_can_update_book()
    {
        $book = Book::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'publish_date' => '2021-01-01'
        ];

        $response = $this->bookService->updateBook($book->id, $data);
        $updatedBook = $response->getData()->data;

        $this->assertDatabaseHas('books', $data);
        $this->assertEquals($updatedBook->title, 'Updated Title');
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();

        $this->bookService->deleteBook($book->id);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
