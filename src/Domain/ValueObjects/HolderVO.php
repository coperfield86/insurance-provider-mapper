<?php

namespace src\Domain\ValueObjects;
use Src\Domain\Constants;

final class HolderVO
{
    private string $value;

    private $validHolder = [
        Constants::HOLDER_MAIN_DRIVER,
        Constants::HOLDER_OCCASIONAL_DRIVER
    ];

    public function __construct(string $value)
    {
        $this->ensureHasValidValue($value);
        $this->value = $value;
    }

    private function ensureHasValidValue(string $value): void
    {
        if (!in_array($value, $this->validHolder))
            throw new \InvalidArgumentException('El valor del holder no es válido');
    }

    public function value(): string
    {
        return $this->value;
    }
}
