<?php


namespace src\Domain\ValueObjects;

use DateTime;

final class PreviousInsuranceContractDateVO
{
    private ?string $value;

    public function __construct(bool $prevInsuranceExists, ?string $value)
    {
        $this->ensureIfPrevInsuranceExistIsNotNull($prevInsuranceExists, $value);
        $this->ensureTheFormatIsCorrect($value);
        $this->ensureIsBeforeTomorrow($value);
        $this->value = $value;
    }

    private function ensureIfPrevInsuranceExistIsNotNull(bool $prevInsuranceExists, ?string $value): void
    {
        if ($prevInsuranceExists && !isset($value))
            throw new \InvalidArgumentException('La fecha del contrato de seguro anterior no puede esta vacía');
    }

    private function ensureTheFormatIsCorrect(?string $value): void
    {
        if (isset($value)) {
            $date = $this->getDate($value);

            if (!$date)
                throw new \InvalidArgumentException('La fecha del contrato de seguro anterior no tiene el formato correcto');
        }
    }

    private function ensureIsBeforeTomorrow(?string $value): void
    {
        if (isset($value)) {
            $tomorrow = new DateTime('tomorrow');
            $date = $this->getDate($value);

            if ($date >= $tomorrow)
                throw new \InvalidArgumentException('La fecha del contrato de seguro anterior no puede ser mayor o igual a mañana');
        }
    }

    private function getDate(string $value): DateTime|bool
    {
        return DateTime::createFromFormat('Y-m-d', $value);
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
