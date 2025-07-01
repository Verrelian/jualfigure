<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Figure Filter System</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; }

        /* Navbar Search */
        .navbar { background: white; padding: 1rem 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100; }
        .navbar-content { display: flex; align-items: center; max-width: 1200px; margin: 0 auto; gap: 2rem; }
        .logo { font-size: 1.5rem; font-weight: bold; color: #2563eb; }
        .search-container { flex: 1; position: relative; max-width: 500px; }
        .search-input { width: 100%; padding: 0.75rem 1rem 0.75rem 3rem; border: 2px solid #e5e7eb; border-radius: 50px; font-size: 1rem; }
        .search-input:focus { outline: none; border-color: #2563eb; }
        .search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #6b7280; }

        /* Filter Container */
        .filter-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .filter-header { display: flex; justify-content: between; align-items: center; margin-bottom: 1.5rem; }
        .filter-toggle { background: #2563eb; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; display: none; }

        /* Filter Layout */
        .filter-layout { display: grid; grid-template-columns: 300px 1fr; gap: 2rem; }
        .filter-sidebar { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); height: fit-content; position: sticky; top: 100px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }

        /* Filter Sections */
        .filter-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; }
        .filter-section:last-child { border-bottom: none; margin-bottom: 0; }
        .filter-title { font-weight: 600; color: #374151; margin-bottom: 1rem; font-size: 1.1rem; }

        /* Filter Controls */
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-checkbox { display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0; }
        .filter-checkbox input { width: 1rem; height: 1rem; accent-color: #2563eb; }
        .filter-checkbox label { font-size: 0.9rem; color: #4b5563; cursor: pointer; }

        .price-range { display: flex; gap: 1rem; align-items: center; }
        .price-input { width: 100px; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; }

        .sort-select { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; }

        /* Active Filters */
        .active-filters { display: flex; flex-wrap: gap; margin-bottom: 1rem; }
        .filter-tag { background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem; }
        .filter-tag button { background: none; border: none; color: #1e40af; cursor: pointer; font-weight: bold; }
        .clear-all { background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; }

        /* Product Cards */
        .product-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .product-image { width: 100%; height: 200px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; }
        .product-info { padding: 1rem; }
        .product-name { font-weight: 600; color: #111827; margin-bottom: 0.5rem; }
        .product-type { color: #6b7280; font-size: 0.8rem; margin-bottom: 0.5rem; }
        .product-price { color: #dc2626; font-weight: bold; font-size: 1.1rem; }
        .product-specs { margin-top: 0.75rem; font-size: 0.8rem; color: #6b7280; }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-content { padding: 0 1rem; }
            .filter-toggle { display: block; }
            .filter-layout { grid-template-columns: 1fr; }
            .filter-sidebar { position: fixed; top: 0; left: -100%; width: 300px; height: 100vh; z-index: 200; transition: left 0.3s; overflow-y: auto; border-radius: 0; }
            .filter-sidebar.open { left: 0; }
            .filter-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 150; display: none; }
            .filter-overlay.open { display: block; }
            .products-grid { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
        }

        /* Loading States */
        .loading { opacity: 0.6; pointer-events: none; }
        .skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; }
        @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    </style>
</head>
<body>
    <!-- Navbar with Search -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">ActionFig</div>
            <div class="search-container">
                <svg class="search-icon" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
                <input type="text" class="search-input" placeholder="Search action figures..." x-model="searchQuery" @input.debounce.300ms="performSearch">
            </div>
        </div>
    </nav>

    <!-- Main Filter System -->
    <div class="filter-container" x-data="filterSystem()">
        <!-- Filter Header -->
        <div class="filter-header">
            <h1>Browse Products</h1>
            <button class="filter-toggle" @click="toggleMobileFilter">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                </svg>
                Filters
            </button>
        </div>

        <!-- Filter Layout -->
        <div class="filter-layout">
            <!-- Filter Sidebar -->
            <div class="filter-sidebar" :class="{ 'open': mobileFilterOpen }">
                <!-- Active Filters -->
                <div class="active-filters" x-show="hasActiveFilters()">
                    <template x-for="filter in activeFilterTags" :key="filter.key">
                        <div class="filter-tag">
                            <span x-text="filter.label"></span>
                            <button @click="removeFilter(filter.key)">×</button>
                        </div>
                    </template>
                    <button class="clear-all" @click="clearAllFilters" x-show="hasActiveFilters()">Clear All</button>
                </div>

                <!-- Type Filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Type</h3>
                    <div class="filter-group">
                        <template x-for="type in filterOptions.types" :key="type">
                            <div class="filter-checkbox">
                                <input type="checkbox" :value="type" x-model="filters.types" @change="applyFilters">
                                <label x-text="type"></label>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="filter-section">
                    <h3 class="filter-title">Price Range</h3>
                    <div class="price-range">
                        <input type="number" class="price-input" placeholder="Min" x-model="filters.priceMin" @input.debounce.500ms="applyFilters">
                        <span>-</span>
                        <input type="number" class="price-input" placeholder="Max" x-model="filters.priceMax" @input.debounce.500ms="applyFilters">
                    </div>
                </div>

                <!-- Scale Filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Scale</h3>
                    <div class="filter-group">
                        <template x-for="scale in filterOptions.scales" :key="scale">
                            <div class="filter-checkbox">
                                <input type="checkbox" :value="scale" x-model="filters.scales" @change="applyFilters">
                                <label x-text="scale"></label>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Material Filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Material</h3>
                    <div class="filter-group">
                        <template x-for="material in filterOptions.materials" :key="material">
                            <div class="filter-checkbox">
                                <input type="checkbox" :value="material" x-model="filters.materials" @change="applyFilters">
                                <label x-text="material"></label>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Manufacturer Filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Manufacturer</h3>
                    <div class="filter-group">
                        <template x-for="manufacturer in filterOptions.manufactures" :key="manufacturer">
                            <div class="filter-checkbox">
                                <input type="checkbox" :value="manufacturer" x-model="filters.manufactures" @change="applyFilters">
                                <label x-text="manufacturer"></label>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Series Filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Series</h3>
                    <div class="filter-group">
                        <template x-for="series in filterOptions.series" :key="series">
                            <div class="filter-checkbox">
                                <input type="checkbox" :value="series" x-model="filters.series" @change="applyFilters">
                                <label x-text="series"></label>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="filter-section">
                    <h3 class="filter-title">Sort By</h3>
                    <select class="sort-select" x-model="filters.sort" @change="applyFilters">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                        <option value="rating">Highest Rated</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" :class="{ 'loading': isLoading }">
                <template x-for="product in products" :key="product.product_id">
                    <div class="product-card">
                        <div class="product-image" x-text="product.name"></div>
                        <div class="product-info">
                            <h3 class="product-name" x-text="product.name"></h3>
                            <p class="product-type" x-text="product.type"></p>
                            <p class="product-price" x-text="product.harga"></p>
                            <div class="product-specs" x-show="product.specifications">
                                <div x-show="product.specifications?.scale">Scale: <span x-text="product.specifications?.scale"></span></div>
                                <div x-show="product.specifications?.material">Material: <span x-text="product.specifications?.material"></span></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Mobile Filter Overlay -->
        <div class="filter-overlay" :class="{ 'open': mobileFilterOpen }" @click="toggleMobileFilter"></div>
    </div>
<script src="{{ asset('js/filter.js') }}"></script>
</body>
</html>