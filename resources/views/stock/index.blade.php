@extends('layouts.app')

@section('content')
    <div class="toolbar" style="justify-content: space-between; margin-bottom: 20px; gap: 16px; flex-wrap: wrap;">
        <div>
            <h1 style="margin: 0; font-size: 1.75rem;">Stock History</h1>
            <p style="margin: 6px 0 0 0; color: #475569;">View all stock in and stock out events.</p>
        </div>

        <form method="GET" action="{{ route('stock.index') }}" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="product_name" placeholder="Filter by product name" value="{{ old('product_name', $query ?? '') }}" style="padding: 10px 14px; border-radius: 12px; border: 1px solid #cbd5e1; min-width: 220px;" />
            <button type="submit" class="button">Search</button>
            <a href="{{ route('stock.index') }}" class="button secondary">Clear</a>
        </form>

        <a href="{{ route('products.index') }}" class="button secondary">Back to products</a>
    </div>

    <div class="card">
        @if($transactions->isEmpty())
            <p>No stock movements yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Row</th>
                        <th>Date</th>
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $transaction->product->name }}</td>
                            <td><span class="badge {{ $transaction->type }}">{{ ucfirst($transaction->type) }}</span></td>
                            @php
                                $notes = [];
                                if ($transaction->notes) {
                                    $notes = preg_split('/[;,]+/', trim($transaction->notes));
                                    $notes = array_map('trim', $notes);
                                    $notes = array_filter($notes);
                                    if (count($notes) === 1) {
                                        $notes = preg_split('/\s+/', $notes[0]);
                                        $notes = array_map('trim', $notes);
                                        $notes = array_filter($notes);
                                    }
                                }
                            @endphp
                            <td>{{ $transaction->quantity }}</td>
                            <td>
                                @if($notes)
                                    <table style="border-collapse: collapse; width: 100%; max-width: 220px;">
                                        <tbody>
                                            @foreach($notes as $index => $note)
                                                <tr>
                                                    <td style="border: 1px solid #e2e8f0; padding: 4px 8px; background: #ffffff;">{{ $index + 1 }}</td>
                                                    <td style="border: 1px solid #e2e8f0; padding: 4px 8px; background: #ffffff;">{{ $note }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
