<?php
// Function that groups emails by domain in an associative array
function groupEmailsByDomain($emails) {
    $grouped = []; // Initialize an empty associative array
    foreach ($emails as $email) { // Loop through each email
        $domain = explode('@', $email)[1]; // Extract the domain part
        $grouped[$domain][] = $email; // Add the email under its domain
    }
    return $grouped; // Return the grouped emails
}
