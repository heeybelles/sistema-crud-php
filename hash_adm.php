<?php
// criar_admin.php
require 'config.php'; // seu arquivo de conexão PDO

$nome = 'Carol';
$email = 'carol@gmail.com';
$senha = '1234@';
$foto = 'https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359554_1280.png'; 
$nivel = 'admin';

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$query = $pdo->prepare("INSERT INTO usuario (nome, email, senha, foto, nivel) VALUES (?, ?, ?, ?, ?)");
$query->execute([$nome, $email, $senhaHash, $foto, $nivel]);

echo "Admin criado com sucesso.";
?>