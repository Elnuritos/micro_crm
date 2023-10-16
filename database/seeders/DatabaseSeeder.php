<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\StockSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OrderItemSeeder;
use Database\Seeders\WarehouseSeeder;
use Database\Seeders\ProductMovementSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WarehouseSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            StockSeeder::class,
            ProductMovementSeeder::class
        ]);
    }
}
