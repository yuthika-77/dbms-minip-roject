<?php
// Admin authentication check
session_start();
require_once('connection.php');

// Check if the admin is logged in (session check)
if (!isset($_SESSION['submit']) !== true) {
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
    <style>
        

    
    
        .dropdown {
            padding:10px;
    margin:10px;
            position: center;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #e7f3ff;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #0088cc;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .admin-box {
            display: inline-block;
            margin: 10px;
            padding: 20px;
            background-color: rgba(231, 243, 255);
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            width: 50%;
            height: 50%;
        }

        ul {
            padding: 20px;
        }
        .suggestions-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.suggestions-list > li {
    margin: 15px 0;
}

.suggestions-list a {
    text-decoration: none;
    
    display: flex;
    align-items: center;
    transition: color 0.3s, transform 0.3s;
}

.suggestions-list a:hover {
    color: #0088cc;
    transform: translateX(5px);
}

.suggestions-list ul {
    list-style-type: none;
    padding-left: 20px;
    margin-top: 5px;
}

.suggestions-list li ul li a {
    
 
    transition: color 0.3s;
}

.suggestions-list li ul li a:hover {
    color: #0077b3;
}

/* Icons Styling */
.suggestions-list a::before {
    content: "🔹";
    margin-right: 8px;
    font-size: 20px;
}
    </style>
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <h1>GoOn Airline</h1>
        <p>The best journey starts with us...</p>
        <nav>
        <div class="dropdown">
            <a href="admin.php">Home</a>
    </div>
            <div class="dropdown">
                <a href="#">Manage Flights</a>
                <div class="dropdown-content">
                    <a href="AddFlight.html">Add Flight</a>
                    <a href="viewflight.php">View Flight</a>
                </div>
            </div>
            
            
            <div class="dropdown">
            <a href="logout.php">Logout</a>
    </div>
        </nav>
    </header>

    <div class="login-container" style="width:80%; height:auto; margin:5%">
        <h1>Welcome to the Admin Dashboard</h1>
        <div class="admin-box">
            <h2>Latest Report</h2>
            <h3>Total Flights: <?php echo getTotalFlights(); ?></h3>
            <h3>Total Bookings: <?php echo getTotalBookings(); ?></h3>
            <h3>Total Passengers: <?php echo getTotalPassengers(); ?></h3>
            <h3>Total Users: <?php echo getTotalUsers(); ?></h3>
        </div>
        <div class="admin-box">
    <h2>Task Bar</h2>
    <ul class="suggestions-list">
        <li>
            <a >
                ✈️ Manage Flights
            </a>
            <ul>
                <li><a href="AddFlight.html">➕ Add Flight</a></li>
                <li><a href="viewflight.php">👀 View Flight</a></li>
            </ul>
        </li>
        
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

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
?>
