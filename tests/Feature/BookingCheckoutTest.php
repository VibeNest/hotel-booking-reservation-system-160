<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('checkout store redirects when booking session is missing', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('checkout.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'country' => 'Vietnam',
        'phone' => '123456789',
        'address' => '123 Test Street',
        'state' => 'Test State',
        'zip_code' => '10000',
        'payment_method' => 'COD',
    ]);

    $response->assertRedirect(route('checkout'));
    $response->assertSessionHas('error', 'Session expired');
});
