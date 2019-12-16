require_once "config.php";
$pid=$_POST['pid'];
$user=$_COOKIE['user'];
$action=$_POST['action'];
if ($action=='like'){
 $sql=$dbh->prepare("SELECT * FROM fdlikes WHERE pid=? and user=?");
 $sql->execute(array($pid,$user));
 $matches=$sql->rowCount();
 if($matches==0){
 $sql=$dbh->prepare("INSERT INTO fdlikes (pid, user) VALUES(?, ?)");
 $sql->execute(array($pid,$user));
 $sql=$dbh->prepare("UPDATE fdposts SET likes=likes+1 WHERE id=?");
 $sql->execute(array($pid));
 }else{
 die("There is No Post With That ID");
 }
}
if ($action=='unlike'){
 $sql = $dbh->prepare("SELECT 1 FROM fdlikes WHERE pid=? and user=?");
 $sql->execute(array($pid,$user));
 $matches = $sql->rowCount();
 if ($matches != 0){
 $sql=$dbh->prepare("DELETE FROM fdlikes WHERE pid=? AND user=?");
 $sql->execute(array($pid,$user));
 $sql=$dbh->prepare("UPDATE fdposts SET likes=likes-1 WHERE id=?");
 $sql->execute(array($pid));
 }
}
?>
