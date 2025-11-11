<?php

// Set the timezone to Athens to ensure the correct local time.
date_default_timezone_set("Europe/Athens");

// Get the current date and time in "Month Day, Year - Hour:Minute" format.
$currentDateTime = date("F j, Y - H:i");

// Display the formatted date and time.
echo "Today is: $currentDateTime<br>";

// Get the full name of the current day (e.g., "Saturday" or "Sunday").
$dayOfWeek = date("l");

// Check if the day is Saturday or Sunday.
if ($dayOfWeek == "Saturday" || $dayOfWeek == "Sunday") {
    // Display a weekend message if it is Saturday or Sunday.
    echo "It's the weekend! Enjoy your time off!";
}
