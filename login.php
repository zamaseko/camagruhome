<html>
<head>
       <!-- <meta http-equiv="refresh" content="30">-->
        <title>Camagru-login page</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
        <div class="box">
                <form action="login.php"  method="POST">
                <div>
                        <h2 class="app-name">camagru<h2>
                        <input type="text"  method="POST" name="u" placeholder="username"> <br>
                        <input type="password"  placeholder="password" > <br>
                        <input type="submit" name="login" value="Login">
                </div>
                <div>
                        <a href="#" type="button">Sign Up</a><br><br>
                        <a href="#" type="button">Forgot Password?</a>
                </div>
                </form>
        </div>
</body>
</html>

<?php
include 'config/database.php';
$usrname = trim($_POST['u']);
$passwd = trim($_POST['pass_word']);

try
{
	
	if (!empty($_POST['username']) && !empty($_POST['pass_word']))	
	{
		
		if(isset($_POST['u']) && isset($_POST['pass_word']))
		{
			
			$dsn = "mysql:host=$server;dbname=$db";
 			$connect = new PDO($dsn, $user, $password);
 			$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$mys = $connect->prepare("SELECT username, pass_word FROM users WHERE username = :username OR pass_word = :pass_word");
 			//$stmt = $connect->prepare($mys);
 			$mys->bindValue(':username', $usrname);
			//$mys->bindValue(':pass_word', md5($passwd));
		 	$mys->execute(['username' => $usrname, 'pass_word' => $passwd]);
		 	$usr = $mys->fetch(PDO::FETCH_ASSOC);
			if($usrname == $usr[1])// && $passwd == $usr[4])
			{
				
					var_dump("hee");
					die();
			}
		}
	}
}
catch(PDOException $e)
{
	echo $e;
}
?>
