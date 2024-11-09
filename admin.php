<?php
// Admin authentication check
session_start();
require_once('connection.php');

// Check if the admin is logged in (session check)
if (!isset($_SESSION['submit'])!== true) {
    // Redirect to login page if not logged in
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <h1>GoOn Airline</h1>
        <p>The best journey starts with us...</p>
        <nav>
            <a href="admin.html">Home</a>
            <a href="manage_flights.php">Manage Flights</a>
            <a href="manage_bookings.php">Manage Bookings</a>
            <a href="manage_passengers.php">Manage Passengers</a>
            <a href="manage_seats.php">Manage Seats</a>
            <a href="view_reports.php">View Reports</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    
    <div class="login-container" style="width:80%;">
        <h1>Welcome to the Admin Dashboard</h1>
        <div class="dashboard-overview">
            <p>Total Flights: <?php echo getTotalFlights(); ?></p>
            <p>Total Bookings: <?php echo getTotalBookings(); ?></p>
            <p>Total Passengers: <?php echo getTotalPassengers(); ?></p>
            <p>Total Users: <?php echo getUsers(); ?></p>
        </div>
        <div class="admin-functions">
            <h2>Admin Functions</h2>
            <ul>
                <li><a href="manage_flights.php">Manage Flights</a></li>
                <li><a href="manage_bookings.php">Manage Bookings</a></li>
                <li><a href="manage_passengers.php">Manage Passengers</a></li>
                <li><a href="manage_seats.php">Manage Seats</a></li>
                <li><a href="view_reports.php">View Reports</a></li>
            </ul>
        </div>
    </div>
    
    <footer>
        <p>2024 Airline Reservation. All Rights Reserved.</p>
    </footer>
</body>
</html>

<?php
// Helper functions to get counts from the database
function getTotalFlights() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM flight";
    $result = mysqli_query($con, $query);

    // Error handling if query fails
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getTotalBookings() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM booking";
    $result = mysqli_query($con, $query);

    // Error handling if query fails
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getTotalPassengers() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM passenger";
    $result = mysqli_query($con, $query);

    // Error handling if query fails
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
function getTotalUsers() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM user";
    $result = mysqli_query($con, $query);

    // Error handling if query fails
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
function getTotalAvailableSeats() {
    global $con;
    $query = "SELECT SUM(available_seats) AS total FROM flight";
    $result = mysqli_query($con, $query);

    // Error handling if query fails
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
?>
