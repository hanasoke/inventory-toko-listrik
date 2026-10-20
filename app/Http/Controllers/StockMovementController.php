<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function index(Request $request) 
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->filled('type'), function($query) use ($request) {
                $query->where('type', $request->input('type'));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); 

        return view('stock-movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock-movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'type' => [
                'required',
                Rule::in(['masuk', 'keluar']),
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'reference_number' => [
                'nullable',
                'string',
                'max:50',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            // Mengunci baris produk selama stok diperbarui.
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            if (
                $validated['type'] === 'keluar'
                && $product->stock < $quantity
            ) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi. Stok tersedia: '
                        . $product->stock . ' ' . $product->unit . '.',
                ]);
            }

            if ($validated['type'] === 'masuk') {
                $product->stock += $quantity;
            } else {
                $product->stock -= $quantity;
            }

            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'quantity' => $quantity,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);
        }, 3);

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Transaksi stok berhasil disimpan.');
    }
}
