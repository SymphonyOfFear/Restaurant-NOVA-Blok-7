document.addEventListener('DOMContentLoaded', function () {
    var dropdowns = document.querySelectorAll('.dropdown-btn');

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('click', function () {

            var dropdownContent = this.parentElement.querySelector('.dropdown-content');
            var isCurrentlyDisplayed = dropdownContent.style.display === "block";

            document.querySelectorAll('.dropdown-content').forEach(function (content) {
                content.style.display = 'none';

            });

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

            if (currentlyDisplayedContent) {
                currentlyDisplayedContent.style.display = 'none';
            }

            var contentId = this.getAttribute('data-content');
            var contentToShow = document.getElementById(contentId);
            if (contentToShow) {
                contentToShow.style.display = 'block';

                currentlyDisplayedContent = contentToShow;
            } else {
                console.error('Content with ID "' + contentId + '" not found.');
            }
        });
    });

    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            var confirmDeletion = confirm('Weet je zeker dat je dit wilt verwijderen? Dit kan niet ongedaan worden gemaakt.');
            if (confirmDeletion) {

                this.closest('form').submit();
            }
        });
    });

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

    document.getElementById('name').readOnly = true;
}