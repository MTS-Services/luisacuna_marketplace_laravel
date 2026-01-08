<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Hero::insert(
            [
                [
                    'title' => 'Finish Your Brainrot Set',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ], [
                    'title' => 'Finish Your Brainrot Set 2',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now 2',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ],
                [
                    'title' => 'Finish Your Brainrot Set 3',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now 3',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ],
                [
                    'title' => 'Finish Your Brainrot Set',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ],
                [
                    'title' => 'Finish Your Brainrot Set',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ], [
                    'title' => 'Finish Your Brainrot Set 2',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now 2',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ],
                [
                    'title' => 'Finish Your Brainrot Set 3',
                    'content' => 'Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.',
                    'action_title' => 'Shop Now 3',
                    'action_url' => '/shop',
                    'image' => 'b8139764f2bfc9cf363d2632afd404c8dad49732_1_ieucbr',
                    'mobile_image' => 'heroes/hero1.jpg',
                    'target' => '_self',
                    'status' => 'active',
                ],
            ]
        );

    }
}
