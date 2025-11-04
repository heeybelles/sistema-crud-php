<?php
require 'config.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $caminho_foto = null; 
 
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('user_', true) . '.' . $extensao;
        $caminho_foto = 'images/users/' . $nome_arquivo;
 
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)) {
            echo 'Erro ao salvar a foto.';
            exit;
        }
    }
 
    
    $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
 
     $query = $pdo->prepare("INSERT INTO usuario (nome, email, senha, foto, nivel)
                        VALUES (?, ?, ?, ?, 'usuario')");
 
    $query->execute([$_POST['nome'], $_POST['email'], $senha_hash, $caminho_foto]);
 
    header("Location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" type="text/css" href="css/create.css">
</head>
<body>
  <a href="index.php"><button>← Voltar </button></a>
    <h1>Cadastro</h1>
    <h3>Faça seu cadastro preenchendo o formulário abaixo:</h3>
    <form action="#" method="post" enctype="multipart/form-data">
    <br><br>   
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>
        <label>E-mail:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*"><br><br>
        <input type="submit" value="Salvar">
        <p>Já tem cadastro? <a href="login.php">Clique aqui</a></p>
    </form>
 
    
</body>
</html>