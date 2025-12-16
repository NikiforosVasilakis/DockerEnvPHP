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
		<link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="../css/news.css">
	</head>
	<body>
		<?php include '../components/navbar.php';?>

		<!-- Page header -->
		<section class="page-header">
			<div class="page-header-bg">
				<img src="../img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="News header" class="page-header-img">
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
						<img src="../img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="Campus research lab">
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
						<img src="../img/nyu-logo.png" alt="Student event">
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
						<img src="../img/51e4ddfa-2491-4cff-9d0e-115b39ebb8a5.png" alt="Graduation ceremony">
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

		<?php include '../components/footer.php';?>
	</body>
</html>