<?php

namespace Database\Seeders;

use App\Models\{User, Rank, UserRank,};
use Illuminate\Database\Seeder;

class UserRankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = Rank::pluck('id')->toArray();

        if (empty($ranks)) {
            $this->command->error("No ranks found. Seed the ranks table first.");
            return;
        }

        User::all()->each(function ($user) use ($ranks) {
            UserRank::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'rank_level' => collect($ranks)->random(),
                    'activated_at' => now(),
                ]
            );
        });
    }
}
