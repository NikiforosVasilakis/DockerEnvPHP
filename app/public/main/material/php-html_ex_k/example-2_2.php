<?php
// Define a function to sanitize input data and prevent XSS attacks
function sanitizeInput($data) {
    // Trim the input, strip unnecessary HTML tags, and encode special characters
    return htmlspecialchars(strip_tags(trim($data)));
}

// Initialize variables for form fields
$name = $email = $message = "";

// Define an array to collect errors
$errors = [];

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the name
    if (!empty($_POST['name'])) {
        $name = sanitizeInput($_POST['name']);
        if (strlen($name) < 3) {
            $errors['name'] = "Name must be at least 3 characters long.";
        }
    } else {
        $errors['name'] = "Name is required.";
    }

    // Sanitize and validate the email
    if (!empty($_POST['email'])) {
        $email = sanitizeInput($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
    } else {
        $errors['email'] = "Email is required.";
    }

    // Sanitize and validate the message
    if (!empty($_POST['message'])) {
        $message = sanitizeInput($_POST['message']);
        if (strlen($message) < 5) {
            $errors['message'] = "Message must be at least 5 characters long.";
        }
    } else {
        $errors['message'] = "Message is required.";
    }

    // If there are no errors, proceed with processing the data
    if (empty($errors)) {
        // Here you can proceed to save the data to a database, send an email, etc.
        // Example: Save to database or send an email (omitted for simplicity)

        // Display success message
        echo "<h2>Form Submission Successful</h2>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
        echo "<p><strong>Message:</strong> " . nl2br(htmlspecialchars($message)) . "</p>";
    } else {
        // Display errors
        echo "<h2>Form Submission Failed</h2>";
        foreach ($errors as $field => $error) {
            echo "<p><strong>Error in $field:</strong> $error</p>";
        }
    }
} else {
    echo "<h2>No form data submitted.</h2>";
}
