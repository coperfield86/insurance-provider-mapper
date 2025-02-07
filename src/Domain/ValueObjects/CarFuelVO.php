<?php



namespace src\Domain\ValueObjects;
final class CarFuelVO
{
    private string $value;

    public function __construct(?string $value)
    {
        $this->ensureIsNotNull($value);
        $this->value = $value;
    }

    private function ensureIsNotNull(?string $value): void
    {
        if (!isset($value))
            throw new \InvalidArgumentException('The price is null');
    }

    public function value(): string
    {
        return $this->value;
    }
}
