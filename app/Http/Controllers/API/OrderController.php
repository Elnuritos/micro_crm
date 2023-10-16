<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{


        protected $orderService;

        public function __construct(OrderService $orderService)
        {
            $this->orderService = $orderService;
        }

        public function index(Request $request)
        {
            $orders = $this->orderService->getAllOrders($request->all());
            return response()->json($orders);
        }

        public function show($id)
        {
            $order = $this->orderService->getOrder($id);
            return response()->json($order);
        }

        public function store(Request $request)
        {
            $order = $this->orderService->createOrder($request->all());
            return response()->json($order, 201);
        }

        public function update(Request $request, $id)
        {
            $order = $this->orderService->updateOrder($id, $request->all());
            return response()->json($order);
        }

        public function complete($id)
        {
            $order = $this->orderService->completeOrder($id);
            return response()->json($order);
        }

        public function cancel($id)
        {
            $order = $this->orderService->cancelOrder($id);
            return response()->json($order);
        }

        public function resume($id)
        {
            $order = $this->orderService->resumeOrder($id);
            return response()->json($order);
        }
}
