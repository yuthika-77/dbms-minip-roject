<?php
require_once("connection.php");

if (isset($_POST['submit'])) 
{
    // Check if any required fields are empty
    if (empty($_POST['fname']) ||empty($_POST['lname']) || empty($_POST['email']) ||empty($_POST['username']) || empty($_POST['age']) || empty($_POST['gender']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['password1'])) 
    {
        echo '<script>alert("Please fill in all the fields.")';
    } 
    else 
    {
         
        $UserFirst = $_POST['fname'];
        $UserLast = $_POST['lname'];
        $UserUsername = $_POST['username'];
        $UserAge = $_POST['age'];
        $UserGender = $_POST['Gender'];
        $UserPhone = $_POST['PhoneNumber'];
        $UserPassword = $_POST['password'];
        $ConfirmPassword = $_POST['password1'];

        // Validate that both passwords match
        if ($UserPassword !== $ConfirmPassword)
        { echo "<script>
            alert( 'Passwords do not match.');
            window.location.href = 'Signup.html'; // Redirect to login page
        </script>";
        }
        else 
        { 
            $checkQuery = "SELECT * FROM users WHERE username = '$UserUsername' OR phone_number = '$UserPhone' OR password='$UserPassword'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) 
            { echo "<script>
                alert( 'Username/Phone Number/Account/Password already exists. Try Again.');
                window.location.href = 'Signup.html'; // Redirect to login page
            </script>";
            } 
            else 
            {
                // SQL query to insert the data into the users table
                $query = "INSERT INTO users (Lname,Fname, username, age, password, gender, phone_number) VALUES ('$UserName', '$UserUsername', '$UserAge', '$UserPassword', '$UserGender', '$UserPhone')";

                // Execute the query
                $result = mysqli_query($con, $query);

                if ($result)
                {
                    echo "<script>
                    alert('Sign up successful!');
                    window.location.href = 'user.html'; // Redirect to login page
                </script>";
                } 
                else
                {
                    $error = 'Please check your query.';
                }
            }
        }
    }
}
?>