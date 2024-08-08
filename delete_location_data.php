<?php
// Include the database connection file
require('connection.php');

// Check if latitude and longitude are received via POST
if(isset($_POST['lat']) && isset($_POST['lng'])) {
    // Escape user inputs for security
    $latitude = mysqli_real_escape_string($con, $_POST['lat']);
    $longitude = mysqli_real_escape_string($con, $_POST['lng']);
    
    // Delete location data from the database based on latitude and longitude
    $sql = "DELETE FROM `location_data` WHERE `lat`='$latitude' AND `long`='$longitude'";
    
    if(mysqli_query($con, $sql)) {
        echo "Location data deleted successfully";
    } else {
        echo "Error deleting location data: " . mysqli_error($con);
    }
} else {
    echo "Latitude and longitude not provided";
}
?>
