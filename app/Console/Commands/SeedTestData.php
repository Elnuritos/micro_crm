<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-testdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds database with test data for products, warehouses and stocks.';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('Seeding products, warehouses and stocks with test data...');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->info('Database seeding completed.');
    }
}
