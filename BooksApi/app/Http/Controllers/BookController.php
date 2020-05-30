<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $books = Book::all();
        return $this->successResponse($books);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];
        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);
    }


    public function show(int $id)
    {
        $book = Book::findOrFail($id);
        return $this->successResponse($book);
    }

    public function update(Request $request, int $id)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'min:1',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];
        $this->validate($request, $rules);
        $book = Book::findOrFail($id);
        $book->fill($request->all());

        if ($book->isClean()) {
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();
        return $this->successResponse($book);
    }

    public function destroy(int $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return $this->successResponse($book);
    }
}