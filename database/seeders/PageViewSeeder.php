<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('page_views')->insert([
                'sort_order'    => $i,
                'viewable_type' => 'App\Models\Post',
                'viewable_id'   => rand(1, 20),
                'viewer_type'   => 'App\Models\User',
                'viewer_id'     => rand(1, 5),
                'ip_address'    => '192.168.0.' . rand(1, 255),
                'user_agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'referrer'      => 'https://example.com',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }
}
