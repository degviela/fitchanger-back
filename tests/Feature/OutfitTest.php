<?php

use App\Models\ClothingItem;
use App\Models\Outfit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('can create a new outfit', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    Sanctum::actingAs($user);

    // Create clothing items
    $head = ClothingItem::factory()->create(['type' => 'head']);
    $top = ClothingItem::factory()->create(['type' => 'top']);
    $bottom = ClothingItem::factory()->create(['type' => 'bottom']);
    $footwear = ClothingItem::factory()->create(['type' => 'footwear']);

    // Data for the outfit
    $outfitData = [
        'user_id' => $user->id,
        'name' => 'Casual Outfit',
        'head_id' => $head->id,
        'top_id' => $top->id,
        'bottom_id' => $bottom->id,
        'footwear_id' => $footwear->id,
    ];

    // Make a POST request to create the outfit
    $response = $this->postJson('/api/authenticated/outfits', $outfitData);

    // Assert the response status
    $response->assertStatus(201);

    // Assert the outfit was created in the database
    $this->assertDatabaseHas('outfits', [
        'user_id' => $user->id,
        'name' => 'Casual Outfit',
        'head_id' => $head->id,
        'top_id' => $top->id,
        'bottom_id' => $bottom->id,
        'footwear_id' => $footwear->id,
    ]);
});

test('can change the clothes on an outfit', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    Sanctum::actingAs($user);

    // Create clothing items
    $head = ClothingItem::factory()->create(['type' => 'head']);
    $top = ClothingItem::factory()->create(['type' => 'top']);
    $bottom = ClothingItem::factory()->create(['type' => 'bottom']);
    $footwear = ClothingItem::factory()->create(['type' => 'footwear']);

    // Create an outfit
    $outfit = Outfit::factory()->create([
        'user_id' => $user->id,
        'name' => 'Casual Outfit',
        'head_id' => $head->id,
        'top_id' => $top->id,
        'bottom_id' => $bottom->id,
        'footwear_id' => $footwear->id,
    ]);

    // Data for updating the outfit
    $updateData = [
        'user_id' => $user->id,
        'name' => 'Updated Outfit',
        'head_id' => $head->id,
        'top_id' => $top->id,
        'bottom_id' => $bottom->id,
        'footwear_id' => $footwear->id,
    ];

    // Make a PUT request to update the outfit
    $response = $this->putJson("/api/authenticated/outfits/{$outfit->id}", $updateData);

    // Assert the response status
    $response->assertStatus(200);

    // Assert the outfit was updated in the database
    $this->assertDatabaseHas('outfits', [
        'id' => $outfit->id,
        'name' => 'Updated Outfit',
    ]);
});

test('can remove an outfit from saved outfits', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    Sanctum::actingAs($user);

    // Create an outfit
    $outfit = Outfit::factory()->create([
        'user_id' => $user->id,
        'name' => 'Casual Outfit',
    ]);

    // Make a DELETE request to delete the outfit
    $response = $this->deleteJson("/api/authenticated/outfits/{$outfit->id}");

    // Assert the response status
    $response->assertStatus(200);

    // Assert the outfit was deleted from the database
    $this->assertDatabaseMissing('outfits', [
        'id' => $outfit->id,
    ]);
});
