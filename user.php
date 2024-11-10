<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html?login=user"); // Redirect to login page if not logged in
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>GoOn Airline - Services</title>
    <style>
       
       .modal-content .close {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #aaa;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}
            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
            }

     
        /* Input field styling */
        input[type="text"],
        input[type="date"],
        input[type="number"],
        button {
            width: 90%; /* Full width for inputs */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

            button:hover {
                background-color: #00aaff;
            }
            .button {
            width: 20%; /* Full width for inputs */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #00aaff;
            color: white;
            border: none;
            cursor: pointer;
        }

            .button:hover {
                background-color: #00aaff;
            }
            .destinations-section {
            padding: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.0);
            margin: 20px 0;
        }
       /* Live search suggestion container */
#livesearch-from, #livesearch-to {
    border: 1px solid #A5ACB2;
    display: none; /* Initially hidden */
    width: 100%;
    max-width: 300px;
    background-color: white;
    position: absolute;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 5px;
    border-radius: 4px;
    padding: 5px 0;
    left: 0;  /* Align suggestion box with the left edge of the input */
    cursor: pointer;}
    

/* Styling for each suggestion item */
#livesearch-from div, #livesearch-to div {
    padding: 10px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
    padding-left: 12px;
}

/* Hover effect for suggestion items */
#livesearch-from div:hover, #livesearch-to div:hover {
    background-color: #f0f0f0;
    color: #007bff;
}

/* Ensure the input fields are positioned relative to contain the absolute dropdown */
input[type="text"] {
    position: relative;
    padding-right: 25px;
}

        
        
    </style>
</head>
<body>
    <header>
        <h1>GoOn Airline</h1>
        <p>The best journey starts with us...</p>
        <nav>
            <a href="user.html">Home</a>
            <a class="tablink"onclick="openModal('bookFlightModal')">Book a Flight</a>
            <a class="tablink" onclick="openModal('manageFlightModal')">Manage Flight</a>
            <a href="#" class="tablink" onclick="openModal('checkStatusModal')">Check Flight Status</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
   
    <div class="news-section">
        <div class="carousel">
            <div class="news-item" style="background-image: url('airline2.jpg');"onclick="window.location.href='dubai.html';">
                <div class="overlay">
                    <h3> New Route Launch</h3>
                    <p>"GoOn Airlines is proud to introduce our newest route international with non-stop flights from Goa to Dubai. Enjoy world-class service as you explore Dubai’s rich culture and cuisine."</p>
                    <a href="dubai.html" target="_blank" class="button">Know More</a>
                </div>
            </div>
            <div class="news-item" style="background-image: url('visa.jpg');">
                <div class="overlay">
                    <h3>Visa Assistance for Your Destination</h3>
                    <p>GoOn Airline offers comprehensive support to help you understand and manage visa requirements for your chosen destination. Our team stays up-to-date with the latest travel regulations and ensures you have the right information at the right time.</p>
                    <a href="dubai.html" target="_blank" class="button">Know More</a>
                </div>
            </div>
            <div class="news-item" style="background-image: url('family.jpg');">
                <div class="overlay">
                    <h3>Assistance for Families and Special Needs</h3>
                    <p>Traveling with children, elderly family members, or passengers with reduced mobility? We’re here to make your experience seamless.</p>
                    <a href="dubai.html" target="_blank" class="button">Know More</a>
                </div>
            </div>
        </div>
        <div class="nav-dots">
            <span class="dot" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </div>
    <div class="destinations-section">
        <h2 style="color:antiquewhite">Destinations We Fly</h2>
        <div class="destination-item" onclick="window.location.href='goa.html';" style="background-image:url('goa.jpg'); background-size: cover;">
            <h3>Goa</h3>
            <p>Explore the beaches and vibrant culture of Goa.</p>
        </div>
        <div class="destination-item" onclick="window.location.href='mumbai.html';"style="background-image:url('mumbai.jpg'); background-size: cover;">
            <h3>Mumbai</h3>
            <p>Discover the city that never sleeps with amazing sights.</p>
        </div>
        <div class="destination-item" onclick="window.location.href='delhi.html';"style="background-image:url('delhi.jpg'); background-size: cover;">
            <h3>Delhi</h3>
            <p>Experience the rich history and modernity of Delhi.</p>
        </div>
        <div class="destination-item" onclick="window.location.href='dubai.html';"style="background-image:url('airline2.jpg'); background-size: cover;">
            <h3>Dubai</h3>
            <p>Indulge in luxury shopping, desert safaris, and much more.</p>
        </div>
        
    </div>
    
    <div id="bookFlightModal" class="modal">
        <div class="modal-content">
            <!-- Corrected close modal target here -->
            <span class="close" onclick="closeModal('bookFlightModal')">&times;</span>
            <h2>Book a Flight</h2>
            <p style="color:#aaa">Search and Book flights here</p>
            <form action="Search.php" method="post" onsubmit="return validateBook()">
               
                    <label for="one-way">One-Way</label>
                    <input type="radio" id="one-way" name="trip-type" value="oneway" checked>
                    <label for="round-trip">Round-Trip</label>
                    <input type="radio" id="round-trip" name="trip-type" value="roundtrip">
                <br/><br/>
                <div class="dropdown-container">
                <label for="from">From:</label><br/>
                <input type="text" id="from" name="from"  placeholder="Departure City or Airport" required>
                <div id="livesearch-from"></div>
