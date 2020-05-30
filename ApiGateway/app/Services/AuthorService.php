<?php

declare(strict_types=1);

namespace App\Services;

use App\Traits\ConsumeExternalService;

class AuthorService
{
    use ConsumeExternalService;

    public string $baseUri;

    public string $secret;

    public function __construct()
    {
        $this->baseUri = config('services.authors.base_uri');
        $this->secret = config('services.authors.secret');
    }

    public function obtainAuthors()
    {
        return $this->performRequest('GET', '/authors');
    }

    public function createAuthor(array $data)
    {
        return $this->performRequest('POST', '/authors', $data);
    }

    public function obtainAuthor(int $id)
    {
        return $this->performRequest('GET', "/authors/{$id}");
    }

    public function editAuthor(array $data, int $id)
    {
        return $this->performRequest('PUT', "/authors/{$id}", $data);
    }

    public function deleteAuthor(int $id)
    {
        return $this->performRequest('DELETE', "/authors/{$id}");
    }
}
