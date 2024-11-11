<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>GoOn Airline - Booking</title>
    <style>
        /* Outer login container for the entire form */
        #outer {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 150%; /* Set the width to a larger size for outer container */
        }

        /* Inner login container for each passenger or details */
        .login-container {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: auto; /* Inner container should be smaller */
        }

        /* Group input fields within each container */
        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Button styling */
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
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
require_once("connection.php");

// Get the passenger count from the session
$passengerCount = $_SESSION['passengerCount'];

if (!isset($_SESSION['username'])) {
    header("Location: index.html?login=user"); // Redirect to login page if not logged in
    exit;
}

if (isset($_POST['select'])) {
    // Generate PNR code
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pnr = substr(str_shuffle($characters), 0, 6);

    // Get the flight ID 
    $F_id = $_POST['FlightID'];
    
    // Fetch the price based on the class (p_eco or p_bus)
    $query = "SELECT p_eco, p_bus FROM flight WHERE F_no = '$F_id'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $flight = mysqli_fetch_assoc($result);
        // Get the price for the selected class
        $ecoPrice = $flight['p_eco'];
        $busPrice = $flight['p_bus'];
    }

    // Begin the form to collect passenger details
    echo '<form method="post" action="insert_passenger.php" onsubmit="return validateForm()">';

    // Outer container to wrap everything (with proper styling)
    echo '<div class="login-container" id="outer">';

    // Initialize total price to 0
    $totalPrice = 0;

    // Loop through passenger count and display fields for each passenger within their own container
    for ($i = 1; $i <= $passengerCount; $i++) {
        echo '<div class="login-container">
                <h3>Enter details for Passenger ' . $i . '</h3>
                <div class="input-group">
                    <label for="fname' . $i . '">First Name:</label>
                    <input type="text" id="fname' . $i . '" name="fname[]" placeholder="Enter first name" required>
                </div>
                <div class="input-group">
                    <label for="lname' . $i . '">Last Name:</label>
                    <input type="text" id="lname' . $i . '" name="lname[]" placeholder="Enter last name" required>
                </div>
                <div class="input-group">
                    <label for="dob' . $i . '">Date of Birth:</label>
                    <input type="date" id="dob' . $i . '" name="DOB[]" required max="' . date('Y-m-d') . '">
                </div>
                <div class="input-group">
                    <label for="gender' . $i . '">Gender:</label>
                    <select id="gender' . $i . '" name="gender[]" required>
                        <option value="none">---Select Gender---</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="passport_no' . $i . '">Passport Number:</label>
                    <input type="text" id="passport_no' . $i . '" name="passport_no[]" placeholder="Enter passport number" required>
                </div>
                <div class="input-group">
                    <label for="class' . $i . '">Class:</label>
                    <select id="class' . $i . '" name="class[]" onchange="updateTotalPrice()" required>
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                    </select>
                </div>
              </div>';
    }

    // Contact details section (below the passenger details)
    echo '<div class="login-container">
            <h3>Enter Contact Details</h3>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="input-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>
          </div>';

    // Total price display
    echo '<div class="input-group">
            <label for="totalPrice">Total Price:</label>
            <input type="hidden" id="totalPrice" name="totalPrice" value="0"  >
          </div>';

    // Hidden fields to pass Flight ID, PNR, and total cost for further processing
    echo '<input type="hidden" value="' . htmlspecialchars($F_id) . '" name="FlightID">
          <input type="hidden" value="' . htmlspecialchars($pnr) . '" name="PNR">
                    

          <button type="submit" class="button" name="submit">Proceed to Checkout</button>
    </div>'; // Close outer-container

    // End of form
    echo '</form>';
}
?>

<!-- Footer -->
<footer>
    <p>2024 Airline Reservation. All Rights Reserved.</p>
</footer>

<!-- JavaScript for validation and total price calculation -->
<script>
    // Validation function
    function validateForm() {
        const fnameFields = document.querySelectorAll('input[name="fname[]"]');
        const lnameFields = document.querySelectorAll('input[name="lname[]"]');
        const dobFields = document.querySelectorAll('input[name="DOB[]"]');
        
        for (let i = 0; i < fnameFields.length; i++) {
            if (!fnameFields[i].value || !lnameFields[i].value || !dobFields[i].value) {
                alert('Please fill out all fields for each passenger.');
                return false;
            }
        }
        return true;
    }

    // Update total price based on class selection
    function updateTotalPrice() {
        // Prices for economy and business class
        const ecoPrice = <?php echo $ecoPrice; ?>;
        const busPrice = <?php echo $busPrice; ?>;

        let totalPrice = 0;
        
        // Loop through each passenger and calculate the price
        const classFields = document.querySelectorAll('select[name="class[]"]');
        classFields.forEach(function(field) {
            if (field.value === "economy") {
                totalPrice += ecoPrice;
            } else if (field.value === "business") {
                totalPrice += busPrice;
            }
        });
        
        // Update the total price field
        document.getElementById('totalPrice').value = totalPrice.toFixed(2);
    }
</script>
</body>
</html>
