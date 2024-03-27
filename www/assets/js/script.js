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

    // Confirm delete function
    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            var confirmDeletion = confirm('Weet je zeker dat je dit wilt verwijderen? Dit kan niet ongedaan worden gemaakt.');
            if (confirmDeletion) {
                // Assuming the form id or class to be dynamically generated or specific
                // You might need to adjust the selector accordingly
                this.closest('form').submit();
            }
        });
    });

    // Search clients functionality
    var clientSearchInput = document.getElementById('clientSearch');
    if (clientSearchInput) {
        clientSearchInput.addEventListener('keyup', function () {
            searchClients(this.value);
        });
    }
});

function searchClients(searchTerm) {
    if (searchTerm.length < 3) {
        document.getElementById('clientSearchResults').style.display = 'none';
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('clientSearchResults').innerHTML = this.responseText;
            document.getElementById('clientSearchResults').style.display = 'block';
        }
    };

    xhr.open("GET", "../controllers/search_clients.php?q=" + encodeURIComponent(searchTerm), true);
    xhr.send();
}

function selectClient(clientId, clientName) {
    document.getElementById('selectedClientId').value = clientId;
    document.getElementById('clientSearch').value = clientName;
    document.getElementById('clientSearchResults').style.display = 'none';
}
