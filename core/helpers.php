<?php
function clean(?string $data): string {
    return htmlspecialchars(strip_tags(trim($data ?? '')), ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header('Location: ' . SITE_URL . '/' . ltrim($path, '/'));
    exit();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function userRole(): ?string {
    return $_SESSION['role'] ?? null;
}

function requireRole(string $role): void {
    if (!isLoggedIn() || userRole() !== $role) {
        redirect('login');
    }
}

function requireAuth(): void {
    if (!isLoggedIn()) redirect('login');
}

 
