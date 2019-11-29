<html>
	<form action="forgotpwd.php" method="POST"><br>
		Enter Current email:<br><input type="email" name="e" required><br>
		<input type="submit" name= "ForgotPassword" value="Request Reset"><br><br>
	<form>
</html>


<?php
include_once 'config/database.php';

try 
{
		$dsn = "mysql:host=$server;dbname=$db";
		$connect = new PDO($dsn, $user, $password);
		
		if (isset($_POST['ForgotPassword']))
	{
		if (filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL))
		{
			$email = $_POST['email_address'];
		}
		else
		{
			echo 'The email is not valid<br>';
		}

		$stmt = $connect->prepare('SELECT email_address FROM users WHERE email = : email_address');
		$stmt->bindParam(':email_address', $email);
		$stmt->execute();
		$usr = $stmt->fetch();

		if ($usr['email_address'])
		{
			$pass = $usr['email_address'];
			$phash = hash('md5', $pass);
			$email_cont = "Camagru Forgot Password";
   			$head = "From noreply@camagruteam.co.za" . "\r\n";
   			$head .= 'MIME-Version: 1.0' . "\r\n";
   			$head .= 'Content-type:text/html; 
    				charset=iso-8859-1' . "\r\n";
			$content = "Hey $fname $lname. <br> We have noticed that you requested to 
					you want to change your password. <br> Please click here 
					<a href='http://localhost:8080/cha_pwd.php?email=$email'>Change password</a> <br><br>
		   	 		From: The Camagru team";
			mail($email, $email_cont, $content, $head);
				echo 'Password Recovery key has been sent to your email address.';
		}
		else
		{	
			echo "No user with this email was found";
		}	
	}
}
catch(PDOException $e)
{
	echo $e;
}








































/*
try
{
	if(!empty($_POST['email_address']) )
	{
		if(isset($_POST['email']))
		{
			$dsn = "mysql:host=$server;dbname=$db";
			$connect = new PDO($dsn, $user, $password);
			$connect->setAttribute(PDO::ATRR_ERRMODE, PDO::ERROMODE_EXCEPTION);
			$mys= 'SELECT email_address FROM users WHERE email_address= :email_address';
			$stmt = $connect->prepare($mys);
   			$stmt->bindValue('email_address', $email);
   			$stmt->execute(['email_address' => $email]);
	   		$usr = $stmt->fetch();
   			if($usr[5] == $email)
			{	
				$email_cont = "Camagru Forgot Password";
   				$head = "From noreply@camagruteam.co.za" . "\r\n";
    			$head .= 'MIME-Version: 1.0' . "\r\n";
   				$head .= 'Content-type:text/html; 
  		  		charset=iso-8859-1' . "\r\n";
 	  			$content = "Hey $fname $lname. <br> We have noticed that you requested to you want to change your password. <br> Please click here <a href='http://localhost:8080/cha_pwd.php?email=$email'>CHANGE</a> <br><br>
		   	 				From: The Camagru team";
				if (mail($email, $email_cont, $content, $head))
				{

   								echo 'Click the change link to continue';
				}
				else 
				{
					echo 'Email not successfully sent';
				}
			}
			else
			{
				echo 'Enter you email address';
			}
		}
	}
}
catch(PDOException $e)

{
	echo $e;  //'error, fill in the missing field';
}
i*/
?>

