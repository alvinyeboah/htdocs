<?php
require_once '../utils/auth.php';
checkAuth();
?>

<aside id="sidebar" class="bg-gray-800 text-white w-16 flex-shrink-0 transition-all duration-300 ease-in-out">
    <div class="h-full flex flex-col justify-between py-4">
        <div>
            <div class="flex justify-center mb-8">
                <img src="https://via.placeholder.com/40" alt="Logo" class="rounded-full">
            </div>
            <nav>
                <ul>
                    <li class="mb-4 sidebar-item relative">
                        <a href="dashboard.php" class="flex justify-center p-2 hover:bg-gray-700 rounded transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </a>
                        <span class="sidebar-item-tooltip hidden absolute left-full ml-2 bg-gray-700 text-white text-xs py-1 px-2 rounded">Analytics</span>
                    </li>
                    <li class="mb-4 sidebar-item relative">
                        <a href="users.php" class="flex justify-center p-2 hover:bg-gray-700 rounded transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#fff" fill="none">
                                <path d="M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                        </a>
                        <span class="sidebar-item-tooltip hidden absolute left-full ml-2 bg-gray-700 text-white text-xs py-1 px-2 rounded">User Management</span>
                    </li>
                    <li class="mb-4 sidebar-item relative">
                        <a href="recipes.php" class="flex justify-center p-2 hover:bg-gray-700 rounded transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#ffffff" fill="none">
                                <path d="M22 14V10C22 6.22876 22 4.34315 20.8284 3.17157C19.6569 2 17.7712 2 14 2H12C8.22876 2 6.34315 2 5.17157 3.17157C4 4.34315 4 6.22876 4 10V14C4 17.7712 4 19.6569 5.17157 20.8284C6.34315 22 8.22876 22 12 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14Z" stroke="currentColor" stroke-width="1.5" />
                                <path d="M5 6L2 6M5 12H2M5 18H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17.5 7L13.5 7M15.5 11H13.5" stroke="currentColor" stroke-width="1.5" />
                                <path d="M9 22L9 2" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                        </a>
                        <span class="sidebar-item-tooltip hidden absolute left-full ml-2 bg-gray-700 text-white text-xs py-1 px-2 rounded">Recipe Management</span>
                    </li>
                </ul>
            </nav>
        </div>
        <div>
            <button id="theme-toggle" class="w-full flex justify-center p-2 hover:bg-gray-700 rounded transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
    </div>
</aside>