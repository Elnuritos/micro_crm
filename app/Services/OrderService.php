<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    /**
     * Получить все заказы.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllOrders()
    {
        return Order::with(['orderItems.product', 'warehouse'])->get();
    }
    /**
     * Получить заказ по ID.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getOrder($id)
    {
        return Order::with(['orderItems.product', 'warehouse'])->where('id', $id)->first();
    }

    /**
     * Создание заказа
     *
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function createOrder(array $data): Order
    {
         /*  $stock = Stock::where('product_id', $data['items'][0]['product_id'])
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->first();
        dd($stock); */

        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer' => $data['customer'],
                'status' => 'active',
                'warehouse_id' => $data['warehouse_id'],
            ]);

            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                ]);


                $stock = Stock::where('product_id', $item['product_id'])
                    ->where('warehouse_id', $order->warehouse_id)
                    ->first();

                if ($stock) {
                    DB::table('stocks')
                        ->where('product_id', $item['product_id'])
                        ->where('warehouse_id', $order->warehouse_id)
                        ->decrement('stock', $item['count']);
                } else {
                    throw new Exception('Недостаточно товара на складе');
                }
            }

            return $order;
        });
    }

    /**
     * Обновление заказа
     *
     * @param int $id
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function updateOrder(int $id, array $data): Order
    {
        return DB::transaction(function () use ($id, $data) {
            $order = Order::find($id);
            if (!$order) {
                throw new Exception('Заказ не найден');
            }

            $order->update([
                'customer' => $data['customer'],
                'warehouse_id' => $data['warehouse_id'],
            ]);

            foreach ($order->orderItems as $item) {
                Stock::where('product_id', $item->product_id)
                     ->where('warehouse_id', $order->warehouse_id)
                     ->update(['stock' => DB::raw('stock + ' . $item->count)]);
            }

            $order->orderItems()->delete();

            foreach ($data['items'] as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'count' => $itemData['count'],
                ]);

                $stock = Stock::where('product_id', $itemData['product_id'])
                    ->where('warehouse_id', $order->warehouse_id)
                    ->first();

                if (!$stock || $stock->stock < $itemData['count']) {
                    throw new Exception('Недостаточно товара на складе');
                }

                Stock::where('product_id', $itemData['product_id'])
                     ->where('warehouse_id', $order->warehouse_id)
                     ->update(['stock' => DB::raw('stock - ' . $itemData['count'])]);
            }

            return $order;
        });
    }




    /**
     * Завершение заказа
     *
     * @param int $id
     * @return Order
     */
    public function completeOrder(int $id): Order
    {
        $order = Order::find($id);
        if (!$order) {
            throw new Exception('Заказ не найден');
        }

        $order->update(['status' => 'completed', 'completed_at' => now()]);
        return $order;
    }

    /**
     * Отмена заказа
     *
     * @param int $id
     * @return Order
     */
    public function cancelOrder(int $id): Order
    {
        return DB::transaction(function () use ($id) {
            $order = Order::find($id);
            if (!$order) {
                throw new Exception('Заказ не найден');
            }

            $order->update(['status' => 'canceled']);

            foreach ($order->orderItems as $item) {
                Stock::where('product_id', $item->product_id)
                     ->where('warehouse_id', $order->warehouse_id)
                     ->update(['stock' => DB::raw('stock + ' . $item->count)]);
            }

            return $order;
        });
    }
    /**
     * Возобновление заказа
     *
     * @param int $id
     * @return Order
     */
    public function resumeOrder(int $id): Order
    {
        return DB::transaction(function () use ($id) {
            $order = Order::find($id);
            if (!$order) {
                throw new Exception('Заказ не найден');
            }

            if ($order->status !== 'canceled') {
                throw new Exception('Заказ не может быть возобновлен');
            }

            $order->update(['status' => 'active']);

            foreach ($order->orderItems as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->where('warehouse_id', $order->warehouse_id)
                    ->first();

                if (!$stock || $stock->stock < $item->count) {
                    throw new Exception('Недостаточно товара на складе для возобновления заказа');
                }

                Stock::where('product_id', $item['product_id'])
                     ->where('warehouse_id', $order->warehouse_id)
                     ->update(['stock' => DB::raw('stock - ' . $item['count'])]);
            }

            return $order;
        });
    }
}
