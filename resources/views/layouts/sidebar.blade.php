<aside class="sidebar">
    <div class="sidebar-header">
        📊 Dashboard Menu
    </div>

    @if(true)
        <div class="user-card">
            <div class="user-card-avatar">A</div>
            <div class="user-card-name">Koang Bol</div>
            <div class="user-card-role">Administrator</div>
        </div>
    @endif

    <!-- Main Navigation -->
    <div class="sidebar-section">
        <div class="sidebar-section-title">Navigation</div>
        <a href="{{ route('products.index') }}" 
           class="sidebar-link @if(request()->routeIs('products.index')) active @endif">
            <span class="sidebar-icon">📦</span>
            <span>Products</span>
        </a>
        <a href="{{ route('products.create') }}" 
           class="sidebar-link @if(request()->routeIs('products.create')) active @endif">
            <span class="sidebar-icon">➕</span>
            <span>Add Product</span>
        </a>
    </div>

    <!-- Stock Management -->
    <div class="sidebar-section">
        <div class="sidebar-section-title">Stock</div>
        <a href="{{ route('stock.index') }}" 
           class="sidebar-link @if(request()->routeIs('stock.index')) active @endif">
            <span class="sidebar-icon">📋</span>
            <span>Stock History</span>
            <span class="sidebar-badge success">Live</span>
        </a>
    </div>

    <!-- Settings & More -->
    <div class="sidebar-section">
        <div class="sidebar-section-title">Settings</div>
        <a href="#settings" class="sidebar-link">
            <span class="sidebar-icon">⚙️</span>
            <span>Settings</span>
        </a>
        <a href="#reports" class="sidebar-link">
            <span class="sidebar-icon">📊</span>
            <span>Reports</span>
        </a>
        <a href="#help" class="sidebar-link">
            <span class="sidebar-icon">❓</span>
            <span>Help & Support</span>
        </a>
    </div>

    <!-- Footer -->
    <div class="sidebar-footer">
        <button onclick="window.location.href='#profile'">Profile</button>
        <button onclick="window.location.href='#settings'">Settings</button>
    </div>
</aside>
