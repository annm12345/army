<?php
require('connection.php');
// Retrieve the label from the GET request
$label = $_GET['label'];

// Prepare SQL statement to search for the location by label
$sql = "SELECT * FROM location_data WHERE label = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $label);
$stmt->execute();
$result = $stmt->get_result();

// Check if a location with the given label exists
if ($result->num_rows > 0) {
    // Location found, retrieve its details
    $row = $result->fetch_assoc();
    $location = [
        'latitude' => $row['lat'],
        'longitude' => $row['long'],
        'label' => $row['label']
    ];
    $response = ['success' => true, 'location' => $location];
} else {
    // Location not found
    $response = ['success' => false];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$stmt->close();
$con->close();

?>