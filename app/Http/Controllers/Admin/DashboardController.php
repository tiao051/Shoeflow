<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Application\Services\OrderService;
use Application\Services\ShoeService;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private ShoeService $shoeService
    ) {
        $this->middleware('admin');
    }

    public function index()
    {
        $statistics = $this->orderService->getStatistics();
        $totalUsers = User::where('role', 'user')->count();
        $totalShoes = count($this->shoeService->getAllShoes());
        
        $recentOrders = $this->orderService->getAllOrders(5);

        return view('admin.dashboard', compact('statistics', 'totalUsers', 'totalShoes', 'recentOrders'));
    }
}
