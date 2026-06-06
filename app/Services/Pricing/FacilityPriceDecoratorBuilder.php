<?php

namespace App\Services\Pricing;

final class FacilityPriceDecoratorBuilder
{
    /**
     * @param  array<string, float|int>  $facilityFees
     */
    public function __construct(private array $facilityFees)
    {
    }

    public static function fromConfig(): self
    {
        return new self(config('facilities.fees', []));
    }

    /**
     * @param  array<int, mixed>  $selectedFacilities
     */
    public function build(RoomPrice $basePrice, array $selectedFacilities): RoomPrice
    {
        $decorated = $basePrice;

        foreach ($selectedFacilities as $facilityName) {
            if (!is_string($facilityName)) {
                continue;
            }

            if (!array_key_exists($facilityName, $this->facilityFees)) {
                continue;
            }

            $decorated = new FacilityFeeDecorator(
                $decorated,
                (float) $this->facilityFees[$facilityName]
            );
        }

        return $decorated;
    }
}