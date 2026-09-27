<?php
/**
 * Funções auxiliares de autenticação
 * Controla sessão do usuário logado e protege páginas restritas
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica se existe um usuário logado na sessão
 */
function usuarioLogado(): bool
{
    return isset($_SESSION['usuario_id']);
}

/**
 * Bloqueia o acesso à página caso o usuário não esteja logado,
 * redirecionando para a tela de login
 */
function protegerPagina(): void
{
    if (!usuarioLogado()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Retorna o id do usuário logado
 */
function usuarioIdLogado(): ?int
{
    return $_SESSION['usuario_id'] ?? null;
}
