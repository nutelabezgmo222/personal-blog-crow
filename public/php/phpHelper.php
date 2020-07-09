<?php
require_once 'default.php';
$sql = "INSERT INTO comments VALUES " . " (NULL,".$_POST['post_id'].",".$_POST['user_id'].", '" . $_POST['content'] . "', '".$_POST['comment_date']."')";
$result = $db->exec($sql);
return $result;
 ?>
