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
}
