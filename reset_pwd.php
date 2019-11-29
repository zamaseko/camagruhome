<?php echo '

<form action="reset.php" method="POST">
E-mail Address:<br> <input type="text" name="email" size="20" /><br />
New Password: <br> <input type="password" name="password" size="20" /><br />
Confirm Password: <br> <input type="password" name="confirmpassword" size="20" /><br />
<input type="hidden" name="q" value="';
if (isset($_GET["q"])) {
	echo $_GET["q"];
}
    echo '" /><input type="submit" name="ResetPasswordForm" value=" Reset Password " />
</form>';

?>


<?php
try
{
	$dsn = "mysql;host=$server;dbname=$db";
	$connect = new PDO($dsn, $user, $password);

	if(isset($_POST['ResetPasswordForm']))
	{
		$email = $_POST['email_address'];
		$passwd = $_POST['pass_word'];
		$passwd2 = $_POST['confirmpassword'];
		$phash = $_POSt["q"];

		$reset = hash('md5', $passwd);
		if($reset == $phash)
		{
			if($passwd == $passwd2)
			{
				$passwd = hash('md5', $passwd);
				$mys = 'UPDATE users SET pass_word = :pass_word WHERE email_address = :email_address';
				$stmt = $connect->prepare($mys);
				$stmt->bindParam(':pass_word', $passwd);
				$stmt->bindParam(':email_address', $email);
				{
					echo 'The password has been successfully changed';
				}
			}
			else
			{
				echo "The passwords dont match";
			}
		}
		else 
		{
			echo "password reset was not successful";
		}
	}
}
catch(PDOException $e)
{
	echo $e;
}
?>
