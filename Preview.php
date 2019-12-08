<?php
include_once ("head.php");
$u = $_GET['u'];
$o = $_GET['o'];
$mp = $_GET['mp'];
$s = $conn->prepare('SELECT * FROM media WHERE verhash = :verhash AND mediapath = :mediapath');
$s->execute(['verhash' => $o, 'mediapath'=>$mp]);
$med = $s->fetchAll();
echo '<img height = 25% width = 25% src='.$med[0][2].' /> <br>';
?>
<form action="preview.php?u=<?php echo $u;?>&mp=<?php echo $mp; ?>&o=<?php echo $o; ?>" method="POST" enctype="multipart/form-data">
<textarea name="com" rows="10" cols="100"></textarea><br>
<input type = "submit" value = "Post">
</form>
<?php
function sanitize($dirty)
{
return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}
$com = sanitize($_POST['com']);
if (isset($com))
{
if (!empty($com))
{
$d = date('Y-m-d H:i:s');
$sql = 'insert into comments(mediapath, verhash_owner, comments,comment_date, verhash_com) VALUES(?, ?, ?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$mp,$o, $com,$d,$u]);
$stmt2 = $conn->prepare('SELECT * FROM users WHERE verhash = :verhash');
$stmt2->execute(['verhash' => $o]);
$formail = $stmt2->fetch();
$stmt3 = $conn->prepare('SELECT * FROM users WHERE verhash = :verhash');
$stmt3->execute(['verhash' => $u]);
$formail2 = $stmt3->fetch();
if($formail[9] == 1)
{
$subject = "Media Was Commented On!!!";
                                $h  = "From : noreply@camagru.org" . "\r\n";
$h .= "Content-type: text/html";
                                $body = "Greetings $formail[3] $formail[4];<br>
                                $formail2[0] just commented on something you posted<br>
                                Regards: The Camagru Team!!!";
}
mail($formail[2], $subject, $body, $h);
echo "Comment recorded successfully!!<br>";
}
else
{
echo "No comment has been posted as yet!!!<br>";
}
}
$st = $conn->prepare('SELECT * FROM comments WHERE verhash_owner = :verhash_owner AND mediapath = :mediapath ORDER BY comment_date desc');
$st->execute(['verhash_owner' => $o, 'mediapath'=>$mp]);
$coms = $st->fetchAll();
$st2 = $conn->prepare('SELECT * FROM users');
$st2->execute();
$dat = $st2->fetchAll();
$i = 0;
$i2 = 0;
$a = count($coms);
$i3 = 0;
$names = array_fill(0, $a, '0');
while ($i < $a)
{
while($i2 < $a)
{
if ($coms[$i][4] == $dat[$i2][7])
{
$names[$i3] = $dat[$i2][0];
$i3++;
break;
}
$i2++;
}
$i++;
$i2 = 0;
}
$i = 0;
while ($i < $a)
{
echo '<b>' . strtoupper($names[$i]). '</b>' . '<br>';
echo $coms[$i][3] . "<br>";
echo $coms[$i][2] . "<br>";
$i++;
}
