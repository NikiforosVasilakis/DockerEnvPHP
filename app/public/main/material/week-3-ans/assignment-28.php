<?php

// Define 'registrationTimestamp' with a Unix timestamp representing registration time.
$registrationTimestamp = 1698741600; // Example timestamp

// Get the current time in seconds since the Unix epoch.
$currentTimestamp = time();

// Calculate the time difference between now and registration time in seconds.
$timeDifference = $currentTimestamp - $registrationTimestamp;

// Convert the time difference from seconds to hours.
$hoursSinceRegistration = floor($timeDifference / 3600);

// Display the number of hours since registration.
echo "You registered $hoursSinceRegistration hours ago.";
