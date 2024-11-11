<?php
session_start();
require_once("connection.php");

// Get the passenger count from the session
$passengerCount = $_SESSION['passengerCount'];

if (!isset($_SESSION['username'])) {
    header("Location: index.html?login=user"); // Redirect to login page if not logged in
    exit;
}

// Handle the selection of flight and store the FlightID in the session
if (isset($_POST['select'])) {
    $F_id = $_POST['FlightID'];
    $_SESSION['FlightID'] = $F_id; // Store FlightID in session

    // Generate PNR code
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pnr = substr(str_shuffle($characters), 0, 6);

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
    echo '<form method="post" action="insert_passenger.php" onsubmit="updateTotalPrice(); return validateForm()">'; // Call updateTotalPrice on submit

    // Outer container to wrap everything (with proper styling)
    echo '<div class="login-container" id="outer">';

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
            <input type="text" id="totalPrice" name="totalPrice" value="0" readonly>
          </div>';

    // Proceed to checkout button
    echo '<button type="submit" class="button" name="submit" id="submitBtn">Proceed to Checkout</button>';
    
    echo '</div>'; // Close outer-container

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
