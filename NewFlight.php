<?php
require_once( "connection.php");


if(isset($_POST['submit']))
{
    $TripType=$_POST['trip_type'];
    $FlightNo=$_POST['f_no'];
    $From=$_POST['from_location'];
    $To=$_POST['to_location'];
    $ArrivalTime=$_POST['arrival_time'];
    $DepartureTime=$_POST['departure_time'];
    $ReturnDate=$_POST['return'];
    $ArrivalDate=$_POST['arrival_date'];
    $DepartureDate=$_POST['departure_date'];
    $Price=$_POST['price'];
    $insert_query ="INSERT into flight( Trip_type,F_no,Arrival_date,Departure_date,From_location,To_location,Arrival_time,Departure_time,Price) VALUES ('$TripType','$FlightNo','$ArrivalDate','$DepartureDate','$From','$To','$ArrivalTime','$DepartureTime','$Price')";
    $insert_result=mysqli_query($con,$insert_query);
     
    if($insert_result)
    {
        echo'<script>alert('Flight Added successfully!!!!');</script>';
    }
    else
    {
        echo'<div>Error</div>';
    }
}
?>
