<?php

namespace Database\Factories;

use App\Models\Outfit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outfit>
 */
class OutfitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Outfit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->word,
            'head_id' => \App\Models\ClothingItem::factory(),
            'top_id' => \App\Models\ClothingItem::factory(),
            'bottom_id' => \App\Models\ClothingItem::factory(),
            'footwear_id' => \App\Models\ClothingItem::factory(),
        ];
    }
}
