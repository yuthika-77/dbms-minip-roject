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
    <form action="update.php?ID=<?php echo $id ?>" method="post">
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
