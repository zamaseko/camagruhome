<html>
	<form action="forgotpwd.php" method="POST"><br>
		Enter Current email:<br><input type="email" name="e" required><br>
		<input type="submit" value="Submit">
	<form>
</html>

<?php
include 'config/database.php';
//Connect to MySQL database using PDO.
$connect = new PDO($dsn, $user, $password);
 
//Get the name that is being searched for.
$email = isset($_POST['email_address']) ? trim($_POST['email_address']) : '';
 
//The simple SQL query that we will be running.
$sql = "SELECT `id`, `email` FROM `users` WHERE `email_address` = :email_address";
 
//Prepare our SELECT statement.
$statement = $connect->prepare($sql);
 
//Bind the $name variable to our :name parameter.
$statement->bindValue(':email_address', $email);
 
//Execute the SQL statement.
$statement->execute();
 
//Fetch our result as an associative array.
$usr = $statement->fetch(PDO::FETCH_ASSOC);
 
//If $userInfo is empty, it means that the submitted email
//address has not been found in our users table.
if(empty($usr)){
    echo 'That email address was not found in our system!';
    exit;
}
else 
 {
    if($usr[6] == $email)
    {
           $email_cont = "Camagru Forgot Password";
           $head = "From noreply@camagruteam.co.za" . "\r\n";
        $head .= 'MIME-Version: 1.0' . "\r\n";
           $head .= 'Content-type:text/html; 
            charset=iso-8859-1' . "\r\n";
           $content = "Hey $fname $lname. <br> We have noticed that you requested to you want to change your password. <br> Please click here <a href='http://localhost:8080/cha_pwd.php?email=$email'>CHANGE</a> <br><br><br>
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
 }
//The user's email address and id.
$userEmail = $usr['email_address'];
$userId = $usr['id'];
 
//Create a secure token for this forgot password request.
//-$token = openssl_random_pseudo_bytes(16);
//-$token = bin2hex($token);
 
//Insert the request information
//into our password_reset_request table.
 
//The SQL statement.
$insertSql = "INSERT INTO password_reset_request (id, email_address, pass_word) VALUES (:id, :email_address, :pass_word)";
 
//Prepare our INSERT SQL statement.
$statement = $pdo->prepare($insertSql);
 
//Execute the statement and insert the data.
$statement->execute(array(
    "id" => $userId,
    "date_requested" => date("Y-m-d H:i:s"),
    "token" => $token
));
 
//Get the ID of the row we just inserted.
$passwordRequestId = $pdo->lastInsertId();
 
 
//Create a link to the URL that will verify the
//forgot password request and allow the user to change their
//password.
$verifyScript = 'http://localhost:8080/cha_pwd.php';
 
//The link that we will send the user via email.
$linkToSend = $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token;
 
//Print out the email for the sake of this tutorial.
echo $linkToSend;

?> 
