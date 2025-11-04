<?php
require 'config.php';
session_start(); 

$usuario = null;
if (isset($_SESSION['usuario_id'])) {
    $query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
    $query->execute([$_SESSION['usuario_id']]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
}

if (!$usuario) {
    echo "Usuário não encontrado!";
    exit;
}

if ($usuario['nivel'] !== 'admin') {
    echo "Acesso negado!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $caminho_foto = null;

    $verifica = $pdo->prepare("SELECT id FROM usuario WHERE email = ?");
    $verifica->execute([$email]);
    if ($verifica->fetch()) {
        echo "<script>alert('E-mail já cadastrado!'); history.back();</script>";
        exit;
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('user_', true) . '.' . $extensao;
        $caminho_foto = 'images/users/' . $nome_arquivo;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)) {
            echo 'Erro ao salvar a foto.';
            exit;
        }
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $query = $pdo->prepare("
        INSERT INTO usuario (nome, email, senha, foto, nivel)
        VALUES (?, ?, ?, ?, ?)
    ");
    $query->execute([$nome, $email, $senha_hash, $caminho_foto, 'usuario']);

    header("Location: list-users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" type="text/css" href="css/create-add.css">
    <link rel="stylesheet" type="text/css" href="css/menu-adm.css">
</head>
<body class="create-page">
<header>
    <a href="dashboard.php" class="logo">Nome - Usuário</a>
    
    <div class="header-center">
        <ul class="nav-center">
            <li><a href="list-users.php">Voltar</a></li>
        </ul>
    </div>

    <div class="user-info">
        <?php if($usuario): ?>
            <img class="avatar" 
                 src="<?= !empty($usuario['foto']) ? htmlspecialchars($usuario['foto']) : 'https://static.vecteezy.com/system/resources/previews/036/280/651/original/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg' ?>" 
                 alt="Avatar">
            <span class="username"><?= htmlspecialchars($usuario['nome']) ?> (admin)</span>
            <a href="logout.php" class="btnSair">Sair</a>
        <?php endif; ?>
    </div>
</header>

<main><br>
    <h1>Cadastrar Novo Usuário</h1><br>
    <form action="#" method="post" enctype="multipart/form-data" style="max-width:400px;margin:auto;">
        <label>Nome:</label><br>
        <input type="text" name="nome" required>

        <label>E-mail:</label><br>
        <input type="email" name="email" required>

        <label>Senha:</label><br>
        <input type="password" name="senha" required>

        <label>Foto (opcional):</label><br>
        <input type="file" name="foto" accept="image/*"><br>

        <input type="submit" value="Salvar">
    </form>
</main>
</body>
</html>
