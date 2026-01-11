<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research — NYU</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../css/research.css">
</head>
<body>
    <?php include '../components/navbar.php';?>
    <!-- Hero -->
    <section class="page-hero">
        <div class="hero-inner">
            <div class="hero-copy">
                <h1>Research & Labs</h1>
                <p>NYU research spans disciplines — from AI and machine learning to biomedical engineering, sustainability and the social sciences. Explore our labs, recent breakthroughs and collaborations with industry.</p>
                <a class="cta" href="#labs">Explore Labs</a>
            </div>
            <div class="hero-media">
                <img src="../img/research.jpg" alt="Research" style="width:420px;max-width:40vw;border-radius:10px;box-shadow:0 18px 40px rgba(20,30,80,0.12)">
            </div>
        </div>
    </section>

    <!-- Labs -->
    <section id="labs" class="labs-section">
        <h2 style="text-align:center;margin-bottom:1rem;color:#0f1724;">Our Labs</h2>
        <div class="labs-grid">
            <div class="lab-card">
                <h3>Center for Artificial Intelligence</h3>
                <p>Advancing deep learning research, responsible AI and applications in healthcare and language understanding.</p>
                <a href="#">Learn more →</a>
            </div>
            <div class="lab-card">
                <h3>Biomedical Engineering Lab</h3>
                <p>Bringing together engineers and clinicians to develop next-generation diagnostic and therapeutic technologies.</p>
                <a href="#">Learn more →</a>
            </div>
            <div class="lab-card">
                <h3>Sustainability & Climate Research</h3>
                <p>Interdisciplinary projects addressing climate resilience, urban systems and sustainable design.</p>
                <a href="#">Learn more →</a>
            </div>
            <div class="lab-card">
                <h3>Human-Computer Interaction Studio</h3>
                <p>Designing and evaluating next-generation interfaces, accessibility tools, and mixed-reality experiences.</p>
                <a href="#">Learn more →</a>
            </div>
        </div>
    </section>

    <!-- Latest Tech -->
    <section class="tech-section">
        <h2 style="text-align:center;margin-bottom:1rem;color:#0f1724;">Latest Technology & Publications</h2>
        <div class="tech-grid">
            <article class="tech-card">
                <img src="../img/research_1.jpg" alt="tech">
                <h4>Efficient Language Models</h4>
                <p>New approaches to compress and distill language models without losing quality.</p>
            </article>
            <article class="tech-card">
                <img src="../img/research_2.jpg" alt="tech">
                <h4>Wearable Health Sensors</h4>
                <p>Low-power sensing and analytics for continuous health monitoring in real-world settings.</p>
            </article>
            <article class="tech-card">
                <img src="../img/research_3.jpg" alt="tech">
                <h4>Urban Climate Modeling</h4>
                <p>High-resolution simulations to predict heat islands and inform mitigation strategies.</p>
            </article>
            <article class="tech-card">
                <img src="../img/research_4.jpg" alt="tech">
                <h4>Robotics & Automation</h4>
                <p>Robust perception and control systems for collaborative robots in complex environments.</p>
            </article>
        </div>
    </section>

    <?php include '../components/footer.php';?>

</body>
</html>
