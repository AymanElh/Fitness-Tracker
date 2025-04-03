
// Dom Elements
const createFoodModal = document.getElementById('createFoodModal');
const editFoodModal = document.getElementById('editFoodModal');
const viewFoodModal = document.getElementById('viewFoodModal');
const deleteFoodModal = document.getElementById('deleteFoodModal');
const createFoodForm = document.getElementById('createFoodForm');
const updateFoodForm = document.getElementById('updateFoodForm');
const deleteFoodForm = document.getElementById('deleteFoodForm');
const viewEditFoodButton = document.getElementById('viewEditFoodButton');

// Configure Axios defaults
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.headers.common['Accept'] = 'application/json';

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
successAlert.style.display = 'none';
}
}, 3000);

// Set up view edit button action
if (viewEditFoodButton) {
viewEditFoodButton.addEventListener('click', function () {
const foodId = this.getAttribute('data-id');
closeViewFoodModal();
openEditFoodModal(foodId);
});
}
});

// Display notifications
function showNotification(message, type = 'success') {
const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';

const notification = `
        <div class="mb-4 p-4 ${alertClass} border rounded" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    ${type === 'success' ?
`<svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>` :
`<svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>`
}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">
                        ${message}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <button type="button" class="inline-flex rounded-md p-1.5 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

// Insert notification at the top of the content
const contentArea = document.querySelector('.py-6');
const firstChild = contentArea.firstChild;

// Create temporary div to convert HTML string to DOM element
const temp = document.createElement('div');
temp.innerHTML = notification;
const alertElement = temp.firstChild;

contentArea.insertBefore(alertElement, firstChild);

// Auto-remove after 5 seconds
setTimeout(() => {
if (alertElement.parentNode) {
alertElement.remove();
}
}, 5000);
}

// Handle form data conversion for requests
function formDataToJson(formElement) {
const formData = new FormData(formElement);
const data = {};

formData.forEach((value, key) => {
// Handle nested objects (nutrients)
if (key.includes('.')) {
const [parent, child] = key.split('.');
if (!data[parent]) data[parent] = {};
data[parent][child] = value;
} else if (key.includes('[') && key.includes(']')) {
// Handle array notation (nutrients[calories])
const parent = key.substring(0, key.indexOf('['));
const child = key.substring(key.indexOf('[')+1, key.indexOf(']'));
if (!data[parent]) data[parent] = {};
data[parent][child] = value;
} else {
data[key] = value;
}
});

return data;
}

// Clear validation errors
function clearValidationErrors() {
document.querySelectorAll('.error-message').forEach(el => el.remove());
}

// Display validation errors
function displayValidationErrors(errors) {
Object.keys(errors).forEach(field => {
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

// Handle creating a new food item with Axios
async function handleCreateFood(e) {
e.preventDefault();

// Clear previous error messages
clearValidationErrors();

// Get form data and convert to JSON
const data = formDataToJson(createFoodForm);

try {
// Post request with axios
const response = await axios.post('{{ route("admin.foods.store") }}', data);

// Success response
if (response.data.success) {
// Close modal
closeCreateFoodModal();

// Show success notification
showNotification(response.data.message);

// Add new row to table
addFoodRow(response.data.food);

// Refresh stats
refreshStats();

// Reset form
createFoodForm.reset();
}
} catch (error) {
if (error.response) {
// The request was made and the server responded with a status code
// that falls out of the range of 2xx
if (error.response.status === 422) {
// Validation errors
displayValidationErrors(error.response.data.errors);
} else {
// Other error responses
showNotification(error.response.data.message || 'An error occurred', 'error');
}
} else if (error.request) {
// The request was made but no response was received
showNotification('Network error. Please check your connection.', 'error');
} else {
// Something happened in setting up the request that triggered an Error
showNotification('Error: ' + error.message, 'error');
}
}
}

// Handle updating a food item with Axios
async function handleUpdateFood(e) {
e.preventDefault();

// Clear previous error messages
clearValidationErrors();

// Get form data
const foodId = document.getElementById('edit_food_id').value;
const data = formDataToJson(updateFoodForm);

try {
// Put request with axios
const response = await axios.put(`/admin/foods/${foodId}`, data);

// Success response
if (response.data.success) {
// Close modal
closeEditFoodModal();

// Show success notification
showNotification(response.data.message);

// Update row in table
updateFoodRow(response.data.food);
}
} catch (error) {
if (error.response) {
if (error.response.status === 422) {
// Validation errors
displayValidationErrors(error.response.data.errors);
} else {
showNotification(error.response.data.message || 'An error occurred', 'error');
}
} else if (error.request) {
showNotification('Network error. Please check your connection.', 'error');
} else {
showNotification('Error: ' + error.message, 'error');
}
}
}

// Handle deleting a food item with Axios
async function handleDeleteFood(e) {
e.preventDefault();

const foodId = deleteFoodForm.getAttribute('data-food-id');

try {
// Delete request with axios
const response = await axios.delete(`/admin/foods/${foodId}`);

// Success response
if (response.data.success) {
// Close modal
closeDeleteFoodModal();

// Show success notification
showNotification(response.data.message);

// Remove row from table
const foodRow = document.querySelector(`.food-row[data-id="${foodId}"]`);
if (foodRow) {
foodRow.remove();
}

// Refresh stats
refreshStats();
}
} catch (error) {
if (error.response) {
showNotification(error.response.data.message || 'An error occurred', 'error');
} else if (error.request) {
showNotification('Network error. Please check your connection.', 'error');
} else {
showNotification('Error: ' + error.message, 'error');
}
}
}

// Refresh statistics via Axios
async function refreshStats() {
try {
const response = await axios.get('/admin/foods/stats/refresh');

if (response.data.success) {
const stats = response.data.stats;

// Update stat cards
document.querySelector('[data-stat="totalFoods"]').textContent = stats.totalFoods;
document.querySelector('[data-stat="categoryCount"]').textContent = stats.categoryCount;
document.querySelector('[data-stat="avgCalories"]').textContent = stats.avgCalories;
}
} catch (error) {
console.error('Error refreshing stats:', error);
}
}

// Initialize delete confirmation
function confirmDeleteFood(id, name) {
document.getElementById('delete-food-text').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
deleteFoodForm.setAttribute('data-food-id', id);
openDeleteFoodModal();
}

// Add a new food row to the table
function addFoodRow(food) {
const row = document.createElement('tr');
row.className = 'hover:bg-gray-50 food-row';
row.setAttribute('data-id', food.id);
row.setAttribute('data-name', food.name.toLowerCase());
row.setAttribute('data-category', food.category_id);
row.setAttribute('data-calories', food.nutrients.calories || 0);
row.setAttribute('data-protein', food.nutrients.protein_g || 0);
row.setAttribute('data-carbs', food.nutrients.carbs_g || 0);
row.setAttribute('data-fat', food.nutrients.fat_g || 0);
row.setAttribute('data-fiber', food.nutrients.fiber_g || 0);

let categoryName = 'Uncategorized';
let categoryColor = '#6B7280';

if (food.category) {
categoryName = food.category.name;
categoryColor = food.category.color_code || '#6B7280';
}

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
                <button type="button"
                        onclick="openViewFoodModal(${food.id})"
                        class="text-blue-600 hover:text-blue-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
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
                        onclick="confirmDeleteFood(${food.id}, '${food.name}')"
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

// If table is empty, remove the "no items" row
const noItems = document.querySelector('#foodsTableBody tr td[colspan="8"]');
if (noItems) {
noItems.parentNode.remove();
}

// Add to table
document.getElementById('foodsTableBody').appendChild(row);
}

// Update existing food row in the table
function updateFoodRow(food) {
const row = document.querySelector(`.food-row[data-id="${food.id}"]`);
if (!row) return;

// Update data attributes
row.setAttribute('data-name', food.name.toLowerCase());
row.setAttribute('data-category', food.category_id);
row.setAttribute('data-calories', food.nutrients.calories || 0);
row.setAttribute('data-protein', food.nutrients.protein_g || 0);
row.setAttribute('data-carbs', food.nutrients.carbs_g || 0);
row.setAttribute('data-fat', food.nutrients.fat_g || 0);
row.setAttribute('data-fiber', food.nutrients.fiber_g || 0);

let categoryName = 'Uncategorized';
let categoryColor = '#6B7280';

if (food.category) {
categoryName = food.category.name;
categoryColor = food.category.color_code || '#6B7280';
}

// Update food name
row.querySelector('.text-sm.font-medium.text-gray-900').textContent = food.name;

// Update category
const categoryCell = row.querySelector('td:nth-child(2)');
if (food.category) {
categoryCell.innerHTML = `
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  style="background-color: ${hexToRgba(categoryColor, 0.1)}; color: ${categoryColor};">
                ${categoryName}
            </span>
        `;
} else {
categoryCell.innerHTML = `
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                Uncategorized
            </span>
        `;
}

// Update other cells
row.querySelector('td:nth-child(3)').textContent = food.portion_default;
row.querySelector('td:nth-child(4) div').textContent = food.nutrients.calories || 'N/A';
row.querySelector('td:nth-child(5) div').textContent = food.nutrients.protein_g || 'N/A';
row.querySelector('td:nth-child(6) div').textContent = food.nutrients.carbs_g || 'N/A';
row.querySelector('td:nth-child(7) div').textContent = food.nutrients.fat_g || 'N/A';
}

// Open view food modal with Axios
async function openViewFoodModal(id) {
try {
const response = await axios.get(`/admin/foods/${id}`);

if (response.data.success) {
const food = response.data.food;

// Populate view fields
document.getElementById('view_food_name').textContent = food.name;
document.getElementById('view_food_category').textContent = food.category ? food.category.name : 'Uncategorized';
document.getElementById('view_portion_default').textContent = food.portion_default;
document.getElementById('view_calories').textContent = food.nutrients.calories || '0';
document.getElementById('view_protein_g').textContent = `${food.nutrients.protein_g || '0'}g`;
document.getElementById('view_carbs_g').textContent = `${food.nutrients.carbs_g || '0'}g`;
document.getElementById('view_fat_g').textContent = `${food.nutrients.fat_g || '0'}g`;
document.getElementById('view_fiber_g').textContent = food.nutrients.fiber_g ? `${food.nutrients.fiber_g}g` : '0g';
document.getElementById('view_sugar_g').textContent = food.nutrients.sugar_g ? `${food.nutrients.sugar_g}g` : '0g';
document.getElementById('view_description').textContent = food.description || 'No description available.';

// Set edit button data
viewEditFoodButton.setAttribute('data-id', food.id);

// Set food image if available
const imageContainer = document.getElementById('view_food_image');
if (food.image_url) {
imageContainer.innerHTML = `<img src="${food.image_url}" alt="${food.name}" class="h-16 w-16 rounded-full object-cover">`;
} else {
imageContainer.innerHTML = `
                    <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                `;
}

// Show modal
viewFoodModal.classList.remove('hidden');
}
} catch (error) {
if (error.response) {
showNotification(error.response.data.message || 'Error loading food data', 'error');
} else if (error.request) {
showNotification('Network error. Please check your connection.', 'error');
} else {
showNotification('Error: ' + error.message, 'error');
}
}
}

// Open edit food modal with Axios
async function openEditFoodModal(id) {
try {
const response = await axios.get(`/admin/foods/${id}`);

if (response.data.success) {
const food = response.data.food;

// Populate form fields
document.getElementById('edit_food_id').value = food.id;
document.getElementById('edit_food_name').value = food.name;
document.getElementById('edit_category_id').value = food.category_id || '';
document.getElementById('edit_portion_default').value = food.portion_default;
document.getElementById('edit_calories').value = food.nutrients.calories || '';
document.getElementById('edit_protein_g').value = food.nutrients.protein_g || '';
document.getElementById('edit_carbs_g').value = food.nutrients.carbs_g || '';
document.getElementById('edit_fat_g').value = food.nutrients.fat_g || '';
document.getElementById('edit_fiber_g').value = food.nutrients.fiber_g || '';
document.getElementById('edit_sugar_g').value = food.nutrients.sugar_g || '';
document.getElementById('edit_description').value = food.description || '';

// Show modal
editFoodModal.classList.remove('hidden');
}
} catch (error) {
if (error.response) {
showNotification(error.response.data.message || 'Error loading food data', 'error');
} else if (error.request) {
showNotification('Network error. Please check your connection.', 'error');
} else {
showNotification('Error: ' + error.message, 'error');
}
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

function closeEditFoodModal() {
editFoodModal.classList.add('hidden');
}

function closeViewFoodModal() {
viewFoodModal.classList.add('hidden');
}

function openDeleteFoodModal() {
deleteFoodModal.classList.remove('hidden');
}

function closeDeleteFoodModal() {
deleteFoodModal.classList.add('hidden');
}

// Helper function to capitalize first letter
function ucfirst(string) {
return string.charAt(0).toUpperCase() + string.slice(1);
}

// Helper function for hex to rgba conversion
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
