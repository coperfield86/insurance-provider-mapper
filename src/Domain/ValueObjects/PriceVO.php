<?php

namespace src\Domain\ValueObjects;
final class PriceVO
{
    private float $value;

    public function __construct(?float $value)
    {
        $this->ensureIsNotNull($value);
        $this->value = $value;
    }

    private function ensureIsNotNull(?float $value): void
    {
        if (!isset($value))
            throw new \InvalidArgumentException('The price is null');
    }

    public function value(): float
    {
        return $this->value;
    }
}
