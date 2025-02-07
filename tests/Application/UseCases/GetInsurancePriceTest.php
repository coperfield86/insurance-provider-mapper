<?php

namespace Tests\Application\UseCases;

use Exception;
use InvalidArgumentException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Src\Application\UseCases\GetInsurancePrice;
use Src\Domain\Repositories\InsurancePriceRepository;
use Tests\Application\Requests\InsurancePriceRequestMother;
use Tests\TestCase;

class GetInsurancePriceTest extends TestCase
{
    private MockInterface $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->repository();
    }

    #[Test]
    public function should_get_xml_request_for_acme_with_previous_insurance(): void
    {
        $this->mock->shouldReceive('getPrice')->andReturns(array());

        $useCase = new GetInsurancePrice();
        $useCase->__invoke(InsurancePriceRequestMother::createASuccessDataWithPreviousInsurance());

        self::assertTrue(true);
    }

    #[Test]
    public function should_get_xml_request_for_acme_without_previous_insurance(): void
    {
        $this->mock->shouldReceive('getPrice')->andReturns(array());

        $useCase = new GetInsurancePrice();
        $useCase->__invoke(InsurancePriceRequestMother::createASuccessDataWithoutPreviousInsurance());

        self::assertTrue(true);
    }

    #[Test]
    public function should_fail_because_count_occasional_drivers_is_0(): void
    {
        $this->mock->shouldReceive('getPrice')->andReturns(array());

        $this->expectException(InvalidArgumentException::class);

        $useCase = new GetInsurancePrice();
        $useCase->__invoke(InsurancePriceRequestMother::createDataWith0OccasionalDriversAndSingleDriverIsFalse());
    }

    #[Test]
    public function should_fail_because_provider_id_does_not_exist(): void
    {
        $this->mock->shouldReceive('getPrice')->andReturns(array());

        $this->expectException(InvalidArgumentException::class);

        $useCase = new GetInsurancePrice();
        $useCase->__invoke(InsurancePriceRequestMother::createDataWithABadProviderId());
    }

    private function repository(): MockInterface|InsurancePriceRepository
    {
        return Mockery::mock(InsurancePriceRepository::class);
    }
}
