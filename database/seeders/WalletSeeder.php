<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $wallets = [];

        foreach ($users as $user) {
            $balance = rand(1000, 10000);
            $wallets[] = [
                'user_id' => $user->id,
                'currency_code' => 'USD',
                'balance' => $balance,
                'locked_balance' => 0.00,
                'pending_balance' => 0.00,
                'total_deposits' => $balance,
                'total_withdrawals' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Wallet::insert($wallets);
    }
}
