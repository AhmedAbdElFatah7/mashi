<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class SampleImagesSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample images directory if it doesn't exist
        if (!Storage::disk('public')->exists('ads')) {
            Storage::disk('public')->makeDirectory('ads');
        }

        // Sample image URLs from Picsum (placeholder images)
        $imageUrls = [
            'https://picsum.photos/800/600?random=1',
            'https://picsum.photos/800/600?random=2', 
            'https://picsum.photos/800/600?random=3',
            'https://picsum.photos/800/600?random=4',
            'https://picsum.photos/800/600?random=5',
            'https://picsum.photos/800/600?random=6',
            'https://picsum.photos/800/600?random=7',
            'https://picsum.photos/800/600?random=8',
            'https://picsum.photos/800/600?random=9',
            'https://picsum.photos/800/600?random=10',
        ];

        foreach ($imageUrls as $index => $url) {
            $filename = 'sample' . ($index + 1) . '.jpg';
            $path = 'ads/' . $filename;
            
            // Skip if file already exists
            if (Storage::disk('public')->exists($path)) {
                $this->command->info("Image {$filename} already exists, skipping...");
                continue;
            }

            try {
                // Download image
                $response = Http::timeout(30)->get($url);
                
                if ($response->successful()) {
                    // Save image to storage
                    Storage::disk('public')->put($path, $response->body());
                    $this->command->info("Downloaded sample image: {$filename}");
                } else {
                    $this->command->error("Failed to download image from: {$url}");
                }
            } catch (\Exception $e) {
                $this->command->error("Error downloading {$filename}: " . $e->getMessage());
            }
        }

        $this->command->info('Sample images seeding completed!');
    }
}
