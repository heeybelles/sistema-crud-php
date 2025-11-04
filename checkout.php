<?php 
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
$query->execute([$usuario_id]);
$usuario = $query->fetch(PDO::FETCH_ASSOC);

$produto_id = $_GET['id'] ?? $_POST['produto_id'] ?? null;
$produto = null;

if ($produto_id) {
    $stmt = $pdo->prepare("SELECT * FROM servico WHERE id = ?");
    $stmt->execute([$produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar']) && $produto_id) {
    // Insere a compra no banco
    $insert = $pdo->prepare("INSERT INTO compras (id_usuario, id_servico, data_compra) VALUES (?, ?, NOW())");
    $insert->execute([$usuario_id, $produto_id]);

    // Redireciona direto para add-comment.php
    header("Location: add-comment.php?id=" . $produto_id);
    exit;
}

$sqlCompras = "
    SELECT s.foto, s.titulo, s.descricao, s.preco, c.data_compra
    FROM compras c
    JOIN servico s ON c.id_servico = s.id
    WHERE c.id_usuario = ?
    ORDER BY c.data_compra DESC
";
$stmtHist = $pdo->prepare($sqlCompras);
$stmtHist->execute([$usuario_id]);
$historico = $stmtHist->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Checkout - Aura Belle</title>
<link rel="stylesheet" href="css/checkout.css" />
</head>
<body>

<header>
    <a href="index.php" class="logo">Aura Belle</a>
    <ul class="nav-center">
        <li><a href="index.php">Voltar</a></li>
    </ul>
    <div class="user-info">
        <?php if ($usuario): ?>
            <img class="avatar" src="<?= !empty($usuario['foto']) ? htmlspecialchars($usuario['foto']) : 'https://static.vecteezy.com/system/resources/previews/036/280/651/original/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg' ?>" alt="Avatar" />
            <span class="username"><?= htmlspecialchars($usuario['nome']) ?></span>
            <a href="logout.php" class="btnLogin">Sair</a>
        <?php endif; ?>
    </div>
</header>

<main class="checkout-container">
    <?php if ($produto): ?>
        <div class="checkout-card">
            <h2 class="checkout-title">Checkout do Produto</h2>
            <img src="<?= htmlspecialchars($produto['foto']) ?>" class="checkout-img" alt="<?= htmlspecialchars($produto['titulo']) ?>" />
            <p><strong>Produto:</strong> <?= htmlspecialchars($produto['titulo']) ?></p>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($produto['descricao']) ?></p>
            <p><strong>Preço:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>

            <form method="post">
                <input type="hidden" name="produto_id" value="<?= htmlspecialchars($produto['id']) ?>">
                <button type="submit" name="finalizar" class="btnFinalizar">Finalizar Compra</button>
            </form>
        </div>
    <?php else: ?>
        <p class="erro">Produto não encontrado.</p>
    <?php endif; ?>

    <section class="historico">
        <h3 class="title-historico">Histórico de Compras</h3>
        <div class="container-historico">
            <?php if ($historico): ?>
                <?php foreach ($historico as $item): ?>
                    <div class="card-historico">
                        <img src="<?= htmlspecialchars($item['foto']) ?>" alt="<?= htmlspecialchars($item['titulo']) ?>" />
                        <h4><?= htmlspecialchars($item['titulo']) ?></h4>
                        <p><?= htmlspecialchars($item['descricao']) ?></p>
                        <span class="preco">R$ <?= number_format($item['preco'], 2, ',', '.') ?></span>
                        <div class="data-compra">
                            Comprado em <?= date('d/m/Y H:i', strtotime($item['data_compra'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="sem-compras">Você ainda não realizou compras.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <div class="footer-bottom">
        © 2025 Aura Belle — Todos os direitos reservados
    </div>
</footer>

</body>
</html>
