        function filterSystem() {
            return {
                // State
                searchQuery: '',
                isLoading: false,
                mobileFilterOpen: false,
                products: [],

                // Filter options from backend
                filterOptions: {
                    types: ['Nendoroid', 'Pop Up Parade', 'Hot Toys'],
                    scales: ['1/7', '1/8', '1/12', 'Non-scale'],
                    materials: ['PVC', 'ABS', 'Resin'],
                    manufactures: ['Good Smile Company', 'Kotobukiya', 'Hot Toys'],
                    series: ['Demon Slayer', 'Attack on Titan', 'Marvel']
                },

                // Active filters
                filters: {
                    types: [],
                    priceMin: '',
                    priceMax: '',
                    scales: [],
                    materials: [],
                    manufactures: [],
                    series: [],
                    sort: 'newest'
                },

                // Initialize
                init() {
                    this.loadProducts();
                    this.loadFilterOptions();
                },

                // Methods
                async loadProducts() {
                    this.isLoading = true;
                    try {
                        const response = await fetch('/mole/products/filter?' + this.buildQueryString());
                        const data = await response.json();
                        this.products = data.products || [];
                    } catch (error) {
                        console.error('Error loading products:', error);
                    }
                    this.isLoading = false;
                },

                async loadFilterOptions() {
                    try {
                        const response = await fetch('/api/filter-options');
                        const data = await response.json();
                        this.filterOptions = data;
                    } catch (error) {
                        console.error('Error loading filter options:', error);
                    }
                },

                buildQueryString() {
                    const params = new URLSearchParams();

                    if (this.searchQuery) params.append('search', this.searchQuery);
                    if (this.filters.priceMin) params.append('price_min', this.filters.priceMin);
                    if (this.filters.priceMax) params.append('price_max', this.filters.priceMax);
                    if (this.filters.sort) params.append('sort', this.filters.sort);

                    // Ubah dari type[] jadi type
                    this.filters.types.forEach(type => params.append('type', type));
                    this.filters.scales.forEach(scale => params.append('scale', scale));
                    this.filters.materials.forEach(material => params.append('material', material));
                    this.filters.manufactures.forEach(manufacture => params.append('manufacture', manufacture));
                    this.filters.series.forEach(series => params.append('series', series));

                    return params.toString();
                },

                applyFilters() {
                    this.loadProducts();
                    this.updateURL();
                },

                performSearch() {
                    this.applyFilters();
                },

                updateURL() {
                    const url = new URL(window.location);
                    url.search = this.buildQueryString();
                    window.history.pushState({}, '', url);
                },

                toggleMobileFilter() {
                    this.mobileFilterOpen = !this.mobileFilterOpen;
                },

                hasActiveFilters() {
                    return this.filters.types.length > 0 ||
                           this.filters.scales.length > 0 ||
                           this.filters.materials.length > 0 ||
                           this.filters.manufactures.length > 0 ||
                           this.filters.series.length > 0 ||
                           this.filters.priceMin ||
                           this.filters.priceMax ||
                           this.searchQuery;
                },

                get activeFilterTags() {
                    const tags = [];

                    if (this.searchQuery) tags.push({ key: 'search', label: `Search: ${this.searchQuery}` });
                    if (this.filters.priceMin) tags.push({ key: 'priceMin', label: `Min: ${this.filters.priceMin}` });
                    if (this.filters.priceMax) tags.push({ key: 'priceMax', label: `Max: ${this.filters.priceMax}` });

                    this.filters.types.forEach(type => tags.push({ key: `type-${type}`, label: type }));
                    this.filters.scales.forEach(scale => tags.push({ key: `scale-${scale}`, label: scale }));
                    this.filters.materials.forEach(material => tags.push({ key: `material-${material}`, label: material }));
                    this.filters.manufactures.forEach(manufacture => tags.push({ key: `manufacture-${manufacture}`, label: manufacture }));
                    this.filters.series.forEach(series => tags.push({ key: `series-${series}`, label: series }));

                    return tags;
                },

                removeFilter(key) {
                    if (key === 'search') {
                        this.searchQuery = '';
                    } else if (key === 'priceMin') {
                        this.filters.priceMin = '';
                    } else if (key === 'priceMax') {
                        this.filters.priceMax = '';
                    } else if (key.startsWith('type-')) {
                        const type = key.replace('type-', '');
                        this.filters.types = this.filters.types.filter(t => t !== type);
                    } else if (key.startsWith('scale-')) {
                        const scale = key.replace('scale-', '');
                        this.filters.scales = this.filters.scales.filter(s => s !== scale);
                    } else if (key.startsWith('material-')) {
                        const material = key.replace('material-', '');
                        this.filters.materials = this.filters.materials.filter(m => m !== material);
                    } else if (key.startsWith('manufacture-')) {
                        const manufacture = key.replace('manufacture-', '');
                        this.filters.manufactures = this.filters.manufactures.filter(m => m !== manufacture);
                    } else if (key.startsWith('series-')) {
                        const series = key.replace('series-', '');
                        this.filters.series = this.filters.series.filter(s => s !== series);
                    }

                    this.applyFilters();
                },

                clearAllFilters() {
                    this.searchQuery = '';
                    this.filters = {
                        types: [],
                        priceMin: '',
                        priceMax: '',
                        scales: [],
                        materials: [],
                        manufactures: [],
                        series: [],
                        sort: 'newest'
                    };
                    this.applyFilters();
                }
            }
        }
