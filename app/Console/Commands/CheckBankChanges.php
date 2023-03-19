<?php

namespace App\Console\Commands;

use App\Services\BankMonitorService;
use Illuminate\Console\Command;

class CheckBankChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-bank-changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        (new BankMonitorService())->checkUpdates();
    }
}
