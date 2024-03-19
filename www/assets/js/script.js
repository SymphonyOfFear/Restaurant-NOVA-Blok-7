// When the document is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Select all dropdown buttons
    document.querySelectorAll('.dropbtn').forEach(function(dropbtn) {
        // Add click event listener to each button
        dropbtn.addEventListener('click', function(event) {
            event.preventDefault();
            let dropdownContent = this.nextElementSibling;

            // If the next element is the dropdown content, toggle the 'show' class
            if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
                dropdownContent.classList.toggle('show');
            }
        });
    });

    // Close the dropdown by clicking outside of it
    window.addEventListener('click', function(event) {
        if (!event.target.matches('.dropbtn')) {
            document.querySelectorAll('.dropdown-content.show').forEach(function(dropdown) {
                dropdown.classList.remove('show');
            });
        }
    });
});
