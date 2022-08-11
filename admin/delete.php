<?php

require('../config.php');

session_start();
if(!isset($_SESSION['isAdmin'])) {
  header('location:login.php');
}
$stmt = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
$stmt->execute();

header('location:index.php');
 ?>
