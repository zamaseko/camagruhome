<?php

include 'config/database.php';


if (isset($_GET['action']) == 'signup')
{
    if (isset($_GET['email']) && isset($_GET['vk']))
    {
        $vkey = $_GET['vk'];
        $email = $_GET['email'];
        try
        {
            $dsn = "mysql:host=$server;dbname=$db";
            $connect = new PDO($dsn, $user, $password);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $mys = $connect->prepare("SELECT email_address, vkey FROM users WHERE email_address =:email_address AND vkey =:vkey");
            $mys->bindValue(':email_address', $email);
            $mys->bindValue(':vkey', $vkey);
            $mys->execute();
            $usr = $mys->fetch(PDO::FETCH_ASSOC);
            if ($usr === false)
            {
                echo "<b>Error: Could not verify the account/ email address already taken</b>";
            }	
            else
            {
                
                $smtp = $connect->prepare("UPDATE users SET verified = '1' WHERE email_address =:email_address AND vkey =:vkey");
                $smtp->bindParam(':email_address', $email);
                $smtp->bindParam(':vkey', $vkey);
                $smtp->execute();
              
                $smtp1 = $connect->prepare("UPDATE users SET vkey =:vkey WHERE email_address =:email_address");
                $smtp1->bindParam(':email_address', $email);
                $smtp1->bindParam(':vkey', $vkey);
                $smtp1->execute();

                header('Location: login.php');

            }
        }
        catch(PDOException $e)
        {
            echo $e;
        }
    }
    else
    {
        echo "Could not verify your details, missing key or email address";
    }
}
?>
