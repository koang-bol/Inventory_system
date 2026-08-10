<header class="topbar">
    <div class="topbar-brand">
        <a href="{{ route('products.index') }}">
            📦 {{ config('app.name', 'Inventory System') }}
        </a>
    </div>

    <nav class="topbar-nav">
        <a href="{{ route('products.index') }}" 
           class="@if(request()->routeIs('products.*')) active @endif">
            Products
        </a>
        <a href="{{ route('stock.index') }}" 
           class="@if(request()->routeIs('stock.*')) active @endif">
            Stock History
        </a>
    </nav>

    <div class="topbar-nav">
        <div class="dropdown" id="userDropdown">
            <button class="user-info" onclick="toggleDropdown()">
                👤 Koang Bol
                <span style="font-size: 0.8rem;">▼</span>
            </button>
            <div class="dropdown-menu">
                <a href="#profile">Profile</a>
                <a href="#settings">Settings</a>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
        }
    });
</script>
