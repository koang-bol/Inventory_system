<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar { min-height: 100vh; width: 260px; }
        .content-area { flex-grow: 1; }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    <!-- Sidebar Navigation -->
    <div class="sidebar bg-dark text-white p-3 d-flex flex-column justify-content-between">
        <div>
            <div class="d-flex align-items-center mb-4 px-2">
                <i class="bi bi-box-seam text-primary fs-3 me-2"></i>
                <span class="fs-4 fw-bold">Inventory System</span>
            </div>
            
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="{{ route('dashboard') }}" class="nav-link active text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('products.index') }}" class="nav-link text-white-50">
                        <i class="bi bi-box me-2"></i> All Products
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('stock.in.form') }}" class="nav-link text-white-50">
                        <i class="bi bi-arrow-down-left-circle text-success me-2"></i> Stock In
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('stock.out.form') }}" class="nav-link text-white-50">
                        <i class="bi bi-arrow-up-right-circle text-warning me-2"></i> Stock Out
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('stock.index') }}" class="nav-link text-white-50">
                        <i class="bi bi-journal-text me-2"></i> Stock Movement Logs
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Info & Logout -->
        <div class="border-top border-secondary pt-3">
            <div class="d-flex align-items-center mb-2 px-2">
                <i class="bi bi-person-circle fs-4 me-2 text-primary"></i>
                <div>
                    <strong class="d-block text-truncate" style="max-width: 160px;">{{ Auth::user()->name ?? 'User' }}</strong>
                    <small class="text-muted d-block text-truncate" style="max-width: 160px;">{{ Auth::user()->email ?? '' }}</small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 btn-sm text-start mt-2">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="content-area p-4">
        
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Product Inventory</h2>
                <p class="text-muted mb-0">Manage stock levels and process inventory movements</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('stock.in.form') }}" class="btn btn-outline-success">
                    <i class="bi bi-plus-circle me-1"></i> Stock In
                </a>
                <a href="{{ route('stock.out.form') }}" class="btn btn-outline-warning">
                    <i class="bi bi-dash-circle me-1"></i> Stock Out
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Product
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Products Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">SKU</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="ps-3 fw-semibold text-secondary">{{ $product->sku ?? 'N/A' }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td><span class="fw-bold">{{ $product->quantity }}</span></td>
                                    <td>
                                        @if($product->quantity <= 5)
                                            <span class="badge bg-danger">Low Stock</span>
                                        @else
                                            <span class="badge bg-success">In Stock</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No products found in the inventory.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(method_exists($products, 'links'))
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>