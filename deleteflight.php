<?php
require_once("connection.php");

if (isset($_GET['Del'])) {
    $userId = (int)$_GET['Del'];

    $query = "DELETE FROM flight WHERE F_id = $userId"; 
    $result = $con->query($query);
    
    if ($result) {
        echo "<script>
            alert('Flight deleted successfully.');
                window.location.href = 'viewflight.php'; // Redirect to view flights page
        </script>";
    } else {
        echo 'Please check your query';
    }
} else {
    header("Location: admin.php");
}
?>