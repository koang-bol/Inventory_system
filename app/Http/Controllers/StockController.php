<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('product_name');

        $transactionsQuery = StockTransaction::select('stock_transactions.*')
            ->join('products', 'stock_transactions.product_id', '=', 'products.id')
            ->with('product');

        if ($query) {
            $transactionsQuery->where('products.name', 'like', '%' . $query . '%');
        }

        $transactions = $transactionsQuery
            ->orderBy('products.name')
            ->orderByDesc('stock_transactions.created_at')
            ->get();

        return view('stock.index', compact('transactions', 'query'));
    }

    public function createIn(Product $product)
    {
        return view('stock.in', compact('product'));
    }

    public function storeIn(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        $product->increment('quantity', $data['quantity']);

        StockTransaction::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $data['quantity'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Stock updated successfully.');
    }

    public function createOut(Product $product)
    {
        return view('stock.out', compact('product'));
    }

    public function storeOut(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->quantity],
            'notes' => ['nullable', 'string'],
        ]);

        $product->decrement('quantity', $data['quantity']);

        StockTransaction::create([
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => $data['quantity'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Stock updated successfully.');
    }
}
