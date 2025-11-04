<?php  
require 'config.php';
session_start();

$usuario = null;
$contatos = null;

// Verifica se usuário logado
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

$busca = $_GET['q'] ?? '';
if (!empty($busca)) {
    $query = $pdo->prepare("SELECT * FROM contato WHERE email LIKE ? OR mensagem LIKE ?");
    $query->execute(["%$busca%", "%$busca%"]);
} else {
    $query = $pdo->query("SELECT * FROM contato");
}

$contatos = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/menu-adm.css">
<link rel="stylesheet" type="text/css" href="css/list-user.css">
<title>Gerenciar Contatos</title>
</head>

<body>
<header>
    <a href="#" class="logo">Painel - Contatos</a>
    
    <div class="header-center">
        <ul class="nav-center">
            <li><a href="dashboard.php">Início</a></li>
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
    <h1>Contatos</h1>
    <br><br>
    
    <form method="GET" class="search-container" style="display:flex;justify-content:center;align-items:center;margin:20px 0; margin-top:-30px">
        <input 
            type="search" 
            name="q"
            placeholder="Buscar contato..."
            value="<?= htmlspecialchars($busca) ?>"
            class="search-input"
            style="
                padding:10px 15px;
                width:250px;
                border:2px solid transparent;
                border-radius:30px;
                font-size:14px;
                background:#fff;
                transition:0.3s;
                outline:none;
                box-shadow:0 2px 5px rgba(0,0,0,0.1);
            "
            onfocus="this.style.border='2px solid #b37fff'"
            onblur="this.style.border='2px solid transparent'"
        >
        <button 
            type="submit"
            class="search-btn"
            style="
                padding:10px 18px;
                border:none;
                background:#b37fff;
                color:#fff;
                font-size:16px;
                cursor:pointer;
                border-radius:30px;
                transition:0.25s;
                box-shadow:0 2px 5px rgba(0,0,0,0.1);
            "
            onmouseover="this.style.transform='scale(1.05)'"
            onmouseout="this.style.transform='scale(1)'"
        >🔎</button>
    </form>

    <div class="table-users">
        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Comentário</th>
                <th>Ações</th>
            </tr>
            <?php if (count($contatos) > 0): ?>
                <?php foreach($contatos as $c): ?>
                    <tr> 
                        <td><?= htmlspecialchars($c['id']) ?></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= htmlspecialchars($c['mensagem']) ?></td>
                        <td>
                            <a class="btnExcluir" href="delete-contact.php?id=<?= $c['id']; ?>">Excluir</a>
                        </td> 
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;">Nenhum contato encontrado.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</main>
</body>
</html>
