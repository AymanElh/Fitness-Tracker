let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let targetFoodContainer = null;
let selectedFood = null;
let currentlyEditingMeal = null;

document.addEventListener('DOMContentLoaded', function () {
    startSearchFoods();

    // Initialize chart on meal view page
    initMealChart();

    // Initialize delete form handler
    const deleteMealForm = document.getElementById('deleteMealForm');
    if (deleteMealForm) {
        deleteMealForm.addEventListener('submit', handleDeleteMeal);
    }
});

/**
 * Initialize macronutrient chart on the meal view page
 */
function initMealChart() {
    const chartCanvas = document.getElementById('macronutrientChart');
    if (!chartCanvas) return; // Not on the meal view page

    // Get nutrient data from the data attributes
    const protein = parseFloat(chartCanvas.getAttribute('data-protein') || 0);
    const carbs = parseFloat(chartCanvas.getAttribute('data-carbs') || 0);
    const fat = parseFloat(chartCanvas.getAttribute('data-fat') || 0);

    // Convert to calories
    const proteinCal = protein * 4;  // 4 calories per gram of protein
    const carbsCal = carbs * 4;      // 4 calories per gram of carbs
    const fatCal = fat * 9;          // 9 calories per gram of fat

    // Create chart
    new Chart(chartCanvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Protein', 'Carbs', 'Fat'],
            datasets: [{
                data: [proteinCal, carbsCal, fatCal],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',  // Blue for protein
                    'rgba(16, 185, 129, 0.8)',  // Green for carbs
                    'rgba(245, 158, 11, 0.8)'   // Yellow for fat
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} cal (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 15,
                        font: {
                            size: 12
                        }
                    }
                },
            }
        }
    });
}

// open and close create meal modal
function openCreateMealModal() {
    const modal = document.getElementById("createMealModal");
    if (!modal) return;

    document.getElementById("createMealForm").reset();
    document.getElementById('food-items-container').innerHTML = '';
    document.getElementById('no-food-items').style.display = 'block';

    modal.classList.remove("hidden");
}

function closeCreateMealModal() {
    document.getElementById("createMealModal").classList.add("hidden");
}

