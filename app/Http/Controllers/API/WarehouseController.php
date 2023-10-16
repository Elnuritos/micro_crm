<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }


    public function index()
    {
        return response()->json($this->warehouseService->getAllWarehouses());
    }
}
