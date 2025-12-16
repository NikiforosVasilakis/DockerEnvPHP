<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>News - NYU</title>
		<link rel="stylesheet" href="styles.css">
		<style>
			/* Page-specific styles kept small and aligned with existing theme */
			.news-list { max-width:1400px; margin:2.5rem auto 4rem; padding:0 2rem; }
			.news-item { display:flex; gap:2rem; align-items:center; margin-bottom:2.5rem; }
			.news-item .news-image { flex:0 0 45%; }
			.news-item .news-image img { width:100%; height:280px; object-fit:cover; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.08); display:block; }
			.news-item .news-content { flex:1; }
			.news-item .news-content h3 { color:#57068c; font-size:1.6rem; margin-bottom:0.5rem; }
			.news-item .meta { color:#888; font-size:0.9rem; margin-bottom:1rem; }
			.news-item .excerpt { color:#444; line-height:1.7; margin-bottom:1rem; }
			.news-item .read-more { color:#57068c; text-decoration:none; font-weight:600; }
			.news-item.reverse { flex-direction: row-reverse; }
			@media (max-width:768px) { .news-item{flex-direction:column;} .news-item .news-image img{height:220px;} }
		</style>
	</head>
	<body>
		<?php include 'components/navbar.php';?>

		<!-- Page header -->
		<section class="page-header">
			<div class="page-header-bg">
				<img src="img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="News header" class="page-header-img">
				<div class="page-header-overlay">
					<h1>News</h1>
					<p>Latest updates and stories from the university community</p>
				</div>
			</div>
		</section>

		<!-- News list: TOP ITEM uses 'reverse' so image is on the right -->
		<main class="news-list">
			<div class="content-wrapper">
				<h2>Latest News</h2>

				<!-- Top: image on the RIGHT, text on the LEFT -->
				<article class="news-item reverse">
					<div class="news-image">
						<img src="img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="Campus research lab">
					</div>
					<div class="news-content">
						<div class="meta">Oct 15, 2025 &middot; Research</div>
						<h3>Breakthrough Research in Urban Sustainability</h3>
						<p class="excerpt">Our interdisciplinary team published new findings on sustainable urban infrastructure, presenting a scalable model to reduce energy consumption in dense cities.</p>
						<a class="read-more" href="#">Read more →</a>
					</div>
				</article>

				<!-- Second: image left, text right -->
				<article class="news-item">
					<div class="news-image">
						<img src="img/nyu-logo.png" alt="Student event">
					</div>
					<div class="news-content">
						<div class="meta">Nov 02, 2025 &middot; Campus Life</div>
						<h3>Annual Community Fair Brings Together Students</h3>
						<p class="excerpt">Students and local partners hosted workshops, musical performances, and career panels at the community fair — a celebration of creativity and collaboration.</p>
						<a class="read-more" href="#">Read more →</a>
					</div>
				</article>

				<!-- Third: image on the right, text left -->
				<article class="news-item reverse">
					<div class="news-image">
						<img src="img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="Graduation ceremony">
					</div>
					<div class="news-content">
						<div class="meta">Dec 01, 2025 &middot; Events</div>
						<h3>Graduation Ceremony Honors Class of 2025</h3>
						<p class="excerpt">Families and faculty gathered to celebrate the graduates. Highlights included keynote speeches, student awards, and campus recognitions.</p>
						<a class="read-more" href="#">Read more →</a>
					</div>
				</article>

			</div>
		</main>

		<?php include 'components/footer.php';?>
	</body>
</html>