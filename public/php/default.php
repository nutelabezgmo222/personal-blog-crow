<?php
$config = [
  'host'=>'localhost',
  'name'=>'blog',
  'password'=>'',
  'user'=>'root',
];

$db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].';charset=utf8', $config['user'], $config['password']);
 ?>
