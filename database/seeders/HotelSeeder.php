<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use Illuminate\Support\Facades\File;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing hotels to start fresh with real data
        Hotel::truncate();

        // Path to the real CSV file
        $csvPath = base_path('server/real_hotels.csv');

        if (!File::exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header
        
        // Header: hotel_name,city,country,price,rating,tags,image,url,booking_url,description

        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            // Map CSV columns to database columns
            // Assuming row structure matches header order exactly as written by pandas
            
            $name = $row[0];
            $city = $row[1];
            $country = $row[2];
            $price = $row[3];
            $rating = $row[4];
            $tags = $row[5];
            $image = $row[6];
            $url = $row[7];
            $booking_url = $row[8];
            $description = $row[9];

            Hotel::create([
                'name' => $name,
                'city' => $city,
                'country' => $country,
                'address' => $city . ', ' . $country, // Generic address if not available
                'description' => $description,
                'price' => is_numeric($price) ? $price : 0,
                'rating' => is_numeric($rating) ? $rating : 0,
                'image' => $image,
                'url' => $url, // Review URL
                'booking_url' => $booking_url, // Direct Booking URL
                'tags' => $tags,
            ]);
            $count++;
        }

        fclose($file);
        $this->command->info("Successfully seeded $count real hotels.");
    }
}
