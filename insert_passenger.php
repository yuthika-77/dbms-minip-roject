<?php
session_start();
require_once("connection.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html?login=user"); // Redirect to login page if not logged in
    exit;
}

// Retrieve the FlightID from the session
if (isset($_SESSION['FlightID'])) {
    $F_id = $_SESSION['FlightID']; // Get the FlightID from the session
} else {
    echo "No flight selected.";
    exit;
}

// Retrieve the passenger details from the form
$firstNames = $_POST['fname'];  // Array of first names
$lastNames = $_POST['lname'];   // Array of last names
$dob = $_POST['DOB'];           // Array of dates of birth
$genders = $_POST['gender'];    // Array of genders
$passportNos = $_POST['passport_no'];  // Array of passport numbers
$classes = $_POST['class'];     // Array of selected classes
$email = $_POST['email'];       // Email
$phone = $_POST['phone'];       // Phone number
$totalPrice = $_POST['totalPrice']; // Total price calculated

// Insert each passenger into the database
for ($i = 0; $i < count($firstNames); $i++) {
    $fname = mysqli_real_escape_string($con, $firstNames[$i]);
    $lname = mysqli_real_escape_string($con, $lastNames[$i]);
    $dateOfBirth = mysqli_real_escape_string($con, $dob[$i]);
    $gender = mysqli_real_escape_string($con, $genders[$i]);
    $passportNo = mysqli_real_escape_string($con, $passportNos[$i]);
    $class = mysqli_real_escape_string($con, $classes[$i]);

    // Generate a unique PNR code for each passenger
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pnr = substr(str_shuffle($characters), 0, 6);

    // Insert the passenger data into the database
    $query = "INSERT INTO passengers (F_id, PNR, first_name, last_name, date_of_birth, gender, passport_no, class, email, phone, total_price) 
              VALUES ('$F_id', '$pnr', '$fname', '$lname', '$dateOfBirth', '$gender', '$passportNo', '$class', '$email', '$phone', '$totalPrice')";

    if (!mysqli_query($con, $query)) {
        echo "Error inserting passenger details: " . mysqli_error($con);
        exit;
    }
}

// Clear the session data after inserting the details
unset($_SESSION['FlightID']);  // Remove the FlightID from session

// Redirect to a confirmation page or success page
header("Location: confirmation.php?status=success");
exit;
?>
