// Handle nutrition plan creation

document.addEventListener("DOMContentLoaded", function () {
    const daysContainer = document.getElementById("daysContainer");
    const addDayBtn = document.getElementById("addDayBtn");
    const dayTemplate = document.getElementById("dayTemplate");
    const mealItemTemplate = document.getElementById("mealItemTemplate");
    const foodItemTemplate = document.getElementById("foodItemTemplate");
    const durationSelect = document.getElementById("duration_days");

    // console.log(daysContainer, addDayBtn, dayTemplate, mealItemTemplate, foodItemTemplate, durationSelect);

    let dayCount = 0;

    addDay();

    durationSelect.addEventListener('change', function () {
        const newDayCount = parseInt(this.value, 10);

        if (newDayCount > dayCount) {
            for (let i = dayCount; i < newDayCount; i++) {
                addDay();
            }
        } else if (newDayCount < dayCount) {
            const dayElements = daysContainer.querySelectorAll(".day-container");
            for (let i = dayCount - 1; i >= newDayCount; i--) {
                dayElements[i].remove();
            }
            dayCount = newDayCount;
            updateDayNumbers();
        }
    });

    addDayBtn.addEventListener("click", function () {
        addDay();
        durationSelect.value = dayCount;
    });


    daysContainer.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-day-btn")) {
            const dayContainer = e.target.closest(".day-container");
            dayContainer.remove();
            dayCount--;
            updateDayNumbers();
            durationSelect.value = dayCount;
        }

        if (e.target.classList.contains("add-meal-btn")) {
            const btn = e.target;
            const dayContainer = btn.closest(".day-container");
            const dayIndex = Array.from(daysContainer.children).indexOf(dayContainer);
            const mealType = btn.dataset.mealType;
            const itemsContainer = daysContainer.querySelector(`.${mealType}-items-container`);
            addMealItem(dayIndex, mealType, itemsContainer);
        }

        if (e.target.classList.contains('add-food-btn') || e.target.closest('.add-food-btn')) {
            const btn = e.target.classList.contains('add-food-btn') ? e.target : e.target.closest('.add-food-btn');
            const dayContainer = btn.closest('.day-container');
            const dayIndex = Array.from(daysContainer.children).indexOf(dayContainer);
            const mealType = btn.dataset.mealType;
            const itemsContainer = dayContainer.querySelector(`.${mealType}-items-container`);

            addFoodItem(dayIndex, mealType, itemsContainer);
        }

        if (e.target.classList.contains('remove-item-btn') || e.target.closest('.remove-item-btn')) {
            const itemContainer = e.target.closest('.meal-item, .food-item');
            itemContainer.remove();
        }
    });

    function addMealItem(dayIndex, mealType, container) {
        const mealElement = mealItemTemplate.content.cloneNode(true);

        const mealCount = container.querySelectorAll('.meal-item').length;
        updateInputNames(mealElement, 'days[0][meals][0]', `days[${dayIndex}][meals][${mealCount}]`);

        mealElement.querySelector('.meal-type-input').value = mealType;

        container.appendChild(mealElement);
    }

    function addDay() {
        if (daysContainer.querySelector('p')) {
            daysContainer.innerHTML = "";
        }

        const dayElement = dayTemplate.content.cloneNode(true);

        dayCount++;
        dayElement.querySelector(".day-number").textContent = dayCount;

        // updateInputNames(dayElement, 'days[0]', `days[${dayCount - 1}]`)

        daysContainer.appendChild(dayElement);
    }


    function updateDayNumbers() {
        const dayElements = daysContainer.querySelectorAll(".day-container");
        dayElements.forEach((day, index) => {
            day.querySelector(".day-number").textContent = index + 1;
            updateInputNames(day, `days[${index}]`, `days[${index}]`);
        })
    }

    function updateInputNames(element, search, replace) {
        const inputs = element.querySelectorAll('input, select, textarea');
        console.log(inputs);
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(search, replace);
            }
        })
    }
});