// open and close edit meal modal
function openEditMealModal(mealId) {
    try {
        currentlyEditingMeal = mealId;

        // Show loading in the modal
        const modal = document.getElementById('editMealModal');
        const form = document.getElementById('editMealForm');
        if (!modal || !form) return;

        // Reset and prepare form
        form.reset();
        document.getElementById('edit-food-items-container').innerHTML = '';
        document.getElementById('edit-no-food-items').style.display = 'block';

        // Set the form action
        form.action = `/admin/meals/${mealId}`;
        document.getElementById('edit_meal_id').value = mealId;

        // Show modal with loading state
        modal.classList.remove('hidden');

        // Fetch meal data
        fetch(`/admin/meals/${mealId}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch meal data');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to fetch meal data');
                }

                const meal = data.meal;

                // Populate form fields
                document.getElementById('edit_name').value = meal.name;
                document.getElementById('edit_description').value = meal.description || '';
                document.getElementById('edit_type').value = meal.type;
                document.getElementById('edit_image_url').value = meal.image_url || '';
                console.log(meal);
                // Add food items to form
                if (meal.items && meal.items.length > 0) {
                    document.getElementById('edit-no-food-items').style.display = 'none';

                    meal.items.forEach(item => {
                        addFoodItemToUI({
                            food: item.food,
                            quantity: item.quantity,
                            quantity_unit: item.quantity_unit
                        }, 'edit-food-items-container', true, item.id);
                    });
                }
            })
            .catch(error => {
                console.error('Error opening edit modal:', error);
                showNotification('Failed to load meal data', 'error');
                closeEditMealModal();
            });
    } catch (error) {
        console.error('Error opening edit modal:', error);
        showNotification('Failed to load meal data', 'error');
        closeEditMealModal();
    }
}

function closeEditMealModal() {
    document.getElementById("editMealModal").classList.add("hidden");
    currentlyEditingMeal = null;
}

// open and close food search modal
function addFoodItem() {
    targetFoodContainer = 'create';
    openFoodSearchModal();
}

function addFoodItemToEdit() {
    targetFoodContainer = 'edit';
    openFoodSearchModal();
}

function openFoodSearchModal() {
    // Reset the modal state
    document.getElementById('food-search-input').value = '';
    document.getElementById('food-search-results').innerHTML = `
        <div class="text-center text-gray-500 py-4">
            Type to search for foods
        </div>
    `;
    document.getElementById('food-quantity-section').classList.add('hidden');
    document.getElementById('add-selected-food-btn').classList.add('hidden');
    selectedFood = null;

    document.getElementById("foodSearchModal").classList.remove("hidden");
}

function closeFoodSearchModal() {
    document.getElementById("foodSearchModal").classList.add("hidden");
}

// Search food Item
function startSearchFoods() {
    const searchInput = document.getElementById("food-search-input");
    if (!searchInput) return;

    // Add debounced search
    let searchTimeout;

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);

        const key = this.value.trim();
        console.log(key);
        if (key.length < 2) {
            document.getElementById("food-search-results").innerHTML = `
                <div class="text-center text-gray-500 py-4">
                    Type at least 2 characters to search
                </div>
            `;
            return;
        }

        searchTimeout = setTimeout(() => {
            searchFoods(key);
        }, 300);
    });
}

function searchFoods(key) {
    try {
        const resultContainer = document.getElementById("food-search-results");

        resultContainer.innerHTML = `
            <div class="text-center text-gray-500 py-4">
                <svg class="animate-spin h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2">Searching...</p>
            </div>
        `;

        fetch(`/admin/meals/search-foods?search=${encodeURIComponent(key)}`, {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    return Promise.reject("Failed to find item");
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error("Failed to search foods" || data.message);
                }

                if (data.foods.length === 0) {
                    resultContainer.innerHTML = `
                        <div class="text-center text-gray-500 py-4">
                            No foods found matching "${key}"
                        </div>
                    `;
                    return;
                }

                let html = `<div class="grid grid-cols-1 gap-2">`;
                data.foods.forEach(food => {
                    html += `
                        <div class="border rounded-lg p-3 hover:bg-gray-50 cursor-pointer flex items-center" onclick="selectFood(${JSON.stringify(food).replace(/"/g, '&quot;')})">
                        ${food.image_url ?
                        `<img src="${food.image_url}" alt="${food.name}" class="h-10 w-10 rounded-full object-cover">` :
                        `<div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>`
                    }
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between">
                            <h3 class="text-sm font-medium text-gray-900">${food.name}</h3>
                            <span class="text-sm text-gray-600">${food.nutrients.calories || 0} cal</span>
                        </div>
                        <div class="text-xs text-gray-500">
                            <span>P: ${food.nutrients.protein_g || 0}g</span>
                            <span class="mx-2">C: ${food.nutrients.carbs_g || 0}g</span>
                            <span>F: ${food.nutrients.fat_g || 0}g</span>
                        </div>
                    </div>
                    </div>
                    `;
                });

                html += '</div>';
                resultContainer.innerHTML = html;
            })
            .catch(error => {
                console.error("Error search foods: ", error);
                resultContainer.innerHTML = `
                    <div class="text-center text-red-500 py-4">
                        Error searching foods. Please try again.
                    </div>
                `;
            });

    } catch (error) {
        console.error("Error search foods: ", error.message);
    }
}

function selectFood(food) {
    selectedFood = food;
    // console.log(food);
    // Show quantity section
    document.getElementById('food-quantity-section').classList.remove('hidden');
    document.getElementById('add-selected-food-btn').classList.remove('hidden');

    // Display selected food details
    const detailsContainer = document.getElementById('selected-food-details');
    detailsContainer.innerHTML = `
        <div class="flex items-center w-full">
            ${food.image_url ?
        `<img src="${food.image_url}" alt="${food.name}" class="h-10 w-10 rounded-full object-cover">` :
        `<div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>`
    }
            <div class="ml-3 flex-1">
                <div class="flex justify-between">
                    <h3 class="text-sm font-medium text-gray-900">${food.name}</h3>
                    <span class="text-sm text-gray-600">${food.nutrients.calories || 0} cal</span>
                </div>
                <div class="text-xs text-gray-500">
                    <span>P: ${food.nutrients.protein_g || 0}g</span>
                    <span class="mx-2">C: ${food.nutrients.carbs_g || 0}g</span>
                    <span>F: ${food.nutrients.fat_g || 0}g</span>
                </div>
            </div>
        </div>
    `;
}

/**
 * Add the selected food to the meal
 */
function addSelectedFood() {
    if (!selectedFood) return;

    const quantity = parseFloat(document.getElementById('food-quantity').value) || 1;
    const unit = document.getElementById('food-quantity-unit').value || 'serving';

    // Create food item element
    const foodItem = {
        food: selectedFood,
        quantity: quantity,
        quantity_unit: unit
    };

    if (targetFoodContainer === 'create') {
        addFoodItemToUI(foodItem, 'food-items-container');
    } else if (targetFoodContainer === 'edit') {
        addFoodItemToUI(foodItem, 'edit-food-items-container', true);
    }

    // Close modal
    closeFoodSearchModal();
}

function addFoodItemToUI(item, containerId, isEdit = false, itemId = null) {
    const container = document.getElementById(containerId);

    // Hide "no items" message
    document.getElementById(isEdit ? 'edit-no-food-items' : 'no-food-items').style.display = 'none';

    // Create a unique ID for this item
    const itemUniqueId = 'food-item-' + Date.now();

    // Create item HTML
    const itemHTML = `
        <div class="food-item border rounded-lg p-3" id="${itemUniqueId}">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    ${item.food.image_url ?
        `<img src="${item.food.image_url}" alt="${item.food.name}" class="h-10 w-10 rounded-full object-cover">` :
        `<div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>`
    }
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">${item.food.name}</h3>
                        <div class="text-xs text-gray-500">
                            <span>${item.quantity} ${item.quantity_unit}</span>
                            <span class="mx-2">${item.food.nutrients.calories || 0} cal</span>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="removeFoodItem('${itemUniqueId}')" class="text-red-500 hover:text-red-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            ${itemId ? `<input type="hidden" name="food_items[${container.children.length}][id]" value="${itemId}">` : ''}
            <input type="hidden" name="food_items[${container.children.length}][food_id]" value="${item.food.id}">
            <input type="hidden" name="food_items[${container.children.length}][quantity]" value="${item.quantity}">
            <input type="hidden" name="food_items[${container.children.length}][quantity_unit]" value="${item.quantity_unit}">
        </div>
    `;

    // Add to container
    container.insertAdjacentHTML('beforeend', itemHTML);
}

/**
 * Remove a food item from the UI
 */
function removeFoodItem(itemId) {
    const item = document.getElementById(itemId);
    if (!item) return;

    // Remove the item
    item.remove();

    // Check if there are any items left
    const createContainer = document.getElementById('food-items-container');
    const editContainer = document.getElementById('edit-food-items-container');

    if (createContainer && createContainer.children.length === 0) {
        document.getElementById('no-food-items').style.display = 'block';
    }

    if (editContainer && editContainer.children.length === 0) {
        document.getElementById('edit-no-food-items').style.display = 'block';
    }

    // Reindex remaining items
    reindexFoodItems();
}

/**
 * Reindex food items in forms to ensure sequential indexes
 */
function reindexFoodItems() {
    // Reindex create form
    const createContainer = document.getElementById('food-items-container');
    if (createContainer) {
        Array.from(createContainer.children).forEach((item, index) => {
            const inputs = item.querySelectorAll('input[name^="food_items"]');
            inputs.forEach(input => {
                const name = input.name;
                const newName = name.replace(/food_items\[\d+\]/, `food_items[${index}]`);
                input.name = newName;
            });
        });
    }

    // Reindex edit form
    const editContainer = document.getElementById('edit-food-items-container');
    if (editContainer) {
        Array.from(editContainer.children).forEach((item, index) => {
            const inputs = item.querySelectorAll('input[name^="food_items"]');
            inputs.forEach(input => {
                const name = input.name;
                const newName = name.replace(/food_items\[\d+\]/, `food_items[${index}]`);
                input.name = newName;
            });
        });
    }
}

/**
 * Submit the create meal form
 */
function submitCreateMealForm() {
    try {
        const form = document.getElementById('createMealForm');
        const formData = new FormData(form);

        // Validate that there's at least one food item
        const container = document.getElementById('food-items-container');
        if (container.children.length === 0) {
            showNotification('Please add at least one food item to the meal', 'error');
            return;
        }

        // Disable submit button
        const submitButton = document.querySelector('#createMealModal button[type="button"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Creating...';
        }

        // Clear previous error messages
        clearFormErrors(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                if (!result.success) {
                    if (result.errors) {
                        displayValidationErrors(result.errors);
                    } else {
                        showNotification(result.message || 'An error occurred while creating the meal', 'error');
                    }
                    return;
                }

                // Success
                showNotification(result.message || 'Meal created successfully');

                // Add the new meal to the table or reload the page
                if (result.meal) {
                    addMealRow(result.meal);
                } else {
                    window.location.reload();
                }

                // Close modal
                closeCreateMealModal();
            })
            .catch(error => {
                console.error('Error creating meal:', error);
                showNotification('An error occurred while creating the meal', 'error');
            })
            .finally(() => {
                // Re-enable submit button
                const submitButton = document.querySelector('#createMealModal button[type="button"]');
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Create Meal';
                }
            });
    } catch (error) {
        console.error('Error creating meal:', error);
        showNotification('An error occurred while creating the meal', 'error');
    }
}

/**
 * Submit the edit meal form
 */
function submitEditMealForm() {
    try {
        const form = document.getElementById('editMealForm');
        const formData = new FormData(form);

        // Validate that there's at least one food item
        const container = document.getElementById('edit-food-items-container');
        if (container.children.length === 0) {
            showNotification('Please add at least one food item to the meal', 'error');
            return;
        }

        // Disable submit button
        const submitButton = document.querySelector('#editMealModal button[type="button"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Updating...';
        }

        // Clear previous error messages
        clearFormErrors(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                if (!result.success) {
                    if (result.errors) {
                        displayValidationErrors(result.errors);
                    } else {
                        showNotification(result.message || 'An error occurred while updating the meal', 'error');
                    }
                    return;
                }

                // Success
                showNotification(result.message || 'Meal updated successfully');

                // Update the meal row or reload the page
                if (result.meal) {
                    updateMealRow(result.meal);
                } else {
                    window.location.reload();
                }

                // Close modal
                closeEditMealModal();
            })
            .catch(error => {
                console.error('Error updating meal:', error);
                showNotification('An error occurred while updating the meal', 'error');
            })
            .finally(() => {
                // Re-enable submit button
                const submitButton = document.querySelector('#editMealModal button[type="button"]');
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Update Meal';
                }
            });
    } catch (error) {
        console.error('Error updating meal:', error);
        showNotification('An error occurred while updating the meal', 'error');
    }
}

/**
 * Confirm meal deletion
 */
function confirmDeleteMeal(id, name) {
    const modal = document.getElementById('deleteMealModal');
    if (!modal) return;

    document.getElementById('delete-meal-text').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;

    // Set form action
    const form = document.getElementById('deleteMealForm');
    if (form) {
        form.action = `/admin/meals/${id}`;
    }

    // Show modal
    modal.classList.remove('hidden');
}

/**
 * Close the delete meal modal
 */
function closeDeleteMealModal() {
    const modal = document.getElementById('deleteMealModal');
    if (!modal) return;

    modal.classList.add('hidden');
}

/**
 * Handle meal deletion
 */
async function handleDeleteMeal(e) {
    e.preventDefault();

    try {
        const form = e.target;

        const response = await fetch(form.action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (!result.success) {
            showNotification(result.message || 'Failed to delete meal', 'error');
            return;
        }

        // Success - redirect if on view page, remove row if on index page
        const mealId = form.action.split('/').pop();
        const mealRow = document.querySelector(`.meal-row[data-id="${mealId}"]`);

        if (mealRow) {
            // On index page - remove row
            mealRow.remove();

            // Update stats
            // refreshStats();

            showNotification(result.message || 'Meal deleted successfully');
            closeDeleteMealModal();
        } else {
            // On view page - redirect to index
            showNotification(result.message || 'Meal deleted successfully');
            window.location.href = '/admin/meals';
        }

    } catch (error) {
        console.error('Error deleting meal:', error);
        showNotification('An error occurred while deleting the meal', 'error');
    }
}

/**
 * Add a new meal row to the table
 */
function addMealRow(meal) {
    const tableBody = document.querySelector('table tbody');
    if (!tableBody) return;

    // Remove "no meals" row if it exists
    const noMealRow = tableBody.querySelector('tr:only-child td[colspan]');
    if (noMealRow) {
        noMealRow.parentElement.remove();
    }

    // Prepare type styling
    const typeColors = {
        'breakfast': 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'lunch': 'bg-green-100 text-green-800 border-green-200',
        'dinner': 'bg-purple-100 text-purple-800 border-purple-200',
        'snack': 'bg-blue-100 text-blue-800 border-blue-200'
    };
    const typeColor = typeColors[meal.type] || 'bg-gray-100 text-gray-800 border-gray-200';

    // Create new row
    const newRow = document.createElement('tr');
    newRow.className = 'meal-row';
    newRow.setAttribute('data-id', meal.id);

    newRow.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                ${meal.image_url ?
        `<div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full object-cover" src="${meal.image_url}" alt="${meal.name}">
                    </div>` :
        `<div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>`
    }
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">${meal.name}</div>
                    <div class="text-xs text-gray-500 truncate max-w-xs">
                        ${meal.description ? meal.description.substring(0, 60) + (meal.description.length > 60 ? '...' : '') : ''}
                    </div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border ${typeColor}">
                ${meal.type.charAt(0).toUpperCase() + meal.type.slice(1)}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${meal.items ? meal.items.length : 0}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${calculateTotalCalories(meal)}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${meal.creator ? meal.creator.name : 'System'}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="/admin/meals/${meal.id}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                View
            </a>
            <button type="button" onclick="openEditMealModal(${meal.id})" class="text-yellow-600 hover:text-yellow-900 mr-3">
                Edit
            </button>
            <button type="button" onclick="confirmDeleteMeal(${meal.id}, '${meal.name}')" class="text-red-600 hover:text-red-900">
                Delete
            </button>
        </td>
    `;

    // Add to table
    tableBody.prepend(newRow);

    // Update stats
    // refreshStats();
}

