<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NYU - New York University</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="styles.css">
    </head>
<body>
    <?php include '../components/navbar.php';?>
    <!-- Hero Section -->
    <section class="hero-wrapper">
        <div class="hero">
            <div class="hero-image">
                <div class="hero-overlay">
                    <h1 class="hero-text">New York</h1>
                </div>
                <img src="../img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="NYU Campus" class="hero-bg">
            </div>
            <div class="promo-banner">
                <div class="promo-content">
                    <div class="promo-year">2025</div>
                    <div class="promo-message">
                        Fully Funded Graduate Studentship For 2025-2026. Check our selection of studentship accepting applications now.
                    </div>
                    <div class="promo-nav">
                        <button class="nav-arrow" aria-label="Previous">‹</button>
                        <button class="nav-arrow" aria-label="Next">›</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="history-section">
        <div class="history-container">
            <h2 class="history-title">History</h2>
            <div class="history-content">
                <p>
                    New York University has a rich and storied history spanning nearly two centuries. Founded in 1831, 
                    NYU has grown from a small institution into one of the world's leading research universities, 
                    consistently ranking among the top universities globally.
                </p>
                <p>
                    Throughout its distinguished history, NYU has been at the forefront of academic excellence, 
                    research innovation, and social progress. From its humble beginnings in lower Manhattan, 
                    the university has expanded to multiple campuses and become a beacon of intellectual achievement 
                    and cultural diversity.
                </p>
                <p>
                    Today, NYU continues its legacy of excellence through groundbreaking research, world-class faculty, 
                    and a vibrant community of scholars, artists, and leaders from around the globe. Our commitment 
                    to pushing the boundaries of knowledge and fostering critical thinking remains as strong as ever.
                </p>
            </div>
        </div>
    </section>

    <?php include '../components/footer.php';?>
</body>
</html>

