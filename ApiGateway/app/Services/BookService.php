<?php

declare(strict_types=1);

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BookService
{
    use ConsumeExternalService;

    public string $baseUri;
    public string $secret;

    public function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
    }

    public function obtainBooks()
    {
        return $this->performRequest('GET', '/books');
    }

    public function createBook(array $data)
    {
        return $this->performRequest('POST', '/books', $data);
    }

    public function obtainBook(int $id)
    {
        return $this->performRequest('GET', "/books/{$id}");
    }

    public function editBook(array $data, int $id)
    {
        return $this->performRequest('PUT', "/books/{$id}", $data);
    }

    public function deleteBook(int $id)
    {
        return $this->performRequest('DELETE', "/books/{$id}");
    }
}
