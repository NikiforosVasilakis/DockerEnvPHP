<?php
// Define an associative array to store the navigation items and their corresponding query strings
$navItems = [
    "Home" => "home",
    "About" => "about",
    "Services" => "services",
    "Portfolio" => "portfolio",
    "Contact" => "contact"
];

// Get the current page from the query string or set a default value of "home"
$currentPage = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="exercise-4.css">
    <title>Navigation Menu</title>
    <style>
        /* Basic CSS for the navigation menu and active class */
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-between;
        }
        nav ul li a.active {
            font-weight: bold;
            color: #ffcc00;
            background: #555;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <?php
                // Loop through the navigation items and create each <li> dynamically
                foreach ($navItems as $itemName => $itemPage) {
                    // Sanitize both the item name and page name for security
                    $safeItemName = htmlspecialchars($itemName);
                    $safeItemPage = htmlspecialchars($itemPage);

                    // Determine if this page is the current page to add an "active" class
                    $activeClass = ($currentPage === $safeItemPage) ? 'active' : '';
                    
                    // Generate the <li> element with a dynamic URL and class
                    echo "<li><a href=\"?page=$safeItemPage\" class=\"$activeClass\">$safeItemName</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>

    <article>
        <?php
        // Display content based on the current page
        switch ($currentPage) {
            case 'home':
                echo "<h2>Welcome to the Home Page</h2>";
                echo "<p>This is the homepage of our website. Explore different sections using the navigation menu above.</p>";
                break;
            case 'about':
                echo "<h2>About Us</h2>";
                echo "<p>Learn more about our company and what we do.</p>";
                break;
            case 'services':
                echo "<h2>Our Services</h2>";
                echo "<p>We offer a wide range of services to meet your needs.</p>";
                break;
            case 'portfolio':
                echo "<h2>Our Portfolio</h2>";
                echo "<p>Check out our portfolio to see our past projects.</p>";
                break;
            case 'contact':
                echo "<h2>Contact Us</h2>";
                echo "<p>If you have any questions, feel free to reach out through our contact page.</p>";
                break;
            default:
                echo "<h2>Page Not Found</h2>";
                echo "<p>The page you are looking for does not exist.</p>";
                break;
        }
        ?>
    </article>
</body>
</html>
