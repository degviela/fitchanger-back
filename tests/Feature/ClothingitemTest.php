<?php

use App\Models\ClothingItem;
use App\Models\Outfit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('can add a clothing item', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    Sanctum::actingAs($user);

    // Create outfits
    $outfit1 = Outfit::factory()->create();
    $outfit2 = Outfit::factory()->create();

    // Data for the clothing item
    $clothingItemData = [
        'type' => 'top',
        'name' => 'T-Shirt',
        'image' => UploadedFile::fake()->image('tshirt.jpg'),
        'outfit_ids' => [$outfit1->id, $outfit2->id],
    ];

    // Make a POST request to create the clothing item
    $response = $this->postJson('/api/authenticated/clothingitems', $clothingItemData);

    // Assert the response status
    $response->assertStatus(201);

    // Debugging: Output the response content
    $response->dump();

    // Assert the clothing item was created in the database
    $this->assertDatabaseHas('clothing_items', [
        'type' => 'top',
        'name' => 'T-Shirt',
    ]);

    // Assert the clothing item is attached to the outfits
    $clothingItem = ClothingItem::where('name', 'T-Shirt')->first();
    $this->assertTrue($clothingItem->outfits->contains($outfit1));
    $this->assertTrue($clothingItem->outfits->contains($outfit2));
});

test('can change / update the clothing item', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    Sanctum::actingAs($user);

    // Create a clothing item
    $clothingItem = ClothingItem::factory()->create([
        'type' => 'top',
        'name' => 'Old T-Shirt',
    ]);

    // Data for updating the clothing item
    $updateData = [
        'type' => 'top',
        'name' => 'New T-Shirt',
        'image' => UploadedFile::fake()->image('new_tshirt.jpg'),
    ];

    // Make a PUT request to update the clothing item
    $response = $this->putJson("/api/authenticated/clothingitems/{$clothingItem->id}", $updateData);

    // Assert the response status
    $response->assertStatus(200);

    // Debugging: Output the response content
    $response->dump();

    // Assert the clothing item was updated in the database
    $this->assertDatabaseHas('clothing_items', [
        'id' => $clothingItem->id,
        'name' => 'New T-Shirt',
    ]);
});

test('can remove the clothing item from the selection', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    Sanctum::actingAs($user);

    // Create a clothing item
    $clothingItem = ClothingItem::factory()->create([
        'type' => 'top',
        'name' => 'T-Shirt',
    ]);

    // Make a DELETE request to delete the clothing item
    $response = $this->deleteJson("/api/authenticated/clothingitems/{$clothingItem->id}");

    // Assert the response status
    $response->assertStatus(200);

    // Debugging: Output the response content
    $response->dump();

    // Assert the clothing item was deleted from the database
    $this->assertDatabaseMissing('clothing_items', [
        'id' => $clothingItem->id,
    ]);
});
