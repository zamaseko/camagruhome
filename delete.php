php
    require("includes/header.php");
    if(!isset($_SESSION['user_id']) && !isset($_SESSION['username']) && !isset($_SESSION['password']) && !isset($_SESSION['fullname']) && !isset($_SESSION['profile_pic'])  && !isset($_SESSION['email_address']) && !isset($_SESSION['receive_email']))
    { 
        header("Location: signin.php");
    }
   
?>
<main>
        <section class="timeline_section">
            <div class="container">
                <div class="row">
                    <div class="timeline_feeds" style="width:100% !important; text-align:center">
                    <h4 class="right">Post</h4>
                    <?php
                    if (isset($_GET["action"]) && $_GET["action"] == "delete"){
                        if (isset($_GET['id']))
                        {
                            try{
                                $image_id = $_GET['id'];
                                $user_id = $_SESSION['user_id'];
                                $stmt = $conn->prepare("DELETE FROM `image` WHERE `image`.`image_id` = $image_id");
                                if($stmt->execute())
                                {
                                    echo "<script language='javascript'>alert('Post Deleted!!');</script>"; 
                                    header("refresh:0.5; url=explore.php");
                                }
                            }catch(PDOException $e)
                            {
                                echo "Error: ".$e->getMessage();
                            }
                        }
                    }  
                       ?> 
                     
                    </div>
                </div>
            </div>
        </section>
</main>
<?php
    require("includes/footer.php");
?>
</body>

</html>
