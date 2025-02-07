<?php

namespace Src\Application\UseCases;

use InvalidArgumentException;
use Src\Application\Requests\InsurancePriceRequest;
use src\Domain\ValueObjects\CountOccasionalDriversVO;
use src\Domain\ValueObjects\HolderVO;
use src\Domain\ValueObjects\InsurancePriceParametersVO;
use src\Domain\ValueObjects\PreviousInsuranceContractDateVO;

final class GetInsurancePrice
{
    public function __construct()
    {
    }

    public function __invoke(InsurancePriceRequest $request): string
    {
        $insuranceProviders = config('app.insurance_providers');

        if (!array_key_exists($request->getProviderId(), $insuranceProviders)) {
            throw new InvalidArgumentException('Insurance provider not found');
        }

        $insuranceProviderPriceClass = $insuranceProviders[$request->getProviderId()]['class'];
        return (new $insuranceProviderPriceClass)->getPrice($this->requestMapper($request));
    }

    private function requestMapper(InsurancePriceRequest $request): InsurancePriceParametersVO
    {
        return new InsurancePriceParametersVO(
            new HolderVO($request->getHolder()),
            $request->isPrevInsuranceExists(),
            $request->isSingleDriver(),
            new PreviousInsuranceContractDateVO($request->isPrevInsuranceExists(), $request->getPrevInsuranceContractDate()),
            new CountOccasionalDriversVO($request->getCountOccasionalDrivers())
        );
    }
}

