<?php 
  require 'config.php';
   
  if(isset($_GET['id'])){
    $query = $pdo->prepare("DELETE FROM servico WHERE id=?");
    $query->execute([$_GET['id']]);

  }

   header("Location: list-product.php");
   exit;
?>