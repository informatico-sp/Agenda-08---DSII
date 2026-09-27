<?php
require_once __DIR__ . '/includes/auth.php';

if (usuarioLogado()) {
    header('Location: listar.php');
} else {
    header('Location: login.php');
}
exit;
