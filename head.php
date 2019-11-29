
<html>
<style>	
body
{
	background-color: grey;
}

.navigation{
	background-color: white;
}
.title{
    font-style: oblique;
    font-size: 100px;
    color: black;
	text-align: center;
}
</style>
<body>
<div>
	<h1 class="title">camagru<h1>
	<nav class="navigation">
		<a href="index.php?usr=<?php echo $usr?>">Home</a>
		<a href="explore.php?usr=<?php echo $usr?>">Explore</a>
		<a href="search.php?usr=<?php echo $usr?>">Search</a>
		<a href="profile.php?usr=<?php echo $usr?>">Profile</a>
	</nav>	
</div>
	<button type="button" action="login2.php">LogOut</button>
</body>
</html

<?php
include 'database.php';
$usrname = $_GET['u'];

if($usr)
{
	$connect = new PDO($dsn, $usr, $passwd);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $connect->prepare();
	$stmt->execute();
	$usr = $stmt->fetc();
}
// //else
// {
// 	header('Location:login.php');
// }
?>

