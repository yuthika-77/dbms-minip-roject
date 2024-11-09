<?php
session_start();
include('connection.php');

// Fetch all flights
$query = "SELECT * FROM flight";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <h1>GoOn Airline</h1>
        <p>The best journey starts with us...</p>
        <nav>
            <a href="admin.html">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="login-container">
        <h1>Manage Flights</h1>
        <button><a href="add_flight.php">Add New Flight</a></button>
        <table>
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Total Seats</th>
                    <th>Available Seats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['f_no']; ?></td>
                        <td><?php echo $row['origin']; ?></td>
                        <td><?php echo $row['destination']; ?></td>
                        <td><?php echo $row['total_seats']; ?></td>
                        <td><?php echo $row['available_seats']; ?></td>
                        <td>
                            <a href="edit_flight.php?flight_id=<?php echo $row['f_id']; ?>">Edit</a>
                            <a href="delete_flight.php?flight_id=<?php echo $row['f_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
