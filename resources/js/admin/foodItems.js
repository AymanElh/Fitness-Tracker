document.addEventListener('DOMContentLoaded', function () {
    // Search Modal Functionality
    const openModalBtn = document.getElementById('openFoodSearchModal');
    const emptyStateAddFoodBtn = document.getElementById('emptyStateAddFoodBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const foodSearchModal = document.getElementById('foodSearchModal');
    const apiSearchInput = document.getElementById('apiSearchInput');
    const apiSearchResults = document.getElementById('apiSearchResults');

    // Open modal
    openModalBtn?.addEventListener('click', openModal);
    emptyStateAddFoodBtn?.addEventListener('click', openModal);

    // Close modal
    closeModalBtn?.addEventListener('click', closeModal);
    modalBackdrop?.addEventListener('click', closeModal);

    function openModal() {
        foodSearchModal.classList.remove('hidden');
        setTimeout(() => {
            apiSearchInput.focus();
        }, 100);
    }

    function closeModal() {
        foodSearchModal.classList.add('hidden');
    }

    // API Search Functionality
    let searchTimeout;

    apiSearchInput?.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        console.log(query);
        if (query.length < 2) {
            apiSearchResults.innerHTML = '<div class="text-center py-4 text-gray-500">Type at least 2 characters to search</div>';
            return;
        }

        // Show loading
        apiSearchResults.innerHTML = `
            <div class="flex justify-center items-center py-4">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-500">Searching...</span>
            </div>
        `;

        // Debounce search to avoid too many requests
        searchTimeout = setTimeout(() => {
            fetchFoodResults(query);
        }, 500);
    });

    // This function would make an API call to your Laravel backend
    function fetchFoodResults(query) {
        fetch(`/api/food/search?query=${encodeURIComponent(query)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
            .then(response => response.json())
            .then(data => {
                renderSearchResults(data);
            })
            .catch(error => {
                console.error('Error searching food:', error);
                apiSearchResults.innerHTML = `
                    <div class="text-center py-4 text-red-500">
                        Error searching for food items. Please try again.
                    </div>
                `;
            });
    }

    // Render search results in the modal
    function renderSearchResults(data) {
        if (!data || !data.hints || data.hints.length === 0) {
            apiSearchResults.innerHTML = `
                <div class="text-center py-4 text-gray-500">
                    No food items found. Try a different search term.
                </div>
            `;
            return;
        }

        const resultsHtml = data.hints.map(item => {
            const food = item.food;
            const measures = item.measures || [];

            return `
                <div class="food-item p-3 border-b border-gray-200 hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                                                                                        ${food.image ?
                `<img class="h-12 w-12 rounded-full object-cover" src="${food.image}" alt="${food.label}">` :
                `<div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                                                                                </svg>
                                                                                            </div>`
            }
                                                                                    </div>
                                                                                    <div class="ml-4 flex-1">
                                                                                        <div class="text-sm font-medium text-gray-900">${food.label}</div>
                                                                                        <div class="text-xs text-gray-500">
                                                                                            ${food.nutrients ?
                `${Math.round(food.nutrients.ENERC_KCAL || 0)} kcal | ${(food.nutrients.PROCNT || 0).toFixed(1)}g protein | ${(food.nutrients.FAT || 0).toFixed(1)}g fat` :
                'Nutrition data not available'
            }
                                                                                        </div>
                                                                                    </div>
                                                                                    <button
                                                                                        class="add-food-btn ml-4 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                                                        data-food-id="${food.foodId}"
                                                                                        data-food-label="${food.label}"
                                                                                        data-food-image="${food.image || ''}"
                                                                                        data-food-calories="${food.nutrients ? food.nutrients.ENERC_KCAL || 0 : 0}"
                                                                                        data-food-protein="${food.nutrients ? food.nutrients.PROCNT || 0 : 0}"
                                                                                        data-food-carbs="${food.nutrients ? food.nutrients.CHOCDF || 0 : 0}"
                                                                                        data-food-fat="${food.nutrients ? food.nutrients.FAT || 0 : 0}"
                                                                                        data-food-fiber="${food.nutrients ? food.nutrients.FIBTG || 0 : 0}"
                                                                                    >
                                                                                        Add
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        `;
        }).join('');

        apiSearchResults.innerHTML = resultsHtml;

        // Add event listeners to the Add buttons
        document.querySelectorAll('.add-food-btn').forEach(button => {
            button.addEventListener('click', function () {
                const foodData = {
                    name: this.dataset.foodLabel,
                    api_food_id: this.dataset.foodId,
                    image: this.dataset.foodImage,
                    calories: parseFloat(this.dataset.foodCalories),
                    protein: parseFloat(this.dataset.foodProtein),
                    carbohydrates: parseFloat(this.dataset.foodCarbs),
                    fat: parseFloat(this.dataset.foodFat),
                    fiber: parseFloat(this.dataset.foodFiber)
                };

                // Save to database
                saveFoodItem(foodData);
            });
        });
    }

    function saveFoodItem(foodData) {
        // Show saving indicator in the button
        const button = event.target;
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Saving...';

        fetch('/api/food-items', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(foodData)
        })
            .then(response => response.json())
            .then(data => {
                // Show success message
                button.textContent = 'Added!';
                button.classList.remove('bg-indigo-100', 'text-indigo-700');
                button.classList.add('bg-green-100', 'text-green-700');

                // Close modal and refresh page after a brief delay
                setTimeout(() => {
                    closeModal();
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                console.error('Error saving food item:', error);
                button.textContent = 'Error';
                button.classList.remove('bg-indigo-100', 'text-indigo-700');
                button.classList.add('bg-red-100', 'text-red-700');

                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-red-100', 'text-red-700');
                    button.classList.add('bg-indigo-100', 'text-indigo-700');
                    button.disabled = false;
                }, 2000);
            });
    }

    // Setup edit and delete buttons
    document.querySelectorAll('.edit-food-btn').forEach(button => {
        button.addEventListener('click', function () {
            const foodId = this.dataset.foodId;
            // Redirect to edit page or open edit modal
            window.location.href = `/admin/food-items/${foodId}/edit`;
        });
    });

    document.querySelectorAll('.delete-food-btn').forEach(button => {
        button.addEventListener('click', function () {
            const foodId = this.dataset.foodId;
            if (confirm('Are you sure you want to delete this food item?')) {
                // Make delete request
                fetch(`/api/food-items/${foodId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        // Refresh page
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error deleting food item:', error);
                        alert('Error deleting food item. Please try again.');
                    });
            }
        });
    });

    // Filter functionality
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');

    searchInput?.addEventListener('input', debounce(function () {
        applyFilters();
    }, 500));

    categorySelect?.addEventListener('change', function () {
        applyFilters();
    });

    function applyFilters() {
        const searchTerm = searchInput?.value.trim().toLowerCase();
        const category = categorySelect?.value;

        // Build query string for filters
        const params = new URLSearchParams(window.location.search);

        if (searchTerm) {
            params.set('search', searchTerm);
        } else {
            params.delete('search');
        }

        if (category) {
            params.set('category', category);
        } else {
            params.delete('category');
        }

        // Redirect with filters
        window.location.href = window.location.pathname + '?' + params.toString();
    }

    // Utility function for debouncing
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
});
