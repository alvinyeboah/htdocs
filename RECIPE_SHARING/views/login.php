<?php
session_start();
$redirectReason = isset($_SESSION['redirect_reason']) ? $_SESSION['redirect_reason'] : '';
$signoutMessage = isset($_SESSION['signout']) ? $_SESSION['signout'] : '';
unset($_SESSION['redirect_reason']);
unset($_SESSION['signout']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tasty Bytes - Login/Signup</title>
  <link rel="stylesheet" href="../assets/css/auth.css" />
  <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
</head>

<body>
  <div class="left-section">
    <img id="imageSwitcher" src="../assets/images/img1.jpg" alt="Background Image" />
  </div>
  <div class="right-section">
    <div class="tab-switch">
      <button id="loginTab" class="active">Log In</button>
      <button id="signupTab">Sign Up</button>
    </div>
    <div class="login-page">
      <p id="login-text">Log In</p>
      <div class="button-container">
        <a href="../Assignment2/index.html" class="button-icon disabled">
          <ion-icon id="facebook" name="logo-facebook"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
        <a href="../Assignment2/index.html" class="button-icon disabled">
          <ion-icon id="twitter" name="logo-twitter"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
        <a href="../Assignment2/index.html" class="button-icon disabled">
          <ion-icon id="github" name="logo-github"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
        <a href="../Assignment2/index.html" class="button-icon disabled">
          <ion-icon id="google" name="logo-google"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
      </div>
      <div class="division">
        <hr />
        <span>Or</span>
        <hr />
      </div>
      <form action="../actions/login.php" method="post">
        <div class="input-wrapper">
          <label for="email">Email</label>
          <input placeholder="Email address" name="email" type="email" id="email" />
        </div>
        <div class="input-wrapper">
          <label for="password">Password</label>
          <input placeholder="Password" type="password" name="password" id="password" />
        </div>
        <div class="form-bottom">
          <div class="rememberme">
            <input type="checkbox" id="rememberMe" />
            <label for="rememberMe">Remember Me</label>
          </div>
          <a href="#">Forgot Password?</a>
        </div>
        <button value="submit" type="submit">Log In</button>
      </form>
    </div>
    <div class="signup-page">
      <p id="login-text">Sign Up</p>
      <div class="button-container">
        <a href="#" class="button-icon disabled">
          <ion-icon id="facebook" name="logo-facebook"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
        <a href="#" class="button-icon disabled">
          <ion-icon id="twitter" name="logo-twitter"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
        <a href="#" class="button-icon disabled">
          <ion-icon id="github" name="logo-github"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
        <a href="#" class="button-icon disabled">
          <ion-icon id="google" name="logo-google"></ion-icon>
          <span class="tooltip">Feature not available</span>
        </a>
      </div>
      <div class="division">
        <hr />
        <span>Or</span>
        <hr />
      </div>
      <form action="../actions/register.php" method="post">
        <div class="names">
          <div class="input-wrapper">
            <label for="fName">First Name</label>
            <input placeholder="Alvin" type="text" id="fname" />
          </div>
          <div class="input-wrapper">
            <label for="lName">Last Name</label>
            <input placeholder="Yeboah" type="text" id="lname" />
          </div>
        </div>
        <div class="input-wrapper">
          <label for="email1">Email</label>
          <input placeholder="xxxx@xxxx.com" type="email" id="email1" />
        </div>
        <div class="input-wrapper">
          <label for="register-password">Password</label>
          <input placeholder="*******" type="password" id="register-password" />
        </div>
        <div class="input-wrapper">
          <label for="confirmPassword">Confirm Password</label>
          <input placeholder="*******" type="password" id="confirmPassword" />
        </div>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <script src="sweetalert2.all.min.js"></script>
  <script src="../utils/session.js"></script>
  <script>
    const notyf = new Notyf();
    const signoutMessage = <?php echo json_encode($signoutMessage); ?>;
    if (signoutMessage) {
        const notyf = new Notyf();
        notyf.success(signoutMessage);
    }
  </script>
  <script src="../assets/js/auth.js"></script>
  <script src="../assets/js/authvalidation.js"></script>
</body>

</html>