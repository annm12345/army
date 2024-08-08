<?php
require('top.php');
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Set the height of the map container */
        #map {
            margin-top:4.5rem;
            height: 90vh;
            width: 100%;
            position: relative; /* Make the map container a reference for positioning */
        }
        @media (max-width: 768px) {
            #map {
                margin-top:2.5rem;
            }
        }
        .location-label {
            background-color: #000;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .location-label-blue {
            background-color: rgba(63, 10, 189, 0.6);
            color: white;
            padding: 3px 5px;
            border-radius: 5px;
        }

        /* Style for form */
        #calculate-btn, #save-btn ,#save-option,#delete-option{
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        #result-label {
            position: absolute;
            background-color: white;
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 9999;
        }

        #cancel-btn {
            background-color: #FF0000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            display: none;
            z-index: 9999;
        }

        #ask-form-container, #save-form-container,#ask-form-container-label {
            display: none;
            position: absolute;
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            max-width: 90%; /* Limit width for responsiveness */
        }

        #ask-form-container label, #save-form-container label  ,#ask-form-container-label label{
            display: block;
            margin-bottom: 10px;
        }

        #ask-form-container input[type="text"], #save-form-container input[type="text"],#ask-form-container-label input[type="text"] {
            width: calc(100% - 20px); /* Adjust for padding */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        #ask-form-container button, #save-form-container button ,#ask-form-container-label button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        #ask-form-container button:last-child, #save-form-container button:last-child ,#ask-form-container-label button:last-child{
            margin-right: 0;
        }

        #cancel-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #888;
        }

        #cancel-icon:hover {
            color: #555; /* Change color on hover */
        }

        
        /* Style for custom control */
        .custom-control {
            background-color: #fff;
            border: 2px solid #fff;
            border-radius: 3px;
            box-shadow: 0 2px 6px rgba(0,0,0,.3);
            cursor: pointer;
            margin-bottom: 22px;
            text-align: center;
            position: absolute;
            top: 50px; /* Adjust as needed */
            left: 10px;
            z-index: 9999;
        }

        .custom-control i {
            color: rgb(25,25,25);
            font-family: Roboto, Arial, sans-serif;
            font-size: 16px;
            line-height: 38px;
            padding-left: 5px;
            padding-right: 5px;
        }
        #sidebar {
            position: fixed;
            top: 73px;
            right: -300px; /* Initially off-screen */
            width: 200px;
            height: 83%;
            background-color: rgba(0,0,0,0.7);
            transition: right 0.3s ease; /* Smooth transition */
            z-index: 9999;
        }

        #sidebar ul {
            padding-top:20px;
            padding-left:20px;
            margin: 0;
            list-style-type: none;
        }

        #sidebar ul li {
            padding: 10px;
            color: #fff;
        }

        #sidebar ul li:hover {
            background-color: #555;
        }

        #open-sidebar-btn {
            position: fixed;
            top: 180px;
            right: 5px;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
            z-index: 10000;
        }
        .cancel-button {
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancel-button:hover {
            background-color: #e74c3c;
        }
        #locationdisplay {
            position: absolute;
            height:40px;
            top: 73px;
            left: 30px;
            z-index: 9999;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            color:darkblue;

        }
        @media (max-width: 768px) {
            #locationdisplay {
                top: 47px;
            }
        }
    
        /* Search container */
        .search-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 9999;
        }

        /* Search content */
        .search-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Close button */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 24px;
            color: #888;
        }

        .close:hover {
            color: #555;
        }

        /* Search input */
        #search-input {
            width: 70%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Search button */
        #search-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #search-btn:hover {
            background-color: #45a049;
        }
        .mic-button {
            position: absolute;
            bottom: 70px; /* Adjust as needed */
            left: 20px; /* Adjust as needed */
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
                bottom:75px; /* Adjust as needed */
                left: 2px; /* Adjust as needed */
            }
        }



    </style>

    
    <div id="map"></div>
    <div id="result-label"></div>
    <!-- Search container -->
    <div id="search-container" class="search-popup">
        <div class="search-content">
            <span class="close">&times;</span>
            <input type="text" id="search-input" placeholder="Search by label">
            <!-- <input type="text" id="search-input-MGRS" placeholder="Search by MGRS..."> -->
            <button id="search-btn">Search</button>
        </div>
    </div>
    <div id="ask-form-container">
        <i id="cancel-icon" class="fas fa-times"></i>
        <button id="calculate-btn">Calculate</button>
        <button id="save-option">Save</button>
    </div>
    <div id="ask-form-container-label">
        <i id="cancel-icon" class="fas fa-times"></i>
        <button id="calculate-btn">Calculate</button>
        <button id="delete-option">Delete</button>
    </div>
    <div id="save-form-container">
        <i id="cancel-icon" class="fas fa-times"></i>
        <label for="location-name-save">Location Name:</label>
        <input type="text" id="location-name-save" placeholder="Enter a name for the location...">
        <button id="save-btn">Save</button>
    </div>
    <div id="locationdisplay">
        <span id="location"></span>
    </div>
    

    <div id="sidebar">
        <ul>
            <li id="draw">Set as target</li>
            <li id="search-by-location">Search by Location name</li>
            <li id="ma7">MA7</li>
            <li>MA8</li>
            <li>122 MM</li>
            
        </ul>
    </div>

    <!-- Button to open the sidebar -->
    <div id="open-sidebar-btn">
        <i class="fas fa-bars"></i>
    </div>
    <button class="mic-button" style="">
            <i class="fas fa-microphone"></i>
    </button>

    <!-- <script src="map.js"></script> -->
    <!-- Leaflet JavaScript -->
    <!-- <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> -->
    <!-- proj4 library -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.5/proj4.js"></script> -->
    <script>
        


        var map;
        var clickedLocation;
        var polyline;
        var currentLocation;
        var infowindow;
        var endMarker;

        

        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var isOpen = sidebar.style.right === '0px';
            sidebar.style.right = isOpen ? '-300px' : '0'; // Toggle sidebar position
        }

        // Event listener for opening the sidebar
        document.getElementById('open-sidebar-btn').addEventListener('click', function() {
            document.getElementById('ask-form-container').style.display = 'none';
            document.getElementById('ask-form-container-label').style.display = 'none';
            toggleSidebar();
        });

        // Initialize and display the map
        function initMap() {
            // Create a map object and specify the DOM element for display.
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: { lat: 0, lng: 0 }, // Initial center
                mapTypeId: 'hybrid' // Set the map type to hybrid
            });
            infowindow = new google.maps.InfoWindow();
            // Create a marker for the center point of the screen
            var centerIcon = {
                url: 'https://maps.google.com/mapfiles/kml/paddle/red-circle.png', // Custom icon
                scaledSize: new google.maps.Size(32, 32), // Adjust size as needed
                origin: new google.maps.Point(0, 0), // Set the origin point of the icon
                anchor: new google.maps.Point(16, 16) // Set the anchor point of the icon
            };

            var centerMarker = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                icon: centerIcon
            });

            // Update the position of the center icon when the map center changes
            google.maps.event.addListener(map, 'center_changed', function() {
                centerMarker.setIcon(centerIcon); // Refresh icon
                centerMarker.setPosition(map.getCenter()); // Update position
                var centerLat = map.getCenter().lat();
                var centerLng = map.getCenter().lng();

                function MGRSString(Lat, Long) {
                    if (Lat < -80) return 'Too far South';
                    if (Lat > 84) return 'Too far North';

                    var c = 1 + Math.floor((Long + 180) / 6);
                    var e = c * 6 - 183;
                    var k = Lat * Math.PI / 180;
                    var l = Long * Math.PI / 180;
                    var m = e * Math.PI / 180;
                    var n = Math.cos(k);
                    var o = 0.006739496819936062 * Math.pow(n, 2);
                    var p = 40680631590769 / (6356752.314 * Math.sqrt(1 + o));
                    var q = Math.tan(k);
                    var r = q * q;
                    var s = r * r * r - Math.pow(q, 6);
                    var t = l - m;
                    var u = 1.0 - r + o;
                    var v = 5.0 - r + 9 * o + 4.0 * (o * o);
                    var w = 5.0 - 18.0 * r + (r * r) + 14.0 * o - 58.0 * r * o;
                    var x = 61.0 - 58.0 * r + (r * r) + 270.0 * o - 330.0 * r * o;
                    var y = 61.0 - 479.0 * r + 179.0 * (r * r) - (r * r * r);
                    var z = 1385.0 - 3111.0 * r + 543.0 * (r * r) - (r * r * r);
                    var aa = p * n * t + (p / 6.0 * Math.pow(n, 3) * u * Math.pow(t, 3)) + (p / 120.0 * Math.pow(n, 5) * w * Math.pow(t, 5)) + (p / 5040.0 * Math.pow(n, 7) * y * Math.pow(t, 7));
                    var ab = 6367449.14570093 * (k - (0.00251882794504 * Math.sin(2 * k)) + (0.00000264354112 * Math.sin(4 * k)) - (0.00000000345262 * Math.sin(6 * k)) + (0.000000000004892 * Math.sin(8 * k))) + (q / 2.0 * p * Math.pow(n, 2) * Math.pow(t, 2)) + (q / 24.0 * p * Math.pow(n, 4) * v * Math.pow(t, 4)) + (q / 720.0 * p * Math.pow(n, 6) * x * Math.pow(t, 6)) + (q / 40320.0 * p * Math.pow(n, 8) * z * Math.pow(t, 8));
                    aa = aa * 0.9996 + 500000.0;
                    ab = ab * 0.9996;
                    if (ab < 0.0) ab += 10000000.0;
                    var ad = 'CDEFGHJKLMNPQRSTUVWXX'.charAt(Math.floor(Lat / 8 + 10));
                    var ae = Math.floor(aa / 100000);
                    var af = ['ABCDEFGH', 'JKLMNPQR', 'STUVWXYZ'][(c - 1) % 3].charAt(ae - 1);
                    var ag = Math.floor(ab / 100000) % 20;
                    var ah = ['ABCDEFGHJKLMNPQRSTUV', 'FGHJKLMNPQRSTUVABCDE'][(c - 1) % 2].charAt(ag);

                    function pad(val) {
                        if (val < 10) {
                            val = '0000' + val
                        } else if (val < 100) {
                            val = '000' + val
                        } else if (val < 1000) {
                            val = '00' + val
                        } else if (val < 10000) {
                            val = '0' + val
                        };
                        return val
                    };

                    aa = Math.floor(aa % 100000);
                    aa = pad(aa);
                    ab = Math.floor(ab % 100000);
                    ab = pad(ab);
                    return c + ad + ' ' + af + ah + ' ' + aa + ' ' + ab;
                };

                

                const utmPosition = MGRSString(centerLat, centerLng);
                document.getElementById('location').innerText = utmPosition;                
                console.log(utmPosition);


            });
            



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
            centerMarker.addListener('click', function(event) {
                clickedLocation = event.latLng;
                showOptions(map, clickedLocation);
            });
            
            map.addListener('click', function(event) {
                clickedLocation = event.latLng;
                showOptions(map, clickedLocation);
            });
            // Initialize DrawingManager for drawing polylines
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: null, // Initially set to null
                drawingControl: false, // Disable drawing control
                polylineOptions: {
                editable: true,
                draggable: true,
                strokeColor: 'green', // Set polyline color to green
                strokeWeight: 3 // Set polyline width
                }
            });

            drawingManager.setMap(map);
            
            // Add controls for switching between 2D and 3D views
            var mapTypeControlDiv = document.createElement('div');
            var mapTypeControl = new MapTypeControl(mapTypeControlDiv, map);
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapTypeControlDiv);
            var myLocationControlDiv = document.createElement('div');
            var myLocationControl = new MyLocationControl(myLocationControlDiv, map);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(myLocationControlDiv);
            
            

            // Event listener for draw button
            document.getElementById('draw').addEventListener('click', function() {
                var sidebar = document.getElementById('sidebar');
                var isOpen = sidebar.style.right === '0px';
                sidebar.style.right = isOpen ? '-300px' : '0'; 

                if (drawingManager.getDrawingMode() === null) {
                    // Set drawing mode to polyline if not already in drawing mode
                    document.getElementById('ask-form-container').style.display = 'none';
                    document.getElementById('ask-form-container-label').style.display = 'none';
                    drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYLINE);
                } else {
                    // Cancel drawing mode if already in drawing mode
                    drawingManager.setDrawingMode(null);
                    removeDistanceLabels();
                    if (polyline) {
                        polyline.setMap(null);
                    }
                }
            });

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                if (event.type === google.maps.drawing.OverlayType.POLYLINE) {
                    polyline = event.overlay;
                    calculateDistanceLine(polyline);
                }
            });

            var markers = [];

            document.getElementById('delete-option').addEventListener('click', function() {
                document.getElementById('save-form-container').style.display = 'none';
                document.getElementById('ask-form-container').style.display = 'none';
                document.getElementById('ask-form-container-label').style.display = 'none';
                // Check if clickedLocation is defined before accessing its properties
                if (typeof clickedLocation !== 'undefined' && clickedLocation !== null) {
                    // Send AJAX request to delete location and label from the database
                    var xhrDelete = new XMLHttpRequest();
                    xhrDelete.open('POST', 'delete_location_data.php', true);
                    xhrDelete.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhrDelete.onreadystatechange = function() {
                        if (xhrDelete.readyState === 4) {
                            if (xhrDelete.status === 200) {
                                // Upon successful deletion, fetch all locations again
                                fetchAllLocations();
                            } else {
                                console.error('Error occurred while deleting data.');
                            }
                        }
                    };
                    // Prepare data to send
                    var dataDelete = 'lat=' + clickedLocation.lat() + '&lng=' + clickedLocation.lng();
                    xhrDelete.send(dataDelete);
                } else {
                    console.error('clickedLocation is not defined');
                }
            });
            // Event listener for save button
            document.getElementById('save-btn').addEventListener('click', function() {
                saveLocation();
            });
            // Function to save the location as a waypoint
            function saveLocation() {
                var locationName = document.getElementById('location-name-save').value;
                // Create a marker at the clicked location with a flag icon and label
                
                // Hide the form
                document.getElementById('save-form-container').style.display = 'none';
                document.getElementById('ask-form-container').style.display = 'none';
                document.getElementById('ask-form-container-label').style.display = 'none';

                // Prepare the data to send
                var data = new FormData();
                data.append('locationName', locationName);
                data.append('lat', clickedLocation.lat());
                data.append('lng', clickedLocation.lng());

                // Send an AJAX request to save the location data
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_location_data.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            // Upon successful saving, fetch all locations again
                            fetchAllLocations();
                        } else {
                            alert('Error occurred while saving data.');
                        }
                    }
                };
                xhr.send(data);

            }

            document.getElementById('delete-option').addEventListener('click', function() {
                document.getElementById('save-form-container').style.display = 'none';
                document.getElementById('ask-form-container').style.display = 'none';
                document.getElementById('ask-form-container-label').style.display = 'none';
                // Check if clickedLocation is defined before accessing its properties
                if (typeof clickedLocation !== 'undefined' && clickedLocation !== null) {
                    // Send AJAX request to delete location and label from the database
                    var xhrDelete = new XMLHttpRequest();
                    xhrDelete.open('POST', 'delete_location_data.php', true);
                    xhrDelete.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhrDelete.onreadystatechange = function() {
                        if (xhrDelete.readyState === 4) {
                            if (xhrDelete.status === 200) {
                                // Upon successful deletion, fetch all locations again
                                fetchAllLocations();
                            } else {
                                console.error('Error occurred while deleting data.');
                            }
                        }
                    };
                    // Prepare data to send
                    var dataDelete = 'lat=' + clickedLocation.lat() + '&lng=' + clickedLocation.lng();
                    xhrDelete.send(dataDelete);
                } else {
                    console.error('clickedLocation is not defined');
                }
            });


            // Function to fetch all locations from the server
            function fetchAllLocations() {
                fetch('all_location.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(locations => {
                    // Clear existing markers from the map
                    clearMarkers();
                    // Add markers for each location
                    locations.forEach(location => {
                        var marker = new google.maps.Marker({
                            position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
                            map: map,
                            icon: {
                                url: 'https://maps.google.com/mapfiles/kml/paddle/blu-circle.png', // Flag icon
                                scaledSize: new google.maps.Size(32, 32), // Adjust size as needed
                                labelOrigin: new google.maps.Point(16, 32) // Bottom center label
                            },
                            label: {
                                text: location.label,
                                color: 'white',
                                className: 'location-label-blue',
                                fontWeight: 'bold', // Make the text bold
                                padding: '6px 12px', // Padding around the text
                                borderRadius: '6px', // Border radius for rounded corners
                                fontSize: '14px', // Font size of the text
                                lineHeight: '1.5' // Line height of the text
                            }
                        });
                        marker.addListener('click', function(event) {
                            clickedLocation = event.latLng;
                            showOptionslabel(map, clickedLocation);
                        });
                        // Store marker in the markers array
                        markers.push(marker);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            }

            // Function to clear all markers from the map
            function clearMarkers() {
                // Clear all existing markers from the map
                markers.forEach(marker => {
                    marker.setMap(null);
                });
                // Clear the markers array
                markers = [];
            }
            fetchAllLocations();

           // Function to show the search popup
            function showSearchPopup() {
                var searchPopup = document.getElementById("search-container");
                searchPopup.style.display = "block";
            }

            // Function to close the search popup
            function closeSearchPopup() {
                var searchPopup = document.getElementById("search-container");
                searchPopup.style.display = "none";
            }

            // Event listener for opening the search popup
            document.getElementById('search-by-location').addEventListener('click', function() {
                showSearchPopup();
                var sidebar = document.getElementById('sidebar');
                var isOpen = sidebar.style.right === '0px';
                sidebar.style.right = isOpen ? '-300px' : '0'; 
            });

            // Event listener for closing the search popup
            document.querySelector(".close").addEventListener("click", function() {
                closeSearchPopup();
            });
            
            document.getElementById('search-btn').addEventListener('click', function() {
                var labelQuery = document.getElementById('search-input').value.trim().toLowerCase();
                // var mgrsQuery = document.getElementById('search-input-MGRS').value.trim().toUpperCase();

                if (labelQuery !== '') {
                    // Implement logic to search by label
                    searchByLabel(labelQuery);
                } 
                // else if (mgrsQuery !== '') {
                //     // Define the UTM coordinate string from the MGRS query
                //     function MGRSStringToLatLon(mgrsString) {
                //         // Parse the MGRS string
                //         const parts = mgrsString.split(' ');
                //         const zone = parseInt(parts[0]);
                //         const easting = parseInt(parts[2]);
                //         const northing = parseInt(parts[3]);

                //         // Convert MGRS to UTM
                //         const utm = MGRStoUTM(easting, northing, zone);

                //         // Convert UTM to Lat/Lon
                //         const latLon = UTMtoLatLon(utm);

                //         return latLon;
                //     }

                //     function MGRStoUTM(easting, northing, zone) {
                //         // Constants for UTM calculations
                //         const k0 = 0.9996; // Scale factor
                //         const a = 6378137; // Semi-major axis of Earth (WGS84)
                //         const f = 1 / 298.257223563; // Flattening factor

                //         // Calculate meridian arc length
                //         const n = f / (2 - f);
                //         const A = a / (1 + n) * (1 + Math.pow(n, 2) / 4 + Math.pow(n, 4) / 64);
                //         const alpha = [(3 / 2) * n - (27 / 32) * Math.pow(n, 3), (21 / 16) * Math.pow(n, 2) - (55 / 32) * Math.pow(n, 4), (151 / 96) * Math.pow(n, 3)];
                //         const beta = [(15 / 16) * Math.pow(n, 2) - (77 / 32) * Math.pow(n, 4), (35 / 48) * Math.pow(n, 3), (315 / 512) * Math.pow(n, 4)];

                //         const phi0 = 0; // Latitude of natural origin (equator)
                //         const lambda0 = (zone - 1) * 6 - 180 + 3; // Central meridian

                //         // Convert easting and northing to meters
                //         const E = easting - 500000;
                //         const N = northing;

                //         // Calculate latitude
                //         const xi = N / (k0 * A);
                //         const eta = E / (k0 * A);
                //         const xi_prime = xi - alpha[0] * Math.sin(2 * xi) * Math.cosh(2 * eta) - alpha[1] * Math.sin(4 * xi) * Math.cosh(4 * eta) - alpha[2] * Math.sin(6 * xi) * Math.cosh(6 * eta);
                //         const eta_prime = eta - beta[0] * Math.cos(2 * xi) * Math.sinh(2 * eta) - beta[1] * Math.cos(4 * xi) * Math.sinh(4 * eta) - beta[2] * Math.cos(6 * xi) * Math.sinh(6 * eta);
                //         const phi = Math.asin(Math.sin(xi_prime) / Math.cosh(eta_prime));

                //         // Calculate longitude
                //         const lambda = lambda0 + Math.atan(Math.sinh(eta_prime) / Math.cos(xi_prime));

                //         return { easting: E, northing: N, zone: zone, latitude: (phi * 180) / Math.PI, longitude: (lambda * 180) / Math.PI };
                //     }

                //     function UTMtoLatLon(utm) {
                //         // Define the UTM projection parameters
                //         const utmProjection = `+proj=utm +zone=${utm.zone} +ellps=WGS84`;

                //         // Define the projection parameters for WGS84
                //         const wgs84Projection = '+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs';

                //         // Convert UTM coordinates to latitude and longitude
                //         const latLongCoord = proj4(utmProjection, wgs84Projection, [utm.easting, utm.northing]);

                //         return { latitude: latLongCoord[1], longitude: latLongCoord[0] };
                //     }

                //     // Example usage:
                //     const mgrsString = "47Q KE 39402 38279";
                //     const latLonResult = MGRSStringToLatLon(mgrsString);
                //     console.log('Latitude:', latLonResult.latitude);
                //     console.log('Longitude:', latLonResult.longitude);

                //     // Assuming `map` is your Google Map object
                //     map.setCenter(new google.maps.LatLng(latLonResult.latitude, latLonResult.longitude));
                //     closeSearchPopup();
                
            // } 
            else {
                // Handle empty search queries
                console.log('Please enter a search query.');
            }
        });

        // Function to search by label
        function searchByLabel(labelQuery) {
            // Implement logic to search for the location label
            var foundLocation = markers.find(function(marker) {
                return marker.label.text.toLowerCase().includes(labelQuery);
            });
            if (foundLocation) {
                var position = foundLocation.getPosition();
                map.setCenter(position); // Set the center of the map to the found location
                map.setZoom(16); // Set the zoom level to 16
                closeSearchPopup();
            } else {
                console.log('Location not found.');
            }
        }
        document.querySelector(".mic-button").addEventListener("click", function() {
            const recognition = new webkitSpeechRecognition(); // For Chrome, you might need to use webkit prefix.

            recognition.lang = 'my-MM';
            recognition.start();
            console.log('Listening for speech...');
            recognition.onresult = (event) => {
                const result = event.results[0][0].transcript;
                
                console.log('transcript:', result);
                sendData(result); // Send the recognized text to the PHP script
            };
            recognition.onend = () => {
                
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error detected: ' + event.error);
            };

            function sendData(transcript) {
                $.ajax({
                    url: 'map_text.php',
                    type: 'GET',
                    data: { transcript: transcript },
                    success: function(response) {
                    if (response.success) {
                        const label = response.label;
                        searchByVoiceLabel(label);
                        
                        console.log('Predicted label:', label);
                    } else {
                        alert("Location not found.");
                    }
                    },
                    error: function(xhr, status, error) {
                    console.error('Error:', error);
                    }
                });
            }
            // const recognition = new webkitSpeechRecognition() || new SpeechRecognition();
            // recognition.lang = 'my'; // Set language to Burmese (Myanmar)
            // recognition.start();
            // console.log('Listening for speech...');

            // recognition.onresult = function(event) {
            //     const transcript = event.results[0][0].transcript;
            //     console.log('Speech recognition result:', transcript);
                
            //     if (transcript !== "") {
            //         // Perform a request to search for the label
            //         // For simplicity, let's assume you have a server-side endpoint to perform this search
            //         // Replace 'search_location_by_label.php' with your actual endpoint
            //         const xhr = new XMLHttpRequest();
            //         xhr.open("GET", `map_text.php?transcript=${encodeURIComponent(transcript)}`, true);
            //         xhr.onreadystatechange = function() {
            //             if (xhr.readyState === 4) {
            //                 if (xhr.status === 200) {
            //                     const response = JSON.parse(xhr.responseText);
            //                     if (response.success) {
            //                         const label = response.label;
            //                         searchByVoiceLabel(label);
            //                     } else {
            //                         alert("Location not found.");
            //                     }
            //                 } else {
            //                     alert("Error occurred while searching for location.");
            //                 }
            //             }
            //         };
            //         xhr.send();
            //     } else {
            //         alert("Please speak a location to search.");
            //     }
            // };

            // recognition.onerror = function(event) {
            //     console.error('Speech recognition error:', event.error);
            // };
        });

        function searchByVoiceLabel(labelQuery) {
            // Implement logic to search for the location label
            var foundLocation = markers.find(function(marker) {
                return marker.label.text.toLowerCase().includes(labelQuery);
            });
            if (foundLocation) {
                var position = foundLocation.getPosition();
                map.setCenter(position); // Set the center of the map to the found location
                map.setZoom(16); // Set the zoom level to 16
                closeSearchPopup();
            } else {
                console.log('Location not found.');
            }
        }


            
        }
        



        
        // Function to show options when clicking on the map
        function showOptions(map, location) {
            document.getElementById('ask-form-container').style.display = 'flex';
        }
        function showOptionslabel(map, location) {
            document.getElementById('ask-form-container-label').style.display = 'flex';
        }
        // Fetch saved locations from PHP script



        let distanceLabels = []; // Array to store references to distance labels
        let totalDistanceLabel = null; // Reference to the total distance label

        function calculateDistanceLine(polyline) {
            const path = polyline.getPath();
            let totalDistance = 0;
            for (let i = 0; i < path.getLength() - 1; i++) {
                const point1 = path.getAt(i);
                const point2 = path.getAt(i + 1);
                const segmentDistance = google.maps.geometry.spherical.computeDistanceBetween(point1, point2);
                totalDistance += segmentDistance;
                // Display the distance for each line segment
                const segmentMidPoint = google.maps.geometry.spherical.interpolate(point1, point2, 0.5);
                const distanceInKm = (segmentDistance / 1000).toFixed(2);
                const distanceLabel = new google.maps.Marker({
                    position: segmentMidPoint,
                    map: map,
                    label: {
                        text: distanceInKm + ' km',
                        color: 'gold',
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                });
                distanceLabels.push(distanceLabel); // Store reference to the distance label
            }
            // Display the total distance
            const totalDistanceInKm = (totalDistance / 1000).toFixed(2);
            totalDistanceLabel = new google.maps.Marker({
                position: path.getAt(Math.floor(path.getLength() / 2)),
                map: map,
                label: {
                    text: 'Total: ' + totalDistanceInKm + ' km',
                    color: 'gold',
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            });
        }

        // Function to remove distance labels and total distance label
        function removeDistanceLabels() {
            // Remove distance labels
            distanceLabels.forEach(label => {
                label.setMap(null);
            });
            distanceLabels = []; // Clear the array
            // Remove total distance label
            if (totalDistanceLabel) {
                totalDistanceLabel.setMap(null);
                totalDistanceLabel = null;
            }
        }

        // Function to handle errors in geolocation
        function handleLocationError(browserHasGeolocation, pos, map) {
            // Do something if geolocation fails
        }

        // Custom control for switching between 2D and 3D views
        function MapTypeControl(controlDiv, map) {
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#fff';
            controlUI.style.border = '2px solid #fff';
            controlUI.style.borderRadius = '3px';
            controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
            controlUI.style.cursor = 'pointer';
            controlUI.style.marginBottom = '22px';
            controlUI.style.textAlign = 'center';
            controlUI.title = 'Click to toggle map type';
            controlDiv.appendChild(controlUI);

            var controlText = document.createElement('div');
            controlText.style.color = 'rgb(25,25,25)';
            controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
            controlText.style.fontSize = '16px';
            controlText.style.lineHeight = '38px';
            controlText.style.paddingLeft = '5px';
            controlText.style.paddingRight = '5px';
            controlText.innerHTML = '<i class="fa-solid fa-layer-group"></i>';
            controlUI.appendChild(controlText);

            controlUI.addEventListener('click', function() {
                var currentMapTypeId = map.getMapTypeId();
                map.setMapTypeId(currentMapTypeId === 'hybrid' ? 'roadmap' : 'hybrid');
            });
        }

        // Custom control for finding user's location
        function MyLocationControl(controlDiv, map) {
            var controlUI = document.createElement('div');
            controlUI.id = 'find-my-location';
            controlUI.innerHTML = '<i class="fa-solid fa-map-location-dot"></i><span id="gps-coordinates"></span>';
            controlUI.style.backgroundColor = 'white';
            controlUI.style.color = '#000';
            controlUI.style.fontSize = '16px';
            controlUI.style.lineHeight = '38px';
            controlUI.style.paddingLeft = '5px';
            controlUI.style.paddingRight = '5px';
            controlUI.style.cursor = 'pointer';
            controlUI.style.zIndex = '9999';
            controlDiv.appendChild(controlUI);

            controlUI.addEventListener('click', function() {
                findMyLocation();
            });

            function updateGPS(coordinates) {
                document.getElementById('gps-coordinates').textContent = coordinates;
            }
        
            
        }

        // Function to find user's current location
        function findMyLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    map.setCenter(pos);
                }, function() {
                    handleLocationError(true, map.getCenter(), map);
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, map.getCenter(), map);
            }
        }

        // Function to convert degrees to mils (angular mils)
        function convertDegreesToMils(degrees) {
            // 360 degrees = 6400 mils
            var positiveDegrees = (degrees + 360) % 360; // Ensure positive degrees
            return (positiveDegrees * 6400 / 360).toFixed(2);
        }

        function calculateDistance(clickedPosition) {
            if (polyline) {
                polyline.setMap(null); // Remove existing polyline
                endMarker.setMap(null); // Remove existing end marker
            }
        
            var distance = google.maps.geometry.spherical.computeDistanceBetween(
                new google.maps.LatLng(currentLocation),
                clickedPosition
            );
            var distanceInKm = (distance / 1000).toFixed(2);
            var distanceInMeters = distance.toFixed(2); // Distance in meters
        
            // Calculate bearing in degrees
            var bearing = google.maps.geometry.spherical.computeHeading(
                currentLocation,
                clickedPosition
            );
        
            // Ensure the bearing is within the range of 0 to 360 degrees
            var positiveBearing = (bearing + 360) % 360;
        
            // Convert bearing to mils (angular mils)
            var mils = convertDegreesToMils(positiveBearing);
        
            // Draw polyline
            polyline = new google.maps.Polyline({
                path: [currentLocation, clickedPosition],
                geodesic: true,
                strokeColor: 'gold',
                strokeOpacity: 1.0,
                strokeWeight: 3,
                map: map
            });
        
            // Add end marker
            endMarker = new google.maps.Marker({
                position: clickedPosition,
                map: map,
                icon: {
                    url: 'https://maps.google.com/mapfiles/kml/paddle/blu-circle.png', // Flag icon
                    scaledSize: new google.maps.Size(32, 32), // Adjust size as needed
                    labelOrigin: new google.maps.Point(16, 16) // Center label
                },
                label: {
                    text: 'Waypoint',
                    color: 'white',
                    fontWeight: 'bold'
                }
            });
            function MGRSString(Lat, Long) {
                    if (Lat < -80) return 'Too far South';
                    if (Lat > 84) return 'Too far North';

                    var c = 1 + Math.floor((Long + 180) / 6);
                    var e = c * 6 - 183;
                    var k = Lat * Math.PI / 180;
                    var l = Long * Math.PI / 180;
                    var m = e * Math.PI / 180;
                    var n = Math.cos(k);
                    var o = 0.006739496819936062 * Math.pow(n, 2);
                    var p = 40680631590769 / (6356752.314 * Math.sqrt(1 + o));
                    var q = Math.tan(k);
                    var r = q * q;
                    var s = r * r * r - Math.pow(q, 6);
                    var t = l - m;
                    var u = 1.0 - r + o;
                    var v = 5.0 - r + 9 * o + 4.0 * (o * o);
                    var w = 5.0 - 18.0 * r + (r * r) + 14.0 * o - 58.0 * r * o;
                    var x = 61.0 - 58.0 * r + (r * r) + 270.0 * o - 330.0 * r * o;
                    var y = 61.0 - 479.0 * r + 179.0 * (r * r) - (r * r * r);
                    var z = 1385.0 - 3111.0 * r + 543.0 * (r * r) - (r * r * r);
                    var aa = p * n * t + (p / 6.0 * Math.pow(n, 3) * u * Math.pow(t, 3)) + (p / 120.0 * Math.pow(n, 5) * w * Math.pow(t, 5)) + (p / 5040.0 * Math.pow(n, 7) * y * Math.pow(t, 7));
                    var ab = 6367449.14570093 * (k - (0.00251882794504 * Math.sin(2 * k)) + (0.00000264354112 * Math.sin(4 * k)) - (0.00000000345262 * Math.sin(6 * k)) + (0.000000000004892 * Math.sin(8 * k))) + (q / 2.0 * p * Math.pow(n, 2) * Math.pow(t, 2)) + (q / 24.0 * p * Math.pow(n, 4) * v * Math.pow(t, 4)) + (q / 720.0 * p * Math.pow(n, 6) * x * Math.pow(t, 6)) + (q / 40320.0 * p * Math.pow(n, 8) * z * Math.pow(t, 8));
                    aa = aa * 0.9996 + 500000.0;
                    ab = ab * 0.9996;
                    if (ab < 0.0) ab += 10000000.0;
                    var ad = 'CDEFGHJKLMNPQRSTUVWXX'.charAt(Math.floor(Lat / 8 + 10));
                    var ae = Math.floor(aa / 100000);
                    var af = ['ABCDEFGH', 'JKLMNPQR', 'STUVWXYZ'][(c - 1) % 3].charAt(ae - 1);
                    var ag = Math.floor(ab / 100000) % 20;
                    var ah = ['ABCDEFGHJKLMNPQRSTUV', 'FGHJKLMNPQRSTUVABCDE'][(c - 1) % 2].charAt(ag);

                    function pad(val) {
                        if (val < 10) {
                            val = '0000' + val
                        } else if (val < 100) {
                            val = '000' + val
                        } else if (val < 1000) {
                            val = '00' + val
                        } else if (val < 10000) {
                            val = '0' + val
                        };
                        return val
                    };

                    aa = Math.floor(aa % 100000);
                    aa = pad(aa);
                    ab = Math.floor(ab % 100000);
                    ab = pad(ab);
                    return c + ad + ' ' + af + ah + ' ' + aa + ' ' + ab;
                };

                

            const utmPosition = MGRSString(clickedPosition.lat(), clickedPosition.lng());
        
            // Create cancellation of the polyline
            google.maps.event.addListener(polyline, 'click', function(event) {
                polyline.setMap(null); // Remove polyline
                endMarker.setMap(null); // Remove end marker
            });
        
            let contentString = '<div class="infowindow">Distance: ' + distanceInKm + ' km (' + distanceInMeters + ' m)</div>' +
                                '<div class="infowindow">Direction in degrees: ' + positiveBearing.toFixed(2) + '&deg;</div>' +
                                '<div class="infowindow">Direction in mils: ' + mils + ' mil</div>'  +
                                '<div class="infowindow">MGRS Location: ' + utmPosition + '</div>';
            infowindow.setContent(contentString);
            infowindow.setPosition(clickedPosition);
            infowindow.open(map);
        }
        
        

        
            // Function to fetch all locations from the server
            function fetchAllLocations() {
                fetch('all_location.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(locations => {
                    // Clear existing markers from the map
                    clearMarkers();
                    // Add markers for each location
                    locations.forEach(location => {
                        var marker = new google.maps.Marker({
                            position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
                            map: map,
                            icon: {
                                url: 'https://maps.google.com/mapfiles/kml/paddle/blu-circle.png', // Flag icon
                                scaledSize: new google.maps.Size(32, 32), // Adjust size as needed
                                labelOrigin: new google.maps.Point(16, 32) // Bottom center label
                            },
                            label: {
                                text: location.label,
                                color: 'white',
                                className: 'location-label-blue',
                                fontWeight: 'bold', // Make the text bold
                                padding: '6px 12px', // Padding around the text
                                borderRadius: '6px', // Border radius for rounded corners
                                fontSize: '14px', // Font size of the text
                                lineHeight: '1.5' // Line height of the text
                            }
                        });
                        marker.addListener('click', function(event) {
                            clickedLocation = event.latLng;
                            showOptionslabel(map, clickedLocation);
                        });
                        // Store marker in the markers array
                        markers.push(marker);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            }

            // Function to clear all markers from the map
            function clearMarkers() {
                // Clear all existing markers from the map
                markers.forEach(marker => {
                    marker.setMap(null);
                });
                // Clear the markers array
                markers = [];
            }
        
        

        // Event listener for calculate button
        document.querySelectorAll('#calculate-btn').forEach(function(calculateIcon) {
            calculateIcon.addEventListener('click', function() {
                calculateDistance(clickedLocation);
                document.getElementById('ask-form-container').style.display = 'none';
                document.getElementById('ask-form-container-label').style.display = 'none';
            });
        });

        
        document.getElementById('save-option').addEventListener('click', function() {
            document.getElementById('save-form-container').style.display = 'block';
            document.getElementById('ask-form-container').style.display = 'none';
            document.getElementById('ask-form-container-label').style.display = 'none';
        });


        // Event listener for cancel button
        document.querySelectorAll('#cancel-icon').forEach(function(cancelIcon) {
            cancelIcon.addEventListener('click', function() {
                document.getElementById('ask-form-container').style.display = 'none';
                document.getElementById('ask-form-container-label').style.display = 'none';
                document.getElementById('save-form-container').style.display = 'none';
            });
        });
        
        function drawCircles(clickedPosition) {
            if (!clickedPosition && !currentLocation) {
                console.error('No location provided.');
                return;
            }

            if (polyline) {
                polyline.setMap(null); // Remove existing polyline
                endMarker.setMap(null); // Remove existing end marker
            }

            // Determine the center position for drawing circles
            let centerPosition = clickedPosition || currentLocation;

            // Initialize bounds to include all circles
            let bounds = new google.maps.LatLngBounds();

            // Start drawing circles with a radius of 1000 meters
            for (let radius = 1000; radius <= 5000; radius += 1000) {
                let circleOptions = {
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '',
                    fillOpacity: 0,
                    map: map,
                    center: centerPosition,
                    radius: radius
                };

                // Draw the circle
                let circle = new google.maps.Circle(circleOptions);

                // Extend the bounds to include the circle
                bounds.union(circle.getBounds());

                let centerMarker = new google.maps.Marker({
                    position: centerPosition,
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 5,
                        fillColor: '#FF0000',
                        fillOpacity: 1,
                        strokeWeight: 0
                    },
                    zIndex: 1 // Ensure the marker is above the circle
                });

                // Calculate label position
                let labelPosition = calculateLabelPosition(centerPosition, radius);

                // Create label for the circle
                let label = new google.maps.Marker({
                    position: labelPosition,
                    map: map,
                    label: {
                        text: radius + 'm',
                        color: 'gold',
                        fontWeight: 'bold'
                    },
                    icon: {
                        url: 'data:image/svg+xml;utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>',
                    },
                    zIndex: 2 // Ensure the label is above the circle
                });

                // Create InfoWindow for the circle
                let infoWindowContent = '<div><button class="hide-btn">Hide</button></div>';
                let infoWindow = new google.maps.InfoWindow({
                    content: infoWindowContent
                });

                // Attach click event listener to the circle to open its InfoWindow
                google.maps.event.addListener(circle, 'click', function(event) {
                    infoWindow.setPosition(event.latLng);
                    infoWindow.open(map); // Open the InfoWindow
                });

                // Attach click event listener to the hide button to remove the circle
                google.maps.event.addListenerOnce(infoWindow, 'domready', function() {
                    let hideButton = document.querySelector('.hide-btn');
                    hideButton.addEventListener('click', function() {
                        circle.setMap(null); // Remove the circle
                        infoWindow.close(); // Close the InfoWindow
                        label.setMap(null); // Remove the label
                    });
                });
                
            }

            // Adjust map bounds to include all circles
            map.fitBounds(bounds);
        }





        // Function to calculate label position along the circumference of the circle
        function calculateLabelPosition(center, radius) {
            // Angle for label position
            let angle = 45; // Adjust as needed

            // Calculate label position using spherical geometry
            let labelPosition = google.maps.geometry.spherical.computeOffset(
                center,
                radius,
                angle
            );

            return labelPosition;
        }

        // Event listener for clicking on the MA7 option
        document.getElementById('ma7').addEventListener('click', function() {
            document.getElementById('ask-form-container').style.display = 'none';
            document.getElementById('ask-form-container-label').style.display = 'none';
            var sidebar = document.getElementById('sidebar');
            var isOpen = sidebar.style.right === '0px';
            sidebar.style.right = isOpen ? '-300px' : '0'; 
            drawCircles(clickedLocation);
        });

        // Function to check if a point is inside any of the circles
        function isPointInsideCircle(point, circles) {
            for (let i = 0; i < circles.length; i++) {
                if (google.maps.geometry.spherical.computeDistanceBetween(point, circles[i].getCenter()) <= circles[i].getRadius()) {
                    return true;
                }
            }
            return false;
        }

    </script>
    


    <!-- Load the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIiZlZsKy0XKQQzpOzWLBgcAf8P8dFoOc&libraries=geometry,drawing&callback=initMap" async defer></script>
    <!-- Replace 'YOUR_API_KEY' with your actual Google Maps API key -->

