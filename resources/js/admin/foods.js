const createFoodModal = document.getElementById('createFoodModal');
const editFoodModal = document.getElementById('editFoodModal');
const viewFoodModal = document.getElementById('viewFoodModal');
const deleteFoodModal = document.getElementById('deleteFoodModal');
const updateFoodForm = document.getElementById('updateFoodForm');
const deleteFoodForm = document.getElementById('deleteFoodForm');
const viewEditFoodButton = document.getElementById('viewEditFoodButton');
const createFoodForm = document.getElementById('createFoodForm');
const tableBody = document.getElementById('foodsTableBody');

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Get all foods
fetchFoods();

// Search and filter functionality
document.addEventListener('DOMContentLoaded', function () {
    const foodSearch = document.getElementById('foodSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const nutritionFilter = document.getElementById('nutritionFilter');
    const sortFoods = document.getElementById('sortFoods');

    // Set up form submissions with AJAX
    if (createFoodForm) {
        createFoodForm.addEventListener('submit', handleCreateFood);
    }

    if (updateFoodForm) {
        updateFoodForm.addEventListener('submit', handleUpdateFood);
    }
    //
    if (deleteFoodForm) {
        deleteFoodForm.addEventListener('submit', handleDeleteFood);
    }

    // Handle search input
    if (foodSearch) {
        foodSearch.addEventListener('input', filterFoods);
    }

    // Handle category filter
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterFoods);
    }

    // Handle nutrition filter
    if (nutritionFilter) {
        nutritionFilter.addEventListener('change', filterFoods);
    }

    // Handle sorting
    if (sortFoods) {
        sortFoods.addEventListener('change', sortFoodItems);
    }

    // Hide success alerts after 3 seconds
    setTimeout(() => {
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            successAlert.classList.add('hidden');
        }
    }, 10000);

    // Set up view edit button action
    // if (viewEditFoodButton) {
    //     viewEditFoodButton.addEventListener('click', function () {
    //         const foodId = this.getAttribute('data-id');
    //         closeViewFoodModal();
    //         openEditFoodModal(foodId);
    //     });
    // }
});

// Fetch foods
async function fetchFoods() {
    try {
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) loadingIndicator.style.display = '';

        const response = await fetch('/api/foods', {
            method: 'GET',
        });

        console.log("Response: ", response.ok);

        if (!response.ok) {
            throw new Error('Failed to fetch foods');
        }

        const data = await response.json();
        console.log("Fetched data: ", data);
        if (loadingIndicator) loadingIndicator.style.display = 'none';

        if (tableBody) {
            const loadingRow = loadingIndicator ? loadingIndicator.parentNode : null;
            console.log("Loading row: ", loadingRow);
            tableBody.innerHTML = "";
        }
        console.log(data.data.foods);
        if (data.data.foods && data.data.foods.length > 0) {
            data.data.foods.forEach(food => {
                // console.log(food);
                addFoodRow(food);
            });
            updateStats(data.data);
        }

    } catch (error) {
        console.log('Error fetching foods: ', error.message);
    }
}

// Show flash messages
function showFlashMessages(type, message) {
    const flashContainer = document.getElementById('flashMessages');
    const alertHtml = `
                <div class="bg-${type === 'success' ? 'green' : 'red'}-100 border-${type === 'success' ? 'green' : 'red'}-500 text-${type === 'success' ? 'green' : 'red'}-700 mb-4 p-4 rounded shadow-sm border-l-4">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="h-6 w-6 mr-4 text-${type === 'success' ? 'green' : 'red'}-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                ${type === 'success'
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <p class="font-bold">${type === 'success' ? 'Success!' : 'Error!'}</p>
                            <p class="text-sm">${message}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">
                            <svg class="h-4 w-4 text-${type === 'success' ? 'green' : 'red'}-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `;

    flashContainer.innerHTML = alertHtml;
}

