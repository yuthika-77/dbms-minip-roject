<?php

require_once("connection.php");

if (isset($_POST['submit'])) {
    $TripType = $_POST['trip-type'];
    $FromLocation= $_POST['fromlocation'];
    $ToLocation = $_POST['tolocation'];
    $DepartureDate = $_POST['departure'];
    $ReturnDate = $_POST['return'];
    $Passengers = $_POST['passengers'];
    $Class = $_POST['class'];

    // Prepare the query to check for flights
    $check_query = "SELECT * FROM flight WHERE Trip_type='$TripType' AND Departure_date='$DepartureDate' AND To_location='$ToLocation' AND From_location='$FromLocation'";
    $result = mysqli_query($con, $check_query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the first matching flight
        $row = mysqli_fetch_array($result);
        $Fid = $row['F_id'];

        // Get Arrival and Departure times for the flight
        $get_query = "SELECT Arrival_time, Departure_time FROM flight WHERE F_id='$Fid'";
        $getres = mysqli_query($con, $get_query);

        if ($getres) {
            $getrow = mysqli_fetch_array($getres);
            $DepartureTime = $getrow['Departure_time']; // Correctly access the array
            $ArrivalTime = $getrow['Arrival_time']; // Correctly access the array

            echo '<div class="flights-available">
                <div class="details">
                    <p><strong>Flights Available</strong></p>
                    <p>From: '.$FromLocation.'</p>
                    <p>Departure Time: '.$DepartureTime.'</p>
                    <p>To: '.$ToLocation.'</p>
                    <p>Arrival Time: '.$ArrivalTime.'</p>
                </div>
            </div>';
        } else {
            echo "Error retrieving flight times.";
        }
    } else {
        echo "No flights found for your search criteria.";
    }
} else {
    echo "Form not submitted.";
}
?>


