document.addEventListener('DOMContentLoaded', function() {
  const notyf = new Notyf({
      duration: 3000,
      position: {
          x: 'right',
          y: 'top'
      }
  });

  // DataTable initialization
  $('#recipesTable').DataTable({
      responsive: true,
      pageLength: 10,
      language: {
          search: 'Search recipes:',
          lengthMenu: 'Show _MENU_ entries'
      }
  });

  // Add Recipe Button
  document.getElementById('addRecipeBtn').addEventListener('click', function() {
      document.getElementById('modalTitle').textContent = 'Add New Recipe';
      document.getElementById('action').value = 'create';
      document.getElementById('recipeForm').reset();
      openModal();
  });

  // Edit Button Event Delegation
  document.querySelector('#recipesTable').addEventListener('click', function(e) {
      if (e.target.classList.contains('edit-btn')) {
          const recipeId = e.target.getAttribute('data-id');
          const recipeName = e.target.getAttribute('data-name');
          const recipeCategory = e.target.getAttribute('data-category');
          const recipeCookTime = e.target.getAttribute('data-cook-time');
          const recipeDescription = e.target.getAttribute('data-description');

          document.getElementById('modalTitle').textContent = 'Edit Recipe';
          document.getElementById('action').value = 'update';
          document.getElementById('recipeId').value = recipeId;
          document.getElementById('name').value = recipeName;
          document.getElementById('category').value = recipeCategory;
          document.getElementById('cook_time').value = recipeCookTime;
          document.getElementById('description').value = recipeDescription;
          
          openModal();
      }
  });

  // Delete Button Event Delegation
  document.querySelector('#recipesTable').addEventListener('click', function(e) {
      if (e.target.classList.contains('delete-btn')) {
          const recipeId = e.target.getAttribute('data-id');
          
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
                  const formData = new FormData();
                  formData.append('action', 'delete');
                  formData.append('id', recipeId);

                  fetch('../actions/recipe-admin.php', {
                      method: 'POST',
                      body: formData
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          notyf.success('Recipe deleted successfully');
                          setTimeout(() => location.reload(), 1000);
                      } else {
                          notyf.error(data.message || 'Failed to delete recipe');
                      }
                  })
                  .catch(error => {
                      notyf.error('An error occurred');
                      console.error('Error:', error);
                  });
              }
          });
      }
  });

  // Form Submission
  document.getElementById('recipeForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('../actions/recipe-admin.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              notyf.success(formData.get('action') === 'create' 
                  ? 'Recipe added successfully' 
                  : 'Recipe updated successfully');
              setTimeout(() => location.reload(), 1000);
          } else {
              notyf.error(data.message || 'Operation failed');
          }
      })
      .catch(error => {
          notyf.error('An error occurred');
          console.error('Error:', error);
      });
  });
});

// Modal Functions
function openModal() {
  document.getElementById('recipeModal').classList.remove('hidden');
}

function closeModal() {
  document.getElementById('recipeModal').classList.add('hidden');
}