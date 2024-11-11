<?php
require_once("connection.php");

// Query to fetch all flights from the database
$query = "SELECT * FROM flight";
$result = mysqli_query($con, $query);
$rowcount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>GoOn Airline - View Flights</title>
    <style>
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        
    </style>
</head>
<body>

<header>
    <h1>GoOn Airline</h1>
    <p>The best journey starts with us...</p>
</header>

<div class="login-container" style="width:auto;height:auto;">
    <h3>View Flights</h3>
    <center>
        <div class="login-container"style="width:auto;height:auto;">
            <h3>Flight List</h3>
            <table>
                <tr>
                    <th>Serial No.</th>
                    <th>Flight Id</th>
                    <th>Flight No</th>
                    <th>From Location</th>
                    <th>To Location</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Price Economy</th>
                    <th>Price Business</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($rowcount > 0) {
                    $serial = 1; // Initialize serial number
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['F_id'];
                        $Fno = $row['F_no'];
                        $from = $row['From_location'];
                        $to = $row['To_location'];
                        $deptd = $row['Departure_date'];
                        $dt = $row['Departure_time'];
                        $at = $row['Arrival_time'];
                        $price_eco = $row['P_eco']; // Price
                        $price_bus= $row['P_bus']; // Price
                        ?>
                        <tr>
                            <td><?php echo $serial++; ?></td>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $Fno; ?></td>
                            <td><?php echo $from; ?></td>
                            <td><?php echo $to; ?></td>
                            <td><?php echo $deptd; ?></td>
                            <td><?php echo $dt; ?></td>
                            <td><?php echo $at; ?></td>
                            <td><?php echo $price_eco; ?></td>
                            <td><?php echo $price_bus; ?></td>
                            <td>
                                <a href="editflight.php?GetID=<?php echo trim($id); ?>">Edit</a>
                                <a href="deleteflight.php?Del=<?php echo trim($id); ?>">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="10" style="color:red; font-size:20px;">
                            <center><h4 style="font-weight:bolder">Sorry, No Records To View</h4></center>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <br /><br />
            <!-- Add Flight button -->
           
        </div>
    </center>
    <button onclick="window.location.href='AddFlight.html'">Add Flight</button>
    <button onclick="window.location.href='admin.php'">Back to Dashboard</button>
</div>
<footer>
        <p>2024 Airline Reservation. All Rights Reserved.</p>
    </footer>
</body>
</html>
