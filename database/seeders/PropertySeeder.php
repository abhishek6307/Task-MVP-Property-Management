<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;

class PropertySeeder extends Seeder
{
    public function run()
    {
        // Assuming you have already created some users, you can link the properties to existing users
        $users = User::all();

        // Use a loop to create 10 property records
        foreach (range(1, 10) as $index) {
            Property::create([
                'title' => 'Property ' . $index,
                'description' => 'Description for property ' . $index,
                'address' => 'Address ' . $index,
                'price' => rand(50000, 500000),
                'bedrooms' => rand(1, 5),
                'bathrooms' => rand(1, 3),
                'type' => ['apartment', 'house', 'condo'][array_rand(['apartment', 'house', 'condo'])],
                'latitude' => $this->generateRandomLatitude(),
                'longitude' => $this->generateRandomLongitude(),
                'user_id' => $users->random()->id, // Assign to a random user
            ]);
        }
    }

    private function generateRandomLatitude()
    {
        // Latitude range around Delhi (28.40 to 28.88)
        return mt_rand(284000, 288800) / 10000;
    }

    private function generateRandomLongitude()
    {
        // Longitude range around Delhi (76.84 to 77.34)
        return mt_rand(768400, 773400) / 10000;
    }
}
