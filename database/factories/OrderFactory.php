<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer' => $this->faker->name,
            'created_at' => $this->faker->dateTimeThisYear,
            'completed_at' => $this->faker->optional()->dateTimeThisYear,
            'warehouse_id' => $this->faker->randomElement(Warehouse::pluck('id')->toArray()),
            'status' => $this->faker->randomElement(['active', 'completed', 'canceled']),
        ];
    }
}
