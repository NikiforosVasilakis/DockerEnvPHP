
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cinema</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>User Menu</h2>
  <p><?php echo $_SESSION['username']?></p>
 
  <ul class="nav">
      <a class="nav-link" href="menu.php">Menu</a>
    </li>    
	<li class="nav-item">
      <a class="nav-link" href="reserve.php">Make a reservation</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" href="#">Disabled</a>
    </li>
  </ul>
</div>

</body>
</html>
