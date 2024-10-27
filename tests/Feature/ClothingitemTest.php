<?php

use App\Models\ClothingItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a clothing item can be created', function () {
    $this->withoutExceptionHandling();

    // Data for the new clothing item
    $clothingItemData = [
        'type' => 'top',
        'name' => 'T-Shirt',
        'image_path' => 'https://example.com/images/tshirt.png',
    ];

    // Send a POST request to create the clothing item
    $response = $this->post('/clothing-items', $clothingItemData, [
        'Accept' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest'
    ]);

    // Assert the response status is 201 Created
    $response->assertStatus(201);

    // Assert the clothing item was created in the database
    $this->assertDatabaseHas('clothing_items', ['name' => 'T-Shirt']);
});
