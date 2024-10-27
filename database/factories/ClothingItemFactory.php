<?php

namespace Database\Factories;

use App\Models\ClothingItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClothingItem>
 */
class ClothingItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClothingItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['head', 'top', 'bottom', 'footwear']),
            'name' => $this->faker->word,
            'image_path' => $this->faker->imageUrl(),
        ];
    }
}
