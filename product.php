<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caminho_foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('user_', true) . '.' . $extensao;
        $caminho_foto = 'images/product/' . $nome_arquivo;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)) {
            echo 'Erro ao salvar a foto.';
            exit;
        }
    }

    $preco = str_replace(',', '.', $_POST['preco']);

    $query = $pdo->prepare("
        INSERT INTO servico (titulo, descricao, foto, preco)
        VALUES (?, ?, ?, ?)
    ");
    $query->execute([
        $_POST['titulo'],
        $_POST['descricao'],
        $caminho_foto,
        $preco
    ]);

    header("Location: add-comment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/product-add.css">
    <title>Novo Produto</title>
</head>
<body>
    <a href="dashboard.php"><button>← Voltar</button></a><br>
    <h1>Novo Produto</h1>
    <h3>Adicione um novo produto para os seus usuários:</h3>

    <form action="#" method="post" enctype="multipart/form-data"><br><br>
        <label>Título:</label>
        <input type="text" name="titulo" required><br><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" required><br><br>

        <label>Descrição:</label>
        <textarea name="descricao" rows="4" cols="50" required></textarea><br><br>

        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*"><br><br>

        <input type="submit" value="Salvar">
    </form>
</body>
</html>
