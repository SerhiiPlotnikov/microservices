<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponser;

    public BookService $bookService;

    public AuthorService $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    public function store(Request $request)
    {
        $this->authorService->obtainAuthor((int)$request->author_id);
        return $this->successResponse($this->bookService->createBook($request->all()));
    }


    public function show(int $id)
    {
        return $this->successResponse($this->bookService->obtainBook($id));
    }

    public function update(Request $request, int $id)
    {
        if (isset($request->author_id)) {
            $this->authorService->obtainAuthor($request->author_id);
        }
        return $this->successResponse($this->bookService->editBook($request->all(), $id));
    }

    public function destroy(int $id)
    {
        return $this->successResponse($this->bookService->deleteBook($id));
    }
}
