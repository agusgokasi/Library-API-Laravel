<?php
namespace App\Http\Controllers;

use App\Services\BookService;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        return $this->bookService->getAllBooks();
    }

    public function store(BookRequest $request)
    {
        return $this->bookService->createBook($request->validated());
    }

    public function show($id)
    {
        return $this->bookService->getBookById($id);
    }

    public function update(BookRequest $request, $id)
    {
        return $this->bookService->updateBook($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->bookService->deleteBook($id);
    }
}
