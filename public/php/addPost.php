<?php
require_once 'default.php';
$sql = 'INSERT INTO users_posts VALUES'.'(NULL, '.$_POST['user_id'].','.$_POST['post_id'].')';
return $db->exec($sql);
?>
