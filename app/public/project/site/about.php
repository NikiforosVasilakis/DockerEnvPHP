<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>About — NYU</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="css/about.css">
</head>
<body>
	<?php include 'components/navbar.php';?>
	<!-- Hero -->
	<section class="about-hero">
		<div class="hero-wrap">
			<div class="hero-copy">
				<h1>A Legacy of Excellence,
					<a style="display:block; font-size:0.65em; margin-top:6px; color:#667eea; text-decoration:none;">A Global University</a>
				</h1>
				<p class="lead">Founded in 1831, NYU combines rigorous scholarship with global opportunity. We prepare students to think critically, work creatively, and lead responsibly in a rapidly changing world.</p>
				<a href="academics.html" class="cta-btn">Explore Programs</a>
			</div>

			<div class="hero-media">
				<!-- <img src="img/nyu-camp.jpg" alt="NYU campus" class="hero-img"> -->
			</div>
		</div>

		<div class="hero-stats">
			<div class="stat"><h4>50k+</h4><p>Students & Alumni</p></div>
			<div class="stat"><h4>200+</h4><p>Programs</p></div>
			<div class="stat"><h4>100+</h4><p>Research Centers</p></div>
		</div>
	</section>

	<!-- Profile / Mission -->
	<section class="profile-row">
		<div class="profile-card">
			<img src="img/president.jpg" alt="President">
			<h3>University President</h3>
			<p class="role">Leadership & Vision</p>
			<p>Committed to academic excellence, interdisciplinary research, and global engagement.</p>
		</div>

		<div class="about-mission">
			<h3>Our Mission</h3>
			<p>NYU fosters an environment where creative inquiry and intellectual curiosity drive innovation. We provide students with experiential learning opportunities, research mentorship, and a global network that spans cities and cultures.</p>

			<div class="about-stats" style="margin-top:1.25rem">
				<div class="stat"><h4>50k+</h4><p>Students & Alumni</p></div>
				<div class="stat"><h4>200+</h4><p>Programs</p></div>
				<div class="stat"><h4>100+</h4><p>Research Centers</p></div>
			</div>
		</div>
	</section>

	<!-- Call to Action -->
	<section style="padding:2.5rem; text-align:center;">
		<h3 style="margin-bottom:0.5rem">Want to learn more?</h3>
		<p style="margin-bottom:1rem; color:#555;">Visit our admissions page or contact our office to schedule a campus visit.</p>
		<a class="login-btn" href="#admissions">Admissions & Visits</a>
	</section>

	<!-- Find Us -->
	<section class="find-us-section">
		<div class="find-us-container">
			<div class="find-us-info">
				<h3>Find Us</h3>
				<p>New York University - Washington Square, New York, NY. Visit our main campus or get directions using the map.</p>
				<p style="margin-top:1rem;"><strong>Address:</strong> New York University, Washington Square, New York, NY 10003, United States</p>
				<p style="margin-top:0.5rem;"><a href="https://www.google.com/maps/place/New+York+University/" target="_blank" rel="noopener">Open in Google Maps</a></p>
			</div>
			<div class="find-us-map">
				<iframe src="https://www.google.com/maps?q=New+York+University%2C+Washington+Square%2C+New+York%2C+NY&z=15&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="NYU map"></iframe>
			</div>
		</div>
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

