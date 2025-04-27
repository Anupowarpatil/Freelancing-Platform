<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KaryaSetu - Authentication</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    :root {
      --primary-color: #1e90ff;
      --secondary-color: #6a5acd;
      --bg-light: #f5f7fa;
      --text-dark: #333;
      --text-light: #777;
      --transition: 0.3s ease-in-out;
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-dark);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    .container {
      max-width: 1000px;
      width: 100%;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-wrap: wrap;
      position: relative;
    }
    .form-container {
      flex: 1;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      max-width: 400px;
      width: 100%;
    }
    h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: var(--primary-color);
      text-align: center;
    }
    form {
      width: 100%;
      display: flex;
      flex-direction: column;
    }
    input {
      padding: 12px 15px;
      margin-bottom: 15px;
      border-radius: 30px;
      border: 1px solid #ccc;
      transition: var(--transition);
      font-size: 1rem;
    }
    input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 5px rgba(30, 144, 255, 0.5);
    }
    button {
      padding: 12px;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 30px;
      font-size: 1rem;
      cursor: pointer;
      transition: var(--transition);
    }
    button:hover {
      background: var(--secondary-color);
      transform: translateY(-2px);
    }
    .toggle-buttons {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      gap: 10px;
    }
    .toggle-buttons button {
      background: var(--bg-light);
      color: var(--primary-color);
      border: 1px solid var(--primary-color);
      border-radius: 30px;
      padding: 8px 20px;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition);
    }
    .toggle-buttons button.active,
    .toggle-buttons button:hover {
      background: var(--primary-color);
      color: white;
    }
    .message {
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
    }
    .message.error {
      color: red;
    }
    .message.success {
      color: green;
    }
    .hidden {
      display: none;
    }
    .social-login {
      margin-top: 20px;
      text-align: center;
    }
    .social-login p {
      font-size: 0.9rem;
      color: var(--text-light);
      margin-bottom: 15px;
    }
    .social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    .social-icons a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: var(--bg-light);
      border-radius: 50%;
      color: var(--text-dark);
      transition: var(--transition);
    }
    .social-icons a:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container">
      <div class="toggle-buttons">
        <button id="loginBtn" class="active">Log In</button>
        <button id="signupBtn">Sign Up</button>
      </div>
      <div id="loginForm">
        <h2>Welcome Back</h2>
        <?php
          if (isset($_SESSION['error_login'])) {
            echo '<div class="message error">' . $_SESSION['error_login'] . '</div>';
            unset($_SESSION['error_login']);
          }
          if (isset($_SESSION['success_login'])) {
            echo '<div class="message success">' . $_SESSION['success_login'] . '</div>';
            unset($_SESSION['success_login']);
          }
        ?>
        <form method="POST" action="backend/login.php">
          <input type="email" name="email" placeholder="Email Address" required />
          <input type="password" name="password" placeholder="Password" required />
          <button type="submit">Log In</button>
        </form>
        <div class="social-login">
          <p>Or log in with</p>
          <div class="social-icons">
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
      </div>
      <div id="signupForm" class="hidden">
        <h2>Create Account</h2>
        <?php
          if (isset($_SESSION['error_signup'])) {
            echo '<div class="message error">' . $_SESSION['error_signup'] . '</div>';
            unset($_SESSION['error_signup']);
          }
          if (isset($_SESSION['success_signup'])) {
            echo '<div class="message success">' . $_SESSION['success_signup'] . '</div>';
            unset($_SESSION['success_signup']);
          }
        ?>
        <form method="POST" action="backend/signup.php">
          <input type="text" name="fullname" placeholder="Full Name" required />
          <input type="email" name="email" placeholder="Email Address" required />
          <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="freelancer">Freelancer</option>
            <option value="company">Company</option>
          </select>
          <input type="password" name="password" placeholder="Password" required />
          <input type="password" name="confirm_password" placeholder="Confirm Password" required />
          <button type="submit">Sign Up</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    const loginBtn = document.getElementById('loginBtn');
    const signupBtn = document.getElementById('signupBtn');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    loginBtn.addEventListener('click', () => {
      loginBtn.classList.add('active');
      signupBtn.classList.remove('active');
      loginForm.classList.remove('hidden');
      signupForm.classList.add('hidden');
    });

    signupBtn.addEventListener('click', () => {
      signupBtn.classList.add('active');
      loginBtn.classList.remove('active');
      signupForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
    });
  </script>
</body>
</html>