/**
 * Update an existing meal row in the table
 */
function updateMealRow(meal) {
    const row = document.querySelector(`.meal-row[data-id="${meal.id}"]`);
    if (!row) {
        // If on the view page, reload the page
        if (window.location.pathname.includes(`/admin/meals/${meal.id}`)) {
            window.location.reload();
        }
        return;
    }

    // Prepare type styling
    const typeColors = {
        'breakfast': 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'lunch': 'bg-green-100 text-green-800 border-green-200',
        'dinner': 'bg-purple-100 text-purple-800 border-purple-200',
        'snack': 'bg-blue-100 text-blue-800 border-blue-200'
    };
    const typeColor = typeColors[meal.type] || 'bg-gray-100 text-gray-800 border-gray-200';

    // Update row
    row.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                ${meal.image_url ?
        `<div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full object-cover" src="${meal.image_url}" alt="${meal.name}">
                    </div>` :
        `<div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>`
    }
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">${meal.name}</div>
                    <div class="text-xs text-gray-500 truncate max-w-xs">
                        ${meal.description ? meal.description.substring(0, 60) + (meal.description.length > 60 ? '...' : '') : ''}
                    </div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border ${typeColor}">
                ${meal.type.charAt(0).toUpperCase() + meal.type.slice(1)}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${meal.items ? meal.items.length : 0}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${calculateTotalCalories(meal)}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${meal.creator ? meal.creator.name : 'System'}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="/admin/meals/${meal.id}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                View
            </a>
            <button type="button" onclick="openEditMealModal(${meal.id})" class="text-yellow-600 hover:text-yellow-900 mr-3">
                Edit
            </button>
            <button type="button" onclick="confirmDeleteMeal(${meal.id}, '${meal.name}')" class="text-red-600 hover:text-red-900">
                Delete
            </button>
        </td>
    `;

    // Update stats
    // refreshStats();
}

/**
 * Calculate total calories for a meal
 */
function calculateTotalCalories(meal) {
    if (!meal.items || !meal.items.length) return 0;

    let totalCalories = 0;
    meal.items.forEach(item => {
        if (item.nutrients && item.nutrients.calories) {
            totalCalories += parseFloat(item.nutrients.calories) || 0;
        }
    });

    return Math.round(totalCalories);
}

/**
 * Refresh statistics on the page
 */
// async function refreshStats() {
//     try {
//         const response = await fetch('/admin/meals/stats/refresh', {
//             headers: {
//                 'Accept': 'application/json'
//             }
//         });
//
//         if (!response.ok) {
//             throw new Error('Failed to fetch stats');
//         }
//
//         const data = await response.json();
//
//         if (!data.success) {
//             throw new Error(data.message || 'Failed to fetch stats');
//         }
//
//         // Update stat cards
//         if (data.stats.totalMeals !== undefined) {
//             const totalMealsElement = document.getElementById('totalMeals');
//             if (totalMealsElement) totalMealsElement.textContent = data.stats.totalMeals;
//         }
//
//         if (data.stats.avgCalories !== undefined) {
//             const avgCaloriesElement = document.getElementById('avgCalories');
//             if (avgCaloriesElement) avgCaloriesElement.textContent = data.stats.avgCalories;
//         }
//
//         if (data.stats.mealTypeCount !== undefined) {
//             const mealTypesElement = document.getElementById('mealTypes');
//             if (mealTypesElement) {
//                 const total = Object.values(data.stats.mealTypeCount).reduce((a, b) => a + b, 0);
//                 mealTypesElement.textContent = total;
//             }
//         }
//     } catch (error) {
//         console.error('Error refreshing stats:', error);
//     }
// }

/**
 * Clear all error messages from a form
 */
function clearFormErrors(form) {
    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach(message => message.remove());

    const invalidInputs = form.querySelectorAll('.border-red-500');
    invalidInputs.forEach(input => {
        input.classList.remove('border-red-500');
    });
}

/**
 * Display validation errors on the form
 */
function displayValidationErrors(errors) {
    Object.keys(errors).forEach(field => {
        // Handle array field names like food_items[0][food_id]
        let selector = field.replace(/\[(\d+)\]/g, '\\[$1\\]').replace(/\[(\w+)\]/g, '\\[$1\\]');
        let inputField = document.querySelector(`[name="${selector}"]`);

        if (inputField) {
            inputField.classList.add('border-red-500');

            const errorSpan = document.createElement('span');
            errorSpan.className = 'error-message text-xs text-red-500 mt-1';
            errorSpan.textContent = errors[field][0];

            // Add after the input
            if (inputField.nextElementSibling) {
                inputField.parentNode.insertBefore(errorSpan, inputField.nextElementSibling);
            } else {
                inputField.parentNode.appendChild(errorSpan);
            }
        }
    });
}

/**
 * Show a notification message
 */
/**
 * Show a notification message
 */
function showNotification(message, type = 'success') {
    // Remove any existing notifications
    const existingNotifications = document.querySelectorAll('.notification-toast');
    existingNotifications.forEach(notification => {
        notification.remove();
    });

    // Create the notification element
    const notification = document.createElement('div');
    notification.className = 'notification-toast fixed top-4 right-4 p-4 rounded-md shadow-lg z-50';

    // Add type-specific styles
    if (type === 'success') {
        notification.classList.add('bg-green-500', 'text-white');
    } else if (type === 'error') {
        notification.classList.add('bg-red-500', 'text-white');
    }

    // Add content to the notification
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="mr-3">
                ${type === 'success' ?
        '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>' :
        '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'
    }
            </div>
            <div>${message}</div>
        </div>
    `;

    // Append to body
    document.body.appendChild(notification);

    // Automatically remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.5s ease-out';

        // Remove from DOM after fade out
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}
