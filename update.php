             
<?php
require_once("connection.php");

$successMessage = "";

if (isset($_POST['update'])) {
    $flightID = $_GET['ID']; // Get the flight ID from the URL
    $flightNumber = $_POST['f_no'];
    $fromLocation = $_POST['from_location'];
    $toLocation = $_POST['to_location'];
    $departureDate = $_POST['departure_date'];
    $departureTime = $_POST['departure_time'];
    $arrivalTime = $_POST['arrival_time'];
    $price = $_POST['price'];

    // Update the record
    $query = "UPDATE flight SET F_no='$flightNumber', From_location='$fromLocation', To_location='$toLocation', Departure_date='$departureDate', Departure_time='$departureTime', Arrival_time='$arrivalTime', Price='$price' WHERE F_id='$flightID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>
            alert('Flight updated successfully.');
            
                alert('Heading to view flights page.');
                window.location.href = 'viewflight.php'; // Redirect to view flights page
        </script>";
    } else {
        echo "<script>
            alert('Flight not updated due to errors.');
            window.location.href = 'AddFlight.html'; // Redirect to the add flight page
        </script>";
    }
}

// Fetch existing flight data for the form
if (isset($_GET['ID'])) {
    $flightID = (int)$_GET['ID']; // Ensure it's an integer
    $query = "SELECT * FROM flight WHERE F_id = '$flightID'";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $flightNumber = $row['F_no'];
        $fromLocation = $row['From_location'];
        $toLocation = $row['To_location'];
        $departureDate = $row['Departure_date'];
        $departureTime = $row['Departure_time'];
        $arrivalTime = $row['Arrival_time'];
        $price = $row['Price'];
    } else {
        echo "Flight not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update Flight</title>
</head>
<body>
<header>
    <h1>GoOn Airline</h1>
    <p>The best journey starts with us...</p>
    
</header>

<div class="login-container">
    <h2>Update Flight</h2>
    <div class="login-container">
        <h3>Flight ID: <?php echo htmlspecialchars($flightID); ?></h3>
        <p>Flight Number: <?php echo htmlspecialchars($flightNumber); ?></p>
        <p>From Location: <?php echo htmlspecialchars($fromLocation); ?></p>
        <p>To Location: <?php echo htmlspecialchars($toLocation); ?></p>
        <p>Departure Date: <?php echo htmlspecialchars($departureDate); ?></p>
        <p>Departure Time: <?php echo htmlspecialchars($departureTime); ?></p>
        <p>Arrival Time: <?php echo htmlspecialchars($arrivalTime); ?></p>
        <p>Price: <?php echo htmlspecialchars($price); ?></p>
    </div>
    <button onclick="window.location.href='admin.php'">Back to Dashboard</button>
</div>

<footer>
    <p>&copy; 2024 GoOn Airline. All Rights Reserved.</p>
</footer>

</body>
</html>
