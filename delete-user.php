<?php 
  require 'config.php';
   
  if(isset($_GET['id'])){
    $query = $pdo->prepare("DELETE FROM usuario WHERE id=?");
    $query->execute([$_GET['id']]);

  }

   header("Location: list-users.php");
   exit;
?>