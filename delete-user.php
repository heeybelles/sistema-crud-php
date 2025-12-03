<?php 
require 'config.php';

try {
    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $pdo->prepare("DELETE FROM compras WHERE id_usuario = ?")->execute([$id]);

        $pdo->prepare("DELETE FROM usuario WHERE id = ?")->execute([$id]);
    }

    header("Location: list-users.php");
    exit;

} catch (PDOException $e) {
    echo "Erro ao excluir: " . $e->getMessage();
}
?>
