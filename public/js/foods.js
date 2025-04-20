// Foods search and filter functionality

document.addEventListener("DOMContentLoaded", function() {
    let searchTerm = "";
    let categoryValue = "";

    const searchInput = document.getElementById("searchFood");
    const categoryFilter = document.getElementById("categoryFilter");
    const foodCards = document.querySelectorAll(".food-card");
    const noResultMessage = document.getElementById("noResultsMessage");
    const activeFiltersContainer = document.getElementById("activeFilters");

    if(searchInput) {
        searchInput.addEventListener("input", function() {
            searchTerm = this.value.toLowerCase().trim();
            applyFilters();
            updateActiveFilters();
        })
    }

    if (categoryFilter) {
        categoryFilter.addEventListener("change", function() {
            categoryValue = this.value;
            applyFilters();
            updateActiveFilters();
        });
    }

    function applyFilters() {
        let visibilityCount = 0;

        foodCards.forEach(card => {
            const name = card.getAttribute("data-name");
            const description = card.getAttribute("data-description");
            const category = card.getAttribute("data-category");
            const brand = card.getAttribute("data-brand");

            const matchedSearch = searchTerm === "" ||
                name.includes(searchTerm) ||
                description.includes(searchTerm) ||
                category.includes(searchTerm) ||
                brand.includes(searchTerm);

            const matchesCategory = categoryValue === "" || category === categoryValue;

            if(matchedSearch && matchesCategory) {
                card.style.display = "";
                visibilityCount++;
            } else {
                card.style.display = "none";
            }
        })

        noResultMessage.style.display = visibilityCount === 0 ? "block" : "none";
    }

    function updateActiveFilters() {
        activeFiltersContainer.innerHTML = "";

        if(searchTerm || categoryValue) {
            const label = document.createElement("div");
            label.className = "text-gray-400 mr-2";
            label.textContent = "Active Filters";

            activeFiltersContainer.appendChild(label);

            // Search Pill
            if(searchTerm) {
                const searchPill = document.createElement("span");
                searchPill.className = "bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm flex items-center mr-2";
                searchPill.innerHTML = `"${searchTerm}" <span class="ml-2 hover:text-white cursor-pointer"><i class="fas fa-times"></i></span>`
                searchPill.querySelector("span").addEventListener("click", function() {
                    searchTerm = "";
                    searchInput.value = "";
                    applyFilters();
                    updateActiveFilters();
                });
                activeFiltersContainer.appendChild(searchPill);
            }

            // Category Pill
            if(categoryValue) {
                const categoryName = categoryFilter.options[categoryFilter.selectedIndex].textContent;
                const categoryPill = document.createElement("span");
                categoryPill.className = "bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm flex items-center mr-2";
                categoryPill.innerHTML = `Category: ${categoryName} <span class="ml-2 hover:text-white cursor-pointer"><i class="fas fa-times"></i></span>`;
                categoryPill.querySelector("span").addEventListener("click", function() {
                    categoryValue = "";
                    categoryFilter.value = "";
                    applyFilters();
                    updateActiveFilters();
                });
                activeFiltersContainer.appendChild(categoryPill);
            }

            // Add clear all btn
            const clearBtn = document.createElement("a");
            clearBtn.className = "bg-slate-700 text-white px-3 py-1 rounded-full text-sm hover:bg-slate-600 transition cursor-pointer";
            clearBtn.textContent = "Clear All Filters";
            clearBtn.addEventListener("click", function() {
                searchTerm = "";
                searchInput.value = "";
                categoryValue = "";
                categoryFilter.value = "";
                applyFilters();
                updateActiveFilters();
            });
            activeFiltersContainer.appendChild(clearBtn);
        }
    }


});
