<?php

namespace Database\Seeders;

use App\Models\GameServer;
use Illuminate\Database\Seeder;

class GameServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        GameServer::factory(10)->create();
    }
}
