<?php
require_once("connection.php");

if (isset($_POST['submit'])) {
    // Retrieve all passenger details from the form
    $fnames = $_POST['fname'];
    $lnames = $_POST['lname'];
    $DOBs = $_POST['DOB'];
    $genders = $_POST['gender'];
    $emails = $_POST['email'];
    $phones = $_POST['phone'];
    $FlightID = $_POST['FlightID'];
    $Cost = $_POST['totalCost'];
    $pnr = $_POST['PNR'];

    // Fetch the flight price from the "flights" table
    $getprice = "SELECT Price FROM flights WHERE F_id = $FlightID";
    $result = mysqli_query($con, $getprice);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $price = $row['Price'];
    } else {
        echo "Error: Could not retrieve price for flight ID $FlightID.<br>";
        mysqli_close($con);
        exit;
    }

    // Calculate the total fare based on the price and passenger count
    $Total_fare = count($fnames) * $price;

    // Loop through each passenger and insert their details into the "passenger" table
    for ($i = 0; $i < count($fnames); $i++) {
        $fname = mysqli_real_escape_string($con, $fnames[$i]);
        $lname = mysqli_real_escape_string($con, $lnames[$i]);
        $DOB = mysqli_real_escape_string($con, $DOBs[$i]);
        $gender = mysqli_real_escape_string($con, $genders[$i]);
        $email = mysqli_real_escape_string($con, $emails[$i]);
        $phone = mysqli_real_escape_string($con, $phones[$i]);

        // SQL query to insert passenger details
        $query = "INSERT INTO passenger (Fname, Lname, DOB, Gender, Email, Phone, F_id, PNR) 
                  VALUES ('$fname', '$lname', '$DOB', '$gender', '$email', '$phone', '$FlightID', '$pnr')";

        if (!mysqli_query($con, $query)) {
            echo "Error: Could not add passenger $fname $lname. " . mysqli_error($con) . "<br>";
        }
    }

    // Insert the total fare into the "bill" table
    $insertbill = "INSERT INTO bill (PNR, Total_fare) VALUES ('$pnr', '$Total_fare')";
    
    if (mysqli_query($con, $insertbill)) {
        // Redirect to payment page if insertion is successful
        header("Location: payment.php");
    } else {
        echo "Error: Could not insert bill. " . mysqli_error($con) . "<br>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>
