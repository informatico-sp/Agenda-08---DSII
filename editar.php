<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

protegerPagina();

$pdo = conectar();
$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM amigos WHERE id = ? AND usuario_id = ?');
$stmt->execute([$id, usuarioIdLogado()]);
$amigo = $stmt->fetch();

if (!$amigo) {
    header('Location: listar.php?msg=' . urlencode('Amigo não encontrado.'));
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dataNascimento = $_POST['data_nascimento'] ?? null;
    $observacoes = trim($_POST['observacoes'] ?? '');

    if ($nome === '') {
        $erro = 'O nome é obrigatório.';
    } else {
        $stmt = $pdo->prepare(
            'UPDATE amigos
             SET nome = ?, telefone = ?, email = ?, data_nascimento = ?, observacoes = ?
             WHERE id = ? AND usuario_id = ?'
        );
        $stmt->execute([
            $nome,
            $telefone ?: null,
            $email ?: null,
            $dataNascimento ?: null,
            $observacoes ?: null,
            $id,
            usuarioIdLogado(),
        ]);

        header('Location: listar.php?msg=' . urlencode('Amigo atualizado com sucesso!'));
        exit;
    }

    // Mantém os dados digitados na tela em caso de erro
    $amigo = array_merge($amigo, $_POST);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar amigo - Cadastro de Amigos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <main class="container container-form">
        <h1>Editar amigo</h1>

        <?php if ($erro): ?>
            <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="editar.php?id=<?= $amigo['id'] ?>" class="form-card">
            <label for="nome">Nome *</label>
            <input type="text" id="nome" name="nome" required autofocus
                   value="<?= htmlspecialchars($amigo['nome']) ?>">

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone"
                   value="<?= htmlspecialchars($amigo['telefone'] ?? '') ?>">

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($amigo['email'] ?? '') ?>">

            <label for="data_nascimento">Data de nascimento</label>
            <input type="date" id="data_nascimento" name="data_nascimento"
                   value="<?= htmlspecialchars($amigo['data_nascimento'] ?? '') ?>">

            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="3"><?= htmlspecialchars($amigo['observacoes'] ?? '') ?></textarea>

            <div class="form-acoes">
                <a href="listar.php" class="btn btn-secundario">Cancelar</a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </main>
</body>
</html>
