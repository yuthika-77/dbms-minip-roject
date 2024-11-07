<?php
require_once("connection.php");

if (isset($_POST['submit_passenger'])) {
    // Retrieve all passenger details from the form
    $fnames = $_POST['fname'];
    $lnames = $_POST['lname'];
    $DOBs = $_POST['DOB'];
    $genders = $_POST['gender'];
    $emails = $_POST['email'];
    $phones = $_POST['phone'];
    $classarray=$_POST['class'];
    $FlightID=$_POST['FlightID'];
    // Loop through each passenger and insert their details into the database
    for ($i = 0; $i < count($fnames); $i++) {
        $fname = $fnames[$i];
        $lname = $lnames[$i];
        $DOB = $DOBs[$i];
        $gender = $genders[$i];
        $email = $emails[$i];
        $phone = $phones[$i];
        $class = $classarray[$i];

        $getprice="SELECT Price from flights where F_id= $FlightID";
        $run=mysqli_query($con,$getprice);
         
        
        // SQL query to insert passenger details into the "passenger" table
        $query = "INSERT INTO passenger (Fname, Lname, DOB, Gender, Email, Phone,F_id,class) 
                  VALUES ('$fname', '$lname', '$DOBs', '$gender', '$email', '$phone','$FlightID','$class')";
        $insertbill="INSERT into bill(Total_fare) VALUES ('$getprice')";
        
        // Execute the query
        if (mysqli_query($con, $query)) {
            header("location:payment.php");
        } else {
            echo "Error: Could not add passenger $fname $lname. " . mysqli_error($con) . "<br>";
        }
    }
    
    // Close the database connection
    mysqli_close($con);
}
?>
