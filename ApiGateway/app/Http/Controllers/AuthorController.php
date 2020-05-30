<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    public AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    public function store(Request $request)
    {
        return $this->successResponse($this->authorService->createAuthor($request->all()), Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        return $this->successResponse($this->authorService->obtainAuthor($id));
    }

    public function update(Request $request, int $id)
    {
        return $this->successResponse($this->authorService->editAuthor($request->all(), $id));
    }

    public function destroy(int $id)
    {
        return $this->successResponse($this->authorService->deleteAuthor($id));
    }
}
