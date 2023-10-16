<?php


namespace App\Services;

use App\Models\ProductMovement;

class ProductMovementService
{
    /**
     * Запись движения товара.
     *
     * @param int $productId
     * @param int $warehouseId
     * @param int $quantity
     * @return ProductMovement
     */
    public function recordMovement($productId, $warehouseId, $quantity)
    {
        return ProductMovement::create([
            'product_id' => $productId,
            'warehouse_id' => $warehouseId,
            'quantity' => $quantity,
        ]);
    }
    /**
     * Получение движений товаров с возможностью фильтрации.
     *
     * @param array $filters
     * @param int $pagination
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getMovements($filters = [], $pagination = 10)
    {
        $query = ProductMovement::with('product', 'warehouse');

        if (isset($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        if (isset($filters['warehouse_id'])) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }


        return $query->paginate($pagination);
    }
}
