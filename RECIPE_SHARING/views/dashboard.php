<?php
require_once '../utils/auth.php';
checkAuth();
$userRole = isset($_SESSION['role']) ? (int)$_SESSION['role'] : null;


require_once '../db/db.php';

?>
<!-- <div style="background-color: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">
    Debug Info:
    <pre>
    Session Data: <?php print_r($_SESSION); ?>
    User Role: <?php var_dump($userRole); ?>
    User Role Type: <?php echo gettype($userRole); ?>
    Role == 1: <?php var_dump($userRole == 1); ?>
    Role == 2: <?php var_dump($userRole == 2); ?>
    Role === 1: <?php var_dump($userRole === 1); ?>
    Role === 2: <?php var_dump($userRole === 2); ?>
    </pre>
</div> -->
<?php

function getDashboardStats($connection, $userRole) {
    $stats = [];
    $userQuery = "SELECT 
        COUNT(*) as total_users,
        COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as new_users_today,
        COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as new_users_week
    FROM users";
    $userResult = $connection->query($userQuery);
    $userStats = $userResult->fetch_assoc();
    
    // Recipe Stats
    $recipeQuery = "SELECT 
        COUNT(*) as total_recipes,
        AVG(cook_time) as avg_cook_time,
        COUNT(DISTINCT category) as total_categories,
        COUNT(DISTINCT difficulty) as difficulty_levels,
        COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as new_recipes_week,
        COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as new_recipes_today
    FROM recipes";
    $recipeResult = $connection->query($recipeQuery);
    $recipeStats = $recipeResult->fetch_assoc();
    
    $difficultyQuery = "SELECT difficulty, COUNT(*) as count 
        FROM recipes 
        GROUP BY difficulty";
    $difficultyResult = $connection->query($difficultyQuery);
    $difficultyStats = [];
    while ($row = $difficultyResult->fetch_assoc()) {
        $difficultyStats[$row['difficulty']] = $row['count'];
    }
    
    // Recent Activity (last 5 recipes)
    $recentQuery = "SELECT r.name, r.created_at, u.fname, u.lname 
        FROM recipes r 
        JOIN users u ON r.created_by = u.user_id 
        ORDER BY r.created_at DESC 
        LIMIT 5";
    $recentResult = $connection->query($recentQuery);
    $recentActivity = [];
    while ($row = $recentResult->fetch_assoc()) {
        $recentActivity[] = $row;
    }
    
    return [
        'users' => $userStats,
        'recipes' => $recipeStats,
        'difficulty' => $difficultyStats,
        'recent' => $recentActivity
    ];
}

$stats = getDashboardStats($connection, $userRole);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TastyBytes Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <?php include '../components/sidebar.php'; ?>
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include '../components/header.php'; ?>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <?php if ($userRole == 1 || $userRole == 2): // Changed from === to == ?>
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-2">Total Users</h2>
                        <p class="text-3xl font-bold text-blue-500"><?php echo number_format($stats['users']['total_users']); ?></p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-500 mr-2">+<?php echo $stats['users']['new_users_today']; ?></span>
                            <span class="text-gray-500">today</span>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-2">Total Recipes</h2>
                        <p class="text-3xl font-bold text-green-500"><?php echo number_format($stats['recipes']['total_recipes']); ?></p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-500 mr-2">+<?php echo $stats['recipes']['new_recipes_today']; ?></span>
                            <span class="text-gray-500">today</span>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-2">Avg. Cook Time</h2>
                        <p class="text-3xl font-bold text-purple-500"><?php echo round($stats['recipes']['avg_cook_time']); ?> min</p>
                        <div class="flex items-center mt-2">
                            <span class="text-gray-500">across all recipes</span>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-2">Categories</h2>
                        <p class="text-3xl font-bold text-yellow-500"><?php echo $stats['recipes']['total_categories']; ?></p>
                        <div class="flex items-center mt-2">
                            <span class="text-gray-500">recipe categories</span>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">Recipe Difficulty Distribution</h2>
                        <canvas id="difficultyChart"></canvas>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">Weekly Activity</h2>
                        <div class="flex justify-between items-center">
                            <div class="text-center p-4">
                                <p class="text-gray-600">New Users</p>
                                <p class="text-2xl font-bold text-blue-500">+<?php echo $stats['users']['new_users_week']; ?></p>
                            </div>
                            <div class="text-center p-4">
                                <p class="text-gray-600">New Recipes</p>
                                <p class="text-2xl font-bold text-green-500">+<?php echo $stats['recipes']['new_recipes_week']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Recent Recipes</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Recipe Name
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Created By
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['recent'] as $activity): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 font-medium text-gray-900"><?php echo htmlspecialchars($activity['name']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900"><?php echo htmlspecialchars($activity['fname'] . ' ' . $activity['lname']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                        <?php echo date('M d, Y', strtotime($activity['created_at'])); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php else: ?>
                <!-- Limited View for Regular Users -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Recipe Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-gray-600">Total Recipes</p>
                            <p class="text-2xl font-bold text-blue-500"><?php echo number_format($stats['recipes']['total_recipes']); ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Categories</p>
                            <p class="text-2xl font-bold text-green-500"><?php echo $stats['recipes']['total_categories']; ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Avg. Cook Time</p>
                            <p class="text-2xl font-bold text-purple-500"><?php echo round($stats['recipes']['avg_cook_time']); ?> min</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Recipes for Regular Users -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Recent Recipes</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Recipe Name
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Created By
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['recent'] as $activity): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 font-medium text-gray-900"><?php echo htmlspecialchars($activity['name']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900"><?php echo htmlspecialchars($activity['fname'] . ' ' . $activity['lname']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                        <?php echo date('M d, Y', strtotime($activity['created_at'])); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
    <script src="../assets/js/recipes.js"></script>
    <script src="../assets/js/dashboard.js"></script>


    <script>
    <?php if ($userRole == 1 || $userRole == 2): // Changed from === to == ?>
    const difficultyCtx = document.getElementById('difficultyChart').getContext('2d');
    new Chart(difficultyCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($stats['difficulty'])); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($stats['difficulty'])); ?>,
                backgroundColor: [
                    '#22C55E', // Easy - Green
                    '#EAB308', // Medium - Yellow
                    '#EF4444'  // Hard - Red
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    <?php endif; ?>
    </script>
</body>
</html>