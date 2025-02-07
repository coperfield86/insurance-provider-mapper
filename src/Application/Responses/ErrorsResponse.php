<?php

namespace Src\Application\Responses;

final class ErrorsResponse
{
    public function __construct(
        private array $errors
    ) {}

    public function getErrors(): array
    {
        return $this->errors;
    }
}
