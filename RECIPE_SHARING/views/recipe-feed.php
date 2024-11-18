<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasty Bytes - Recipe Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../assets/css/recipe-feed.css">



</head>

<body class="bg-gray-100">
    <nav id="main-nav">
        <div class="nav-content">
            <a href="index.php" class="logo">Tasty<span>Bytes</span></a>
            <div class="nav-links">
                <!-- <a href="index.php">Home</a> -->
                <a href="index.php/#featured">Featured</a>
                <a href="recipe-feed.php">All Recipes</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a id="join-community-button" href="dashboard.php">My User</a>
                <?php else: ?>
                    <!-- Show "Join the Community" if the user is not signed in -->
                    <a id="join-community-button" href="login.php">Join the Community</a>
                <?php endif; ?>



            </div>
            <button id="menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
    <main class="recipe-feed">
        <header class="recipe-feed__header">
            <h1 class="recipe-feed__title">Discover Delicious Recipes</h1>
            <div class="recipe-feed__search">
                <input type="text" id="search-input" placeholder="Search recipes" class="recipe-feed__search-input">
                <button class="recipe-feed__search-button">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </header>

        <section class="recipe-feed__filters">
            <button class="recipe-feed__filter-button active" data-filter="all">All</button>
            <button class="recipe-feed__filter-button" data-filter="breakfast">Breakfast</button>
            <button class="recipe-feed__filter-button" data-filter="lunch">Lunch</button>
            <button class="recipe-feed__filter-button" data-filter="dinner">Dinner</button>
            <button class="recipe-feed__filter-button" data-filter="dessert">Dessert</button>
        </section>

        <section class="recipe-feed__grid">
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About Tasty Bytes</h3>
                    <p class="text-gray-400">We're passionate about bringing food lovers together to share and discover
                        amazing recipes.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">About
                                Us</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors duration-200">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy
                                Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Terms of
                                Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-400">&copy; 2024 Tasty Bytes. All rights reserved. Alvin Yeboah</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            const filterButtons = document.querySelectorAll('.recipe-feed__filter-button');
            const recipeCards = document.querySelectorAll('.recipe-card');
            const searchInput = document.getElementById('search-input');
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const filter = button.getAttribute('data-filter');

                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    recipeCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Search functionality
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();

                recipeCards.forEach(card => {
                    const title = card.querySelector('.recipe-card__title').textContent.toLowerCase();
                    const description = card.querySelector('.recipe-card__description').textContent.toLowerCase();

                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // GSAP animations
            gsap.from('.recipe-feed__title', {
                opacity: 0,
                y: -50,
                duration: 1,
                ease: 'power3.out'
            });

            gsap.from('.recipe-feed__search', {
                opacity: 0,
                y: 50,
                duration: 1,
                ease: 'power3.out',
                delay: 0.3
            });

            gsap.from('.recipe-feed__filter-button', {
                opacity: 0,
                y: 20,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.6
            });

            gsap.from('.recipe-card', {
                opacity: 0,
                y: 50,
                duration: 0.8,
                stagger: 0.2,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '.recipe-feed__grid',
                    start: 'top 80%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let isFetching = false;

            function fetchRecipes() {
                if (isFetching) return;

                isFetching = true;

                fetch('../actions/fetch_recipes.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(response => {
                        if (response.status === 'error') {
                            throw new Error(response.message);
                        }

                        const recipes = response.data;
                        const recipeGrid = document.querySelector('.recipe-feed__grid');
                        recipeGrid.innerHTML = '';

                        if (recipes.length === 0) {
                            recipeGrid.innerHTML = '<p class="text-center text-gray-500 py-8">No recipes found</p>';
                            return;
                        }

                        recipes.forEach(recipe => {
                            const recipeCard = document.createElement('article');
                            recipeCard.className = 'recipe-card';
                            recipeCard.setAttribute('data-category', recipe.category.toLowerCase());

                            const imageUrl = recipe.image || 'RECIPE_SHARING/assets/images/default-recipe.jpg';
                            const recipeImage = document.createElement('img');
                            recipeImage.className = 'recipe-card__image';
                            recipeImage.alt = recipe.title;

                            // Add a flag to track if we've already tried the default image
                            recipeImage.dataset.usedDefaultImage = 'false';

                            recipeImage.onerror = function () {
                                if (this.dataset.usedDefaultImage === 'false') {
                                    this.dataset.usedDefaultImage = 'true';
                                    this.src = 'RECIPE_SHARING/assets/images/default-recipe.jpg';
                                } else {
                                    this.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBkb21pbmFudC1iYXNlbGluZT0ibWlkZGxlIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOTk5Ij5ObyBJbWFnZTwvdGV4dD48L3N2Zz4=';
                                    this.onerror = null; // Remove the error handler entirely
                                }
                            };

                            recipeImage.src = imageUrl;

                            const contentDiv = document.createElement('div');
                            contentDiv.className = 'recipe-card__content';
                            contentDiv.innerHTML = `
                        <h3 class="recipe-card__title">${recipe.name}</h3>
                        <p class="recipe-card__description">${recipe.description}</p>
                        <div class="recipe-card__tags">
                            <span class="recipe-card__tag recipe-card__tag--${recipe.category.toLowerCase()}">${recipe.category}</span>
                            <span class="recipe-card__tag recipe-card__tag--${recipe.difficulty.toLowerCase()}">${recipe.difficulty}</span>
                        </div>
                    `;

                            recipeCard.appendChild(recipeImage);
                            recipeCard.appendChild(contentDiv);
                            recipeGrid.appendChild(recipeCard);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching recipes:', error);
                        const recipeGrid = document.querySelector('.recipe-feed__grid');
                        recipeGrid.innerHTML = `
                    <p class="text-center text-red-500 py-8">
                        Error loading recipes. Please try again later.
                    </p>
                `;
                    })
                    .finally(() => {
                        isFetching = false;
                    });
            }

            fetchRecipes();
        });
    </script>
</body>

</html>