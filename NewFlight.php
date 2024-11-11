<?php
require_once("connection.php");

if (isset($_POST['submit'])) {
    // Collect form data
    $FlightNo = mysqli_real_escape_string($con, $_POST['f_no']);  // Escape user input to prevent SQL injection issues
    $From = mysqli_real_escape_string($con, $_POST['from_location']);
    $To = mysqli_real_escape_string($con, $_POST['to_location']);
    $ArrivalTime = mysqli_real_escape_string($con, $_POST['arrival_time']);
    $DepartureTime = mysqli_real_escape_string($con, $_POST['departure_time']);
    $DepartureDate = mysqli_real_escape_string($con, $_POST['departure_date']);
    $Price = mysqli_real_escape_string($con, $_POST['price']);

    // Check if the flight number already exists in the database
    $check_query = "SELECT * FROM flight WHERE F_no = '$FlightNo'";
    $check_result = mysqli_query($con, $check_query);

    // If flight number already exists, alert the user
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>
            alert('Flight number already exists. Try again with a different flight number.');
            window.location.href = 'AddFlight.html'; // Redirect to the add flight page
        </script>";
        exit;  // Stop further execution
    }

    // Insert query to add the flight details
    $insert_query = "INSERT INTO flight (F_no, Departure_date, From_location, To_location, Arrival_time, Departure_time, Price)
                     VALUES ('$FlightNo', '$DepartureDate', '$From', '$To', '$ArrivalTime', '$DepartureTime', '$Price')";

    $insert_result = mysqli_query($con, $insert_query);

    // Check if the insert was successful
    if ($insert_result) {
        echo "<script>
            alert('Flight added successfully.');
            if (confirm('Want to add another flight?')) {
                window.location.href = 'AddFlight.html'; // Redirect to the add flight page
            } else {
                alert('Heading to view flights page.');
                window.location.href = 'viewflight.php'; // Redirect to view flights page
            }
        </script>";
    } else {
        echo "<script>
            alert('Flight not added due to errors.');
            window.location.href = 'AddFlight.html'; // Redirect to the add flight page
        </script>";
    }
}
?>
