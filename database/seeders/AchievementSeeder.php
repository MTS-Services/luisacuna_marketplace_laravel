<?php

namespace Database\Seeders;

use App\Enums\AchievementStatus;
use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $folder = storage_path('app/public/achievements'); // Path to store achievement images

        // Create folder if not exists
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Achievement titles
        $titles = [
            'Starter Badge', 'First Step', 'Pro Level', 'Ultimate Winner', 
            'Sharp Shooter', 'Speed Runner', 'Master Player', 'Daily Grinder',
            'Weekly Hero', 'Gold Collector', 'King of Points', 'Rising Star',
            'Champion Badge', 'Milestone Achiever', 'Elite Ranker', 'Top Performer',
            'Skill Builder', 'Progress Hunter', 'Level Dominator', 'Victory Badge'
        ];

        $achievements = [];
        $now = now();

        // Loop through and create achievements
        for ($i = 1; $i <= 40; $i++) {

            // Generate a dynamic image name
            $imageName = "achievement_{$i}.png";
            $imagePath = $folder . '/' . $imageName;

            // Create blank true color image 400x400 with alpha support
            $img = imagecreatetruecolor(400, 400);
            imagealphablending($img, true);
            imagesavealpha($img, true);

            // Allocate colors
            $bgColor = imagecolorallocate($img, 60, 35, 20);  // Base brown for background
            $textColor = imagecolorallocate($img, 255, 255, 255);  // White text color

            // Fill the background
            imagefilledrectangle($img, 0, 0, 399, 399, $bgColor);

            // Draw a simple circle for the achievement icon (can be customized later)
            $circleColor = imagecolorallocate($img, 255, 215, 0); // Gold for the circle
            imagefilledellipse($img, 200, 200, 350, 350, $circleColor);

            // Add Achievement title text in the middle
            $fontSize = 5;
            $text = $titles[$i % count($titles)];
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textX = (400 - $textWidth) / 2;
            $textY = 160;
            imagestring($img, $fontSize, $textX, $textY, $text, $textColor);

            // Save the image as PNG
            imagepng($img, $imagePath);
            imagedestroy($img);

            // Insert achievement into the database
            $achievements[] = [
                'sort_order'   => $i,
                'rank_id'      => rand(1, 10),             // Random rank id
                'icon'         => "achievements/{$imageName}", // Save the icon path
                'title'        => $text,
                'description'  => "This achievement unlocks for {$text}.",
                'category_id'  => rand(1, 5),              // Random category
                'target_value' => rand(50, 500),           // Random target value
                'point_reward' => rand(20, 200),           // Random point reward
                'status'       => AchievementStatus::ACTIVE->value,
                'created_by'   => 1,                       // Admin ID who created this
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        // Insert all achievements into the database
        Achievement::insert($achievements);
    }
}
