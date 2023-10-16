<?php
namespace App\Services;

use App\Models\Warehouse;

class WarehouseService
{
    /**
     * Получить все склады.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllWarehouses()
    {
        return Warehouse::all();
    }

    /**
     * Получить склад по ID.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getWarehouse($id)
    {
        return Warehouse::find($id);
    }

    /**
     * Добавить новый склад.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createWarehouse(array $data)
    {
        return Warehouse::create($data);
    }

    /**
     * Обновить информацию о складе.
     *
     * @param  int    $id
     * @param  array  $data
     * @return bool|int
     */
    public function updateWarehouse($id, array $data)
    {
        return Warehouse::where('id', $id)->update($data);
    }

    /**
     * Удалить склад.
     *
     * @param  int  $id
     * @return bool|null
     */
    public function deleteWarehouse($id)
    {
        return Warehouse::destroy($id);
    }


}
