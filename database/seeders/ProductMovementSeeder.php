<?php

namespace Database\Seeders;

use App\Models\ProductMovement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductMovement::factory()->count(20)->create();

    }
}
