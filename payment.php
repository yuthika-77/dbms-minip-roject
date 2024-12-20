<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            text-align: center;
            margin-top: 50px;
            height:auto;
        }
        .header {
            text-align: center;
            padding: 10px;
            font-size: 24px;
            color: purple;
        }
        .payment-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            display: inline-block;
            text-align: left;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .payment-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .payment-box button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .payment-box button:hover {
            background-color: plum;
        }
        .footer {
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payment</h1>
    </div>
    <div class="container">
        <div class="payment-box">
            <h2>Enter Payment Details</h2>
            <form method="post">
                <label for="card-number">Card Number:</label>
                <input type="number" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" required>

                <label for="expiry-date">Expiry Date:</label>
                <input type="date" id="expiry-date" name="expiry-date" placeholder="MM/YY" required>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" required>

                <label for="name">Cardholder's Name:</label>
                <input type="text" id="name" name="name" placeholder="John Doe" required>

                <button type="submit" name="payment">Complete Payment</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
session_start();
require_once("connection.php");

if (isset($_POST['payment'])) {
    // Get payment form data
    $CardNo = $_POST['card-number'];
    $Expiry = $_POST['expiry-date'];
    $Name = $_POST['name'];

    // Retrieve booking ID and total amount from session
    $booking_id = $_SESSION['booking_id'];
    $totalAmount = $_SESSION['totalAmount'];

    // Insert payment details into the Bill table
    $query = "INSERT INTO Bill (Amount, booking_id, payment_status) 
              VALUES ('$totalAmount', '$booking_id', 'paid')";

    if (mysqli_query($con, $query)) {
        // Update booking status to 'confirmed' after successful payment
        $update_booking = "UPDATE booking SET status = 'confirmed' WHERE booking_id = '$booking_id'";
        mysqli_query($con, $update_booking);

        // Redirect to the confirmation page with the booking ID
        header("Location: confirmation.php?bid=$booking_id");
        exit();
    } else {
        echo '<script>alert("Error: Payment failed. Please try again.");</script>';
    }
}
?>

