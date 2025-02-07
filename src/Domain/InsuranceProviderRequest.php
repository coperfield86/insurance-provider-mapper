<?php

namespace src\Domain;

interface InsuranceProviderRequest
{
    public function toArray(): array;
    public function validate(): void;
}
