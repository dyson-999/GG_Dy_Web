document.addEventListener('DOMContentLoaded', function() {
    // Get all necessary elements
    const categoryLinks = document.querySelectorAll('.category-list a');
    const brandCheckboxes = document.querySelectorAll('input[name="brand"]');
    const compatibilityCheckboxes = document.querySelectorAll('input[name="compatibility"]');
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    const clearFiltersBtn = document.querySelector('.clear-filters');
    const productCards = document.querySelectorAll('.product-card');
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    // Mobile menu toggle
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    // Update price range display
    priceRange.addEventListener('input', function() {
        priceValue.textContent = `$0 - $${this.value}`;
        filterProducts();
    });

    // Category filtering
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.dataset.category;
            
            // Remove active class from all links
            categoryLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
            
            filterProducts();
        });
    });

    // Brand and compatibility filtering
    brandCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });

    compatibilityCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });

    // Clear filters
    clearFiltersBtn.addEventListener('click', function() {
        // Reset checkboxes
        brandCheckboxes.forEach(cb => cb.checked = false);
        compatibilityCheckboxes.forEach(cb => cb.checked = false);
        
        // Reset price range
        priceRange.value = 5000;
        priceValue.textContent = '$0 - $5000';
        
        // Remove active class from category links
        categoryLinks.forEach(link => link.classList.remove('active'));
        
        // Show all products
        productCards.forEach(card => card.style.display = 'flex');
    });

    // Main filtering function
    function filterProducts() {
        const selectedBrands = Array.from(brandCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value.toLowerCase());
        
        const selectedCompatibilities = Array.from(compatibilityCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value.toLowerCase());
        
        const maxPrice = parseInt(priceRange.value);
        const activeCategory = document.querySelector('.category-list a.active')?.dataset.category;

        let visibleProducts = 0;

        productCards.forEach(card => {
            const price = parseFloat(card.querySelector('.price').textContent.replace('$', ''));
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            
            // Check if product matches all selected filters
            const matchesBrand = selectedBrands.length === 0 || 
                selectedBrands.some(brand => title.includes(brand));
            
            const matchesCompatibility = selectedCompatibilities.length === 0 || 
                selectedCompatibilities.some(comp => description.includes(comp));
            
            const matchesPrice = price <= maxPrice;
            
            const matchesCategory = !activeCategory || 
                (activeCategory === 'pc-games' && title.includes('game')) ||
                (activeCategory === 'consoles' && description.includes('console')) ||
                (activeCategory === 'accessories' && (title.includes('headset') || title.includes('keyboard'))) ||
                (activeCategory === 'gaming-chairs' && title.includes('chair'));

            // Show/hide product based on filters
            const shouldShow = matchesBrand && matchesCompatibility && matchesPrice && matchesCategory;
            card.style.display = shouldShow ? 'flex' : 'none';
            
            if (shouldShow) {
                visibleProducts++;
            }
        });

        // Show/hide no products message
        let noProductsMessage = document.querySelector('.no-products');
        if (!noProductsMessage) {
            noProductsMessage = document.createElement('div');
            noProductsMessage.className = 'no-products';
            document.querySelector('.products-container').appendChild(noProductsMessage);
        }

        if (visibleProducts === 0) {
            noProductsMessage.textContent = 'No products match your filters. Try adjusting your criteria.';
            noProductsMessage.style.display = 'block';
        } else {
            noProductsMessage.style.display = 'none';
        }
    }
}); 