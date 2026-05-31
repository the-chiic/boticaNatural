// Botica Natural - Catalog JS

// Debounce function to limit rate of function calls
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Function to handle filter form submission via AJAX
window.submitFilterForm = function(e) {
    if (e) {
        e.preventDefault();
    }
    const form = document.getElementById('filterForm');
    const url = new URL(form.action);
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);

    // Include sort parameter from the select outside the form
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        params.set('sort', sortSelect.value);
    }

    url.search = params.toString();

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('catalog-results').innerHTML = html;
        window.history.pushState({}, '', url);
    });
};

// Debounced version for real-time filtering
window.debouncedSubmitFilterForm = debounce(window.submitFilterForm, 300);

// Function to reset all catalog filters via AJAX
window.resetCatalogFilters = function(e) {
    if (e) {
        e.preventDefault();
    }
    const form = document.getElementById('filterForm');
    if (!form) return;

    // 1. Limpiar input de búsqueda
    const searchInput = form.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.value = '';
    }

    // 2. Desmarcar categorías
    const checkboxes = form.querySelectorAll('input[name="categories[]"]');
    checkboxes.forEach(cb => cb.checked = false);

    // 3. Restablecer precios
    const minInput = document.getElementById('price_min_input');
    const maxInput = document.getElementById('price_max_input');
    const minRange = document.getElementById('price_min_range');
    const maxRange = document.getElementById('price_max_range');
    
    if (minInput && maxInput && minRange && maxRange) {
        minInput.value = 0;
        maxInput.value = 200;
        minRange.value = 0;
        maxRange.value = 200;
        
        // Disparar eventos para actualizar visualmente el slider
        minRange.dispatchEvent(new Event('input'));
        maxRange.dispatchEvent(new Event('input'));
    }

    // 5. Enviar formulario por AJAX
    window.submitFilterForm();
};

function initPriceFilter() {
    const filter = document.querySelector('.price-filter');
    if (!filter) {
        return;
    }

    const minLimit = Number(filter.dataset.min || 0);
    const maxLimit = Number(filter.dataset.max || 200);
    const minInput = document.getElementById('price_min_input');
    const maxInput = document.getElementById('price_max_input');
    const minRange = document.getElementById('price_min_range');
    const maxRange = document.getElementById('price_max_range');
    const rangeFill = document.getElementById('price_slider_range');

    if (!minInput || !maxInput || !minRange || !maxRange || !rangeFill) {
        return;
    }

    const clamp = (value, min, max) => Math.min(Math.max(Number(value) || 0, min), max);

    const paintRange = () => {
        const minValue = clamp(minRange.value, minLimit, maxLimit);
        const maxValue = clamp(maxRange.value, minLimit, maxLimit);
        const minPercent = ((minValue - minLimit) / (maxLimit - minLimit)) * 100;
        const maxPercent = ((maxValue - minLimit) / (maxLimit - minLimit)) * 100;

        rangeFill.style.left = `${minPercent}%`;
        rangeFill.style.right = `${100 - maxPercent}%`;
    };

    const syncFromRanges = () => {
        let minValue = clamp(minRange.value, minLimit, maxLimit);
        let maxValue = clamp(maxRange.value, minLimit, maxLimit);

        if (minValue > maxValue) {
            [minValue, maxValue] = [maxValue, minValue];
        }

        minRange.value = minValue;
        maxRange.value = maxValue;
        minInput.value = minValue;
        maxInput.value = maxValue;
        paintRange();
    };

    const syncFromInputs = () => {
        let minValue = clamp(minInput.value, minLimit, maxLimit);
        let maxValue = clamp(maxInput.value, minLimit, maxLimit);

        if (minValue > maxValue) {
            maxValue = minValue;
        }

        minInput.value = minValue;
        maxInput.value = maxValue;
        minRange.value = minValue;
        maxRange.value = maxValue;
        paintRange();
    };

    minRange.addEventListener('input', syncFromRanges);
    maxRange.addEventListener('input', syncFromRanges);
    minRange.addEventListener('change', window.submitFilterForm);
    maxRange.addEventListener('change', window.submitFilterForm);

    minInput.addEventListener('input', syncFromInputs);
    maxInput.addEventListener('input', syncFromInputs);
    minInput.addEventListener('keyup', debounce(window.submitFilterForm, 300));
    maxInput.addEventListener('keyup', debounce(window.submitFilterForm, 300));

    syncFromInputs();
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('Catalog Loaded');
    initPriceFilter();

    // Handle pagination links via AJAX
    document.addEventListener('click', function(e) {
        const paginationLink = e.target.closest('.pagination-container a');
        if (paginationLink) {
            e.preventDefault();
            fetch(paginationLink.href, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('catalog-results').innerHTML = html;
                window.history.pushState({}, '', paginationLink.href);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        window.location.reload();
    });
});
