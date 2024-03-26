document.addEventListener('DOMContentLoaded', function () {
    var dropdowns = document.querySelectorAll('.dropdown-btn');

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('click', function () {
            var dropdownContent = this.parentElement.querySelector('.dropdown-content');
            var isCurrentlyDisplayed = dropdownContent.style.display === "block";

            // Close all dropdowns first
            document.querySelectorAll('.dropdown-content').forEach(function (content) {
                content.style.display = 'none';
            });

            // Toggle the clicked dropdown if it wasn't already open
            if (!isCurrentlyDisplayed) {
                dropdownContent.style.display = "block";
            } else {
                dropdownContent.style.display = "none";
            }
        });
    });

    var dynamicContentButtons = document.querySelectorAll('.dynamic-content-button');
    var currentlyDisplayedContent = null;

    dynamicContentButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Hide the previously displayed dynamic content
            if (currentlyDisplayedContent) {
                currentlyDisplayedContent.style.display = 'none';
            }

            var contentId = this.getAttribute('data-content');
            var contentToShow = document.getElementById(contentId);
            if (contentToShow) {
                contentToShow.style.display = 'block';
                // Update the currently displayed content
                currentlyDisplayedContent = contentToShow;
            } else {
                console.error('Content with ID "' + contentId + '" not found.');
            }
        });
    });
});
function confirmDelete() {
    if (confirm('Weet je zeker dat je je account wilt verwijderen? Dit kan niet ongedaan worden gemaakt.')) {
        document.getElementById('delete-account-form').submit();
    }
}