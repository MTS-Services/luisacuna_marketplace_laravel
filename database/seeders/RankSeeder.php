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
        $folder = storage_path('app/public/ranks');

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Medal colors for top 3 ranks (Gold, Silver, Bronze)
        $medalColors = [
            [255, 215, 0],   // Gold
            [192, 192, 192], // Silver
            [205, 127, 50],  // Bronze
            [115, 194, 255], // Platinum
            [185, 242, 255], // Diamond
            [186, 85, 211],  // Master
            [255, 0, 255],   // Grandmaster
        ];

        // Base brown tones for badge borders and background
        $baseDarkBrown = [60, 35, 20];
        $borderOuter = [101, 67, 33];
        $borderInner = [153, 101, 21];
        $defaultCrown = [230, 126, 34]; // Orange for crown on other ranks

        for ($i = 1; $i <= 10; $i++) {

            $imageName = "rank_{$i}.png";
            $imagePath = $folder . '/' . $imageName;

            // Create blank true color image 400x400 with alpha support
            $img = imagecreatetruecolor(400, 400);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            // Allocate colors
            $bgColor = imagecolorallocate($img, ...$baseDarkBrown);
            $outerBorderColor = imagecolorallocate($img, ...$borderOuter);
            $innerBorderColor = imagecolorallocate($img, ...$borderInner);

            // Medal color for crown (top 3 get medal colors, else default orange)
            if ($i <= count($medalColors)) {
                $crownRGB = $medalColors[$i - 1];
            } else {
                $crownRGB = $defaultCrown;
            }
            $crownColor = imagecolorallocate($img, ...$crownRGB);

            // Fill background
            imagefilledrectangle($img, 0, 0, 399, 399, $bgColor);

            // Draw outer border circle
            imagefilledellipse($img, 200, 200, 380, 380, $outerBorderColor);

            // Draw inner border circle
            imagefilledellipse($img, 200, 200, 350, 350, $innerBorderColor);

            // Draw main badge circle
            imagefilledellipse($img, 200, 200, 300, 300, $bgColor);

            // Draw crown shape (polygon + circles)
            $crownPoints = [
                140,
                280,  // left base
                160,
                180,  // left spike bottom
                180,
                220,  // left spike top
                200,
                160,  // middle spike bottom
                220,
                220,  // middle spike top
                240,
                180,  // right spike bottom
                260,
                280,  // right base
            ];

            imagefilledpolygon($img, $crownPoints, count($crownPoints) / 2, $crownColor);

            // Crown tips as small circles
            imagefilledellipse($img, 160, 180, 20, 20, $crownColor);
            imagefilledellipse($img, 200, 160, 20, 20, $crownColor);
            imagefilledellipse($img, 240, 180, 20, 20, $crownColor);

            // Add Level text below the crown, white color
            $textColor = imagecolorallocate($img, 255, 255, 255);
            $fontSize = 5;
            $text = "Level {$i}";
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textX = (400 - $textWidth) / 2;
            $textY = 320;
            imagestring($img, $fontSize, $textX, $textY, $text, $textColor);

            // Save image as PNG
            imagepng($img, $imagePath);
            imagedestroy($img);

            // Insert rank into database
            Rank::create([
                'name'           => "Rank {$i}",
                'slug'           => Str::slug("Rank {$i}"),
                'status'         => $i === 1 ? RankStatus::ACTIVE->value : RankStatus::INACTIVE->value,
                'minimum_points' => rand(500, 1000),
                'created_by'     => Admin::inRandomOrder()->value('id'),
                'icon'           => "storage/ranks/{$imageName}",
            ]);
        }
    }
}
