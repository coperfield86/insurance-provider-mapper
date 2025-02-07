<?php

namespace src\Domain\ValueObjects;

final class InsurancePriceParametersVO
{
    public function __construct(
        private HolderVO                        $holder,
        private bool                            $prevInsuranceExists,
        private bool                            $singleDriver,
        private PreviousInsuranceContractDateVO $prevInsuranceContractDate,
        private CountOccasionalDriversVO        $countOccasionalDrivers)
    {
    }

    public function getHolder(): HolderVO
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

    public function getPrevInsuranceContractDate(): PreviousInsuranceContractDateVO
    {
        return $this->prevInsuranceContractDate;
    }

    public function getCountOccasionalDrivers(): CountOccasionalDriversVO
    {
        return $this->countOccasionalDrivers;
    }
}
