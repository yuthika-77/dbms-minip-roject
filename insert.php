<?php
require_once("connection.php");

if (isset($_POST['submit_user'])) 
{
    // Check if any required fields are empty
    if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['uname']) || empty($_POST['age']) || empty($_POST['Gender']) || empty($_POST['phone']) || empty($_POST['pass1']) || empty($_POST['pass'])) 
    {
        echo "<script>alert('Please fill in all the fields.'); 
        window.location.href = 'Signup.html';</script>";
    } 
    else 
    {
        // Collect form data
        $UserFirst = $_POST['fname'];
        $UserLast = $_POST['lname'];
        $UserUsername = $_POST['uname'];
        $UserAge = $_POST['age'];
        $UserGender = $_POST['Gender'];
        $UserPhone = $_POST['phone'];
        $UserPassword = $_POST['pass'];
        $ConfirmPassword = $_POST['pass1'];
        $Email = $_POST['email'];

        // Validate that both passwords match
        if ($UserPassword !== $ConfirmPassword)
        { 
            echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'Signup.html';
            </script>";
        }
        else 
        { 
            // Check if the username, phone, or email already exists
            $checkQuery = "SELECT * FROM user WHERE username = '$UserUsername' OR phone = '$UserPhone' OR email='$Email'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (!$checkResult) {
                die("Query failed: " . mysqli_error($con)); // Debugging line
            }

            if (mysqli_num_rows($checkResult) > 0) 
            { 
                echo "<script>
                    alert('Username, phone number, or email already exists. Try again.');
                    window.location.href = 'Signup.html';
                </script>";
            } 
            else 
            {
                // SQL query to insert the data into the users table
                $query = "INSERT INTO user (first_name, last_name, username, age, password, gender, phone, email) 
                          VALUES ('$UserFirst', '$UserLast', '$UserUsername', '$UserAge', '$UserPassword', '$UserGender', '$UserPhone', '$Email')";

                // Execute the query
                $result = mysqli_query($con, $query);

                if ($result)
                {
                    echo "<script>
                        alert('Sign up successful!');
                        window.location.href = 'index.html?login=user'; // Redirect to login page with query parameter
                    </script>";
                } 
                else
                {
                    echo "<script>alert('Error: Could not execute query.');</script>";
                }
            }
        }
    }
}
?>
