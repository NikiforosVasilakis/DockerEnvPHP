<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Life - New York University</title>
    <link rel="stylesheet" href="../styles.css"> 
    <link rel="stylesheet" href="../css/campus_life.css">
</head>
<body>
    <?php include '../components/navbar.php';?>

    <!-- Hero (matches other pages) -->
    <section class="page-hero">
        <div class="hero-inner">
            <div class="hero-copy">
                <h1>Campus Life</h1>
                <p>Experience the Vibrant NYU Community — student groups, housing, dining, and city life all around our campuses.</p>
                <a class="cta" href="#life">Explore Campus Life</a>
            </div>
            <div class="hero-media">
                <img src="img/nyu-camp.jpg" alt="Campus Life" style="width:420px;max-width:40vw;border-radius:10px;box-shadow:0 18px 40px rgba(20,30,80,0.12)">
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <section class="content-section">
            <div class="content-wrapper">
                <h2>Student Life at NYU</h2>
                <p>Life at NYU extends far beyond the classroom. With our location in the heart of New York City, students have access to world-class cultural institutions, internships, and career opportunities.</p>
            </div>
        </section>

        <section class="content-section">
            <div class="life-grid">
                <div class="life-card">
                    <img src="../img/bb.jpg" alt="Student Activities" class="life-img">
                    <div class="life-content">
                        <h3>Student Organizations</h3>
                        <p>Join over 300 student clubs and organizations covering interests from academics to arts, culture, and community service.</p>
                    </div>
                </div>
                <div class="life-card">
                    <img src="../img/fl.jpg" alt="Housing" class="life-img">
                    <div class="life-content">
                        <h3>Housing & Residence Life</h3>
                        <p>Live in the heart of NYC with a variety of residence halls offering different living experiences and communities.</p>
                    </div>
                </div>
                <div class="life-card">
                    <img src="../img/s-colab.jpg" alt="Dining" class="life-img">
                    <div class="life-content">
                        <h3>Dining & Services</h3>
                        <p>Enjoy diverse dining options across campus, from cafes to dining halls, featuring cuisines from around the world.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-section city-section">
            <div class="content-wrapper">
                <div>
                    <h2>New York City as Your Campus</h2>
                    <p>NYU's location in Greenwich Village places you at the center of one of the world's most vibrant cities. Students access internships, cultural institutions, and career opportunities that turn the city into a living classroom.</p>
                    <p style="margin-top:0.8rem;">Discover opportunities in the arts, finance, tech, and public service — and connect with local organizations through courses, clinics and community partnerships.</p>
                </div>
                <aside class="city-cta">
                    <a class="cta" href="#">View Student Resources</a>
                    <a class="outline-btn" href="php-files/register.php">Join NYU Community</a>
                </aside>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php';?>
</body>
</html>

