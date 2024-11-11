<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>GoOn Airline - Flight Search Results</title>
    <style>
        /* Additional styling */
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
        .details {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .details li {
            font-size: 20px;
            color: #555;
            margin-bottom: 10px;
        }
        .To-dec, .From-dec {
            flex: 1;
            padding: 20px;
            text-align: left;
        }
        .section-title {
            font-size: 22px;
            color: #007BFF;
            font-weight: bold;
            margin-bottom: 10px;
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
    header("Location: index.html?login=user");
    exit;
}

require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $TripType = $_POST['trip-type'];
    $FromLocation = $_POST['from'];
    $ToLocation = $_POST['to'];
    $DepartureDate = $_POST['departure'];
    $Passengers = $_POST['passengers'];
    $_SESSION['passengerCount'] = $Passengers;

    // Round-trip return date
    $ReturnDate = null;
    if ($TripType === 'round-trip' && !empty($_POST['return'])) {
        $ReturnDate = $_POST['return'];
    }

    // Query to find flights matching the search criteria
    $check_query = "
        SELECT F_no,F_id, p_eco, p_bus, Departure_time, Arrival_time, From_location, To_location 
        FROM flight 
        WHERE Departure_date = '$DepartureDate'
        AND From_location = '$FromLocation'
        AND To_location = '$ToLocation'
        
    ";

    $result = mysqli_query($con, $check_query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div class="flights-available"><h2>Flight(s) Available</h2>';
        $i = 0;
        while ($flight = mysqli_fetch_assoc($result)) {
            $i++;
            $Fid = $flight['F_id'];
            $Fno = $flight['F_no'];
            $DepartureTime = $flight['Departure_time'];
            $ArrivalTime = $flight['Arrival_time'];
            $PriceEco = $flight['p_eco'];
            $PriceBus = $flight['p_bus'];

            // Display flight details
            echo '<div class="login-container">
                    <div class="details">
                        <div class="To-dec">
                            <div class="section-title">' . $i . ') From</div>
                            <ul>
                                <li>From Location: <strong>' . $FromLocation . '</strong></li>
                                <li>Departure Date: <strong>' . $DepartureDate . '</strong></li>
                                <li>Departure Time: <strong>' . $DepartureTime . '</strong></li>
                            </ul>
                        </div>
                        <div class="From-dec">
                            <div class="section-title">To</div>
                            <ul>
                                <li>To Location: <strong>' . $ToLocation . '</strong></li>
                                <li>Arrival Time: <strong>' . $ArrivalTime . '</strong></li>
                                <li>Price (Economy): <strong>' . $PriceEco . '</strong></li>
                                <li>Price (Business): <strong>' . $PriceBus . '</strong></li>
                            </ul>
                        </div>
                    </div>';

            // If round-trip, show return flight
            if ($TripType === 'round-trip' && $ReturnDate) {
                $return_query = "
                    SELECT F_no,F_id, p_eco, p_bus, Departure_time, Arrival_time, From_location, To_location
                    FROM flight
                    WHERE Departure_date = '$ReturnDate'
                    AND From_location = '$ToLocation'
                    AND To_location = '$FromLocation'
                     
                ";

                $return_result = mysqli_query($con, $return_query);

                if ($return_result && mysqli_num_rows($return_result) > 0) {
                    echo '<h3>Return Flight</h3>';
                    while ($return_flight = mysqli_fetch_assoc($return_result)) {
                        $ReturnFid = $return_flight['F_id'];
                        $ReturnFno = $return_flight['F_no'];
                        $ReturnDepartureTime = $return_flight['Departure_time'];
                        $ReturnArrivalTime = $return_flight['Arrival_time'];
                        $ReturnPriceEco = $return_flight['p_eco'];
                        $ReturnPriceBus = $return_flight['p_bus'];

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
                                            <li>Price (Economy): <strong>' . $ReturnPriceEco . '</strong></li>
                                            <li>Price (Business): <strong>' . $ReturnPriceBus . '</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    echo "<p>No return flights found for your search criteria.</p>";
                }
            }

            // Button for booking flight
            echo '<form action="booking.php" method="post">
                    <input type="hidden" name="FlightID" value="' . $Fid . '">
                    <input type="hidden" name="PriceEco" value="' . $PriceEco . '">
                    <input type="hidden" name="PriceBus" value="' . $PriceBus . '">
                    <!-- Hidden field to pass the selected class -->
   
                    <button type="submit" class="button " name="select"  >Select</button>
                </form>
            </div>';
        }
        echo '</div>';
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
