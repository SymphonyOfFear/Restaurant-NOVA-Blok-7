document.addEventListener('DOMContentLoaded', function() {
    var dropdowns = document.querySelectorAll('.dropdown-btn');
    
    // Debug: Log the count of dropdown buttons found
    console.log(dropdowns.length + ' dropdown buttons found.');

    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function() {
            console.log('Dropdown button clicked.');

            // Find the dropdown content within the same list item
            var dropdownContent = this.parentElement.querySelector('.dropdown-content');
            
            // Debug: Log if the dropdown content was found
            if (dropdownContent) {
                console.log('Dropdown content found.');
                // Toggle the display of the dropdown content
                dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
            } else {
                console.error('Dropdown content not found!');
            }
        });
    });
    // Handle dynamic content button clicks for the admin dashboard
    var dynamicContentButtons = document.querySelectorAll('.dynamic-content-button');
    dynamicContentButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var contentId = this.getAttribute('data-content');
            var contentSections = document.querySelectorAll('.dynamic-content');

            // Hide all content sections
            contentSections.forEach(function(section) {
                section.style.display = 'none';
            });

            // Show the active section based on the clicked button's data-content attribute
            var activeSection = document.getElementById(contentId);
            if (activeSection) {
                activeSection.style.display = 'block';
            } else {
                // If the active section isn't found, log an error to the console
                console.error('Active section content not found!');
            }
        });
    });
});
