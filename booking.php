
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

        /* Styling for the total cost display */
        .total-cost {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        /* Button styling */
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
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pnr = substr(str_shuffle($characters), 0, 6);
    // Get the price per passenger and calculate total cost
    $cost = $_POST['Price'];
    $total = $passengerCount * $cost;
    $F_id = $_POST['FlightID'];

    // Begin the form to collect passenger details
    echo '<form method="post" action="insert_passenger.php" onsubmit="return validateForm()">';

    // Outer container to wrap everything (with proper styling)
    echo '<div class="login-container" id="outer">';

    // Loop through passenger count and display fields for each passenger within their own container
    for ($i = 1; $i <= $passengerCount; $i++) {
        echo '<div class="login-container">
                <h3>Enter details for Passenger ' . $i . '</h3>
                <div class="input-group">
                    <label for="fname' . $i . '">First Name:</label>
                    <input type="text" id="fname' . $i . '" name="fname" placeholder="Enter first name" required>
                </div>
                <div class="input-group">
                    <label for="lname' . $i . '">Last Name:</label>
                    <input type="text" id="lname' . $i . '" name="lname" placeholder="Enter last name" required>
                </div>
                <div class="input-group">
                    <label for="dob' . $i . '">Date of Birth:</label>
                    <input type="date" id="dob' . $i . '" name="DOB" required required max="' . date('Y-m-d') . '">
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

    // Display the total cost for the booking
    echo '<div id="total" class="total-cost">Total Cost: ' . htmlspecialchars($total) . ' USD</div>';

    // Hidden fields to pass Flight ID and Total cost for further processing
    echo '<input type="hidden" value="' . htmlspecialchars($F_id) . '" name="FlightID">
          <input type="hidden" value="' . htmlspecialchars($total) . '" name="totalCost">
          <input type="hidden" value="' . htmlspecialchars($pnr) . '" name="PNR">
          <button type="submit" class="button" name="submit">Checkout</button>
    </div>'; // Close outer-container

    // End of form
    echo '</form>';
}

// Server-side validation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Loop through the passenger details
    foreach ($_POST['fname'] as $index => $fname) {
        $lname = $_POST['lname'][$index];
        $dob = $_POST['DOB'][$index];
        $gender = $_POST['gender'][$index];
        $passport_no = $_POST['passport_no'][$index];

        // Server-side validation
        if (empty($fname) || empty($lname) || empty($dob) || empty($gender) || empty($passport_no)) {
            die("All fields are required for passenger " . ($index + 1));
        }

        // Validate passport number (e.g., 6 to 9 alphanumeric characters)
        if (!preg_match("/^[A-Za-z0-9]{6,9}$/", $passport_no)) {
            die("Invalid passport number for passenger " . ($index + 1));
        }

        // Validate email format
        $email = $_POST['email'][$index];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format.");
        }

        // Validate phone number (e.g., 10 digits)
        $phone = $_POST['phone'][$index];
        if (!preg_match("/^\d{10}$/", $phone)) {
            die("Invalid phone number format.");
        }
    }

    // If validation passes, insert data into the database
    // Your insertion logic goes here...
}
?>

<!-- Footer -->
<footer>
    <p>2024 Airline Reservation. All Rights Reserved.</p>
</footer>

<!-- JavaScript for validation -->
<script>
    // Function to validate the form before submitting
    function validateForm() {
        // Get all form inputs
        var form = document.querySelector("form");
        var fname = form.querySelectorAll("input[name='fname[]']");
        var lname = form.querySelectorAll("input[name='lname[]']");
        var dob = form.querySelectorAll("input[name='DOB[]']");
        var gender = form.querySelectorAll("select[name='gender[]']");
        var passportNo = form.querySelectorAll("input[name='passport_no[]']");
        var email = form.querySelector("input[name='email[]']");
        var phone = form.querySelector("input[name='phone[]']");

        // Validate each passenger's details
        for (var i = 0; i < fname.length; i++) {
            // Check if first name and last name are not empty
            if (fname[i].value.trim() == "") {
                alert("Please enter the first name for passenger " + (i + 1));
                return false;
            }
            if (lname[i].value.trim() == "") {
                alert("Please enter the last name for passenger " + (i + 1));
                return false;
            }

            // Check if passport number matches a pattern (e.g., alphanumeric or numeric)
            var passportPattern = /^[A-Za-z0-9]{6,9}$/;
            if (!passportPattern.test(passportNo[i].value.trim())) {
                alert("Please enter a valid passport number for passenger " + (i + 1));
                return false;
            }

            // Check if date of birth is valid
            if (dob[i].value.trim() == "") {
                alert("Please enter the date of birth for passenger " + (i + 1));
                return false;
            }

            // Check if gender is selected
            if (gender[i].value == "none") {
                alert("Please select the gender for passenger " + (i + 1));
                return false;
            }
        }

        // Validate contact details
        if (email.value.trim() == "") {
            alert("Please enter your email.");
            return false;
        }
        if (!/\S+@\S+\.\S+/.test(email.value.trim())) {
            alert("Please enter a valid email.");
            return false;
        }

        if (phone.value.trim() == "") {
            alert("Please enter your phone number.");
            return false;
        }
        if (!/^\d{10}$/.test(phone.value.trim())) {
            alert("Please enter a valid phone number (10 digits).");
            return false;
        }

        // If everything is valid, allow the form to submit
        return true;
    }
</script>
</body>
</html>
