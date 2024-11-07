<html>
<head>
    <title>Flights</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container for flight details */
        .flights-available {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: linen;
            border-radius: 15px;
            width: 100%;
            /* max-width: 800px; */
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header for flights available */
        .flights-available h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

         h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        /* Container for From and To sections */
        .details {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        /* Styling for the flight details */
        .details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Styling for each detail item */
        .details li {
            font-size: 20px;
            color: #555;
            margin-bottom: 10px;
            position: relative;
        }

        /* For the "From" and "To" sections */
        .To-dec, .From-dec {
            flex: 1;
            padding: 20px;
            text-align: left;
        }

        /* Titles for sections */
        .section-title {
            font-size: 22px;
            color: #007BFF;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }
        .select
        {
            width:300px;
            background-color: purple;
            font-size: 20px;
            color:white;

            padding:10px;
            border-radius:10px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
   
    require_once("connection.php");

    if (isset($_POST['submit'])) 
    {
        $TripType = $_POST['trip-type'];
        $FromLocation = $_POST['fromlocation'];
        $ToLocation = $_POST['tolocation'];
        $DepartureDate = $_POST['departure'];
        $ReturnDate = $_POST['return'];
        $Passengers = $_POST['passengers'];
        $_SESSION['passengerCount'] = $_POST['passengers'];

        $check_query = "SELECT F_id, Price, Departure_time, Arrival_time FROM flight 
        WHERE Trip_type='$TripType' 
        AND Departure_date='$DepartureDate' 
        AND To_location='$ToLocation' 
        AND From_location='$FromLocation'";
$result = mysqli_query($con, $check_query);

         if ($result && mysqli_num_rows($result)>0)
          {
            while($flight=mysqli_fetch_assoc($result)) 
            {
             
              echo'<h2>Flights Available</h2>';
            
        $Fid = $flight['F_id']; 
                $DepartureTime = $flight['Departure_time'];
                $ArrivalTime = $flight['Arrival_time'];
                $Price = $flight['Price'];
                echo '<div class="flights-available">
                    <h2>Flights Available</h2>
                    <div class="details">
                        <div class="To-dec">
                            <div class="section-title">From</div>
                            <ul>
                                <li>From Location: <strong>' . $FromLocation . '</strong></li>
                                <li>Departure Date: <strong>' . $DepartureDate . '</strong></li>
                                <li>Departure Time: <strong>' . $DepartureTime . '</strong></li>
                            </ul>
                        </div>
                        <div class="From-dec">
                            <div class="section-title">To</div>
                            <ul>
                                <li>To Location: <strong>' . $ToLocation . '</strong></li>';
                if ($TripType == 'roundtrip') {
                    echo '<li>Return Date: <strong>' . $ReturnDate . '</strong></li>';
                }
                echo '<li>Arrival Time: <strong>' . $ArrivalTime . '</strong></li>
                                <li>Price: <strong>' . $Price . '</strong></li>

                            </ul>
                        </div>
                    </div>
                    <form action="booking.php" method="post">
                    <input type="hidden" name="FlightID" value="' . $Fid . '">
                        <input type="hidden" name="Price" value="' . $Price . '">
                    <button type="submit" class="select" name="select" FlightID="'.$Fid.'" Price = "'.$Price.'">Select</button>
                    </form>
                </div>';
            } 
        }
           
         else {
            echo "No flights found for your search criteria.";
            }
              
        }
       
    else {
        echo "Form not submitted.";
    }
    ?>
</body>
</html>  