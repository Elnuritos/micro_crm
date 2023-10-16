<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    protected $model = Stock::class;
    private static $combinations = null;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (is_null(self::$combinations)) {
            $products = Product::all();
            $warehouses = Warehouse::all();

            self::$combinations = $products->crossJoin($warehouses)->map(function ($pair) {
                return ['product' => $pair[0], 'warehouse' => $pair[1]];
            })->shuffle();
        }

        if (!self::$combinations->count()) {
            throw new \Exception("No more unique combinations available");
        }

        $combination = self::$combinations->pop();

        return [
            'product_id' => $combination['product']->id,
            'warehouse_id' => $combination['warehouse']->id,
            'stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
