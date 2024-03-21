document.addEventListener('DOMContentLoaded', function () {
    // Handle dropdown functionality
    document.querySelectorAll('.dropbtn').forEach(function (dropbtn) {
        dropbtn.addEventListener('click', function () {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.previousElementSibling === this) {
                    openDropdown.style.display = openDropdown.style.display === 'block' ? 'none' : 'block';
                } else {
                    openDropdown.style.display = 'none';
                }
            }
        });
    });

    // Clicking outside of the dropdown will close any open dropdown contents
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                openDropdown.style.display = 'none';
            }
        }
    };

    // Periodically check the user's role
    setInterval(function () {
        fetch('../controllers/RolChecker.php')
            .then(response => response.json())
            .then(data => {
                if (data.rol) {
                    console.log("User Role: ", data.rol);
                    // Process role-specific actions here if needed
                }
            })
            .catch(error => console.error('Error fetching user role:', error));
    }, 500); // Check every 0.5 seconds
});
