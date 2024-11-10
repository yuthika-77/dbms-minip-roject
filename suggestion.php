<?php
require_once('connection.php'); // Database connection

// Get parameters from the URL
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'from';

if ($q !== '') {
    $q = strtolower($q); // Sanitize the input for case-insensitive search

    // Based on the type ("from" or "to"), select the correct field from the database
    if ($type === 'from') {
        $sql = "SELECT DISTINCT From_location FROM flight
                WHERE LOWER(From_location) LIKE '$q%' 
                ORDER BY From_location ASC
                LIMIT 5";  // Limit results to 5 suggestions
    } elseif ($type === 'to') {
        $sql = "SELECT DISTINCT To_location FROM flight
                WHERE LOWER(To_location) LIKE '$q%' 
                ORDER BY To_location ASC
                LIMIT 5";  // Limit results to 5 suggestions
    }

    // Execute the query
    $result = $con->query($sql);
    $locations = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Depending on the type, push the appropriate location to the array
            if ($type === 'from') {
                $locations[] = htmlspecialchars($row['From_location']);
            } elseif ($type === 'to') {
                $locations[] = htmlspecialchars($row['To_location']);
            }
        }
    }

    // Return the locations as a JSON response
    echo json_encode($locations);
} else {
    // If no query is provided, return an empty array
    echo json_encode([]);
}
?>
