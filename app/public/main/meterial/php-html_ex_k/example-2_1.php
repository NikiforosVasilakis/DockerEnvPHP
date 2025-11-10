<?php
// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Display the received data (for demonstration purposes)
    echo "<h2>Form Data Received:</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Message:</strong> $message</p>";
    
    // In real-world applications, you would typically store the data in a database, send an email, etc.
}
