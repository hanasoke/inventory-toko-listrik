<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function inventory()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        $totalProducts = Product::count();
        $totalUnits = Product::sum('stock');

        $lowStockCount = Product::whereColumn(
            'stock',
            '<=',
            'min_stock'
        )->count();

        $inventoryValue = Product::selectRaw(
            'COALESCE(SUM(stock * purchase_price), 0) AS total'
        )->value('total');

        return view('reports.inventory', compact(
            'products',
            'totalProducts',
            'totalUnits',
            'lowStockCount',
            'inventoryValue'
        ));
    }

    public function purchases(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'supplier_id' => [
                'nullable',
                'integer',
                'exists:suppliers,id',
            ],
        ]);

        $query = Purchase::with(['supplier', 'user']);

        if (!empty($validated['start_date'])) {
            $query->whereDate(
                'purchase_date',
                '>=',
                $validated['start_date']
            );
        }

        if (!empty($validated['end_date'])) {
            $query->whereDate(
                'purchase_date',
                '<=',
                $validated['end_date']
            );
        }

        if (!empty($validated['supplier_id'])) {
            $query->where(
                'supplier_id',
                $validated['supplier_id']
            );
        }

        $totalPurchase = (clone $query)->sum('total');

        $purchases = $query
            ->latest('purchase_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $suppliers = Supplier::orderBy('name')->get();

        return view('reports.purchases', compact(
            'purchases',
            'suppliers',
            'totalPurchase'
        ));
    }
}
