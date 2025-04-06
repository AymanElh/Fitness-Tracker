// meals mangements javacript file

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    startSearchFoods();
})


// open and close create meal modal
function openCreateMealModal() {
    const modal = document.getElementById("createMealModal");
    if(!modal) return;

    document.getElementById("createMealForm").reset();
    document.getElementById('food-items-container').innerHTML = '';
    document.getElementById('no-food-items').style.display = 'block';

    modal.classList.remove("hidden");
}
function closeCreateMealModal() {
    document.getElementById("createMealModal").classList.add("hidden");
}

// open and close edit meal modal
function openEditMealModal() {
    document.getElementById("editMealModal").classList.remove("hidden");
}
function closeEditMealModal() {
    document.getElementById("editMealModal").classList.add("hidden");
}


// open and close food search modal
function addFoodItem() {
    // Reset the modal state
    document.getElementById('food-search-input').value = '';
    document.getElementById('food-search-results').innerHTML = `
        <div class="text-center text-gray-500 py-4">
            Type to search for foods
        </div>
    `;
    document.getElementById("foodSearchModal").classList.remove("hidden");
}
function closeFoodSearchModal() {
    document.getElementById("foodSearchModal").classList.add("hidden");
}


// Search food Item
function startSearchFoods() {
    const searchInput = document.getElementById("food-search-input");
    if(!searchInput) return;

    searchInput.addEventListener('input', function() {
        const key = this.value.trim();
        console.log(key);
        if(key.length < 2) {
            document.getElementById("food-search-results").innerHTML = `
                <div class="text-center text-gray-500 py-4">
                    Type at least 2 characters to search
                </div>
            `
        }

        searchFoods(key);
    })
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
        `

        fetch(`/admin/meals/search-foods?search=${key}`, {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if(!response.ok) {
                    return Promise.reject("Failed to find item");
                }
                return response.json();
            })
            .then(data => {
                if(!data.success) {
                    throw new Error("Failed to search foods" || data.message);
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

    } catch(error) {
        console.error("Error search foods: ", error.message);
    }
}

function selectFood(value) {
    console.log(value);
}
