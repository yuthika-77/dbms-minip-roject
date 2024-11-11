<?php
session_start();
require_once("connection.php");

if (isset($_POST['submit'])) {
    // Retrieve all passenger details from the form
    $fnames = $_POST['fname'];
    $lnames = $_POST['lname'];
    $DOBs = $_POST['DOB'];
    $genders = $_POST['gender'];
    $emails = $_POST['email'];
    $phones = $_POST['phone'];
    $FlightIDs = $_POST['FlightID'];
    $total = $_POST['totalPrice'];
    $pnrs = $_POST['PNR'];
    
    // Ensure the user is logged in and retrieve the user ID
    if (!isset($_SESSION['username'])) {
        echo "Error: User not logged in.";
        exit;
    }

    // Fetch user ID using the username stored in the session
    $name = $_SESSION['username'];
    $stmt = $con->prepare("SELECT id FROM user WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
    } else {
        echo "Error: User ID not found.";
        exit;
    }

    // Get the current date for booking_date
    $booking_date = date("Y-m-d H:i:s"); // Current timestamp

    // Insert booking details into the "booking" table
    $query_booking = "INSERT INTO booking (user_id, flight_id, booking_date, total_amount, status) 
                      VALUES ('$user_id', '$FlightIDs[0]', '$booking_date', '$total', 'pending')";
    
    if (mysqli_query($con, $query_booking)) {
        // Loop through each passenger and insert their details into the "passenger" table
        for ($i = 0; $i < count($fnames); $i++) {
            $fname = mysqli_real_escape_string($con, $fnames[$i]);
            $lname = mysqli_real_escape_string($con, $lnames[$i]);
            $DOB = mysqli_real_escape_string($con, $DOBs[$i]);
            $gender = mysqli_real_escape_string($con, $genders[$i]);
            $email = mysqli_real_escape_string($con, $emails[$i]);
            $phone = mysqli_real_escape_string($con, $phones[$i]);
            $Fid = mysqli_real_escape_string($con, $FlightIDs[$i]);
            $pnr = mysqli_real_escape_string($con, $pnrs[$i]);

            // SQL query to insert passenger details
            $query_passenger = "INSERT INTO passenger (Fname, Lname, DOB, Gender, Email, Phone, F_id, PNR) 
                                VALUES ('$fname', '$lname', '$DOB', '$gender', '$email', '$phone', '$Fid', '$pnr')";
            
            if (!mysqli_query($con, $query_passenger)) {
                echo "Error: Could not add passenger $fname $lname. " . mysqli_error($con) . "<br>";
            }
        }

        // Redirect to payment page or success page
        header("Location: payment.php");
    } else {
        echo "Error: Could not create booking. " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
