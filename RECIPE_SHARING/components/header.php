<style>
    #join-community-button {
        display: inline-block;
        text-decoration: none;
        color: #fff;
        background-color: #ff6347;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease-in-out;
    }

    #join-community-button:hover {
        background-color: #ff4500;
        transform: scale(1.05);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
    }
</style>
<header class="bg-white shadow-md">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <h1 class="text-xl font-semibold pl-4">Dashboard</h1>
        </div>
        <div class="flex items-center flex-end  gap-x-8">
            <a id="join-community-button" href="index.php">Back to Main</a>
            <div class="relative">
                <button id="user-menu-button" class="flex items-center focus:outline-none">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="User avatar">
                    <span
                        class="ml-2 text-gray-700"><?php echo htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']); ?></span>
                    <svg class="ml-1 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                    <button id="signOutButton"
                        class="block px-4 py-2 w-full text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="../assets/js/dashboard.js"></script>