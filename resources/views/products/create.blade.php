@extends('layouts.app')

@section('content')
    @php
        $products = old('products', [
            ['name' => '', 'description' => '', 'price' => '0.00', 'quantity' => 0],
        ]);
    @endphp

    <div class="toolbar" style="justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 1.75rem;">Add Products</h1>
            <p style="margin: 6px 0 0 0; color: #475569;">Create one or more products in a single submission.</p>
        </div>
        <a href="{{ route('products.index') }}" class="button secondary">Back to products</a>
    </div>

    <div class="card" style="max-width: 900px;">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <div id="product-rows">
                @foreach($products as $index => $product)
                    <div class="product-row" style="margin-bottom: 20px; padding: 16px; border: 1px solid #e2e8f0; border-radius: 16px; position: relative;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px;">
                            <strong style="font-size: 1rem;">Product #{{ $index + 1 }}</strong>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <button type="button" class="button secondary move-row-up" style="font-size: 0.9rem;">Up</button>
                                <button type="button" class="button secondary move-row-down" style="font-size: 0.9rem;">Down</button>
                                <button type="button" class="button secondary edit-row" style="font-size: 0.9rem;">Edit</button>
                                <button type="button" class="button secondary stock-row" style="font-size: 0.9rem;">Stock</button>
                                <button type="button" class="button secondary remove-row" style="font-size: 0.9rem;">Delete</button>
                            </div>
                        </div>

                        <div class="field">
                            <label for="products_{{ $index }}_name">Product name</label>
                            <input id="products_{{ $index }}_name" name="products[{{ $index }}][name]" type="text" value="{{ old('products.' . $index . '.name', $product['name']) }}" required />
                        </div>

                        <div class="field">
                            <label for="products_{{ $index }}_description">Description</label>
                            <textarea id="products_{{ $index }}_description" name="products[{{ $index }}][description]" rows="3">{{ old('products.' . $index . '.description', $product['description']) }}</textarea>
                        </div>

                        <div class="field">
                            <label for="products_{{ $index }}_price">Price</label>
                            <input id="products_{{ $index }}_price" name="products[{{ $index }}][price]" type="number" step="0.01" min="0" value="{{ old('products.' . $index . '.price', $product['price']) }}" required />
                        </div>

                        <div class="field">
                            <label for="products_{{ $index }}_quantity">Initial quantity</label>
                            <input id="products_{{ $index }}_quantity" name="products[{{ $index }}][quantity]" type="number" step="1" min="0" value="{{ old('products.' . $index . '.quantity', $product['quantity']) }}" required />
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;">
                <button type="button" id="add-product-row" class="button secondary">Add another product</button>
            </div>

            <div class="form-actions" style="display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="button">Save products</button>
                <a href="{{ route('products.index') }}" class="button secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const rows = document.getElementById('product-rows');
            const addButton = document.getElementById('add-product-row');

            function updateRowIndexes() {
                Array.from(rows.children).forEach((row, index) => {
                    row.querySelector('strong').textContent = `Product #${index + 1}`;

                    const nameInput = row.querySelector('[name*="[name]"]');
                    const descriptionInput = row.querySelector('[name*="[description]"]');
                    const priceInput = row.querySelector('[name*="[price]"]');
                    const quantityInput = row.querySelector('[name*="[quantity]"]');
                    const labels = row.querySelectorAll('label');

                    nameInput.id = `products_${index}_name`;
                    nameInput.name = `products[${index}][name]`;
                    labels[0].setAttribute('for', nameInput.id);

                    descriptionInput.id = `products_${index}_description`;
                    descriptionInput.name = `products[${index}][description]`;
                    labels[1].setAttribute('for', descriptionInput.id);

                    priceInput.id = `products_${index}_price`;
                    priceInput.name = `products[${index}][price]`;
                    labels[2].setAttribute('for', priceInput.id);

                    quantityInput.id = `products_${index}_quantity`;
                    quantityInput.name = `products[${index}][quantity]`;
                    labels[3].setAttribute('for', quantityInput.id);

                    const removeButton = row.querySelector('.remove-row');
                    removeButton.disabled = rows.children.length <= 1;
                });
            }

            function createRow(product = { name: '', description: '', price: '0.00', quantity: 0 }) {
                const wrapper = document.createElement('div');
                wrapper.className = 'product-row';
                wrapper.style = 'margin-bottom: 20px; padding: 16px; border: 1px solid #e2e8f0; border-radius: 16px; position: relative;';
                wrapper.innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px;">
                        <strong style="font-size: 1rem;">Product</strong>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <button type="button" class="button secondary move-row-up" style="font-size: 0.9rem;">Up</button>
                            <button type="button" class="button secondary move-row-down" style="font-size: 0.9rem;">Down</button>
                            <button type="button" class="button secondary edit-row" style="font-size: 0.9rem;">Edit</button>
                            <button type="button" class="button secondary stock-row" style="font-size: 0.9rem;">Stock</button>
                            <button type="button" class="button secondary remove-row" style="font-size: 0.9rem;">Delete</button>
                        </div>
                    </div>
                    <div class="field">
                        <label>Product name</label>
                        <input name="products[0][name]" type="text" value="${product.name}" required />
                    </div>
                    <div class="field">
                        <label>Description</label>
                        <textarea name="products[0][description]" rows="3">${product.description}</textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px;">
                        <div class="field">
                            <label>Price</label>
                            <input name="products[0][price]" type="number" step="0.01" min="0" value="${product.price}" required />
                        </div>
                        <div class="field">
                            <label>Initial quantity</label>
                            <input name="products[0][quantity]" type="number" step="1" min="0" value="${product.quantity}" required />
                        </div>
                    </div>
                `;
                return wrapper;
            }

            addButton.addEventListener('click', function () {
                rows.appendChild(createRow());
                updateRowIndexes();
            });

            rows.addEventListener('click', function (event) {
                const row = event.target.closest('.product-row');
                if (!row) {
                    return;
                }

                if (event.target.classList.contains('remove-row')) {
                    if (rows.children.length > 1) {
                        row.remove();
                        updateRowIndexes();
                    }
                    return;
                }

                if (event.target.classList.contains('edit-row')) {
                    const nameInput = row.querySelector('input[type="text"]');
                    if (nameInput) {
                        nameInput.focus();
                    }
                    return;
                }

                if (event.target.classList.contains('stock-row')) {
                    const quantityInput = row.querySelector('input[type="number"][name*="[quantity]"]');
                    if (quantityInput) {
                        quantityInput.focus();
                    }
                    return;
                }

                if (event.target.classList.contains('move-row-up')) {
                    const previous = row.previousElementSibling;
                    if (previous) {
                        rows.insertBefore(row, previous);
                        updateRowIndexes();
                    }
                    return;
                }

                if (event.target.classList.contains('move-row-down')) {
                    const next = row.nextElementSibling;
                    if (next) {
                        rows.insertBefore(next, row);
                        updateRowIndexes();
                    }
                    return;
                }
            });

            updateRowIndexes();
        })();
    </script>
@endsection
