<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
require('connection.php');



// Fetch all locations from the database
$sql = "SELECT * FROM location_data";
$result = $con->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $location = array(
            'latitude' => $row['lat'],
            'longitude' => $row['long'],
            'label' => $row['label']
        );
        $locations[] = $location;
    }
} else {
    echo "0 results";
}



// Return locations as JSON data
header('Content-Type: application/json');
echo json_encode($locations);

?>