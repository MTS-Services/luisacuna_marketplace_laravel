<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all configuration caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('cache:clear');
        $this->call('optimize:clear');
        $this->call('config:cache');
        $this->call('icons:cache');
        

        $this->info('Configuration refreshed successfully!');
        return 0;
    }
}
