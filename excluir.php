<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

protegerPagina();

$pdo = conectar();
$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare('DELETE FROM amigos WHERE id = ? AND usuario_id = ?');
$stmt->execute([$id, usuarioIdLogado()]);

header('Location: listar.php?msg=' . urlencode('Amigo excluído com sucesso!'));
exit;
