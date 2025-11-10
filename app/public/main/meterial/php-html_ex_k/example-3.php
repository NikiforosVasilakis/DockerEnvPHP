<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="exercise-3.css">
    <title>Article Page</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="example-3.php?section=intro">Introduction</a></li>
            <li><a href="example-3.php?section=html">Importance of HTML</a></li>
        </ul>
    </nav>
    <article>
        <h2>Web Development Topics</h2>
        <?php
        // Check if the 'section' GET variable is set
        if (isset($_GET['section'])) {
            // Sanitize the GET variable to avoid XSS attacks
            $section = htmlspecialchars($_GET['section']);

            // Display content based on the selected section
            switch ($section) {
                case 'intro':
                    echo "<section>";
                    echo "<h3>Overview</h3>";
                    echo "<p>Web development is the process of creating websites that are accessed through the internet or an intranet. It encompasses several aspects including web design, content development, client-side/server-side scripting, and network security.</p>";
                    echo "</section>";
                    break;

                case 'html':
                    echo "<section class='section-with-image'>";
                    echo "<h3>Importance of HTML</h3>";
                    echo "<img src='html-image.png' alt='HTML Illustration' class='float-image'>";
                    echo "<p>HTML, or HyperText Markup Language, is the fundamental building block of web development. It is used to structure web content, allowing developers to define headings, paragraphs, images, links, and other elements that make up a webpage.</p>";
                    echo "<p>With HTML, you can create documents that can be displayed by web browsers and ensure that the content is properly organized and accessible. Understanding HTML is the first step for anyone looking to enter the world of web development, as it provides the basic framework upon which all websites are built.</p>";
                    echo "</section>";
                    break;

                default:
                    echo "<section>";
                    echo "<h3>Unknown Section</h3>";
                    echo "<p>The section you selected is not available. Please choose a valid section from the menu.</p>";
                    echo "</section>";
                    break;
            }
        } else {
            // Default content when no section is selected
            echo "<section>";
            echo "<h3>Welcome to Web Development Articles</h3>";
            echo "<p>Please choose a section from the navigation menu to learn more about specific web development topics.</p>";
            echo "</section>";
        }
        ?>
    </article>
</body>
</html>
