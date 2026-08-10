@extends('layouts.app')

@section('content')
    <div class="toolbar" style="justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 1.75rem;">Stock In</h1>
            <p style="margin: 6px 0 0 0; color: #475569;">Add quantity to <strong>{{ $product->name }}</strong>.</p>
        </div>
        <a href="{{ route('products.index') }}" class="button secondary">Back to products</a>
    </div>

    <div class="card" style="max-width: 540px;">
        <form method="POST" action="{{ route('stock.in.store', $product) }}">
            @csrf

            <div class="field">
                <label>Current quantity</label>
                <input type="number" value="{{ $product->quantity }}" disabled />
            </div>

            <div class="field">
                <label for="quantity">Quantity to add</label>
                <input id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" required />
            </div>

            <div class="field">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="button">Apply stock in</button>
                <a href="{{ route('products.index') }}" class="button secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
