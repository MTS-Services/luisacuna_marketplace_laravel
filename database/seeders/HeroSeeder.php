<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hero;


class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     */
    public function run(): void
    {
        //
        Hero::create([
            'title' => 'Finish Your Brainrot Set',
            'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
            'action_title' => 'Shop Now',
            'action_url' => '/shop',
            'image' => 'heroes/hero1.jpg',
            'target' => '_self',
            'status' => 'inactive',
        ]);

    }
}
