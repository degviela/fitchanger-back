<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OutfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outfits = [
            ['user_id' => 1, 'name' => 'Casual Outfit', 'head_id' => 1, 'top_id' => 2, 'bottom_id' => 3, 'footwear_id' => 4],
            ['user_id' => 1, 'name' => 'Casual Outfit', 'head_id' => 1, 'top_id' => 3, 'bottom_id' => 4, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Casual Outfit', 'head_id' => 1, 'top_id' => 3, 'bottom_id' => 4, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Casual Outfit', 'head_id' => 1, 'top_id' => 3, 'bottom_id' => 4, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Omaigad', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'bhjbvjvhj', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'sigma', 'head_id' => 2, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 6],
            ['user_id' => 1, 'name' => 'adawddaaw', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'adawdda', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Sigma skibi', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Pink guy', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'swqwswqs', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'wadadwa', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Pinknibab', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'Siiiigma', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
            ['user_id' => 1, 'name' => 'kinda gay', 'head_id' => 1, 'top_id' => 4, 'bottom_id' => 3, 'footwear_id' => 5],
        ];

        foreach ($outfits as $outfit) {
            DB::table('outfits')->insert([
                'user_id' => $outfit['user_id'],
                'name' => $outfit['name'],
                'head_id' => $outfit['head_id'],
                'top_id' => $outfit['top_id'],
                'bottom_id' => $outfit['bottom_id'],
                'footwear_id' => $outfit['footwear_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
