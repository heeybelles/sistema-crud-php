<?php   
require 'config.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
$query->execute([$_SESSION['usuario_id']]);
$usuarioLogado = $query->fetch(PDO::FETCH_ASSOC);

if (!$usuarioLogado || $usuarioLogado['nivel'] !== 'admin') {
    echo "Acesso negado!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = str_replace(',', '.', $_POST['preco']);
    $foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid('produto_', true) . '.' . $extensao;
        $destino = 'images/product/' . $novo_nome;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $foto = $destino;
        }
    }

    $query = $pdo->prepare("INSERT INTO servico (titulo, descricao, preco, foto) VALUES (?, ?, ?, ?)");
    $query->execute([$titulo, $descricao, $preco, $foto]);

    echo "<script>
        alert('Produto adicionado com sucesso!');
        setTimeout(function() {
            window.location.href = 'list-product.php';
        }, 1000);
    </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Produto</title>
<link rel="stylesheet" href="css/menu-adm.css">
<link rel="stylesheet" href="css/edit-product.css">
</head>
<body>
<header>
    <a href="dashboard.php" class="logo">Aura Belle - Produtos</a>
    
    <div class="header-center">
        <ul class="nav-center">
            <li><a href="list-product.php">Voltar</a></li>
        </ul>
    </div>

    <div class="user-info">
        <img class="avatar" 
             src="<?= !empty($usuarioLogado['foto']) ? htmlspecialchars($usuarioLogado['foto']) : 'https://static.vecteezy.com/system/resources/previews/036/280/651/original/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg' ?>" 
             alt="Avatar">
        <span class="username"><?= htmlspecialchars($usuarioLogado['nome']) ?> (<?= htmlspecialchars($usuarioLogado['nivel']) ?>)</span>
        <a href="logout.php" class="btnSair">Sair</a>
    </div>
</header>

<main class="container">
    <h1>Adicionar Produto</h1>

    <form method="post" enctype="multipart/form-data" class="form-box">
        <label>Título:</label>
        <input type="text" name="titulo" required>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" required>

        <label>Descrição:</label>
        <textarea name="descricao" rows="4" cols="50" required></textarea>

        <label>Foto:</label>
        <div class="foto-preview">
            <input type="file" name="foto" accept="image/*" style="border: none;">
        </div>

        <div class="form-actions">
            <input type="submit" value="Adicionar Produto">
        </div>
    </form>
</main>
</body>
</html>
