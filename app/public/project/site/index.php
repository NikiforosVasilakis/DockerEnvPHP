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
    <link rel="stylesheet" href="styles.css">
    <style>
        /* History Section Styles */
        .history-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e8eef7 100%);
            position: relative;
        }

        .history-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .history-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .history-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            text-align: center;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .history-content {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #333;
        }

        .history-content p {
            margin-bottom: 1.8rem;
            text-align: left;
            padding: 1.2rem 1.5rem;
            background: rgba(255, 255, 255, 0.7);
            border-left: 4px solid #667eea;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .history-content p:hover {
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.15);
            transform: translateX(4px);
            background: rgba(255, 255, 255, 0.9);
        }

        .history-content p:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .history-section {
                padding: 3rem 1rem;
            }

            .history-title {
                font-size: 2rem;
            }

            .history-content {
                font-size: 0.95rem;
            }

            .history-content p {
                padding: 1rem;
            }
        }
   
    </style></head>
<body>
    <!-- Header Navigation -->
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <a href="index.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: white;">
                    <img src="img/nyu-logo.png" alt="NYU Logo" class="logo-icon">
                    <span class="logo-text">NEW YORK UNIVERSITY</span>
                </a>
            </div>
            <nav class="main-nav">
                <div class="nav-groups-wrapper">
                    <div class="nav-group nav-group-1">
                        <a href="about.html" class="nav-link">About</a>
                        <a href="research.html" class="nav-link">Research</a>
                        <a href="#admissions" class="nav-link">Admissions</a>
                        <a href="#news" class="nav-link">News</a>
                        <a href="academics.html" class="nav-link">Academics</a>
                        <a href="uni_life.html" class="nav-link">Campus Life</a>
                        <div class="search-container">
                            <input type="text" placeholder="Search..." class="search-input">
                            <button class="search-btn" aria-label="Search"></button>
                        </div>
                    </div>
                </div>
            </nav>
            <?php if ($user): ?>
            <div class="header-actions">
                <div class="user-wrap">
                    <div id="userDropdown" class="user-dropdown" aria-hidden="true">
                        <div class="user-info">
                            <div class="user-name"><?= htmlspecialchars(($user['username'] ?? '') . ' ' . ($user['username'] ?? '')) ?></div>
                            <div class="user-email"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                            <div class="user-role"><?= htmlspecialchars($user['role_name'] ?? ($user['role_id'] ?? 'role_id')) ?></div>
                        </div>
                        <div class="user-actions">
                            <a href="php-files/logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="header-actions">
                <a href="php-files/login.php" class="login-btn" target="_blank">e-class</a>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-wrapper">
        <div class="hero">
            <div class="hero-image">
                <div class="hero-overlay">
                    <h1 class="hero-text">New York</h1>
                </div>
                <img src="img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="NYU Campus" class="hero-bg">
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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about.html">About NYU</a></li>
                    <li><a href="academics.html">Academics</a></li>
                    <li><a href="uni_life.html">Campus Life</a></li>
                    <li><a href="#admissions">Admissions</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Resources</h4>
                <ul>
                    <li><a href="#library">Library</a></li>
                    <li><a href="#careers">Careers</a></li>
                    <li><a href="#alumni">Alumni</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Connect</h4>
                <ul>
                    <li><a href="#facebook">Facebook</a></li>
                    <li><a href="#twitter">Twitter</a></li>
                    <li><a href="#instagram">Instagram</a></li>
                    <li><a href="#linkedin">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 New York University. All rights reserved.</p>
        </div>
    </footer>

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

