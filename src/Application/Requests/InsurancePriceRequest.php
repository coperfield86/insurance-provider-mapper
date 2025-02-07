<?php

namespace Src\Application\Requests;

use InvalidArgumentException;

final class InsurancePriceRequest
{
    public function __construct(
        private int     $providerId,
        private string  $holder,
        private bool    $prevInsuranceExists,
        private bool    $singleDriver,
        private ?string $prevInsuranceContractDate,
        private int     $countOccasionalDrivers
    )
    {
        $this->validate();
    }

    public function getProviderId(): int
    {
        return $this->providerId;
    }

    public function getHolder(): string
    {
        return $this->holder;
    }

    public function isPrevInsuranceExists(): bool
    {
        return $this->prevInsuranceExists;
    }

    public function isSingleDriver(): bool
    {
        return $this->singleDriver;
    }

    public function getPrevInsuranceContractDate(): ?string
    {
        return $this->prevInsuranceContractDate;
    }

    public function getCountOccasionalDrivers(): int
    {
        return $this->countOccasionalDrivers;
    }

    private function validate(): void
    {
        $errors = [];

        if ($this->providerId < 1)
            $errors[] = 'El proveedor de precios no es válido';

        if (empty($this->holder))
            $errors[] = 'El holder no puede estar vacío';

        if ($this->prevInsuranceExists === true && empty($this->prevInsuranceContractDate))
            $errors[] = 'La fecha del contrato del seguro previo no puede estar vacía';

        if ($this->countOccasionalDrivers < 0)
            $errors[] = 'El número de conductores ocasionales no es válido';

        if (!$this->singleDriver && $this->countOccasionalDrivers === 0)
            $errors[] = 'El número de conductores ocasionales no puede ser 0 si no es un conductor único';

        if (!empty($errors))
            throw new InvalidArgumentException(implode(', ', $errors));
    }
}
