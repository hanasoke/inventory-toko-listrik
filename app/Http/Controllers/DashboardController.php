<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'lowStock' => Product::whereColumn(
                'stock', '<=', 'min_stock'
            )->count(),
            'totalStock' => Product::sum('stock'),
            'recentMovements' => StockMovement::with('product')
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }
}
