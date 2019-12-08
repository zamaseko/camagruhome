?php include_once("head.php"); ?>
<form action="post.php?u=<?php echo $u;?>" method="POST" enctype="multipart/form-data">
<br><br>
<input type = "file" name = "file"><br><br>
<textarea name="cap" rows="4" cols="50"></textarea><br>
<input type = "submit" value = "Post">
</form>
<?php
function sanitize($dirty)
{
return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}
$cap = sanitize($_POST['cap']);
$name = $_FILES['file']['name'];
$type = $_FILES['file']['type'];
$tmp_name = $_FILES['file']['tmp_name'];
$ext = array("jpeg", "jpg", "gif", "png", "avi", "wmv", "mov", "qt", "mkv", "mp4", "flv", "swf");
$n = explode('.',$name);
$t = explode('/', $type);
$na = str_shuffle($u . $n[0]) .".". $t[1];
if (in_array($t[1], $ext))
{
if (isset($name))
{
if (!empty($name))
{
$location = 'media/uploads/';
$l = $location.$na;
if(move_uploaded_file($tmp_name, $location.$na))
{
$d = date('Y-m-d H:i:s');
$n = "0";
$f = "none";
$sql = 'insert into media(verhash, mediapath, postdate,caption, filter) VALUES(?, ?, ?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$u,$l, $d,$cap,$f]);
$sql2 = 'insert into likes(verhash_owner, mediapath) VALUES(?,?)';
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$u, $l]);
header("Location: profile.php?u=$u");
}
}
else
{
echo "Please choose a file";
}
}
}
else
echo "Media Must Be Images Or Videos Only!!!!";
?>
