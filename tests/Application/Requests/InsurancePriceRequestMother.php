<?php

namespace Tests\Application\Requests;

use Faker\Factory;
use Faker\Generator;
use Src\Application\Requests\InsurancePriceRequest;
use Src\Domain\Constants;


final class InsurancePriceRequestMother
{
    public static function create(
        ?int    $providerId,
        ?string $holder,
        ?bool   $prevInsuranceExists,
        ?bool   $singleDriver,
        ?string $prevInsuranceContractDate,
        ?int    $countOccasionalDrivers
    ): InsurancePriceRequest
    {
        return new InsurancePriceRequest(
            $providerId,
            $holder,
            $prevInsuranceExists,
            $singleDriver,
            $prevInsuranceContractDate,
            $countOccasionalDrivers
        );
    }

    public static function createASuccessDataWithPreviousInsurance(): InsurancePriceRequest
    {
        $faker = self::createFaker();

        $providerId = 1;
        $holder = Constants::HOLDER_MAIN_DRIVER;
        $prevInsuranceExists = true;
        $singleDriver = true;
        $prevInsuranceContractDate = $faker->date('Y-m-d', 'now');
        $countOccasionalDrivers = 0;

        return self::create(
            $providerId,
            $holder,
            $prevInsuranceExists,
            $singleDriver,
            $prevInsuranceContractDate,
            $countOccasionalDrivers
        );
    }

    public static function createASuccessDataWithoutPreviousInsurance(): InsurancePriceRequest
    {
        $faker = self::createFaker();

        $providerId = 1;
        $holder = Constants::HOLDER_MAIN_DRIVER;
        $prevInsuranceExists = false;
        $singleDriver = true;
        $prevInsuranceContractDate = null;
        $countOccasionalDrivers = 0;

        return self::create(
            $providerId,
            $holder,
            $prevInsuranceExists,
            $singleDriver,
            $prevInsuranceContractDate,
            $countOccasionalDrivers
        );
    }

    public static function createDataWith0OccasionalDriversAndSingleDriverIsFalse(): InsurancePriceRequest
    {
        $providerId = 1;
        $holder = Constants::HOLDER_MAIN_DRIVER;
        $prevInsuranceExists = false;
        $singleDriver = false;
        $prevInsuranceContractDate = null;
        $countOccasionalDrivers = 0;

        return self::create(
            $providerId,
            $holder,
            $prevInsuranceExists,
            $singleDriver,
            $prevInsuranceContractDate,
            $countOccasionalDrivers
        );
    }

    public static function createDataWithABadProviderId(): InsurancePriceRequest
    {
        $faker = self::createFaker();

        $providerId = $faker->numberBetween(1, 1000);
        $holder = Constants::HOLDER_MAIN_DRIVER;
        $prevInsuranceExists = false;
        $singleDriver = false;
        $prevInsuranceContractDate = null;
        $countOccasionalDrivers = 2;

        return self::create(
            $providerId,
            $holder,
            $prevInsuranceExists,
            $singleDriver,
            $prevInsuranceContractDate,
            $countOccasionalDrivers
        );
    }

    private static function createFaker(): Generator
    {
        return Factory::create();
    }
}
