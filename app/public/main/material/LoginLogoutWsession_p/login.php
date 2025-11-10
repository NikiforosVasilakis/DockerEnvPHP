<?php
  session_start();
  if(isset($_SESSION['username']))
  {
	  header("Location:menu.php");
  }

?>

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
  <h2>Login</h2>
  <form >
    <div class="mb-3 mt-3">
      <label for="username">Username:</label>
      <input  class="form-control" id="username" placeholder="Enter username" name="username">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

</body>
</html>


<?php
if( isset ($_GET['username']))
{
$username =  $_GET['username'];
$pswd = $_GET['pswd'];

if( $username =="user1" && $pswd == "1234")
{
	$_SESSION['username'] = $username;
	header("Location:menu.php");
}
else
{
	header("Location:login.php");
		
}
}


?>
