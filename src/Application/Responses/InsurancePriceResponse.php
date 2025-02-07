<?php

namespace Src\Application\Responses;


final class InsurancePriceResponse
{
    public function __construct(
        private ErrorsResponse $errors,
        private ?float         $price
    )
    {
    }

    public function getErrors(): ErrorsResponse
    {
        return $this->errors;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }
}
