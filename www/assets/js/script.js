document.addEventListener('DOMContentLoaded', (event) => {
    // Get all the dropdown buttons
    const dropdownButtons = document.querySelectorAll('.dropdown-btn');

    // Loop through each button and add event listener
    dropdownButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const dropdownId = btn.getAttribute('data-dropdown');
            const dropdownContent = document.getElementById(dropdownId);

            // Toggle the display of the dropdown content
            if (dropdownContent.style.display === 'block') {
                dropdownContent.style.display = 'none';
            } else {
                // First, hide all dropdown contents
                const allDropdownContents = document.querySelectorAll('.dropdown-content');
                allDropdownContents.forEach(content => content.style.display = 'none');

                // Then, show the selected dropdown content
                dropdownContent.style.display = 'block';
            }
        });
    });

    // Optional: Hide dropdowns when clicking outside
    window.addEventListener('click', function (e) {
        if (!e.target.matches('.dropdown-btn')) {
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                let openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    });
});
