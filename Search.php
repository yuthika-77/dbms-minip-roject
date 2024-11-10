<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>GoOn Airline - Flight Search Results</title>
    <style>
        
        /* Header for flights available */
        .flights-available h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

         h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        /* Container for From and To sections */
        .details {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        /* Styling for the flight details */
        .details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Styling for each detail item */
        .details li {
            font-size: 20px;
            color: #555;
            margin-bottom: 10px;
            position: relative;
        }

        /* For the "From" and "To" sections */
        .To-dec, .From-dec {
            flex: 1;
            padding: 20px;
            text-align: left;
        }

        /* Titles for sections */
        .section-title {
            font-size: 22px;
            color: #007BFF;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }
    
    </style>
</head>
<body>
<header>
        <h1>GoOn Airline</h1>
        <p>The best journey starts with us...</p>
    </header>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html?login=user"); // Redirect to login page if not logged in
    exit;
}

require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data without sanitization
    $TripType = $_POST['trip-type'];
    $FromLocation = $_POST['from'];
    $ToLocation = $_POST['to'];
    $DepartureDate = $_POST['departure'];
    $Passengers = $_POST['passengers'];

    // If it's a round-trip, capture return date
    $ReturnDate = null;
    if ($TripType === 'round-trip' && !empty($_POST['return'])) {
        $ReturnDate = $_POST['return'];
    }

    // Store passenger count in session for later use in booking
    $_SESSION['passengerCount'] = $Passengers;

    // Define the SQL query for flight search
    $check_query = "
        SELECT F_no, Price, Departure_time, Arrival_time, From_location, To_location
        FROM flight
        WHERE Departure_date = '$DepartureDate'
        AND To_location = '$ToLocation'
        AND From_location = '$FromLocation'
        AND Availablity >= $Passengers
    ";

    $result = mysqli_query($con, $check_query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div class="login-container" style="width:auto;">
                <h2>Flight(s) Available</h2>';
        $i = 0;  // Initialize flight number counter
        while ($flight = mysqli_fetch_assoc($result)) {
            $i++;  // Increment the flight number for each flight
            $Fid = $flight['F_no'];
            $DepartureTime = $flight['Departure_time'];
            $ArrivalTime = $flight['Arrival_time'];
            $Price = $flight['Price'];

            // Display available flights with numbering
            echo '<div class="login-container">
                    <div class="details">
                        <div class="To-dec">
                            <div class="section-title">' . $i . ')From</div>
                            <ul>
                                <li>From Location: <strong>' . $FromLocation . '</strong></li>
                                <li>Departure Date: <strong>' . $DepartureDate . '</strong></li>
                                <li>Departure Time: <strong>' . $DepartureTime . '</strong></li>
                            </ul>
                        </div>
                        <div class="From-dec">
                            <div class="section-title">To</div>
                            <ul>
                                <li>To Location: <strong>' . $ToLocation . '</strong></li>';
            
            echo '<li>Arrival Time: <strong>' . $ArrivalTime . '</strong></li>
                                <li>Price: <strong>' . $Price . '</strong></li>
                            </ul>
                        </div>
                    </div>
                    </div>';

            // If it's a round trip, show return flight details
            if ($TripType === 'round-trip' && $ReturnDate) {
                $return_query = "
                    SELECT F_no, Price, Departure_time, Arrival_time, From_location, To_location
                    FROM flight
                    WHERE Departure_date = '$ReturnDate'
                    AND From_location = '$ToLocation'
                    AND To_location = '$FromLocation'
                    AND Availablity >= $Passengers
                ";

                $return_result = mysqli_query($con, $return_query);

                if ($return_result && mysqli_num_rows($return_result) > 0) {
                    echo '<h3>Return Flight</h3>';
                    while ($return_flight = mysqli_fetch_assoc($return_result)) {
                        $ReturnFid = $return_flight['F_no'];
                        $ReturnDepartureTime = $return_flight['Departure_time'];
                        $ReturnArrivalTime = $return_flight['Arrival_time'];
                        $ReturnPrice = $return_flight['Price'];

                        // Display return flight with numbering
                        echo '<div class="login-container" style="width:80%;">
                                <div class="details">
                                    <div class="To-dec">
                                        <div class="section-title">' . $i . '). Return From</div>
                                        <ul>
                                            <li>From Location: <strong>' . $ToLocation . '</strong></li>
                                            <li>Departure Date: <strong>' . $ReturnDate . '</strong></li>
                                            <li>Departure Time: <strong>' . $ReturnDepartureTime . '</strong></li>
                                        </ul>
                                    </div>
                                    <div class="From-dec">
                                        <div class="section-title">To</div>
                                        <ul>
                                            <li>To Location: <strong>' . $FromLocation . '</strong></li>
                                            <li>Arrival Time: <strong>' . $ReturnArrivalTime . '</strong></li>
                                            <li>Price: <strong>' . $ReturnPrice . '</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    echo "<p>No return flights found for your search criteria.</p>";
                }
            }

            // Add a selection button for booking the flight
            echo '<form action="booking.php" method="post">
                    <input type="hidden" name="FlightID" value="' . $Fid . '">
                    <input type="hidden" name="Price" value="' . $Price . '">
                    <button type="submit"class="button" >Select</button>
                </form>
            </div>
            ';
        }
    } else {
        echo "<p>No flights found for your search criteria.</p>";
    }
} else {
    echo "<p>Form not submitted correctly.</p>";
}
?>
<footer>
    <p>2024 Airline Reservation. All Rights Reserved.</p>
</footer>
</body>
</html>
