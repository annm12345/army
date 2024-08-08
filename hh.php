<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Custom Map Display</title>
  <style>
    /* Style for the map container */
    #map {
      height: 400px; /* Adjust height as needed */
      width: 100%; /* Take full width of the container */
    }
  </style>
</head>
<body>
  <!-- Map container -->
  <div id="map"></div>

  <!-- Script to initialize the map -->
  <script>
    // Function to initialize the map
    function initMap() {
      // Coordinates to center the map
      var center = { lat: 40.7128, lng: -74.0060 }; // Example: New York City

      // Custom map styles to increase brightness
      var customMapStyles = [
        {
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#f5f5f5" // Adjust color to increase brightness
            }
          ]
        },
        {
          "elementType": "labels.icon",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#616161" // Adjust color to increase brightness
            }
          ]
        },
        {
          "elementType": "labels.text.stroke",
          "stylers": [
            {
              "color": "#f5f5f5" // Adjust color to increase brightness
            }
          ]
        },
        {
          "featureType": "administrative.land_parcel",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "administrative.land_parcel",
          "elementType": "labels.text.fill",
          "stylers": [
            {
              "color": "#bdbdbd" // Adjust color to increase brightness
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "geometry",
          "stylers": [
            {
              "color": "#eeeeee" // Adjust color to increase brightness
            }
          ]
        }
      ];

      // Create a new map object
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12, // Initial zoom level
        center: center, // Center the map on the specified coordinates
        styles: customMapStyles // Apply custom map styles
      });

      // Example: Adding a marker
      var marker = new google.maps.Marker({
        position: center,
        map: map,
        title: 'Hello, World!' // Tooltip text when hovering over the marker
      });
    }
  </script>
  <!-- Load the Google Maps JavaScript API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIiZlZsKy0XKQQzpOzWLBgcAf8P8dFoOc&libraries=geometry&callback=initMap" async defer></script>
</body>
</html>
