<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Src\Application\Requests\InsurancePriceRequest;
use Src\Application\UseCases\GetInsurancePrice;
use Src\Domain\Constants;

class InsurancePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(private GetInsurancePrice $getInsurancePrice)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $providers = config('app.insurance_providers');

            foreach ($providers as $id => $provider) {
                $choices[$id] = $provider['name'];
            }

            $choice = $this->choice('Proveedor de precios', $choices, 1);
            $insuranceProviderId = array_search($choice, $choices);

            $holder = $this->choice('Tipo de conductor', [
                1 => Constants::HOLDER_MAIN_DRIVER,
                2 => Constants::HOLDER_OCCASIONAL_DRIVER
            ], 1);

            $prevInsuranceExists = $this->choice('Seguro en vigor?', [
                0 => 'No',
                1 => 'Si',
            ], 1);

            $singleDriver = $this->choice('Conductor único?', [
                0 => 'No',
                1 => 'Si',
            ], 1);

            $prevInsuranceContractDate = null;

            if ($prevInsuranceExists == 'Si') {
                $prevInsuranceContractDate = $this->ask('Introduce la fecha del contrato anterior (Y-m-d):');
            }

            $countOccasionalDriver = 0;

            if ($singleDriver == 'No') {
                $countOccasionalDriver = $this->ask('Número de conductores adicionales:');
            }

            $request = new InsurancePriceRequest(
                $insuranceProviderId,
                $holder,
                $prevInsuranceExists === 'Si',
                $singleDriver === 'Si',
                $prevInsuranceContractDate,
                $countOccasionalDriver
            );

            $response = ($this->getInsurancePrice)($request);

            $this->info('XML:');
            $this->info($response);
        } catch (\Exception $e) {
            $this->error('Errors:');
            $this->error($e->getMessage());
        }
    }
}
