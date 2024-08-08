<?php
require('top.php');
?>
    <style>
        
        .notification {
        position: fixed;
        top: 10px;
        right: 10px;
        padding: 10px 20px;
        background-color: rgba(255, 0, 0, 0.8); /* Red color with 80% opacity */
        color: #fff;
        border-radius: 5px;
        display: none; /* Initially hidden */
        }


        .map-container {
            position: relative;
            width: 100%;
            height: 80vh;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        .controls-container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            gap: 1rem;
        }
        #searchForm{
            display: flex;
        }

        #searchLabel {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 0.5rem;
            color: #010a14;
        }

        button[type="submit"],
        #search-location {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover,
        #search-location:hover {
            background-color: #0056b3;
        }

        .map-type-buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .map-type-buttons button {
            margin-bottom: 0.5rem;
            background-color: rgba(255,255,255,0.5);
            color: #010a14;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .map-type-buttons button:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #0056b3;
        }

        @media (max-width: 768px) {
            
        }

        .btn-container {
            padding: 20px;
            display: flex;
            gap: 10px;
        }

        .location-label {
            background-color: rgba(255, 0, 0, 0.2);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .location-label-blue {
            background-color: rgba(63, 10, 189, 0.2);
            color: white;
            padding: 3px 5px;
            border-radius: 5px;
        }

        .input-group {
            margin-bottom: 10px;
        }

        .input-group label {
            margin-right: 10px;
        }

        .button-group {
            margin-top: 10px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .distance-info {
            margin-top: 20px;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            #map {
                margin-top:2rem;
                height: 90vh;
            }

            .btn-container {
                position: absolute;
                bottom: 4rem;
                left: 0;
                width: 100%;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 20px;
                box-sizing: border-box;
            }
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 9999;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px;
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        input[type="text"] {
            border: none;
            outline: none;
            padding: 10px 3px;
            border-radius: 4px;
            background-color: rgba(167, 174, 231, 0.7);
            color: #000;
        }
        ::placeholder {
        color: rgb(19, 1, 1);
        opacity: 1; /* Firefox */
        }
        .mic-button {
            position: absolute;
            top: 20px; /* Adjust as needed */
            right: 20px; /* Adjust as needed */
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            padding: 0.5rem;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
            z-index: 999; /* Ensure it's above other elements */
        }

        @media (max-width: 768px) {
            .mic-button {
                top: auto;
                bottom: 150px; /* Adjust as needed */
                right: 20px; /* Adjust as needed */
            }
        }
    </style>

    
    <div class="map-container">
        <div id="map"></div>
        <div class="controls-container">
            <div class="search-container">
                <form id="searchForm">
                    <input type="text" id="searchLabel" placeholder="Enter label">
                    <button type="submit" class="search-button" style="padding: 1rem;border-radius:5px;background-color: rgba(85, 33, 207, 0.5);color: #f3f4f5;">Search</button>
                </form>
                <div id="search-location" onclick="searchLocation()">
                    <i class="fa-solid fa-location-crosshairs"></i>
                </div>
            </div>
            <div class="map-type-buttons">
                <button onclick="changeMapType('roadmap')">Road Map</button>
                <button onclick="changeMapType('satellite')">Satellite</button>
                <button onclick="changeMapType('hybrid')">Hybrid</button>
                <button onclick="changeMapType('terrain')">Terrain</button>
            </div>
        </div>
        <button class="mic-button" onclick="startSpeechToText()" style="">
            <i class="fas fa-microphone"></i>
        </button>
        
    </div>
    <div id="notification" class="notification"></div>

    
    <div class="btn-container">
        <div class="action-container">
            <div class="input-group">
                <label for="latitude">Latitude:</label>
                <input type="text" id="latitude" value="">
            </div>
            <div class="input-group">
                <label for="longitude">Longitude:</label>
                <input type="text" id="longitude" value="">
            </div>
            <div class="button-group">
                <button onclick="calculateDistance()">Calculate Distance</button>
            </div>
        </div>
        <div class="action-container">
            <div class="input-group">
                <label for="savelatitude">Latitude:</label>
                <input type="text" id="savelatitudeInput" value="" readonly>
            </div>
            <div class="input-group">
                <label for="savelongitude">Longitude:</label>
                <input type="text" id="savelongitudeInput" value="" readonly>
            </div>
            <div class="button-group">
                <button id="saveDataBtn" onclick="showLabelInputBox()" disabled>Save Data</button>
            </div>
        </div>
    </div>
    <div id="distance" class="distance-info"></div>

    <!-- The Modal -->
    <div id="labelModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="input-group">
                <label for="label-text">Enter Label:</label>
                <input type="text" id="label-text" placeholder="Enter label">
            </div>
            <div class="button-group">
                <button onclick="saveLabel()">Submit</button>
                <button class="cancel-btn" onclick="cancelLabelInput()">Cancel</button>
            </div>
        </div>
    </div>

<script>
    function showErrorNotification(message) {
        const notification = document.getElementById('notification');
        notification.innerText = message;
        notification.style.display = 'block'; // Show the notification

        // Hide the notification after 5 seconds
        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000); // Adjust the timeout duration as needed
    }

        function startSpeechToText() {
            const recognition = new webkitSpeechRecognition() || new SpeechRecognition();
            recognition.lang = 'my'; // Set language to Burmese (Myanmar)
            recognition.start();
            console.log('Listening for speech...');

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                console.log('Speech recognition result:', transcript);
                
                if (transcript !== "") {
                // Perform a request to search for the label
                // For simplicity, let's assume you have a server-side endpoint to perform this search
                // Replace 'search_location_by_label.php' with your actual endpoint
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `map_text.php?transcript=${encodeURIComponent(transcript)}`, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                const location = response.location;
                                // Get current location
                                navigator.geolocation.getCurrentPosition(position => {
                                    const myLatitude = position.coords.latitude;
                                    const myLongitude = position.coords.longitude;
                                    // Calculate distance
                                    const distance = calculateDistanceToLabel(location, myLatitude, myLongitude);
                                    // Show the location on the map
                                    showLocation(location, distance);
                                }, error => {
                                    showErrorNotification(error.message);
                                });
                            } else {
                                alert("Voice not found.");
                            }
                        } else {
                            alert("Error occurred while searching for Voice.");
                        }
                    }
                };
                xhr.send();
            } else {
                alert("Please enter a Voice to search.");
            }
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
            };
        }
    let map;
    let currentLocation;
    let destinationMarker;
    let distancePolyline;
    let infowindow;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 0, lng: 0 },
            zoom: 16,
            mapTypeId: 'satellite',
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            mapLabels: true,
            language: 'my',
            draggable: true,
            zoomControl: true,
            scaleControl: true,
            rotateControl: true,
            gestureHandling: 'greedy'
        });

        fetchLocations(); // Fetch locations from the server

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                currentLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(currentLocation);
                new google.maps.Marker({
                    position: currentLocation,
                    map: map,
                    title: 'Your Location',
                    label: {
                        text: 'Your Location',
                        color: 'white',
                        className: 'location-label'
                    }
                });
            }, function() {
                handleLocationError(true, map.getCenter());
            });
        } else {
            handleLocationError(false, map.getCenter());
        }

        infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(map, 'click', function(event) {
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();
            document.getElementById('savelatitudeInput').value = event.latLng.lat();
            document.getElementById('savelongitudeInput').value = event.latLng.lng();

            const latitude = parseFloat(event.latLng.lat());
            const longitude = parseFloat(event.latLng.lng());
            toggleSaveDataBtn();
        });

        document.getElementById("searchForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent default form submission
                searchByLabel();
            });
    }
    function searchByLabel() {
        const label = document.getElementById("searchLabel").value.trim();
        if (label !== "") {
            // Perform a request to search for the label
            // For simplicity, let's assume you have a server-side endpoint to perform this search
            // Replace 'search_location_by_label.php' with your actual endpoint
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `search_location_by_label.php?label=${encodeURIComponent(label)}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            const location = response.location;
                            // Get current location
                            navigator.geolocation.getCurrentPosition(position => {
                                const myLatitude = position.coords.latitude;
                                const myLongitude = position.coords.longitude;
                                // Calculate distance
                                const distance = calculateDistanceToLabel(location, myLatitude, myLongitude);
                                // Show the location on the map
                                showLocation(location, distance);
                            }, error => {
                                alert("Error getting your current location: " + error.message);
                            });
                        } else {
                            alert("Label not found.");
                        }
                    } else {
                        alert("Error occurred while searching for label.");
                    }
                }
            };
            xhr.send();
        } else {
            alert("Please enter a label to search.");
        }
    }

    function calculateDistanceToLabel(location, myLatitude, myLongitude) {
        const { latitude, longitude, label } = location;

        // Convert degrees to radians
        const deg2rad = (deg) => deg * (Math.PI / 180);

        // Radius of the earth in kilometers
        const earthRadiusKm = 6371;

        // Calculate the differences
        const latDiff = deg2rad(latitude - myLatitude);
        const lonDiff = deg2rad(longitude - myLongitude);

        // Haversine formula
        const a = Math.sin(latDiff / 2) * Math.sin(latDiff / 2) +
                Math.cos(deg2rad(myLatitude)) * Math.cos(deg2rad(latitude)) *
                Math.sin(lonDiff / 2) * Math.sin(lonDiff / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = earthRadiusKm * c;

        // Round the distance to two decimal places
        const roundedDistance = Math.round(distance * 100) / 100;
        return roundedDistance;
    }

    function showLocation(location, distance) {
        const { latitude, longitude, label } = location;

        // Create a marker for the location
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
            map: map,
            title: label,
        });

        // Open info window with label and distance information
        infowindow.setContent(`<div class="infowindow"><strong>Label:</strong> ${label}<br><strong>Distance:</strong> ${distance} km</div>`);
        infowindow.open(map, marker);

        // Center the map on the marker
        map.setCenter(marker.getPosition());
        map.setZoom(17); // Zoom in for better visibility
    }


    function fetchLocations() {
        setInterval(() => {
            // Send an AJAX request to fetch all locations
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'all_location.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const locations = JSON.parse(xhr.responseText);
                    displayLocations(locations);
                } else {
                    console.error('Failed to fetch locations:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Error occurred while fetching locations.');
            };
            xhr.send();
        } ); // Fetch data every 1000 milliseconds (1 second)
    }

    function displayLocations(locations) {
        // Loop through each location and add a marker with a custom label
        locations.forEach(location => {
            addMarker({ lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) }, location.label);
        });
    }

    function addMarker(location, label) {
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            label: {
                text: label,
                color: 'white',
                className: 'location-label-blue',
                fontSize: '12px',
                fontWeight: 'bold'
            }
        });

        marker.addListener('click', function(event) {
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();
            document.getElementById('savelatitudeInput').value = event.latLng.lat();
            document.getElementById('savelongitudeInput').value = event.latLng.lng();

            measureDistanceToLabel(location);
            toggleSaveDataBtn();
        });
    }

    function measureDistanceToLabel(labelLocation) {
        let distance = google.maps.geometry.spherical.computeDistanceBetween(
            new google.maps.LatLng(currentLocation),
            new google.maps.LatLng(labelLocation)
        );

        let contentString = '<div class="infowindow">Distance to Label: ' + (distance / 1000).toFixed(2) + ' km</div>';
        infowindow.setContent(contentString);
        infowindow.setPosition(labelLocation);
        infowindow.open(map);
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        console.error(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    function toggleSaveDataBtn() {
        const latitude = document.getElementById('savelatitudeInput').value.trim();
        const longitude = document.getElementById('savelongitudeInput').value.trim();
        const saveDataBtn = document.getElementById('saveDataBtn');

        saveDataBtn.disabled = !(latitude !== '' && longitude !== '');
    }

    function calculateDistance() {
        let latitude = parseFloat(document.getElementById('latitude').value);
        let longitude = parseFloat(document.getElementById('longitude').value);
        let destination = { lat: latitude, lng: longitude };

        if (destinationMarker) {
            destinationMarker.setMap(null);
        }

        if (distancePolyline) {
            distancePolyline.setMap(null);
        }

        destinationMarker = new google.maps.Marker({
            position: destination,
            map: map,
            title: 'Destination',
        });

        let distance = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(currentLocation), new google.maps.LatLng(latitude, longitude));

        distancePolyline = new google.maps.Polyline({
            path: [currentLocation, destination],
            geodesic: true,
            strokeColor: '#007bff',
            strokeOpacity: 0.8,
            strokeWeight: 5,
            map: map
        });

        let contentString = '<div class="infowindow">Distance: ' + (distance / 1000).toFixed(2) + ' km</div>';
        infowindow.setContent(contentString);
        infowindow.setPosition(destination);
        infowindow.open(map);

        document.getElementById('distance').innerHTML = 'Distance: ' + (distance / 1000).toFixed(2) + ' km';
    }

    function searchLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                map.setCenter({ lat: latitude, lng: longitude });
            }, function() {
                handleLocationError(true, map.getCenter());
            });
        } else {
            handleLocationError(false, map.getCenter());
        }
    }

    function changeMapType(mapType) {
        map.setMapTypeId(mapType);
    }

    function showLabelInputBox() {
        document.getElementById('labelModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('labelModal').style.display = 'none';
    }

    function saveLabel() {
        let labelText = document.getElementById('label-text').value;
        if (labelText.trim() !== '') {
            const latitude = document.getElementById('savelatitudeInput').value.trim();
            const longitude = document.getElementById('savelongitudeInput').value.trim();

            const data = new FormData();
            data.append('label', labelText);
            data.append('latitude', latitude);
            data.append('longitude', longitude);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_location_data.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                    } else {
                        alert('Error occurred while saving data.');
                    }
                }
            };
            document.getElementById('latitude').value = '';
            document.getElementById('longitude').value = '';
            document.getElementById('savelatitudeInput').value = '';
            document.getElementById('savelongitudeInput').value = '';
            document.getElementById('label-text').value = '';
            document.getElementById('labelModal').style.display = 'none';
            xhr.send(data);
        } else {
            alert('Please enter a label.');
        }
    }

    function cancelLabelInput() {
        document.getElementById('label-text').value = '';
        document.getElementById('labelModal').style.display = 'none';
    }
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIiZlZsKy0XKQQzpOzWLBgcAf8P8dFoOc&libraries=geometry&callback=initMap" async defer></script>
<?php
require('foot.php');
?>