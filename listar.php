<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

protegerPagina();

$pdo = conectar();
$busca = trim($_GET['busca'] ?? '');

if ($busca !== '') {
    $stmt = $pdo->prepare(
        'SELECT * FROM amigos WHERE usuario_id = ? AND nome LIKE ? ORDER BY nome ASC'
    );
    $stmt->execute([usuarioIdLogado(), '%' . $busca . '%']);
} else {
    $stmt = $pdo->prepare('SELECT * FROM amigos WHERE usuario_id = ? ORDER BY nome ASC');
    $stmt->execute([usuarioIdLogado()]);
}

$amigos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Amigos - Cadastro de Amigos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main class="container">
        <div class="page-header">
            <h1>Meus amigos</h1>
            <a href="criar.php" class="btn btn-primary">+ Novo amigo</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alerta alerta-sucesso"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <form method="GET" action="listar.php" class="busca-form">
            <input type="text" name="busca" placeholder="Buscar por nome..." value="<?= htmlspecialchars($busca) ?>">
            <button type="submit" class="btn btn-secundario">Buscar</button>
        </form>

        <?php if (count($amigos) === 0): ?>
            <p class="vazio">Nenhum amigo cadastrado ainda. Clique em "Novo amigo" para começar.</p>
        <?php else: ?>
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Nascimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($amigos as $amigo): ?>
                        <tr>
                            <td><?= htmlspecialchars($amigo['nome']) ?></td>
                            <td><?= htmlspecialchars($amigo['telefone'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($amigo['email'] ?? '-') ?></td>
                            <td>
                                <?= $amigo['data_nascimento']
                                    ? date('d/m/Y', strtotime($amigo['data_nascimento']))
                                    : '-' ?>
                            </td>
                            <td class="acoes">
                                <a href="editar.php?id=<?= $amigo['id'] ?>" class="link-acao">Editar</a>
                                <a href="excluir.php?id=<?= $amigo['id'] ?>"
                                   class="link-acao link-perigo"
                                   onclick="return confirm('Tem certeza que deseja excluir <?= htmlspecialchars($amigo['nome'], ENT_QUOTES) ?>?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>
