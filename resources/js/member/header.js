document.addEventListener('DOMContentLoaded', function () {
    const profileButton = document.getElementById('profileDropdownButton');
    const profileMenu = document.getElementById('profileDropdownMenu');

    if (!profileButton || !profileMenu) return;

    // Toggle dropdown when clicking the profile button
    profileButton.addEventListener('click', function (e) {
        e.stopPropagation();
        profileMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!profileMenu.contains(e.target) && !profileButton.contains(e.target)) {
            profileMenu.classList.add('hidden');
        }
    });
});
