<?php
require_once("connection.php");
session_start();

$error = ''; // Initialize error variable

if (isset($_POST['submit'])) {
    // Check if username and password are filled
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>
        alert( 'Please Fill the blanks.');
        window.location.href = 'index.html?login=user'; // Redirect to login page
    </script>";
    } else {
        // Escape input to prevent issues
        $username = mysqli_real_escape_string($con, trim($_POST['username']));
        $password = trim($_POST['password']);

        // Query to find the user
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['username'] = $username; // Start session if user is found
                echo "<script>
                alert( 'Welcome,$username.....');
                window.location.href = 'user.php'; // Redirect to login page
            </script>";
                exit;
            } else {echo "<script>
                alert( 'Username/Password  is invalid or User does not exist');
                window.location.href = 'index.html?login=user&clear=true'; // Redirect to login page
                
            </script>";
            }
        } else {
            echo "<script>alert('Cannot login');</script>";
        }
    }
}
?>