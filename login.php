<?php
require_once("connection.php");
session_start();

if (isset($_POST['submit'])) {
    // Check if username and password are filled
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>
            alert('Please fill in all fields.');
            window.location.href = 'index.html'; // Redirect to login page
        </script>";
        exit;
    }

    // Directly get the inputs without escaping
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query to find the user
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username; // Start session if user is found
        echo "<script>
            alert('Welcome, $username!');
            window.location.href = 'user.html'; // Redirect to the home page
        </script>";
    } else {
        echo "<script>
            alert('Invalid username or password. Please try again.');
            // Redirect to user login form instead of the prompt box
            window.location.href = 'index.html#userLogin'; // Redirect to the user login section
        </script>";
    }
} else {
    // Clear inputs when returning to the login page
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        });
    </script>";
}
?>