</div>
<div class="dropdown-container">
                <br/><label for="to">To:</label><br/>
                <input type="text" id="to" name="to" placeholder="Arrival City or Airport" required>
                <div id="livesearch-to"></div>
</div>
                <br/><label for="departure">Departure Date:</label>
                <input type="date" id="departure" name="departure" required>
                <div id="return-date-container" style="display: none;">
                <br/><label for="return">Return Date:</label>
                <input type="date" id="return" name="return">
                </div>
               <br/> <label for="passengers">Passengers:</label>
                <select id="passengers" name="passengers" required min="1" max="5">
                    <option value="none" selected>Select No of Passangers</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select><br/><br/>

                <label for="class">Class:</label>
                <select id="class" name="class" required>
                    <option value="none" selected>Select Class</option>
                    <option value="economy">Economy</option>
                    <option value="business">Business</option>
                </select><br/><br/>

                <button type="submit">Search Flights</button>
            </form>
        </div>
    </div>

    <!-- Manage Flight Modal -->
    <div id="manageFlightModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('manageFlightModal')">&times;</span>
            <h2>Manage Your Flight</h2>
            <p style="color:#aaa">Check your flight deatils,manage your trips and more</p>
            <form action="manageFlight.php" method="post" onsubmit="return validateFlight()">
                <input type="text" name="PNR" placeholder="Booking Reference(PNR)" required>
                <input type="text" name="lastName" placeholder="Last Name" required>
                <button type="submit">Manage Flight</button>
            </form>
        </div>
    </div>

    <!-- Check Flight Status Modal -->
    <div id="checkStatusModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('checkStatusModal')">&times;</span>
            <h2>Check Flight Status</h2>
            <p style="color:#aaa">Check your flight status</p>
            <form action="checkStatus.php" method="post" onsubmit="return validateStatus()">
                <input type="text" name="flightNumber" placeholder="Flight Number" required>
                <button type="submit">Check Status</button>
            </form>
        </div>
    </div>
    <footer>
        <p>2024 Airline Reservation. All Rights Reserved.</p>
    </footer>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block"; // Show the modal
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none"; // Hide the modal
        }

        // Close modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        };
        
        let slideIndex = 0;
let slideInterval;  // Variable to store the interval ID for auto-sliding

