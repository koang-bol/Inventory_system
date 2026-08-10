<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    // Display stock transaction history / movement logs
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('stock.index', compact('transactions'));
    }

    // Show Stock In Form
    public function showStockInForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.in', compact('products'));
    }

    // Process Stock In
    public function processStockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->increment('quantity', $request->quantity);

        StockTransaction::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'type' => 'IN',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', "Added {$request->quantity} unit(s) to {$product->name}.");
    }

    // Show Stock Out Form
    public function showStockOutForm()
    {
        $products = Product::where('quantity', '>', 0)->orderBy('name')->get();
        return view('stock.out', compact('products'));
    }

    // Process Stock Out
    public function processStockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->quantity) {
            return back()->withErrors(['quantity' => "Cannot remove {$request->quantity} units. Only {$product->quantity} in stock."])->withInput();
        }

        $product->decrement('quantity', $request->quantity);

        StockTransaction::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'type' => 'OUT',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', "Removed {$request->quantity} unit(s) from {$product->name}.");
    }
}