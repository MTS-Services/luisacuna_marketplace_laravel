<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UserLoyaltyPointAllocationJob;

class UserLoyaltyPointAllocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-loyalty-point-allocation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new UserLoyaltyPointAllocationJob());
    }
}
