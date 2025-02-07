<?php

namespace src\Domain\ValueObjects;

final class CountOccasionalDriversVO
{
    private int $value;

    public function __construct(?int $value)
    {
        $this->ensureIsNotNull($value);
        $this->value = $value;
    }

    private function ensureIsNotNull(?int $value): void
    {
        if (!isset($value))
            throw new \InvalidArgumentException('The price is null');
    }

    public function value(): int
    {
        return $this->value;
    }
}
