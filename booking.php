

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
