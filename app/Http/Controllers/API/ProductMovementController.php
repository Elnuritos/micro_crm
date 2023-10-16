<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\ProductMovementService;

class ProductMovementController extends Controller
{
    protected $productMovementService;

    public function __construct(ProductMovementService $productMovementService)
    {
        $this->productMovementService = $productMovementService;
    }

    /**
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {

        $filters = $request->only(['product_id', 'warehouse_id']);
        $pagination = $request->input('pagination', 10);

        $movements = $this->productMovementService->getMovements($filters, $pagination);
        return response()->json($movements);
    }
}
