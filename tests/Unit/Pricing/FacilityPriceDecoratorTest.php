<?php

use App\Services\Pricing\BaseRoomPrice;
use App\Services\Pricing\FacilityPriceDecoratorBuilder;

it('keeps base total when no facilities are selected', function () {
    $builder = new FacilityPriceDecoratorBuilder([
        'Complimentary Breakfast' => 10,
    ]);

    $price = $builder->build(new BaseRoomPrice(120), []);

    expect($price->total())->toBe(120.0);
});

it('adds fees for selected facilities', function () {
    $builder = new FacilityPriceDecoratorBuilder([
        'Complimentary Breakfast' => 10,
        'Minibar' => 5,
    ]);

    $price = $builder->build(
        new BaseRoomPrice(120),
        ['Complimentary Breakfast', 'Minibar']
    );

    expect($price->total())->toBe(135.0);
});

it('ignores unknown facilities', function () {
    $builder = new FacilityPriceDecoratorBuilder([
        'Minibar' => 5,
    ]);

    $price = $builder->build(new BaseRoomPrice(120), ['Unknown Facility']);

    expect($price->total())->toBe(120.0);
});

it('ignores non-string selections', function () {
    $builder = new FacilityPriceDecoratorBuilder([
        'Minibar' => 5,
    ]);

    $price = $builder->build(
        new BaseRoomPrice(120),
        ['Minibar', 123, null]
    );

    expect($price->total())->toBe(125.0);
});
