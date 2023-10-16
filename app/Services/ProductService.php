<?php
namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Получить все товары с остатками по складам.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllProducts()
    {
        return Product::with('stocks.warehouse')->get();
    }

    /**
     * Получить товар по ID.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getProduct($id)
    {
        return Product::with('stocks.warehouse')->find($id);
    }

    /**
     * Добавить новый товар.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    /**
     * Обновить информацию о товаре.
     *
     * @param  int    $id
     * @param  array  $data
     * @return bool|int
     */
    public function updateProduct($id, array $data)
    {
        return Product::where('id', $id)->update($data);
    }

    /**
     * Удалить товар.
     *
     * @param  int  $id
     * @return bool|null
     */
    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }

    // Дополнительные методы по мере необходимости...
}