function showSlides() {
    const slides = document.querySelectorAll(".news-item");
    const dots = document.querySelectorAll(".dot");

    // Hide all slides and remove active class from all dots
    slides.forEach((slide) => {
        slide.style.opacity = 0;
    });
    dots.forEach((dot) => {
        dot.classList.remove("active");
    });

    // Show the current slide and activate the corresponding dot
    slides[slideIndex].style.opacity = 1;
    dots[slideIndex].classList.add("active");
}

function plusSlides(n) {
    slideIndex += n;
    
    if (slideIndex >= document.querySelectorAll(".news-item").length) {
        slideIndex = 0; // Loop back to the first slide
    }
    
    if (slideIndex < 0) {
        slideIndex = document.querySelectorAll(".news-item").length - 1; // Go to the last slide if going backward
    }

    showSlides();
    resetAutoSlide();  // Reset auto-slide when the user manually navigates
}

function currentSlide(n) {
    slideIndex = n;
    showSlides();
    resetAutoSlide();  // Reset auto-slide when the user clicks a dot
}

// Function to reset or restart the auto-slide interval
function resetAutoSlide() {
    // Clear the existing auto-slide interval (if any)
    clearInterval(slideInterval);

    // Set a new interval to auto-slide every 3 seconds
    slideInterval = setInterval(function() {
        plusSlides(1);
    }, 3000);
}

// Initialize the slideshow
showSlides();

// Optionally, set an auto-slide interval (e.g., every 3 seconds)
resetAutoSlide();

