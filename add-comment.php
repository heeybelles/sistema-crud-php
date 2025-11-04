<?php
require 'config.php';
session_start();

$erro = "";

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nome'])) {
    echo "Você precisa estar logado para enviar uma avaliação!";
    exit;
}


$id_usuario = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $query = $pdo->prepare("
        INSERT INTO avaliacao (id, nome, estrelas, comentario)
        VALUES (?, ?, ?, ?)
    ");
    $query->execute([
        $id_usuario,
        $nome,
        (int)$_POST['estrelas'],
        $_POST['comentario']
    ]);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/comment.css">
    <title>Nova Avaliação</title>
</head>
<body>
    <a href="index.php"><button>← Voltar</button></a><br>
    <h1>Nova Avaliação</h1>
    <h3>Deixe sua avaliação sobre nossos produtos!</h3>

    <form action="#" method="post"><br><br>
        <label>Nome:</label>
        <input type="text" name="nome" required value="<?= htmlspecialchars($nome) ?>" readonly><br><br>

        <label>Estrelas (1 a 5):</label>
        <input type="number" name="estrelas" min="1" max="5" required><br><br>

        <label>Comentários:</label>
        <textarea name="comentario" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Salvar">

        <?php if (!empty($erro)): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
