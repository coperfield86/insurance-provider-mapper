<?php

namespace Src\Infrastructure\Requests;

use Illuminate\Support\Facades\Validator;
use src\Domain\InsuranceProviderRequest;

final class ACMERequest implements InsuranceProviderRequest
{
    private string $quoteDate;

    public function __construct(
        private bool $isPrevInsuranceExists,
        private bool $isSingleDriver,
        private int  $yearsPreviousInsurance,
        private int  $countOccasionalDrivers
    )
    {
        $this->quoteDate = date('Y-m-d\TH:i:s');
    }

    public function toArray(): array
    {
        return [
            'Cotizacion' => 0,
            'Datos' => [
                'DatosAseguradora' => [
                    'SeguroEnVigor' => $this->isPrevInsuranceExists ? 'YES' : 'NO',
                ],
                'DatosGenerales' => [
                    'CondPpalEsTomador' => $this->isSingleDriver ? 'YES' : 'NO',
                    'ConductorUnico' => $this->isSingleDriver ? 'YES' : 'NO',
                    'FecCot' => $this->quoteDate,
                    'AnosSegAnte' => $this->yearsPreviousInsurance,
                    'NroCondOca' => $this->countOccasionalDrivers,
                ]
            ]
        ];
    }

    public function validate(): void
    {
        $validator = Validator::make($this->toArray(), [
            'Datos.DatosGenerales.CondPpalEsTomador' => 'required|string|in:YES,NO',
            'Datos.DatosGenerales.ConductorUnico' => 'required|string|in:YES,NO',
            'Datos.DatosGenerales.FecCot' => 'required|date_format:Y-m-d\TH:i:s',
            'Datos.DatosGenerales.AnosSegAnte' => 'required|integer',
            'Datos.DatosAseguradora.SeguroEnVigor' => 'required|string|in:YES,NO',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException(json_encode($validator->errors()->all()));
        }
    }
}
