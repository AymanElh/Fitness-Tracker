// Search and filters for meals

document.addEventListener("DOMContentLoaded", function () {
    let searchTerm = "";
    let categoryValue = "";
    let typeValue = "";

    const searchInput = document.getElementById("searchMeal");
    const categoryFilter = document.getElementById("categoryFilter");
    const typeFilter = document.getElementById("typeFilter");
    const mealCards = document.querySelectorAll(".card-gradient");
    const noResultMessage = document.getElementById("noResultsMessage");
    const activeFiltersContainer = document.getElementById("activeFilters");

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            searchTerm = this.value.toLowerCase().trim();
            applyFilters();
            updateActiveFilters();
        })
    }

    if (categoryFilter) {
        categoryFilter.addEventListener("change", function () {
            categoryValue = this.value;
            applyFilters();
            updateActiveFilters();
        })
    }

    if (typeFilter) {
        typeFilter.addEventListener("change", function () {
            typeValue = this.value;
            applyFilters();
            updateActiveFilters();
        })
    }

    function applyFilters() {
        let visibilityCount = 0;

        mealCards.forEach(meal => {
            const name = meal.getAttribute("data-name");
            const description = meal.getAttribute("data-description");
            const category = meal.getAttribute("data-category");
            const type = meal.getAttribute("data-type");

            const matchesSearch = searchTerm === "" || name.includes(searchTerm) || description.includes(searchTerm);
            const matchesCategory = categoryValue === "" || category === categoryValue;
            const matchesType = typeValue === "" || type === typeValue;

            if (matchesSearch && matchesCategory && matchesType) {
                meal.style.display = "";
                visibilityCount++;
            } else {
                meal.style.display = "none";
            }
        })

        if (noResultMessage) {
            noResultMessage.style.display = visibilityCount === 0 ? "block" : "none";
        }
    }

    function updateActiveFilters() {
        activeFiltersContainer.innerHTML = "";

        if (searchTerm || categoryValue || typeValue) {
            const label = document.createElement("div");
            label.className = "text-gray-400 mr-2";
            label.textContent = "Active Filters";
            activeFiltersContainer.appendChild(label);

            // Search Pill
            if (searchTerm) {
                const searchPill = document.createElement("span");
                searchPill.className = "bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm flex items-center mr-2";
                searchPill.innerHTML = `"${searchTerm}" <span class="ml-2 hover:text-white cursor-pointer"><i class="fas fa-times"></i></span>`
                searchPill.querySelector("span").addEventListener("click", function () {
                    searchTerm = "";
                    searchInput.value = "";
                    applyFilters();
                    updateActiveFilters();
                })
                activeFiltersContainer.appendChild(searchPill);
            }
        }

        // Category Pill
        if (categoryValue) {
            const categoryName = categoryFilter.options[categoryFilter.selectedIndex].textContent;
            const categoryPill = document.createElement("span");
            categoryPill.className = "bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm flex items-center mr-2";
            categoryPill.innerHTML = `Category: ${categoryName} <span class="ml-2 hover:text-white cursor-pointer"><i class="fas fa-times"></i></span>`;
            categoryPill.querySelector("span").addEventListener("click", function () {
                categoryValue = "";
                categoryFilter.value = "";
                applyFilters();
                updateActiveFilters();
            });
            activeFiltersContainer.appendChild(categoryPill);
        }

        // Type Pill
        if (typeValue) {
            const typeName = typeFilter.options[typeFilter.selectedIndex].textContent;
            const typePill = document.createElement("span");
            typePill.className = "bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full text-sm flex items-center mr-2";
            typePill.innerHTML = `Type: ${typeName} <span class="ml-2 hover:text-white cursor-pointer"><i class="fas fa-times"></i></span>`;
            typePill.querySelector("span").addEventListener("click", function () {
                typeValue = "";
                typeFilter.value = "";
                applyFilters();
                updateActiveFilters();
            });
            activeFiltersContainer.appendChild(typePill);
        }

        // Add clear all button
        const clearBtn = document.createElement("a");
        clearBtn.className = "bg-slate-700 text-white px-3 py-1 rounded-full text-sm hover:bg-slate-600 transition cursor-pointer";
        clearBtn.textContent = "Clear All";
        clearBtn.addEventListener("click", function() {
            searchTerm = "";
            searchInput.value = "";
            categoryValue = "";
            categoryFilter.value = "";
            typeValue = "";
            typeFilter.value = "";
            applyFilters();
            updateActiveFilters();
        });
        activeFiltersContainer.appendChild(clearBtn);
    }
    applyFilters();
});
