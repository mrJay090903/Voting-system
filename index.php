<?php
include 'database/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Voting System</title>
  <!-- Favicon -->
  <link rel="icon" href="../sslgvoting/components/image/logo.png" type="image/png">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- NextUI -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@nextui-org/theme@2.1.0/dist/theme.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@nextui-org/react@2.1.0/dist/index.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
  #loading {
    animation: fadeOut 5s ease-in-out forwards;
    /* 5s fade-out duration */
  }

  @keyframes fadeOut {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
      visibility: hidden;
    }
  }
  </style>
</head>

<body>

  <!-- Loading Logo -->
  <div id="loading" class="fixed inset-0 flex items-center justify-center bg-white z-50">
    <img src="components/image/logo.png" alt="Loading Logo" class="h-44 w-auto">
  </div>

  <?php
    include 'components/notification.php';
    
    if (isset($_GET['success'])) {
        echo showNotification($_GET['success']);
    }
    if (isset($_GET['error'])) {
        echo showNotification($_GET['error'], 'error');
    }
    ?>
  <div class="min-h-screen flex">
    <!-- Left Side - Illustration -->
    <div class="hidden lg:flex w-1/2 bg-gradient-to-tr from-blue-800 to-blue-500 i justify-around items-center">
      <div>
        <img src="./components/image/vote.gif" class="w-100" alt="Illustration">
      </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 bg-white flex items-center justify-center">
      <div class="max-w-md w-full p-6">
        <div class="text-right mb-6">
          <button id="loginBtn"
            class="text-gray-500 px-4 py-2 font-semibold transition-all duration-200 hover:text-blue-600 rounded-lg">Login</button>
          <button id="registerBtn"
            class="text-gray-500 px-4 py-2 font-semibold transition-all duration-200 hover:text-blue-600 rounded-lg">Register</button>
        </div>

        <!-- Login Form -->
        <div id="loginForm">
          <h1 class="text-3xl font-bold mb-2">Welcome!</h1>
          <h2 class="text-2xl mb-8">Sign Into Your Account</h2>
          <div class="flex justify-center space-x-4 mb-6">
            <button type="button" id="studentLoginBtn"
              class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold transition-all duration-200">
              Student
            </button>
            <button type="button" id="adminLoginBtn"
              class="px-4 py-2 text-gray-500 rounded-lg font-semibold transition-all duration-200">
              Admin
            </button>
          </div>

          <!-- Student Login Form -->
          <div id="studentLoginForm">
            <form action="auth/login.php" method="POST">
              <input type="hidden" name="user_type" value="student">
              <div class="space-y-4">
                <div>
                  <label class="block text-gray-600">Full Name</label>
                  <input type="text" name="full_name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your full name">
                </div>
                <div>
                  <label class="block text-gray-600">Student ID</label>
                  <input type="text" name="student_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your student ID">
                </div>
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <input type="checkbox" class="mr-2" id="remember">
                    <label for="remember">Remember me</label>
                  </div>
                  <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
                </div>
                <button type="submit"
                  class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                  Login
                </button>
              </div>
            </form>
          </div>

          <!-- Admin Login Form -->
          <div id="adminLoginForm" class="hidden">
            <form action="auth/login.php" method="POST">
              <input type="hidden" name="user_type" value="admin">
              <div class="space-y-4">
                <div>
                  <label class="block text-gray-600">Username</label>
                  <input type="text" name="username" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your username">
                </div>
                <div>
                  <label class="block text-gray-600">Password</label>
                  <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your password">
                </div>
                <button type="submit"
                  class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                  Login as Admin
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Register Form (Hidden by default) -->
        <div id="registerForm" class="hidden">
          <h1 class="text-3xl font-bold mb-2">Create Account</h1>
          <h2 class="text-2xl mb-8">Sign Up to Get Started</h2>
          <form action="auth/register.php" method="POST">
            <div class="space-y-4">
              <div>
                <label class="block text-gray-600">Student ID</label>
                <input type="text" name="student_id" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Enter your student ID">
              </div>
              <div>
                <label class="block text-gray-600">Full Name</label>
                <input type="text" name="full_name" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Enter your full name">
              </div>
              <div>
                <label class="block text-gray-600">Grade</label>
                <select name="grade" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <option value="">Select Grade</option>
                  <?php
                                    for($i = 7; $i <= 12; $i++) {
                                        echo "<option value='Grade $i'>Grade $i</option>";
                                    }
                                    ?>
                </select>
              </div>
              <div>
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Enter your email">
              </div>
              <div>
                <label class="block text-gray-600">Contact Number</label>
                <input type="tel" name="contact_number" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Enter your contact number">
              </div>
              <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Register
              </button>
            </div>
          </form>
        </div>

        <!-- Social Links -->
        <div class="mt-8">
          <div class="text-center text-gray-600 mb-4">Help & Support</div>
          <div class="flex justify-center space-x-4">
            <a href="#" class="text-gray-600 hover:text-blue-600"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-gray-600 hover:text-blue-400"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-600 hover:text-red-600"><i class="fab fa-google"></i></a>
            <a href="#" class="text-gray-600 hover:text-blue-700"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="text-gray-600 hover:text-red-600"><i class="fab fa-pinterest"></i></a>
            <a href="#" class="text-gray-600 hover:text-red-600"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  const loginBtn = document.getElementById('loginBtn');
  const registerBtn = document.getElementById('registerBtn');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  loginBtn.addEventListener('click', () => {
    loginForm.classList.remove('hidden');
    registerForm.classList.add('hidden');
    loginBtn.classList.add('bg-blue-600', 'text-white');
    loginBtn.classList.remove('text-gray-500', 'hover:text-blue-600');
    registerBtn.classList.add('text-gray-500', 'hover:text-blue-600');
    registerBtn.classList.remove('bg-blue-600', 'text-white');
  });

  registerBtn.addEventListener('click', () => {
    loginForm.classList.add('hidden');
    registerForm.classList.remove('hidden');
    registerBtn.classList.add('bg-blue-600', 'text-white');
    registerBtn.classList.remove('text-gray-500', 'hover:text-blue-600');
    loginBtn.classList.add('text-gray-500', 'hover:text-blue-600');
    loginBtn.classList.remove('bg-blue-600', 'text-white');
  });

  // Login type toggle
  const studentLoginBtn = document.getElementById('studentLoginBtn');
  const adminLoginBtn = document.getElementById('adminLoginBtn');
  const studentLoginForm = document.getElementById('studentLoginForm');
  const adminLoginForm = document.getElementById('adminLoginForm');

  studentLoginBtn.addEventListener('click', () => {
    studentLoginForm.classList.remove('hidden');
    adminLoginForm.classList.add('hidden');
    studentLoginBtn.classList.add('bg-blue-600', 'text-white');
    studentLoginBtn.classList.remove('text-gray-500');
    adminLoginBtn.classList.remove('bg-blue-600', 'text-white');
    adminLoginBtn.classList.add('text-gray-500');
  });

  adminLoginBtn.addEventListener('click', () => {
    adminLoginForm.classList.remove('hidden');
    studentLoginForm.classList.add('hidden');
    adminLoginBtn.classList.add('bg-blue-600', 'text-white');
    adminLoginBtn.classList.remove('text-gray-500');
    studentLoginBtn.classList.remove('bg-blue-600', 'text-white');
    studentLoginBtn.classList.add('text-gray-500');
  });

  // Wait for the window to load
  window.addEventListener('load', function() {
    // Set timeout to hide the loading screen after 5 seconds
    setTimeout(function() {
      // Hide the loading screen after it fades out
      document.getElementById('loading').style.display = 'none';
    }, 1000); // Matches the 5-second animation duration
  });
  </script>
</body>

</html>