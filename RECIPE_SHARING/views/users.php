<?php
include '../actions/user-admin.php';
require_once '../utils/auth.php';
checkAuth();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <style>
        .sidebar-item:hover .sidebar-item-tooltip {
            display: block;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #2D3748;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #4A5568;
            border-radius: 20px;
        }

        .fade-in {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="flex h-screen overflow-hidden">
        <?php require_once '../components/sidebar.php'; ?>
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php require_once '../components/header.php'; ?>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    <h2 class="text-2xl font-bold mb-4">User Management</h2>

                    <!-- Analytics Section -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <?php
                        $totalUsers = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM users"));
                        $adminCount = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM users WHERE role = 1"));
                        $regularUsers = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM users WHERE role = 2"));
                        $recentUsers = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"));
                        ?>

                        <!-- Analytics Cards -->
                        <div class="bg-blue-50 p-4 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Total Users</p>
                                    <h3 class="text-2xl font-bold text-blue-600"><?php echo $totalUsers; ?></h3>
                                </div>
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Administrators</p>
                                    <h3 class="text-2xl font-bold text-green-600"><?php echo $adminCount; ?></h3>
                                </div>
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Regular Users</p>
                                    <h3 class="text-2xl font-bold text-purple-600"><?php echo $regularUsers; ?></h3>
                                </div>
                                <div class="bg-purple-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">New Users (30 days)</p>
                                    <h3 class="text-2xl font-bold text-yellow-600"><?php echo $recentUsers; ?></h3>
                                </div>
                                <div class="bg-yellow-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                        <?php if ($userRole == 1): ?>
                            <button id="addUserBtn"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                                Add New User
                            </button>
                        <?php endif; ?>

                        <table id="usersTable" class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created At</th>
                                    <?php if ($userRole == 1): ?>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $query = "SELECT * FROM users";
                                $result = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['fname'] . ' ' . $row['lname']) . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['email']) . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap'>" . ($row['role'] == 1 ? 'Administrator' : 'Regular User') . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['created_at']) . "</td>";
                                    if ($userRole == 1) {
                                        echo "<td class='px-6 py-4 whitespace-nowrap'>
                                            <button class='text-blue-600 hover:text-blue-900 mr-2 edit-btn' 
                                                data-id='" . $row['user_id'] . "'
                                                data-fname='" . htmlspecialchars($row['fname']) . "'
                                                data-lname='" . htmlspecialchars($row['lname']) . "'
                                                data-email='" . htmlspecialchars($row['email']) . "'
                                                data-role='" . $row['role'] . "'>Edit</button>
                                            <button class='text-red-600 hover:text-red-900 delete-btn' 
                                                data-id='" . $row['user_id'] . "'>Delete</button>
                                        </td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Container -->
    <div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg mx-4">
            <!-- Modal Header -->
            <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
                <h3 class="text-lg font-medium" id="modalTitle">
                    {{ isset($_GET['edit']) ? 'Edit User' : 'Add New User' }}
                </h3>
                <button type="button" class="text-white hover:text-gray-200" onclick="toggleModal('userModal')">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <form id="userForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="px-6 py-4 space-y-4">
                <!-- Hidden Fields -->
                <input type="hidden" id="userId" name="user_id"
                    value="<?php echo isset($_GET['edit']) ? htmlspecialchars($_GET['edit']) : ''; ?>">
                <input type="hidden" id="action" name="action"
                    value="<?php echo isset($_GET['edit']) ? 'update' : 'create'; ?>">

                <!-- First Name -->
                <div>
                    <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="fname" id="fname" required
                        value="<?php echo isset($userData['fname']) ? htmlspecialchars($userData['fname']) : ''; ?>"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="lname" id="lname" required
                        value="<?php echo isset($userData['lname']) ? htmlspecialchars($userData['lname']) : ''; ?>"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        value="<?php echo isset($userData['email']) ? htmlspecialchars($userData['email']) : ''; ?>"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Password (Only for Create) -->
                <?php if (!isset($_GET['edit'])): ?>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                <?php endif; ?>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="2" <?php echo (isset($userData['role']) && $userData['role'] == 2) ? 'selected' : ''; ?>>Regular User</option>
                        <option value="1" <?php echo (isset($userData['role']) && $userData['role'] == 1) ? 'selected' : ''; ?>>Administrator</option>
                    </select>
                </div>
            </form>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-4">
                <button type="submit" form="userForm"
                    class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save
                </button>
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/users.js"></script>


</body>

</html>