// Display Validation errors
function displayValidationErrors(errors) {
    Object.keys(errors).forEach(field => {
        console.log(field);
        let inputField;

        // Handle nested fields (nutrients.calories)
        if (field.includes('.')) {
            const [parent, child] = field.split('.');
            inputField = document.querySelector(`[name="${parent}.${child}"]`) ||
                document.querySelector(`[name="${parent}[${child}]"]`);
        } else {
            inputField = document.querySelector(`[name="${field}"]`);
        }

        if (inputField) {
            const errorSpan = document.createElement('span');
            errorSpan.className = 'error-message text-xs text-red-600 mt-1';
            errorSpan.textContent = errors[field][0];
            inputField.parentNode.appendChild(errorSpan);
        }
    });
}

// clear validation errors
function clearValidationErrors() {
    document.querySelectorAll('.error-message').forEach(el => el.remove());
}

// Add food to table body
function addFoodRow(food) {
    const row = document.createElement('tr');
    row.className = 'hover:bg-gray-50 food-row';

    row.setAttribute('data-id', food.id);
    row.setAttribute('data-name', food.name.toLowerCase());
    row.setAttribute('data-category', food.category_id || '');
    row.setAttribute('data-calories', food.nutrients.calories || 0);
    row.setAttribute('data-protein', food.nutrients.protein_g || 0);
    row.setAttribute('data-carbs', food.nutrients.carbs_g || 0);
    row.setAttribute('data-fat', food.nutrients.fat_g || 0);
    row.setAttribute('data-fiber', food.nutrients.fiber_g || 0);

    // Prepare category display information
    let categoryName = 'Uncategorized';
    let categoryColor = '#6B7280'; // Default gray

    if (food.category) {
        categoryName = food.category.name;
        categoryColor = food.category.color_code || '#6B7280';
    }

    // Build row HTML content
    row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        ${food.image_url ?
                                `<div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" src="${food.image_url}" alt="${food.name}">
                            </div>` :
                                `<div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                </svg>
                            </div>`
                        }
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${food.name}</div>
                            <div class="text-xs text-gray-500">ID: ${food.id}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${food.category ?
                        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                               style="background-color: ${hexToRgba(categoryColor, 0.1)}; color: ${categoryColor};">
                            ${categoryName}
                        </span>` :
                        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Uncategorized
                        </span>`
                 }
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${food.portion_default}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${food.nutrients.calories || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${food.nutrients.protein_g || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${food.nutrients.carbs_g || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${food.nutrients.fat_g || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        <a href="/admin/foods/${food.id}"
                                class="text-blue-600 hover:text-blue-900">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <button type="button"
                                onclick="openEditFoodModal(${food.id})"
                                class="text-indigo-600 hover:text-indigo-900">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                        <button type="button"
                                onclick="openDeleteFoodModal(${food.id}, '${food.name}')"
                                class="text-red-600 hover:text-red-900">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            `;

    // Add the new row to the table
    tableBody.append(row);
}

// Create a new food
async function handleCreateFood(event) {
    event.preventDefault();
    clearValidationErrors();
    const formData = new FormData(createFoodForm);
    console.log("Form data: ", formData);
    // console.log("Form data: ", Object.fromEntries(formData));

    try {
        const response = await fetch('/api/foods', {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        const result = await response.json();
        // console.log("Response: ", result);

        // Check if there are validation errors
        if (!response.ok) {
            if (response.status === 422 && result.errors) {
                // Validation errors
                // console.log("response errors: ", result.errors);
                displayValidationErrors(result.errors)
                return;
            } else {
                // Other errors
                throw new Error(result.message || 'An error occurred');
            }
        }

        if (result.success) {
            closeCreateFoodModal();
            addFoodRow(result.food);
            fetchFoods();
            createFoodForm.reset();
            showFlashMessages('success', result.message);
        }
    } catch (error) {
        console.log("Error creating food: ", error.message);
    }
}

// update a food
async function handleUpdateFood(event) {
    event.preventDefault();
    clearValidationErrors();

    // Get form data
    const foodId = document.getElementById('edit_food_id').value;
    const formData = new FormData(updateFoodForm);


    try {
        // Send request using Fetch API
        const response = await fetch(`/api/foods/${foodId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        // Parse response
        const result = await response.json();
        console.log(response);
        // Check if there are validation errors
        if (!response.ok) {
            if (response.status === 422 && result.errors) {
                // Validation errors
                showFlashMessages('Please fix the following errors:', 'error', result.errors);
                displayValidationErrors(result.errors);
                return;
            } else {
                // Other errors
                throw new Error(result.message || 'An error occurred');
            }
        }

        if (result.success) {
            // Close modal
            closeEditFoodModal();

            // Show success flash message
            showFlashMessages('success', result.message);

            await fetchFoods();
        }
    } catch (error) {
        // Handle any other errors
        console.error('Error updating food:', error.message);
        showFlashMessages(error.message || 'An error occurred', 'error');
    }
}

async function handleDeleteFood(event) {
    event.preventDefault();
    const foodId = deleteFoodForm.getAttribute('data-food-id');
    console.log(foodId);
    try {
        const response = await fetch(`/api/foods/${foodId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': "application/json",
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })

        const result = await response.json();

        // Check response
        if (!response.ok) {
            throw new Error(result.message || 'An error occurred');
        }

        if (result.success) {
            // Close modal
            closeDeleteFoodModal();

            // Show success flash message
            showFlashMessages('success', result.message);
            await fetchFoods();
            // Remove row from table
            const foodRow = document.querySelector(`.food-row[data-id="${foodId}"]`);
            if (foodRow) {
                foodRow.remove();
            }
        }
    } catch (error) {
        console.log("Error deleting food: ", error.message);
        showFlashMessages('false', error.message)
    }
}

// Filter foods based on search and filters
function filterFoods() {
    const searchTerm = document.getElementById('foodSearch').value.toLowerCase();
    const categoryValue = document.getElementById('categoryFilter').value.toLowerCase();
    const nutritionValue = document.getElementById('nutritionFilter').value;

    const foodRows = document.querySelectorAll('.food-row');

    foodRows.forEach(row => {
        const foodName = row.getAttribute('data-name').toLowerCase();
        const foodCategory = row.getAttribute('data-category').toLowerCase();
        const calories = parseFloat(row.getAttribute('data-calories'));
        const protein = parseFloat(row.getAttribute('data-protein'));
        const carbs = parseFloat(row.getAttribute('data-carbs'));
        const fat = parseFloat(row.getAttribute('data-fat'));

        let matchesSearch = foodName.includes(searchTerm);
        let matchesCategory = categoryValue === '' || foodCategory === categoryValue;
        let matchesNutrition = true;

        // Apply nutrition filters
        if (nutritionValue === 'low_calorie') {
            matchesNutrition = calories <= 200;
        } else if (nutritionValue === 'high_protein') {
            matchesNutrition = protein >= 15;
        } else if (nutritionValue === 'low_carb') {
            matchesNutrition = carbs <= 10;
        } else if (nutritionValue === 'low_fat') {
            matchesNutrition = fat <= 5;
        } else if (nutritionValue === 'high_fiber') {
            // Assuming fiber data is available
            const fiber = parseFloat(row.getAttribute('data-fiber') || '0');
            matchesNutrition = fiber >= 5;
        }

        if (matchesSearch && matchesCategory && matchesNutrition) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Sort food items
function sortFoodItems() {
    const sortValue = document.getElementById('sortFoods').value;
    const foodRows = Array.from(document.querySelectorAll('.food-row'));
    const foodsTableBody = document.getElementById('foodsTableBody');

    foodRows.sort((a, b) => {
        if (sortValue === 'name_asc') {
            return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
        } else if (sortValue === 'name_desc') {
            return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
        } else if (sortValue === 'category_asc') {
            return a.getAttribute('data-category').localeCompare(b.getAttribute('data-category'));
        } else if (sortValue === 'calories_asc') {
            return parseFloat(a.getAttribute('data-calories')) - parseFloat(b.getAttribute('data-calories'));
        } else if (sortValue === 'calories_desc') {
            return parseFloat(b.getAttribute('data-calories')) - parseFloat(a.getAttribute('data-calories'));
        } else if (sortValue === 'protein_desc') {
            return parseFloat(b.getAttribute('data-protein')) - parseFloat(a.getAttribute('data-protein'));
        }

        return 0;
    });

    // Clear table and append sorted rows
    while (foodsTableBody.firstChild) {
        foodsTableBody.removeChild(foodsTableBody.firstChild);
    }

    foodRows.forEach(row => {
        foodsTableBody.appendChild(row);
    });
}

// Modal Functions
function openCreateFoodModal() {
    createFoodModal.classList.remove('hidden');
}

function closeCreateFoodModal() {
    createFoodModal.classList.add('hidden');
}

async function openEditFoodModal(foodId) {
    try {
        // Fetch food data from server endpoint
        const response = await fetch(`/api/foods/${foodId}`, {
            headers: {'Accept': 'application/json'}
        });

        if (!response.ok) {
            showFlashMessages(false, "Failed to fetch data");
            throw new Error("Failed to fetch data");
        }

        const data = await response.json();
        const food = data.food;

        document.getElementById('edit_food_id').value = food.id;
        document.getElementById('edit_food_name').value = food.name;
        document.getElementById('edit_portion_default').value = food.portion_default;
        document.getElementById('edit_calories').value = food.nutrients.calories;
        document.getElementById('edit_protein_g').value = food.nutrients.protein_g;
        document.getElementById('edit_carbs_g').value = food.nutrients.carbs_g;
        document.getElementById('edit_fat_g').value = food.nutrients.fat_g;
        document.getElementById('edit_fiber_g').value = food.nutrients.fiber_g || '';
        document.getElementById('edit_sugar_g').value = food.nutrients.sugar_g || '';
        document.getElementById('edit_description').value = food.description || '';

        editFoodModal.classList.remove('hidden');

    } catch (error) {
        console.error("Error fetching food data:", error);
        showFlashMessages(false, "Error loading food data. Please try again.");
    }

}

function closeEditFoodModal() {
    editFoodModal.classList.add('hidden');
}

function closeViewFoodModal() {
    viewFoodModal.classList.add('hidden');
}

function openDeleteFoodModal(foodId, foodName) {
    document.getElementById('delete-food-text').textContent = `Are you sure you want to delete "${foodName}"? This action cannot be undone.`;
    deleteFoodForm.setAttribute("data-food-id", foodId);
    deleteFoodModal.classList.remove('hidden');
}

function closeDeleteFoodModal() {
    deleteFoodModal.classList.add('hidden');
}

// Helper function to capitalize first letter
function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function updateStats(stats) {
    function updateStat(statName, value) {
        // console.log(statName, value);
        let element = document.getElementById(statName);

        if (!element) {
            element = document.querySelector(`[data-stat="${statName}"]`);
        }

        // Update if found
        if (element && value !== undefined) {
            element.textContent = value;
            console.log(`Updated ${statName} to ${value}`);
        } else {
            console.warn(`Could not find element for ${statName} or value is undefined`);
        }
    }

    // Update all stats
    updateStat('totalFoods', stats.totalFoods);
    updateStat('totalCategories', stats.categoryCount);
    updateStat('avgCalories', stats.avgCalories);
}

function hexToRgba(hex, opacity = 1) {
    if (!hex) return `rgba(107, 114, 128, ${opacity})`; // Default gray

    hex = hex.replace('#', '');

    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }

    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    return `rgba(${r}, ${g}, ${b}, ${opacity})`;
}
