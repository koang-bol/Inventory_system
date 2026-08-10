@extends('layouts.app')

@section('content')
    <div class="toolbar" style="justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 1.75rem;">Products</h1>
            <p style="margin: 6px 0 0 0; color: #475569;">Manage products, quantities, and stock movements.</p>
        </div>

        <a href="{{ route('products.create') }}" class="button">Add Product</a>
    </div>

    <div class="card">
        @if($products->isEmpty())
            <p>No products yet. Use the button above to add a new product.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if($product->description)
                                    @php
                                        $rawParts = preg_split('/[;,]\s*|\s+/', trim($product->description));
                                        $parts = array_filter(array_map('trim', $rawParts));
                                        $itemPrices = [
                                            'Jacket' => '$129.95',
                                            'Sweater' => '$49.95',
                                            'Trousers' => '$59.95',
                                            'Shoes' => '$89.95',
                                            'Stockings' => '$12.95',
                                        ];
                                        $preparedParts = array_map(function ($part) use ($itemPrices) {
                                            return [
                                                'label' => $part,
                                                'price' => $itemPrices[$part] ?? null,
                                            ];
                                        }, $parts);
                                    @endphp

                                    @if(count($preparedParts) > 1)
                                        <table style="border-collapse: collapse; width: 100%; max-width: 220px;">
                                            <tbody>
                                                @foreach($preparedParts as $item)
                                                    <tr>
                                                        <td style="border: 1px solid #e2e8f0; padding: 4px 6px; background: #f8fafc;">{{ $item['label'] }}</td>
                                                        <td style="border: 1px solid #e2e8f0; padding: 4px 6px; background: #f8fafc; text-align: right;">{{ $item['price'] ?? '—' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        {{ $product->description }}
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <table style="border-collapse: collapse; width: 100%; max-width: 120px;">
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid #e2e8f0; padding: 6px 8px; background: #f8fafc; text-align: center;">${{ number_format($product->price, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table style="border-collapse: collapse; width: 100%; max-width: 80px;">
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid #e2e8f0; padding: 6px 8px; background: #f8fafc; text-align: center;">{{ $product->quantity }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="white-space: nowrap; display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                                <a href="{{ route('products.edit', $product) }}" class="button">Edit</a>
                                <a href="{{ route('stock.in', $product) }}" class="button secondary">Stock In</a>
                                <a href="{{ route('stock.out', $product) }}" class="button secondary">Stock Out</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button danger" style="font-size: 0.85rem; padding: 8px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
