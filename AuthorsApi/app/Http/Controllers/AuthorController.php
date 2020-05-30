<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use \App\Traits\ApiResponser;
use App\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        //
    }

    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:254',
            'gender' => 'required|max:20|in:male,female',
            'country' => 'required|max:254',
        ];

        $this->validate($request, $rules);
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $author = Author::findOrFail($id);
        return $author;
    }

    public function update(Request $request, int $id)
    {
        $rules = [
            'name' => 'max:254',
            'gender' => 'max:20|in:male,female',
            'country' => 'max:254',
        ];
        $this->validate($request, $rules);
        $author = Author::findOrFail($id);
        $author->fill($request->all());
        if ($author->isClean()) {
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();
        return $this->successResponse($author);
    }

    public function destroy(int $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return $this->successResponse($author);
    }
}
