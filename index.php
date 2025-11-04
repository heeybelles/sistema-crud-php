<?php
require 'config.php';
session_start();

$usuario = null;
if (isset($_SESSION['usuario_id'])) {
    $query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
    $query->execute([$_SESSION['usuario_id']]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);
}

$ordem = $_GET['ordem'] ?? 'novo';
switch ($ordem) {
    case 'antigo':
        $orderBy = "ORDER BY id ASC";
        break;
    case 'maior_preco':
        $orderBy = "ORDER BY preco DESC";
        break;
    case 'menor_preco':
        $orderBy = "ORDER BY preco ASC";
        break;
    default:
        $orderBy = "ORDER BY id DESC";
}

try {
    $sqlServicos = "SELECT id, foto, titulo, descricao, preco FROM servico $orderBy LIMIT 3";
    $stmt = $pdo->query($sqlServicos);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $produtos = [];
}

$ordemAva = $_GET['ordemAva'] ?? 'recentes';
switch ($ordemAva) {
    case 'antigas':
        $orderAva = "ORDER BY id ASC";
        break;
    case 'melhores':
        $orderAva = "ORDER BY estrelas DESC";
        break;
    case 'piores':
        $orderAva = "ORDER BY estrelas ASC";
        break;
    default:
        $orderAva = "ORDER BY id DESC";
}

try {
    $sqlAvaliacao = "SELECT nome, comentario, estrelas FROM avaliacao $orderAva LIMIT 3";
    $stmtAva = $pdo->query($sqlAvaliacao);
    $avaliacoes = $stmtAva->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $avaliacoes = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['assunto'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $insert = $pdo->prepare("INSERT INTO contato (nome, email, mensagem) VALUES (?, ?, ?)");
    $insert->execute([$nome, $email, $assunto]);
    echo "<script>alert('Mensagem enviada com sucesso!');</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/principal.css">
<title>Landing Page</title>
</head>
<body>

<header>
    <a href="index.php" class="logo">Aura Belle</a>
    <ul class="nav-center">
        <li><a href="#home">Início</a></li>
        <li><a href="#about">Quem somos?</a></li>
        <li><a href="#product">Produtos</a></li>
        <li><a href="#avaliate">Avaliações</a></li>
        <li><a href="#contact">Contato</a></li>
    </ul>
    <div class="user-info">
        <?php if($usuario): ?>
            <img class="avatar" src="<?= !empty($usuario['foto']) ? htmlspecialchars($usuario['foto']) : 'https://static.vecteezy.com/system/resources/previews/036/280/651/original/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg' ?>" alt="Avatar">
            <span class="username"><?= htmlspecialchars($usuario['nome']) ?></span>
            <a href="logout.php" class="btnLogin">Sair</a>
        <?php else: ?>
            <a href="login.php" class="btnLogin">Login</a>
        <?php endif; ?>
    </div>
</header>

<section class="hero" id="home">
    <img src="img/tamplete-hero.jpg" class="img-hero" alt="Perfumes">
    <div class="hero-info">
        <h2 class="title">Aura Belle</h2>
        <p class="subtitle">Encante o mundo com a sua essência</p><br>
        <a href="create-user.php"><input type="submit" class="btnCadastrar" value="Inscreva-se"></a>
    </div>
</section>

<section class="about" id="about">
    <h3 class="title-about">Quem somos?</h3>
    <img src="img/img-about.png" class="img-about" alt="ilustração de perfume">
    <p class="txt-about">
        Na Aura Belle, transformamos fragrâncias em experiências que despertam emoções. 
        Cada perfume celebra a beleza única de cada mulher.
    </p>
</section>

<section class="product" id="product">
    <h3 class="title-product">Produtos</h3>
    <p class="txt-product">Escolha sua fragrância favorita</p>
    <form method="get" class="filter-form">
        <select name="ordem" onchange="this.form.submit()">
            <option value="novo" <?= $ordem == 'novo' ? 'selected' : '' ?>>Mais novos</option>
            <option value="antigo" <?= $ordem == 'antigo' ? 'selected' : '' ?>>Mais antigos</option>
            <option value="maior_preco" <?= $ordem == 'maior_preco' ? 'selected' : '' ?>>Maior preço</option>
            <option value="menor_preco" <?= $ordem == 'menor_preco' ? 'selected' : '' ?>>Menor preço</option>
        </select>
    </form>

    <div class="conteiner-product">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $p): ?>
                <div class="card-product">
                    <img src="<?= htmlspecialchars($p['foto']) ?>" class="img-product" alt="<?= htmlspecialchars($p['titulo']) ?>">
                    <h4><?= htmlspecialchars($p['titulo']) ?></h4>
                    <p class="description"><?= htmlspecialchars($p['descricao']) ?></p>
                    <span class="preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span><br>
                    <?php if ($usuario): ?>
                        <a href="checkout.php?id=<?= $p['id']; ?>" class="btnComprar">Comprar</a>
                    <?php else: ?>
                        <a href="login.php" class="btnComprar" onclick="alert('Faça login para comprar.'); return false;">Comprar</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="sem-produtos">Nenhum produto encontrado.</p>
        <?php endif; ?>
    </div>
</section>

<section class="avaliate" id="avaliate">
    <h3 class="title-avaliate">Avaliações</h3>
    <p class="txt-avaliate">Confira o que dizem nossos clientes:</p>
    <form method="get" class="filter-form">
        <select name="ordemAva" onchange="this.form.submit()">
            <option value="recentes" <?= $ordemAva == 'recentes' ? 'selected' : '' ?>>Mais recentes</option>
            <option value="antigas" <?= $ordemAva == 'antigas' ? 'selected' : '' ?>>Mais antigas</option>
            <option value="melhores" <?= $ordemAva == 'melhores' ? 'selected' : '' ?>>Melhores avaliações</option>
            <option value="piores" <?= $ordemAva == 'piores' ? 'selected' : '' ?>>Piores avaliações</option>
        </select>
    </form>
    <div class="conteiner-avaliate">
        <?php foreach ($avaliacoes as $a): ?>
            <div class="card-avaliate">
                <span class="username"><?= htmlspecialchars($a['nome']) ?></span><br>
                <span class="stars">
                    <?php for ($i = 0; $i < (int)$a['estrelas']; $i++): ?>
                        ⭐
                    <?php endfor; ?>
                </span>
                <p class="comment"><?= htmlspecialchars($a['comentario']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<footer>
  <div class="footer-left">
    <h3 class="contact-title">Contato</h3>
    <p class="address-txt">Rua das Flores, 300 — São Paulo/SP</p>
    <p class="address-txt">(13) 93456-7000</p>
    <p class="address-txt">contato@aurabelle.com</p>
  </div>
  <div class="footer-right">
    <h3 class="contact-title">Fale Conosco</h3>
    <form class="contact-form" action="#" method="post">
      <input type="text" placeholder="Seu nome" name="nome">
      <input type="email" placeholder="Seu e-mail" name="email">
      <textarea rows="4" placeholder="Sua mensagem..." name="assunto"></textarea>
      <button type="submit" class="btnEnviar">Enviar Mensagem</button>
    </form>
  </div>
  <div class="footer-bottom">
    © 2025 Aura Belle — Todos os direitos reservados
  </div>
</footer>

</body>
</html>
