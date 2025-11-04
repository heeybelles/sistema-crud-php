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

if (!$usuarioLogado) {
    echo "Usuário não encontrado!";
    exit;
}


if ($usuarioLogado['nivel'] !== 'admin') {
    echo "Acesso negado!";
    exit;
}


$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list-users.php");
    exit;
}

$query = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
$query->execute([$id]);
$usuario = $query->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuário não encontrado!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $foto = $usuario['foto'];

   
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid() . '.' . $extensao;
        $destino = 'images/users/' . $novo_nome;
        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
        $foto = $destino;
    }

   
    $senha_hash = !empty($senha) ? password_hash($senha, PASSWORD_DEFAULT) : $usuario['senha'];

    $query = $pdo->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ?, foto = ? WHERE id = ?");
    $query->execute([$nome, $email, $senha_hash, $foto, $id]);

    header("Location: list-users.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="css/menu-adm.css">
    <link rel="stylesheet" href="css/edit.css">
</head>
  <body>
    <header>
    <a href="dashboard.php" class="logo">Nome - Usuário</a>
    <div class="header-center">
        <?php if($usuarioLogado['nivel'] === 'admin'): ?>
        <ul class="nav-center">
        <li><a href="list-users.php">Voltar</a></li>
        </ul>
   <?php endif; ?>
    </div>
    <div class="user-info">
      <img class="avatar" src="<?= !empty($usuarioLogado['foto']) ? htmlspecialchars($usuarioLogado['foto']) : 'https://static.vecteezy.com/system/resources/previews/036/280/651/original/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg' ?>" alt="Avatar">
       <span class="username"><?= htmlspecialchars($usuarioLogado['nome']) ?> (<?= htmlspecialchars($usuarioLogado['nivel']) ?>)</span>
        <a href="logout.php" class="btnSair">Sair</a>
     </div>
   </header>
       <main class="container">
        <h1>Editar Usuário</h1>
        <form method="post" enctype="multipart/form-data" class="form-box">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label>Senha</label>
        <input type="password" name="senha" placeholder="Deixe em branco para manter a atual">

        <label>Foto</label>
        <div class="foto-preview">
        <img src="<?= !empty($usuario['foto']) ? htmlspecialchars($usuario['foto']) : 'https://static.vecteezy.com/system/resources/previews/036/280/651/original/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg' ?>" alt="Foto atual">
       <input type="file" name="foto" accept="image/*">    
    </div>
     

        <div class="form-actions">
        <input type="submit" value="Salvar">
        </div>
   </form>
  </main>
 </body>
</html>
