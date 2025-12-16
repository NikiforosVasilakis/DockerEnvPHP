<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics — NYU</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/academics.css">
</head>
<body>
    <!-- Header Navigation -->
    <?php include 'components/navbar.php'; ?>

    <!-- Programs grid -->
    <section id="programs" class="programs">
        <article class="program-card">
            <div class="program-meta">Bachelor's &amp; Graduate</div>
            <h3>Computer Science</h3>
            <p>Practical and theoretical foundations in algorithms, systems, machine learning, and software engineering. Strong internship pipelines and research labs focused on AI, security, and data science.</p>
            <div class="program-actions">
                <a class="cta" href="#" style="text-decoration:none;">Learn more</a>
                <a class="outline-btn" href="php-files/register.php">Apply / Register</a>
            </div>
        </article>

        <article class="program-card">
            <div class="program-meta">Bachelor's &amp; Graduate</div>
            <h3>Business &amp; Management</h3>
            <p>Programs in finance, marketing, entrepreneurship and analytics that combine classroom theory with real-world projects, incubators and global study options.</p>
            <div class="program-actions">
                <a class="cta" href="#">Learn more</a>
                <a class="outline-btn" href="php-files/register.php">Apply / Register</a>
            </div>
        </article>

        <article class="program-card">
            <div class="program-meta">Bachelor's &amp; Graduate</div>
            <h3>Engineering</h3>
            <p>Electrical, Mechanical and Biomedical tracks that emphasize design, lab work, and industry collaboration. Strong focus on sustainability and robotics research.</p>
            <div class="program-actions">
                <a class="cta" href="#">Learn more</a>
                <a class="outline-btn" href="php-files/register.php">Apply / Register</a>
            </div>
        </article>

        <article class="program-card">
            <div class="program-meta">Bachelor's &amp; Graduate</div>
            <h3>Arts &amp; Humanities</h3>
            <p>Creative programs across performing arts, film, design and literature with strong studio practice, exhibitions, and industry mentorship.</p>
            <div class="program-actions">
                <a class="cta" href="#">Learn more</a>
                <a class="outline-btn" href="php-files/register.php">Apply / Register</a>
            </div>
        </article>

        <article class="program-card">
            <div class="program-meta">Graduate &amp; Professional</div>
            <h3>Health &amp; Medicine</h3>
            <p>Programs in public health, biomedical research and clinical training with strong partnerships across hospitals and research centers.</p>
            <div class="program-actions">
                <a class="cta" href="#">Learn more</a>
                <a class="outline-btn" href="php-files/register.php">Apply / Register</a>
            </div>
        </article>

        <article class="program-card">
            <div class="program-meta">Interdisciplinary</div>
            <h3>Data Science &amp; Analytics</h3>
            <p>Programs combining statistics, computing and domain knowledge with hands-on projects in research labs and with industry partners.</p>
            <div class="program-actions">
                <a class="cta" href="#">Learn more</a>
                <a class="outline-btn" href="php-files/register.php">Apply / Register</a>
            </div>
        </article>
    </section>

    <!-- Footer -->
    <?php include 'components/footer.php';?>
    <script>
        // Toggle user dropdown (only if logged in)
        (function(){
            var btn = document.getElementById('userBtn');
            var dd = document.getElementById('userDropdown');
            if (!btn || !dd) return; // elements don't exist if not logged in

            btn.addEventListener('click', function(e){
                e.stopPropagation();
                var visible = dd.classList.toggle('visible');
                btn.setAttribute('aria-expanded', visible ? 'true' : 'false');
                dd.setAttribute('aria-hidden', visible ? 'false' : 'true');
            });

            // close dropdown when clicking outside
            document.addEventListener('click', function(e){
                if (dd.classList.contains('visible') && !btn.contains(e.target) && !dd.contains(e.target)) {
                    dd.classList.remove('visible');
                    btn.setAttribute('aria-expanded','false');
                    dd.setAttribute('aria-hidden','true');
                }
            });
        })();
    </script> 
</body>
</html>
