<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    // Mengambil data produk & kategori untuk ditampilkan di tabel Vue
    public function index(): JsonResponse
    {
        // Ambil semua produk beserta nama kategorinya (relasi Eloquent)
        $products = Product::with('category')->latest()->get();
        // Ambil semua kategori untuk pilihan di dropdown form tambah produk
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products,
                'categories' => $categories
            ]
        ]);
    }
}