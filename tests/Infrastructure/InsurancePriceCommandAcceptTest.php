<?php

namespace Tests\Infrastructure;

use PHPUnit\Framework\Attributes\Test;
use Src\Domain\Constants;
use Tests\TestCase;

final class InsurancePriceCommandAcceptTest extends TestCase
{

    private array $choices;

    protected function setUp(): void
    {
        parent::setUp();

        $this->choices = [];

        $providers = config('app.insurance_providers');

        foreach ($providers as $id => $provider) {
            $this->choices[$id] = $provider['name'];
        }

    }

    #[Test]
    public function should_get_xml_request()
    {
        $this->artisan('app:insurance-price')
            ->expectsChoice('Proveedor de precios', $this->choices[1], $this->choices)
            ->expectsChoice('Tipo de conductor', Constants::HOLDER_MAIN_DRIVER, [1 => Constants::HOLDER_MAIN_DRIVER, 2 => Constants::HOLDER_OCCASIONAL_DRIVER])
            ->expectsChoice('Seguro en vigor?', 'Si', [0 => 'No', 1 => 'Si'])
            ->expectsChoice('Conductor único?', 'No', [0 => 'No', 1 => 'Si'])
            ->expectsQuestion('Introduce la fecha del contrato anterior (Y-m-d):', '2024-01-01')
            ->expectsQuestion('Número de conductores adicionales:', '2')
            ->expectsOutput('XML:')
            ->assertExitCode(0);
    }

    #[Test]
    public function should_get_xml_request_witout_date_and_additional_drivers()
    {
        $this->artisan('app:insurance-price')
            ->expectsChoice('Proveedor de precios', $this->choices[1], $this->choices)
            ->expectsChoice('Tipo de conductor', Constants::HOLDER_MAIN_DRIVER, [1 => Constants::HOLDER_MAIN_DRIVER, 2 => Constants::HOLDER_OCCASIONAL_DRIVER])
            ->expectsChoice('Seguro en vigor?', 'No', [0 => 'No', 1 => 'Si'])
            ->expectsChoice('Conductor único?', 'Si', [0 => 'No', 1 => 'Si'])
            ->expectsOutput('XML:')
            ->assertExitCode(0);
    }

    #[Test]
    public function should_get_error_because_date_has_bad_format()
    {
        $this->artisan('app:insurance-price')
            ->expectsChoice('Proveedor de precios', $this->choices[1], $this->choices)
            ->expectsChoice('Tipo de conductor', Constants::HOLDER_MAIN_DRIVER, [1 => Constants::HOLDER_MAIN_DRIVER, 2 => Constants::HOLDER_OCCASIONAL_DRIVER])
            ->expectsChoice('Seguro en vigor?', 'Si', [0 => 'No', 1 => 'Si'])
            ->expectsChoice('Conductor único?', 'No', [0 => 'No', 1 => 'Si'])
            ->expectsQuestion('Introduce la fecha del contrato anterior (Y-m-d):', '01-01-2024')
            ->expectsQuestion('Número de conductores adicionales:', '2')
            ->expectsOutput('Errors:')
            ->assertExitCode(0);
    }

    #[Test]
    public function should_get_error_because_count_additional_drivers_is_0()
    {
        $this->artisan('app:insurance-price')
            ->expectsChoice('Proveedor de precios', $this->choices[1], $this->choices)
            ->expectsChoice('Tipo de conductor', Constants::HOLDER_MAIN_DRIVER, [1 => Constants::HOLDER_MAIN_DRIVER, 2 => Constants::HOLDER_OCCASIONAL_DRIVER])
            ->expectsChoice('Seguro en vigor?', 'Si', [0 => 'No', 1 => 'Si'])
            ->expectsChoice('Conductor único?', 'No', [0 => 'No', 1 => 'Si'])
            ->expectsQuestion('Introduce la fecha del contrato anterior (Y-m-d):', '01-01-2024')
            ->expectsQuestion('Número de conductores adicionales:', '0')
            ->expectsOutput('Errors:')
            ->assertExitCode(0);
    }
}
