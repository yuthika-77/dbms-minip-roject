<?php
session_start();

require_once("connection.php");
$passengerCount=$_SESSION['passengerCount'] ;
 

if(isset($_POST['select']))
{
    $cost=$_POST['Price'];
   $total=$passengerCount*$cost;
    $F_id=$_POST['FlightID'];
    echo '<form method="post" action="insert_passenger.php">';
     
    for ($i = 1; $i <= $passengerCount; $i++) {
        echo "<h3>Enter details for Passenger $i</h3>";
        echo '<input type="text" name="fname[]" placeholder="Enter first name" required>
              <input type="text" name="lname[]" placeholder="Enter last name" required>
              <input type="date" name="DOB[]" placeholder="Enter date of birth" required>
              <select name="gender[]">
                  <option value="none">---Select Gender---</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Others">Others</option>
              </select>
              <input type="email" name="email[]" placeholder="Enter email" required>
              
              <input type="text" name="phone[]" placeholder="Enter phone number" required>
              <label for ="class">Class</label>
                
            <select name="class" >
                <option name="class" value="Economy">Economy</option>                             
                <option name="class" value="Buisness">Buisness</option>
                <option name="class" value="First">First</option>
            </select>';

    }       
    echo '<div id="total">'.$total.'</div>
    <input type="hidden" value="'.$F_id.'" name="FlightID">
    <input type="submit" name="submit_passenger" value="Submit Passenger Details">';
    echo '</form>';
} 
?>

 
