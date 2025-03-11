<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClothingItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clothingItems = [
            ['id' => 1, 'type' => 'head', 'name' => 'pink hat', 'image_path' => 'clothing_items/BfMgSd4Wis0uouXSD7G5NS6aS11m1Y9tUfBZyT0V.png'],
            ['id' => 2, 'type' => 'head', 'name' => 'pink hat', 'image_path' => 'clothing_items/GgTzG4R2H9CyzdJvUXCtOWTbuOAQ4k4Y5gyn5FDT.png'],
            ['id' => 3, 'type' => 'bottom', 'name' => 'pink shorts', 'image_path' => 'clothing_items/jeU2SKT9e2iQGGmRIl5gTbwtKHzalT8dD6epOfVX.png'],
            ['id' => 4, 'type' => 'top', 'name' => 'pink top', 'image_path' => 'clothing_items/BpOxy4nK6OuOUCDOT0Ajgf5GaSH993xqBmnkNT1v.png'],
            ['id' => 5, 'type' => 'footwear', 'name' => 'pink shoes', 'image_path' => 'clothing_items/W5DJ7auHkC1bLjhLWNn1ZF5BPBXzO5mraK4nF1KX.png'],
            ['id' => 6, 'type' => 'footwear', 'name' => 'pink shoes', 'image_path' => 'clothing_items/Z6yjWsVpQpAojJuiuxFdBu8YX6phKEEZTL8255Ff.png'],
            ['id' => 7, 'type' => 'footwear', 'name' => 'pink shoes', 'image_path' => 'clothing_items/WpoUle86p2TNOjHWcKwMVsQMxO56VVaOKp4H2BQF.png'],
        ];

        foreach ($clothingItems as $item) {
            DB::table('clothing_items')->insert($item);
        }
    }
}
