<?php

namespace Database\Seeders;

use App\Enums\RankStatus;
use App\Models\Admin;
use App\Models\Rank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        $folder = public_path('uploads/ranks');

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Define medal colors for levels
        $medalColors = [
            [255, 215, 0],   // Gold
            [192, 192, 192], // Silver
            [205, 127, 50],  // Bronze
        ];

        for ($i = 1; $i <= 10; $i++) {

            $imageName = "rank_{$i}.png";
            $imagePath = $folder . '/' . $imageName;

            // Create blank image
            $img = imagecreatetruecolor(400, 400);

            // Background
            $bg = imagecolorallocate($img, 30, 30, 60); // dark blue
            imagefill($img, 0, 0, $bg);

            // Medal color based on level
            $colorIndex = ($i <= 3) ? $i - 1 : 0; // first 3 ranks get Gold/Silver/Bronze
            $medalRGB = $medalColors[$colorIndex];
            $medalColor = imagecolorallocate($img, $medalRGB[0], $medalRGB[1], $medalRGB[2]);

            // Draw circular medal
            imagefilledellipse($img, 200, 200, 250, 250, $medalColor);

            // Decorative sparkles
            for ($j = 0; $j < 5; $j++) {
                $dotColor = imagecolorallocate($img, rand(200, 255), rand(200, 255), 0);
                $x = rand(50, 350);
                $y = rand(50, 350);
                imagefilledellipse($img, $x, $y, 20, 20, $dotColor);
            }

            // Optional: Add Rank text
            $textColor = imagecolorallocate($img, 0, 0, 0);
            imagestring($img, 5, 140, 180, "Level {$i}", $textColor);

            // Save image
            imagepng($img, $imagePath);
            imagedestroy($img);

            // Insert into database
            Rank::create([
                'name'           => "Rank {$i}",
                'slug'           => Str::slug("Rank {$i}"),
                'status'         => $i === 1 ? RankStatus::ACTIVE->value : RankStatus::INACTIVE->value,
                'minimum_points' => rand(500, 1000),
                'created_by'     => Admin::inRandomOrder()->value('id'),
                'icon'           => "uploads/ranks/{$imageName}",
            ]);
        }
    }
}