function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Set the minimum date for both date inputs
        const minDate = getTodayDate();
        document.getElementById('departure').setAttribute('min', minDate);
        document.getElementById('return').setAttribute('min', minDate);
        document.querySelectorAll('input[name="trip-type"]').forEach(function (element) {
            element.addEventListener('change', function () {
                document.getElementById('return-date-container').style.display = this.id === 'round-trip' ? 'block' : 'none';
            });
        });
            // JavaScript to toggle the display of the return date field
            document.querySelectorAll('input[name="trip-type"]').forEach(function (element) {
            element.addEventListener('change', function () {
                document.getElementById('return-date-container').style.display = this.id === 'round-trip' ? 'block' : 'none';
            });
        });
        $(document).ready(function () {
    // Function to handle input and show suggestions for both "From" and "To"
    function handleInput(inputId, dropdownId, type) {
        $(inputId).on('input', function () {
            var query = $(this).val().trim();
            if (query.length > 0) {
                // Send AJAX request to get suggestions based on the input field type ("from" or "to")
                $.ajax({
                    url: 'suggestion.php',  // PHP file to fetch location data
                    type: 'GET',
                    data: { q: query, type: type },
                    success: function (data) {
                        // Parse the returned data
                        var locations = JSON.parse(data);
                        var dropdown = $(dropdownId);
                        dropdown.empty();  // Clear previous results

                        if (locations.length > 0) {
                            locations.forEach(function (location) {
                                dropdown.append('<div onclick="selectLocation(\'' + location + '\', \'' + inputId + '\')">' + location + '</div>');
                            });
                            dropdown.show();  // Show the dropdown if results are found
                        } else {
                            // Show "No locations found" and make it clickable
                            dropdown.append('<div class="no-location" onclick="hideDropdown(\'' + dropdownId + '\')">No locations found</div>');
                            dropdown.show();
                        }
                    }
                });
            } else {
                $(dropdownId).hide();  // Hide the dropdown if input is empty
            }
        });
    }

    // Function to set the input field with the selected location
    window.selectLocation = function (location, inputId) {
        $(inputId).val(location);
        $(inputId).next('div').hide();  // Hide the dropdown after selection
    };

    // Function to hide the dropdown (for "No locations found" click)
    window.hideDropdown = function (dropdownId) {
        $(dropdownId).hide();  // Hide the dropdown when "No locations found" is clicked
    };

    // Close dropdown if user clicks anywhere outside the input or dropdown
    $(document).on('click', function (event) {
        var target = $(event.target);
        // Check if the clicked target is outside of input and dropdown
        if (!target.closest('#from, #livesearch-from').length && !target.closest('#to, #livesearch-to').length) {
            $('#livesearch-from').hide();  // Hide 'from' dropdown
            $('#livesearch-to').hide();    // Hide 'to' dropdown
        }
    });

    // Initialize the input handlers for both "From" and "To"
    handleInput('#from', '#livesearch-from', 'from');
    handleInput('#to', '#livesearch-to', 'to');
});


        
        function clearResults() {
            document.getElementById("search").value = ''; // Clear the search input
        }
        
        function validateBook() {
    let from = document.getElementById("from").value;
    let to = document.getElementById("to").value;
    let departure = document.getElementById("departure").value;
    let returnDate = document.getElementById("return").value; // Add this line to capture return date
    let passengers = document.getElementById("passengers").value;
    let classType = document.getElementById("class").value;

    // Check if the "From" and "To" fields are not empty
    if (from === "") {
        alert("Select departure city or airport");
        return false;
    }
    if (to === "") {
        alert("Select arrival city or airport");
        return false;
    }

    // Check if "From" and "To" are not the same
    if (from.toLowerCase() === to.toLowerCase()) {
        alert("Departure city and arrival city cannot be the same.");
        document.getElementById("from").value = ""; // Clear departure date
            document.getElementById("to").value = "";    // Clear return date

        return false; // Prevent form submission
    }

    // Check if passengers is a valid selection
    if (parseInt(passengers) < 1 || parseInt(passengers) > 5) {
        alert("Please select a valid number of passengers.");
        return false; // Prevent form submission
    }

    // If "Round-Trip" is selected, validate the dates
    if (document.getElementById('round-trip').checked) {
        if (departure === "" || returnDate === "") {
            alert("Please select both Departure Date and Return Date for a Round-Trip.");
            return false; // Prevent form submission
        }

        // Ensure the Return Date is after the Departure Date (additional check)
        if (new Date(returnDate) < new Date(departure)) {
            alert("Return date must be after the departure date.");
            document.getElementById("departure").value = ""; // Clear departure date
            document.getElementById("return").value = "";    // Clear return date

            return false; // Prevent form submission
        }
    }
    if (document.getElementById('one-way').checked) {
        if (departure === "" ) {
            alert("Please select Departure Date .");
            return false; // Prevent form submission
        }

       
    }

    return true; // Allow form submission if all checks pass
}
function validateFlight() {
    let pnr = document.getElementsByName("PNR")[0].value;
    let lastName = document.getElementsByName("lastName")[0].value;

    // Validate PNR field (checking if it's not empty and if it's alphanumeric)
    if (pnr.trim() === ""||pnr.length>6||pnr.length<6) {
        alert("Please enter valid Booking Reference (PNR).");
        return false; // Prevent form submission
    }
    
    if (!/^[a-zA-Z0-9]+$/.test(pnr)) {
        alert("PNR should be alphanumeric.");
        return false; // Prevent form submission
    }

    // Validate lastName field (checking if it's not empty)
    if (lastName.trim() === "") {
        alert("Please enter your Last Name.");
        return false; // Prevent form submission
    }

    return true; // Allow form submission if all checks pass
}
function validateStatus() {
    let flightNumber = document.getElementsByName("flightNumber")[0].value.trim();

    // Validate Flight Number (should be airline code + exactly 3 digits, e.g., AA123)
    if (flightNumber === "") {
        alert("Please enter a Flight Number.");
        return false; // Prevent form submission
    }

    // Flight number validation: airline code (2+ letters) followed by exactly 3 digits
    const flightNumberPattern = /^[A-Z]{2,}[0-9]{3}$/; // Match 2+ uppercase letters followed by exactly 3 digits
    if (!flightNumberPattern.test(flightNumber)) {
        alert("Flight number must start with 2 or more uppercase letters followed by exactly 3 digits (e.g., AA123).");
        return false; // Prevent form submission
    }

    return true; // Allow form submission if all checks pass
}

    </script>
</body>
</html>
