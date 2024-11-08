<?php
require_once("connection.php");

if (isset($_POST['submit_user'])) 
{
    // Check if any required fields are empty
    if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['uname']) || empty($_POST['age']) || empty($_POST['Gender']) || empty($_POST['phone']) || empty($_POST['pass1']) || empty($_POST['pass'])) 
    {
        echo "<script>alert('Please fill in all the fields.'); window.location.href = 'Signup.html';</script>";
    } 
    else 
    {
        $UserFirst = $_POST['fname'];
        $UserLast = $_POST['lname'];
        $UserUsername = $_POST['username'];
        $UserAge = $_POST['age'];
        $UserGender = $_POST['gender']; // corrected to lowercase
        $UserPhone = $_POST['phone'];
        $UserPassword = $_POST['password'];
        $ConfirmPassword = $_POST['password1'];

        // Validate that both passwords match
        if ($UserPassword !== $ConfirmPassword)
        { 
            echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'Signup.html'; // Redirect to signup page
            </script>";
        }
        else 
        { 
            // Check if the username, phone, or password already exists
            $checkQuery = "SELECT * FROM users WHERE username = '$UserUsername' OR phone_number = '$UserPhone'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) 
            { 
                echo "<script>
                    alert('Username/Phone Number already exists. Try again.');
                    window.location.href = 'Signup.html';
                </script>";
            } 
            else 
            {
                // SQL query to insert the data into the users table
                $query = "INSERT INTO users (Lname, Fname, username, age, password, gender, phone_number) 
                          VALUES ('$UserLast', '$UserFirst', '$UserUsername', '$UserAge', '$UserPassword', '$UserGender', '$UserPhone')";

                // Execute the query
                $result = mysqli_query($con, $query);

                if ($result)
                {
                    echo "<script>
                        alert('Sign up successful!');
                        window.location.href = 'user.html'; // Redirect to user page
                    </script>";
                } 
                else
                {
                    echo "<script>alert('Error: Please check your query.');</script>";
                }
            }
        }
    }
}
?>
