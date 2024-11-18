<?php
include '../actions/recipe-admin.php';
require_once '../utils/auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe Management</title>
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
    <?php
    require_once '../components/sidebar.php';
    ?>
    <div class="flex-1 flex flex-col overflow-hidden">
      <?php
      require_once '../components/header.php';
      ?>
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
        <div class="container mx-auto">
          <h2 class="text-2xl font-bold mb-4">Recipe Management</h2>
          <!-- Analytics Section -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <?php
            $totalRecipes = mysqli_num_rows(mysqli_query($connection, $userRole == 2 ? "SELECT * FROM recipes WHERE created_by = {$_SESSION['user_id']}" : "SELECT * FROM recipes"));
            $avgCookTime = mysqli_fetch_assoc(mysqli_query($connection, $userRole == 2 ? "SELECT AVG(CAST(REGEXP_REPLACE(cook_time, '[^0-9]', '') AS UNSIGNED)) as avg_time FROM recipes WHERE created_by = {$_SESSION['user_id']}" : "SELECT AVG(CAST(REGEXP_REPLACE(cook_time, '[^0-9]', '') AS UNSIGNED)) as avg_time FROM recipes"))['avg_time'];
            $categoryCount = mysqli_fetch_all(mysqli_query($connection, $userRole == 2 ? "SELECT category, COUNT(*) as count FROM recipes WHERE created_by = {$_SESSION['user_id']} GROUP BY category" : "SELECT category, COUNT(*) as count FROM recipes GROUP BY category"), MYSQLI_ASSOC);
            $recentTrend = mysqli_fetch_all(mysqli_query($connection, $userRole == 2 ? "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM recipes WHERE created_by = {$_SESSION['user_id']} GROUP BY month ORDER BY month DESC LIMIT 6" : "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM recipes GROUP BY month ORDER BY month DESC LIMIT 6"), MYSQLI_ASSOC);
            ?>

            <div class="bg-blue-50 p-4 rounded-lg shadow">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Recipes</p>
                  <h3 class="text-2xl font-bold text-blue-600"><?php echo $totalRecipes; ?></h3>
                </div>
                <div class="bg-blue-100 p-2 rounded-full">
                  <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg shadow">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Avg. Cook Time</p>
                  <h3 class="text-2xl font-bold text-green-600"><?php echo round($avgCookTime); ?> mins</h3>
                </div>
                <div class="bg-green-100 p-2 rounded-full">
                  <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-purple-50 p-4 rounded-lg shadow">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Categories</p>
                  <h3 class="text-2xl font-bold text-purple-600"><?php echo count($categoryCount); ?></h3>
                </div>
                <div class="bg-purple-100 p-2 rounded-full">
                  <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg shadow">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">This Month</p>
                  <h3 class="text-2xl font-bold text-yellow-600">
                    <?php
                    $currentMonth = date('Y-m');
                    $thisMonth = array_filter($recentTrend, function ($item) use ($currentMonth) {
                      return $item['month'] === $currentMonth;
                    });
                    echo !empty($thisMonth) ? reset($thisMonth)['count'] : 0;
                    ?>
                  </h3>
                </div>
                <div class="bg-yellow-100 p-2 rounded-full">
                  <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <!-- analytics end -->
          <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <button id="addRecipeBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
              Add New Recipe
            </button>
            <table id="recipesTable" class="w-full">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cook Time
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Difficulty
                  </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>

                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $query = "SELECT * FROM recipes";
                if ($userRole == 2) {
                  $userId = $_SESSION['user_id'];
                  $query .= " WHERE created_by = $userId";
                }
                $result = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['category']) . "</td>";
                  echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['description']) . "</td>";
                  echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['cook_time']) . "</td>";
                  echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['difficulty']) . "</td>";
                    echo "<td class='px-6 py-4 whitespace-nowrap'>
                                            <button class='text-blue-600 hover:text-blue-900 mr-2 edit-btn' data-id='" . $row['id'] . "' data-name='" . htmlspecialchars($row['name']) .
                      "' data-category='" . htmlspecialchars($row['category']) .
                      "' data-cook-time='" . htmlspecialchars($row['cook_time']) . "' data-description='" . htmlspecialchars($row['description']) . "'>Edit</button>
                                            <button class='text-red-600 hover:text-red-900 delete-btn' data-id='" . $row['id'] . "'>Delete</button>
                                          </td>";

                  echo "</tr>";
                }

                mysqli_close($connection);
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>

  <div id="recipeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg mx-4">
      <!-- Modal Header -->
      <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
        <h3 class="text-lg font-medium" id="modalTitle">
          Add New Recipe
        </h3>
        <button type="button" class="text-white hover:text-gray-200" onclick="closeModal()">
          &times;
        </button>
      </div>

      <!-- Modal Body -->
      <form id="recipeForm" method="POST" class="px-6 py-4 space-y-4">
        <!-- Hidden Fields -->
        <input type="hidden" id="recipeId" name="id">
        <input type="hidden" id="action" name="action" value="create">

        <!-- Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Recipe Name</label>
          <input type="text" name="name" id="name" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Category -->
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
          <input type="text" name="category" id="category" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Difficulty -->
        <div>
          <label for="difficulty" class="block text-sm font-medium text-gray-700">Difficulty</label>
          <select name="difficulty" id="difficulty" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
          </select>
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <!-- Cook Time -->
        <div>
          <label for="cook_time" class="block text-sm font-medium text-gray-700">Cook Time</label>
          <input type="text" name="cook_time" id="cook_time" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
      </form>

      <!-- Modal Footer -->
      <div class="bg-gray-50 px-6 py-4 flex justify-end gap-4">
        <button type="submit" form="recipeForm"
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const categoryData = <?php echo json_encode($categoryCount); ?>;
      const trendData = <?php echo json_encode(array_reverse($recentTrend)); ?>;
    });
  </script>
  <script src="../assets/js/recipes.js"></script>
</body>

</html>