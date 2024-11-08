<?php
session_start();

require_once("connection.php");
$passengerCount = $_SESSION['passengerCount'];

if (isset($_POST['select'])) {
    $cost = $_POST['Price'];
    $total = $passengerCount * $cost;
    $F_id = $_POST['FlightID'];
    
    echo '<form method="post" action="insert_passenger.php">';
    
    for ($i = 1; $i <= $passengerCount; $i++) {
        echo '<div class="details">';
        echo "<h3>Enter details for Passenger $i</h3>";
        echo '<input type="text" name="fname[]" placeholder="Enter first name" required>
              <input type="text" name="lname[]" placeholder="Enter last name" required>
              <input type="date" name="DOB[]" placeholder="Enter date of birth" required>
              <select name="gender[]" required>
                  <option value="none">---Select Gender---</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Others">Others</option>
              </select>
              <input type="email" name="email[]" placeholder="Enter email" required>
              <input type="text" name="phone[]" placeholder="Enter phone number" required>
              <label for="class">Class</label>
              <select name="class[]" required>
                  <option value="Economy">Economy</option>
                  <option value="Business">Business</option>
                  <option value="First">First</option>
              </select>';
        echo '</div>';
    }
    
    echo '<div id="total">Total Cost: $' . $total . '</div>';
    echo '<input type="hidden" value="' . $F_id . '" name="FlightID">';
    echo '<input type="submit" name="submit_passenger" value="Submit Passenger Details">';
    echo '</form>';
}
?>

<html>
    <head>
        <style>
            /* General form styling */
form {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    margin: 20px auto;
    font-family: Arial, sans-serif;
    height:600px;
}

/* Passenger details section */
.details {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #ffffff;
}

.details h3 {
    color: #333;
    font-size: 18px;
    margin-bottom: 10px;
}

/* Input and select styling */
input[type="text"],
input[type="date"],
input[type="email"],
select {
    width: 100%;
    padding: 10px;
    margin: 8px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Label styling */
label {
    font-weight: bold;
    color: #555;
    margin-top: 10px;
    display: block;
}

/* Submit button styling */
input[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Total cost display */
#total {
    font-size: 18px;
    color: #333;
    font-weight: bold;
    text-align: center;
    margin: 15px 0;
}

        </style>
    </head>
</html>

 
