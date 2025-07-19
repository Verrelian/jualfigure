document.addEventListener('DOMContentLoaded', function() {
    const fetchUrl = document.getElementById('explore-root')?.dataset.fetchUrl || '';
    const categoryCards = document.querySelectorAll('.category-card');
    const productsContainer = document.getElementById('products-container');
    const loadingIndicator = document.getElementById('loading-indicator');
    const noProductsMessage = document.getElementById('no-products');
    const productsTitle = document.getElementById('products-title');
    const productCount = document.getElementById('product-count');

    // ✅ PERBAIKAN: Deklarasikan variabel SEBELUM pengecekan
    const categoryFilter = document.getElementById('category-filter');
    const priceFilter = document.getElementById('price-filter');
    const searchInput = document.getElementById('search-input');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const priceRangeBtns = document.querySelectorAll('.price-range-btn');

    // ✅ Sekarang pengecekan dilakukan setelah deklarasi
    if (!categoryFilter || !priceFilter || !searchInput) {
        console.error('Required form elements not found');
        return;
    }

    // Category name mapping
    const categoryNames = {
        'nendoroid': 'Nendoroid',
        'popup': 'Pop Up Parade',
        'hottoys': 'Hot Toys',
        '': 'All Products'
    };

    // Category card click handler
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.dataset.category;
            updateCategory(category);
        });
    });

    // Filter button click handler
    applyFiltersBtn.addEventListener('click', function() {
        applyFilters();
    });

    // Clear filters button
    clearFiltersBtn.addEventListener('click', function() {
        clearAllFilters();
    });

    // Price range buttons
    priceRangeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const range = this.dataset.range;
            priceFilter.value = range;
            applyFilters();
        });
    });

    // Search input with debounce
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500);
    });

    // Dropdown change handlers
    categoryFilter.addEventListener('change', applyFilters);
    priceFilter.addEventListener('change', applyFilters);

    function updateCategory(category) {
        // Update active state for category cards
        categoryCards.forEach(c => c.classList.remove('ring-4', 'ring-blue-500'));
        const activeCard = document.querySelector(`[data-category="${category}"]`);
        if (activeCard) {
            activeCard.classList.add('ring-4', 'ring-blue-500');
        }

        // Update dropdown
        categoryFilter.value = category;

        // Apply filters
        applyFilters();
    }

    function applyFilters() {
        const filters = {
            category: categoryFilter.value,
            price_range: priceFilter.value,
            search: searchInput.value.trim()
        };

        // Update URL
        const url = new URL(window.location);
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                url.searchParams.set(key, filters[key]);
            } else {
                url.searchParams.delete(key);
            }
        });
        window.history.pushState({}, '', url);

        // Update title
        productsTitle.textContent = categoryNames[filters.category] || 'All Products';

        // Show loading
        showLoading();

        // Fetch products
        fetchProducts(filters);
    }

    function clearAllFilters() {
        categoryFilter.value = '';
        priceFilter.value = '';
        searchInput.value = '';
        categoryCards.forEach(c => c.classList.remove('ring-4', 'ring-blue-500'));

        // Clear URL parameters
        const url = new URL(window.location);
        url.search = '';
        window.history.pushState({}, '', url);

        applyFilters();
    }

    function showLoading() {
        productsContainer.style.display = 'none';
        noProductsMessage.classList.add('hidden');
        loadingIndicator.classList.remove('hidden');
    }

    function hideLoading() {
        loadingIndicator.classList.add('hidden');
        productsContainer.style.display = 'grid';
    }

    function fetchProducts(filters) {
        const fetchUrl = document.getElementById('explore-root')?.dataset.fetchUrl || '';
        const params = new URLSearchParams(filters);
            // 🔍 DEBUG: Cek URL yang dipanggil
        console.log('🌐 Fetch URL:', fetchUrl);
        console.log('🔗 Full URL:', `${fetchUrl}?${params}`);
        console.log('📋 Filters:', filters);

        fetch(`${fetchUrl}?${params}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ AJAX Response:', data); // Debug log
            hideLoading();

            if (data.success && data.products && data.products.length > 0) {
                renderProducts(data.products);
                productCount.textContent = data.products.length;
                noProductsMessage.classList.add('hidden');
            } else {
                productsContainer.innerHTML = '';
                productCount.textContent = '0';
                noProductsMessage.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('❌ Fetch Error:', error);
            hideLoading();
            productsContainer.innerHTML = '<div class="col-span-full text-center text-red-500 p-4">Error loading products. Please try again.</div>';
        });
    }

    function renderProducts(products) {
        console.log('🎯 Rendering products:', products); // Debug log

        // ✅ Tambahan validasi untuk safety
        if (!Array.isArray(products)) {
            console.error('❌ Products is not an array:', products);
            return;
        }

        productsContainer.innerHTML = products.map(product => {
            console.log('📦 Individual product:', product);

            // ✅ Validasi product object
            if (!product || !product.product_id) {
                console.warn('⚠️ Invalid product:', product);
                return '';
            }

            return `
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <a href="/product/${product.product_id}" class="block">
                        <div class="aspect-square w-full">
                            <img src="${product.gambar_url || '/placeholder.jpg'}" alt="${product.name || 'Product'}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="p-3">
                            <p class="text-xs text-gray-500 mb-1">${product.type || 'Figure'}</p>
                            <h3 class="font-semibold text-sm mb-2 line-clamp-2" title="${product.name || 'Unnamed Product'}">${product.name || 'Unnamed Product'}</h3>
                            <p class="text-lg font-bold text-blue-600">
                                ${product.harga || 'Rp -'}
                            </p>
                            <div class="mt-2">
                                <span class="text-xs px-2 py-1 ${product.stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} rounded-full">
                                    ${product.stok > 0 ? 'Stock: ' + product.stok : 'Out of Stock'}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        }).filter(html => html !== '').join(''); // Filter empty strings
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        const urlParams = new URLSearchParams(window.location.search);

        // Update form inputs
        categoryFilter.value = urlParams.get('category') || '';
        priceFilter.value = urlParams.get('price_range') || '';
        searchInput.value = urlParams.get('search') || '';

        // Update category cards
        const category = urlParams.get('category') || '';
        categoryCards.forEach(c => c.classList.remove('ring-4', 'ring-blue-500'));
        if (category) {
            const activeCard = document.querySelector(`[data-category="${category}"]`);
            if (activeCard) {
                activeCard.classList.add('ring-4', 'ring-blue-500');
            }
        }

        // Update title and fetch products
        productsTitle.textContent = categoryNames[category] || 'All Products';
        showLoading();

        const filters = {
            category: category,
            price_range: urlParams.get('price_range') || '',
            search: urlParams.get('search') || ''
        };

        fetchProducts(filters);
    });
});