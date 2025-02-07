<?php
namespace Src\Domain\Repositories;

use src\Domain\ValueObjects\InsurancePriceParametersVO;
use src\Domain\ValueObjects\InsurancePriceVO;

interface InsurancePriceRepository
{
    public function getPrice(InsurancePriceParametersVO $parameters): string;
}
