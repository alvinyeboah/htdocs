$(document).ready(function () {
  const $loginForm = $(".login-page form");
  const $signupForm = $(".signup-page form");
  var notyf = new Notyf();

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }  

  function isValidPassword(password) {
    const minLength = 8;
    const uppercaseRegex = /[A-Z]/;
    const digitRegex = /\d/g;
    const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

    return (
      password.length >= minLength &&
      uppercaseRegex.test(password) &&
      (password.match(digitRegex) || []).length >= 1 &&
      specialCharRegex.test(password)
    );
  }

  function isValidName(name) {
    return name.length >= 2 && /^[a-zA-Z\s-]+$/.test(name);
  }

  // Error handling functions
  function showError($inputElement, message) {
    clearErrorForInput($inputElement);

    const $errorElement = $("<div>").addClass("error-message").text(message);
    $errorElement.css({ color: "red", fontSize: "12px", marginTop: "5px" });
    $inputElement.parent().append($errorElement);
    $inputElement.addClass("error");
  }

  function clearErrorForInput($inputElement) {
    $inputElement.parent().find(".error-message").remove();
    $inputElement.removeClass("error");
  }

  function clearErrors() {
    $(".error-message").remove();
    $(".error").removeClass("error");
  }

  // Show loading state
  function showLoading() {
    $('form button[type="submit"]').each(function () {
      $(this).prop("disabled", true);
      $(this).html('<span class="loading">Processing...</span>');
    });
  }

  // Hide loading state
  function hideLoading() {
    $('form button[type="submit"]').each(function () {
      $(this).prop("disabled", false);
      $(this).html($(this).data("original-text") || "Submit");
    });
  }

  async function handleLoginSubmit(event) {
    event.preventDefault();
    clearErrors();
    const $email = $("#email");
    const $password = $("#password");
    const $rememberMe = $("#rememberMe");
    let isValid = true;
    if (!$email.val()) {
      showError($email, "Please enter an email");
      isValid = false;
    } else if (!isValidEmail($email.val())) {
      showError($email, "Invalid email format");
      isValid = false;
    }
    if (!$password.val()) {
      showError($password, "Please enter your password");
      isValid = false;
    }

    if (isValid) {
      showLoading();
      try {
        const formData = new FormData();
        formData.append("email", $email.val());
        formData.append("password", $password.val());
        // formData.append('remember_me', $rememberMe.prop('checked'));

        const response = await fetch("../actions/login.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        if (result.success) {
          notyf.success(result.message);
          setTimeout(() => {
            window.location.href = result.redirect;
          }, 1000);
        } else {
          notyf.error(result.message);
        }
      } catch (error) {
        console.error("Login error:", error);
        notyf.error("An error occurred during login. Please try again.");
      } finally {
        hideLoading();
      }
    }
  }
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  // const status = getQueryParam("status");
  // if (status === "signed_out") {
  //   notyf.success("You have successfully signed out!");
  // }


  async function handleSignupSubmit(event) {
    event.preventDefault();
    clearErrors();

    const $fname = $("#fname");
    const $lname = $("#lname");
    const $email = $("#email1");
    const $password = $("#register-password");
    const $confirmPassword = $("#confirmPassword");
    let isValid = true;

    // First name validation
    if (!$fname.val()) {
      showError($fname, "First name is required");
      isValid = false;
    } else if (!isValidName($fname.val())) {
      showError($fname, "Please enter a valid first name");
      isValid = false;
    }

    // Last name validation
    if (!$lname.val()) {
      showError($lname, "Last name is required");
      isValid = false;
    } else if (!isValidName($lname.val())) {
      showError($lname, "Please enter a valid last name");
      isValid = false;
    }

    // Email validation
    if (!$email.val()) {
      showError($email, "Email is required");
      isValid = false;
    } else if (!isValidEmail($email.val())) {
      showError($email, "Invalid email format");
      isValid = false;
    }

    // Password validation
    if (!$password.val()) {
      showError($password, "Password is required");
      isValid = false;
    } else if (!isValidPassword($password.val())) {
      showError(
        $password,
        "Password must contain at least 8 characters, one uppercase letter, 1 digits, and one special character"
      );
      isValid = false;
    }

    // Confirm password validation
    if (!$confirmPassword.val()) {
      showError($confirmPassword, "Please confirm your password");
      isValid = false;
    } else if ($confirmPassword.val() !== $password.val()) {
      showError($confirmPassword, "Passwords do not match");
      isValid = false;
    }

    if (isValid) {
      showLoading();
      try {
        const formData = new FormData();
        formData.append("fname", $fname.val());
        formData.append("lname", $lname.val());
        formData.append("email1", $email.val()); // Changed from 'email' to 'email1' to match PHP
        formData.append("register-password", $password.val()); // Changed to match PHP expectation

        const response = await fetch("../actions/register.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        if (result.success) {
          notyf.success(result.message);
          setTimeout(() => {
            $("#loginTab").click();
            // Clear signup form
            $signupForm[0].reset();
          }, 1000);
        } else {
          notyf.error(result.message);
        }
      } catch (error) {
        console.error("Registration error:", error);
        notyf.error("An error occurred during registration. Please try again.");
      } finally {
        hideLoading();
      }
    }
  }

  // Real-time password strength indicator
  function updatePasswordStrength(password) {
    const $strengthBar = $("#passwordStrength");
    if ($strengthBar.length === 0) return;

    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]{3,}/.test(password)) strength++;
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) strength++;

    const strengthText = ["Weak", "Medium", "Strong", "Very Strong"];
    const strengthColors = ["#ff4d4d", "#ffd700", "#90EE90", "#00ff00"];

    $strengthBar.css("width", `${(strength / 4) * 100}%`);
    $strengthBar.css("backgroundColor", strengthColors[strength - 1] || "#ddd");
    $strengthBar.text(strength > 0 ? strengthText[strength - 1] : "");
  }

  // Event listeners
  if ($loginForm.length > 0) {
    $loginForm.on("submit", handleLoginSubmit);
  }

  if ($signupForm.length > 0) {
    $signupForm.on("submit", handleSignupSubmit);

    // Add real-time password strength indicator
    const $passwordInput = $("#password1");
    if ($passwordInput.length > 0) {
      $passwordInput.on("input", (e) => {
        updatePasswordStrength(e.target.value);
      });
    }
  }

  // Save original button text
  $('form button[type="submit"]').each(function () {
    $(this).data("original-text", $(this).html());
  });
});
