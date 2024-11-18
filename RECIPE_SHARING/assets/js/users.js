$(document).ready(function() {
    // Initialize DataTable
    $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

    // Notyf initialization for toast notifications
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top'
        }
    });

    // Add User Button Handler
    $('#addUserBtn').on('click', function() {
        $('#modalTitle').text('Add New User');
        $('#action').val('create');
        $('#userId').val('');
        $('#userForm')[0].reset();
        $('#password').prop('required', true);
        toggleModal('userModal');
    });

    // Edit Button Handler
    $('.edit-btn').on('click', function() {
        const userId = $(this).data('id');
        const fname = $(this).data('fname');
        const lname = $(this).data('lname');
        const email = $(this).data('email');
        const role = $(this).data('role');

        $('#modalTitle').text('Edit User');
        $('#action').val('update');
        $('#userId').val(userId);
        $('#fname').val(fname);
        $('#lname').val(lname);
        $('#email').val(email);
        $('#role').val(role);
        $('#password').prop('required', false);
        toggleModal('userModal');
    });

    // Delete Button Handler
    $('.delete-btn').on('click', function() {
        const userId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../actions/user-admin.php',
                    method: 'POST',
                    data: {
                        action: 'delete',
                        user_id: userId
                    },
                    success: function(response) {
                        try {
                            const result = JSON.parse(response);
                            if (result.status === 'success') {
                                notyf.success(result.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                notyf.error(result.message);
                            }
                        } catch (e) {
                            notyf.error('An unexpected error occurred');
                        }
                    },
                    error: function() {
                        notyf.error('Failed to delete user');
                    }
                });
            }
        });
    });

    // User Form Submission Handler
    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../actions/user-admin.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        notyf.success(result.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        notyf.error(result.message);
                    }
                } catch (e) {
                    notyf.error('An unexpected error occurred');
                }
            },
            error: function() {
                notyf.error('Failed to save user');
            }
        });
    });
});

// Modal Toggle Functions
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');
}

function closeModal() {
    toggleModal('userModal');
}