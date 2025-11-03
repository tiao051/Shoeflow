<?php

namespace Infrastructure\Repositories;

use App\Models\Order as OrderModel;
use App\Models\OrderItem;
use Domain\Entities\Order;
use Domain\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function findAll(int $perPage = 15): array
    {
        $paginated = OrderModel::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return [
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ];
    }

    public function findById(int $id): ?Order
    {
        $model = OrderModel::with(['items', 'user'])->find($id);
        
        if (!$model) {
            return null;
        }

        $data = $model->toArray();
        return Order::fromArray($data);
    }

    public function findByOrderNumber(string $orderNumber): ?Order
    {
        $model = OrderModel::with(['items', 'user'])
            ->where('order_number', $orderNumber)
            ->first();
        
        if (!$model) {
            return null;
        }

        return Order::fromArray($model->toArray());
    }

    public function findByUser(int $userId, int $perPage = 10): array
    {
        $paginated = OrderModel::where('user_id', $userId)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return [
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ];
    }

    public function create(array $orderData, array $items): Order
    {
        return DB::transaction(function () use ($orderData, $items) {
            $order = OrderModel::create($orderData);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'shoe_id' => $item['shoe_id'],
                    'shoe_name' => $item['shoe_name'],
                    'shoe_image' => $item['shoe_image'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $order->load('items');
            return Order::fromArray($order->toArray());
        });
    }

    public function updateStatus(int $id, string $status): bool
    {
        $order = OrderModel::findOrFail($id);
        $order->status = $status;

        if ($status === 'shipped') {
            $order->shipped_at = now();
        } elseif ($status === 'delivered') {
            $order->delivered_at = now();
        }

        return $order->save();
    }

    public function updatePaymentStatus(int $id, string $paymentStatus): bool
    {
        $order = OrderModel::findOrFail($id);
        $order->payment_status = $paymentStatus;

        if ($paymentStatus === 'paid') {
            $order->paid_at = now();
        }

        return $order->save();
    }

    public function getStatistics(array $filters = []): array
    {
        $query = OrderModel::query();

        if (!empty($filters['start_date'])) {
            $query->where('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('created_at', '<=', $filters['end_date']);
        }

        $totalOrders = (clone $query)->count();
        $totalRevenue = (clone $query)->where('payment_status', 'paid')->sum('total');
        $pendingOrders = (clone $query)->where('status', 'pending')->count();
        $completedOrders = (clone $query)->where('status', 'delivered')->count();

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
        ];
    }
}
