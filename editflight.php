<?php 
require_once("connection.php");

$UserID = (int)$_GET['GetID']; // Ensure it's an integer to prevent SQL injection
$query = "SELECT * FROM flight WHERE F_id = $UserID"; // Direct query using the sanitized $UserID
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $id = $row['F_id'];
    $Fno = $row['F_no'];
    $from = $row['From_location'];
    $to = $row['To_location'];
    $deptd = $row['Departure_date'];
    $dt = $row['Departure_time'];
    $at = $row['Arrival_time'];
    $price = $row['Price']; // Price
} else {
    // Handle case where no flight is found
    echo "<script>alert('Flight not available.');</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>GoOn Airline-Edit Flight</title>
</head>
<body>
<header>
    <h1>GoOn Airline</h1>
    <p>The best journey starts with us...</p>
</header>
<div class="login-container" style="width:auto;height:auto;">
    <h2>Update Flight</h2>
    <div class="login-container"style="width:auto;height:auto;">
    <form  method="post">
        <h3>Flight Id: <?php echo $id; ?></h3>
        <label for="f_no">Flight Number:</label>
        <input type="text" id="f_no" name="f_no" value="<?php echo htmlspecialchars($Fno); ?>" required><br><br>

        <label for="departure_date">Departure Date:</label>
        <input type="date" id="departure_date" name="departure_date" value="<?php echo htmlspecialchars($deptd); ?>" required><br><br>

        <label for="from_location">From Location:</label>
        <input type="text" id="from_location" name="from_location" value="<?php echo htmlspecialchars($from); ?>" required><br><br>

        <label for="to_location">To Location:</label>
        <input type="text" id="to_location" name="to_location" value="<?php echo htmlspecialchars($to); ?>" required><br><br>

        <label for="departure_time">Departure Time:</label>
        <input type="time" id="departure_time" name="departure_time" value="<?php echo htmlspecialchars($dt); ?>" required><br><br>

        <label for="arrival_time">Arrival Time:</label>
        <input type="time" id="arrival_time" name="arrival_time" value="<?php echo htmlspecialchars($at); ?>" required><br><br>

        <label for="price">Base Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required><br><br>
</div>
        <button type="submit" name="update">Update</button>
        <button type="reset" name="reset">Cancel</button>
    </form>
    <button onclick="window.location.href='admin.php'">Back to Dashboard</button>
</div>

<footer>
    <p>&copy; 2024 GoOn Airline. All Rights Reserved.</p>
</footer>
</body>
</html>
<?php

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
            } 
                else {
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
if (isset($_POST['update'])) {
    // Sanitize and collect form data
    $FlightNo = mysqli_real_escape_string($con, $_POST['f_no']);
    $From = mysqli_real_escape_string($con, $_POST['from_location']);
    $To = mysqli_real_escape_string($con, $_POST['to_location']);
    $ArrivalTime = mysqli_real_escape_string($con, $_POST['arrival_time']);
    $DepartureTime = mysqli_real_escape_string($con, $_POST['departure_time']);
    $DepartureDate = mysqli_real_escape_string($con, $_POST['departure_date']);
    $Price = mysqli_real_escape_string($con, $_POST['price']);

    // Update query to update the flight details
    $update_query = "UPDATE flight SET F_no='$FlightNo', From_location='$From', To_location='$To', Departure_date='$DepartureDate', Departure_time='$DepartureTime', Arrival_time='$ArrivalTime', Price='$Price' WHERE F_id='$UserID'";

    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        echo "<script>
            alert('Flight updated successfully.');
            window.location.href = 'viewflight.php'; // Redirect to view flight page
        </script>";
    } else {
        echo "<script>
            alert('Error updating flight: " . mysqli_error($con) . "');
            window.location.href = 'editflight.php?ID=$UserID'; // Stay on the update page
        </script>";
    }
}
?>
?>
