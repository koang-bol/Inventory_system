@extends('layouts.app')

@section('content')
    <div class="toolbar" style="justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 1.75rem;">Edit Product</h1>
            <p style="margin: 6px 0 0 0; color: #475569;">Update product details without changing stock quantity.</p>
        </div>
        <a href="{{ route('products.index') }}" class="button secondary">Back to products</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">Product name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required />
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="field">
                <label for="price">Price</label>
                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" required />
            </div>

            <div class="field">
                <label>Current quantity</label>
                <input type="number" value="{{ $product->quantity }}" disabled />
            </div>

            <div class="form-actions">
                <button type="submit" class="button">Update product</button>
                <a href="{{ route('products.index') }}" class="button secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
