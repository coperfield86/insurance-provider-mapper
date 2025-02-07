<?php
namespace Src\Domain\ValueObjects;

final class InsurancePriceVO
{
    public function __construct(
        private PriceVO $price
    )
    {
    }

    public function getPrimitives(): array
    {
        return [
            'price' => $this->price->value()
        ];
    }
}
