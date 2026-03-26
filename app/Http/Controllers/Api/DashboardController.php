<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getStats(): JsonResponse
    {
        // Ambil tanggal hari ini mulai dari jam 00:00:00
        $today = Carbon::today();

        // 1. Pendapatan Hari Ini (hanya dari order yang sudah 'paid')
        $revenueToday = Order::whereDate('created_at', $today)
            ->where('status', 'paid')
            ->sum('total_amount');

        // 2. Total Order Hari Ini
        $totalOrders = Order::whereDate('created_at', $today)->count();

        // 3. Order Selesai Hari Ini
        $completedOrders = Order::whereDate('created_at', $today)
            ->where('status', 'paid')
            ->count();

        // 4. Order Pending (belum dibayar/masih diproses)
        $pendingOrders = Order::whereDate('created_at', $today)
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->count();

        // Kembalikan data dalam format JSON
        return response()->json([
            'status' => 'success',
            'data' => [
                'revenue_today' => $revenueToday,
                'total_orders' => $totalOrders,
                'completed_orders' => $completedOrders,
                'pending_orders' => $pendingOrders,
            ]
        ]);
    }
}