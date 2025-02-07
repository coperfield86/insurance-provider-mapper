<?php

namespace Src\Infrastructure;

use DateTime;
use Spatie\ArrayToXml\ArrayToXml;
use Src\Domain\Repositories\InsurancePriceRepository;
use Src\Domain\ValueObjects\InsurancePriceParametersVO;
use src\Domain\ValueObjects\PreviousInsuranceContractDateVO;
use Src\Infrastructure\Requests\ACMERequest;

final class ACMEInsurancePrice implements InsurancePriceRepository
{

    public function getPrice(InsurancePriceParametersVO $parameters): string
    {
        $request = $this->mapper($parameters);
        $request->validate();

        return ArrayToXml::convert($request->toArray(), 'TarificacionThirdPartyRequest');
    }

    private function mapper(InsurancePriceParametersVO $parameters): ACMERequest
    {
        return new ACMERequest(
            $parameters->isPrevInsuranceExists(),
            $parameters->isSingleDriver(),
            $this->calcYearsPreviousInsurance($parameters->getPrevInsuranceContractDate()),
            $parameters->getCountOccasionalDrivers()->value()
        );
    }

    private function calcYearsPreviousInsurance(PreviousInsuranceContractDateVO $previousInsuranceContractDate): int
    {
        $date = new DateTime($previousInsuranceContractDate->value());
        $now = new DateTime();
        return $now->diff($date)->y;
    }
}
