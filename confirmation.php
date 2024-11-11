
<?php
require_once("connection.php");
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure that the username exists in the session
if (!isset($_SESSION['username'])) {
    die("Error: User not logged in.");
}

$name = $_SESSION['username']; // Username from session

// Prepare query to fetch user ID from the 'user' table
$query = "SELECT id FROM user WHERE username = ?";
$stmt = $con->prepare($query);

// Check if prepare() was successful
if ($stmt === false) {
    die('Error preparing statement (User ID fetch): ' . $con->error); // Debugging statement preparation error
}

// Bind parameter to the prepared statement
$stmt->bind_param("s", $name);

// Execute the statement and check if it works
$stmt->execute();
$res = $stmt->get_result(); // Get the result

// Check if the user exists
if ($res->num_rows > 0) {
    $user = $res->fetch_assoc(); // Fetch user data
    $user_id = $user['id']; // Get the user_id
} else {
    die("Error: User ID not found.");
}

// Fetch booking details along with flight details for the logged-in user
$query = "
    SELECT b.booking_id, b.pnr_number, b.booking_date, b.total_amount, b.status,
           f.Departure_time, f.From_location, f.To_location
    FROM booking b
    INNER JOIN flight f ON b.flight_id = f.F_id
    WHERE b.user_id = ?";
echo "SQL Query: $query";  // Output query for debugging
$stmt = $con->prepare($query);

// Check if prepare() was successful
if ($stmt === false) {
    die('Error preparing statement (Booking and Flight details fetch): ' . $con->error); // Debugging statement preparation error
}

// Bind the user_id to the query
$stmt->bind_param("i", $user_id);

// Execute the statement and get the result
$stmt->execute();
$res = $stmt->get_result(); // Get the result

// Initialize the $bookings array
$bookings = [];

// Check if any bookings were found
if ($res && $res->num_rows > 0) {
    while ($booking = $res->fetch_assoc()) {
        $bookings[] = $booking;
    }
} else {
    echo '<script>alert("No bookings found."); window.location.href="user.php";</script>';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .confirmation-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .confirmation-container h1 {
            color: #4CAF50;
        }
        .details {
            margin-top: 15px;
            text-align: left;
            font-size: 16px;
            color: #333;
        }
        .details p {
            margin: 8px 0;
        }
        .btn-group {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h1>Booking Confirmed!</h1>
    <p>Your booking has been confirmed. Thank you for choosing us!</p>

    <?php foreach ($bookings as $booking) : ?>
        <div class="details">
            <h2>Booking Details</h2>
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['booking_id']); ?></p>
            <p><strong>PNR Number:</strong> <?php echo htmlspecialchars($booking['pnr_number']); ?></p>
            <p><strong>Departure Time:</strong> <?php echo htmlspecialchars($booking['Departure_time']); ?></p>
            <p><strong>From Location:</strong> <?php echo htmlspecialchars($booking['From_location']); ?></p>
            <p><strong>To Location:</strong> <?php echo htmlspecialchars($booking['To_location']); ?></p>
            <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></p>
            <p><strong>Total Amount:</strong> $<?php echo number_format($booking['total_amount'], 2); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($booking['status'])); ?></p>
        </div>
        <hr>
    <?php endforeach; ?>

    <div class="btn-group">
        <a href="index.php" class="btn">Back to Home</a>
    </div>
</div>

</body>
</html>
