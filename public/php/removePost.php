<?php
require_once 'default.php';
$sql = 'DELETE FROM users_posts  WHERE up_user_id = '.$_POST['user_id'].' AND post_id='.$_POST['post_id'] ;
return $db->exec($sql);
 ?>
