// Search and filters functionalities

// State variables for filters
let searchTerm = "";
let typeFilter = "";
let muscleFilter = "";
let difficultyFilter = "";
let equipmentFilter = "";

// Search input handler
document.getElementById('searchExercise').addEventListener("input", function() {
    searchTerm = this.value.toLowerCase().trim();
    applyFilters();
});

// Filter select handlers
document.querySelectorAll('.filter-select').forEach(select => {
    select.addEventListener('change', function() {
        // Update filter state based on which select changed

        switch(this.name) {
            case 'type':
                typeFilter = this.value.toLowerCase();
                break;
            case 'muscle_group':
                muscleFilter = this.value.toLowerCase();
                break;
            case 'difficulty':
                difficultyFilter = this.value.toLowerCase();
                break;
            case 'equipment':
                equipmentFilter = this.value.toLowerCase();
                break;
        }

        applyFilters();

        updateActiveFilters();
    });
});

// Apply all filters function
function applyFilters() {
    const cards = document.querySelectorAll(".card-gradient");
    let visibleCount = 0;

    cards.forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const description = card.getAttribute('data-description').toLowerCase();
        const type = card.getAttribute('data-type').toLowerCase();
        const equipment = card.getAttribute('data-equipment').toLowerCase();
        const muscle = card.getAttribute('data-muscle').toLowerCase();
        const difficulty = card.getAttribute('data-difficulty').toLowerCase();

        // Check if exercise matches all active filters
        const matchesSearch = searchTerm === "" ||
            name.includes(searchTerm) ||
            description.includes(searchTerm) ||
            type.includes(searchTerm) ||
            equipment.includes(searchTerm) ||
            muscle.includes(searchTerm);

        const matchesType = typeFilter === "" || type === typeFilter;
        const matchesMuscle = muscleFilter === "" || muscle === muscleFilter;
        const matchesDifficulty = difficultyFilter === "" || difficulty === difficultyFilter;
        const matchesEquipment = equipmentFilter === "" || equipment === equipmentFilter;

        if(matchesSearch && matchesType && matchesMuscle && matchesDifficulty && matchesEquipment) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const noResultsMessage = document.getElementById('noResultsMessage');
    if (noResultsMessage) {
        noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

// Update active filters display
function updateActiveFilters() {
    const activeFiltersContainer = document.getElementById('activeFilters');
    if (!activeFiltersContainer) return;

    activeFiltersContainer.innerHTML = '';

    if (searchTerm || typeFilter || muscleFilter || difficultyFilter || equipmentFilter) {
        activeFiltersContainer.innerHTML = '<div class="text-gray-400 mr-2">Active filters:</div>';

        // Add clear all button
        const clearBtn = document.createElement('a');
        clearBtn.className = 'bg-slate-700 text-white px-3 py-1 rounded-full text-sm hover:bg-slate-600 transition cursor-pointer ml-2';
        clearBtn.textContent = 'Clear All';
        clearBtn.addEventListener('click', clearAllFilters);
        activeFiltersContainer.appendChild(clearBtn);
    }

    if (searchTerm) {
        createFilterPill(activeFiltersContainer, `"${searchTerm}"`, 'blue', () => {
            document.getElementById('searchExercise').value = '';
            searchTerm = '';
            applyFilters();
            updateActiveFilters();
        });
    }

    if (typeFilter) {
        createFilterPill(activeFiltersContainer, `Type: ${typeFilter}`, 'green', () => {
            document.querySelector('select[name="type"]').value = '';
            typeFilter = '';
            applyFilters();
            updateActiveFilters();
        });
    }

    if (muscleFilter) {
        createFilterPill(activeFiltersContainer, `Muscle: ${muscleFilter}`, 'purple', () => {
            document.querySelector('select[name="muscle_group"]').value = '';
            muscleFilter = '';
            applyFilters();
            updateActiveFilters();
        });
    }

    if (difficultyFilter) {
        createFilterPill(activeFiltersContainer, `Level: ${difficultyFilter}`, 'yellow', () => {
            document.querySelector('select[name="difficulty"]').value = '';
            difficultyFilter = '';
            applyFilters();
            updateActiveFilters();
        });
    }

    if (equipmentFilter) {
        createFilterPill(activeFiltersContainer, `Equipment: ${equipmentFilter}`, 'red', () => {
            document.querySelector('select[name="equipment"]').value = '';
            equipmentFilter = '';
            applyFilters();
            updateActiveFilters();
        });
    }
}

// Helper to create a filter pill
function createFilterPill(container, text, color, removeCallback) {
    const pill = document.createElement('span');
    pill.className = `bg-${color}-500/20 text-${color}-400 px-3 py-1 rounded-full text-sm flex items-center mr-2`;
    pill.innerHTML = `${text} <span class="ml-2 hover:text-white cursor-pointer"><i class="fas fa-times"></i></span>`;

    pill.querySelector('span').addEventListener('click', removeCallback);
    console.log(pill);
    container.appendChild(pill);
}

// Clear all filters
function clearAllFilters() {
    // Clear all filters
    searchTerm = "";
    typeFilter = "";
    muscleFilter = "";
    difficultyFilter = "";
    equipmentFilter = "";

    // Reset form inputs
    document.getElementById('searchExercise').value = "";
    document.querySelectorAll('.filter-select').forEach(select => {
        select.value = "";
    });

    applyFilters();
    updateActiveFilters();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log(document.getElementById("noResultsMessage"));
    if (!document.getElementById('noResultsMessage')) {
        const container = document.querySelector('.container');
        const noResultsMsg = document.createElement('p');
        noResultsMsg.id = 'noResultsMessage';
        noResultsMsg.className = 'text-center text-gray-400 py-8';
        noResultsMsg.textContent = 'No exercises found matching your criteria.';
        noResultsMsg.style.display = 'none';
        container.appendChild(noResultsMsg);
    }
});
