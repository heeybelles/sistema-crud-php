<?php 
require 'config.php';
session_start();

$usuario = null;

if (isset($_SESSION['usuario_id'])) {
    $query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
    $query->execute([$_SESSION['usuario_id']]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
     <link rel="stylesheet" type="text/css" href="css/menu-adm.css">
    <title>Dashboard</title>
</head>

<body>
<header>
    <a href="#" class="logo">Nome</a>
    
    <div class="header-center">
        <ul class="nav-center">
            <li><a href="#home" style="margin-left:80px">Início</a></li>
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

<main><br><br>
    <h1>Dashboard</h1>
    <br><br>
    <div class="menu-dashboard">
        <div class="dashboard-body">
            <div class="option-dashboard">
                <span class="figure">⭐</span>
                <h3>Avaliações</h3>
                <a class="link" href="list-comment.php">Acessar</a>
            </div>
            <div class="option-dashboard">
                <span class="figure">💖</span>
                <h3>Produtos</h3>
                <a class="link" href="list-product.php">Acessar</a>
            </div>
            <div class="option-dashboard">
                <span class="figure">📞</span>
                <h3>Contatos</h3>
                <a class="link" href="list-contact.php">Acessar</a>
            </div>
            <div class="option-dashboard">
                <span class="figure">👥</span>
                <h3>Usuários</h3>
                <a class="link" href="list-users.php">Acessar</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>
