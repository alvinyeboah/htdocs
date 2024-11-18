$(document).ready(function() {
    $('#user-menu-button').on('click', function() {
        $('#user-menu').toggleClass('hidden');
    });

    // Sign out functionality
    $('#signOutButton').on('click', function() {
        window.location.href = "../actions/logout.php";
    });
});
