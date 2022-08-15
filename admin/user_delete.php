<?php

require('../config.php');

session_start();
if($_SESSION['register']['role'] !=1) {
  header('location:login.php');
}
$stmt = $pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$stmt->execute();

header('location:user_list.php');
 ?>
