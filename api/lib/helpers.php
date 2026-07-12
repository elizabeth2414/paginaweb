<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/** Envía una respuesta JSON y termina la ejecución. */
function json_out($data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/** Error JSON estándar. */
function json_error(string $message, int $status = 400, array $extra = []): void
{
    json_out(array_merge(['ok' => false, 'error' => $message], $extra), $status);
}

/** Aplica cabeceras CORS según la configuración. */
function apply_cors(): void
{
    $cfg = ms_config();
    $allowed = $cfg['cors_origins'];
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if ($allowed === '*') {
        header('Access-Control-Allow-Origin: *');
    } else {
        $list = array_map('trim', explode(',', $allowed));
        if ($origin && in_array($origin, $list, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
        }
    }
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}

/** Devuelve el cuerpo JSON de la petición como array. */
function request_body(): array
{
    $raw = file_get_contents('php://input');
    if ($raw === '' || $raw === false) {
        return $_POST ?: [];
    }
    $data = json_decode($raw, true);
    return is_array($data) ? $data : ($_POST ?: []);
}

/** Genera un token aleatorio. */
function make_token(int $bytes = 32): string
{
    return bin2hex(random_bytes($bytes));
}

/** Marca de tiempo ISO 8601 en UTC. */
function now_iso(): string
{
    return gmdate('Y-m-d\TH:i:s\Z');
}

/** Lee el token Bearer de la cabecera Authorization. */
function bearer_token(): ?string
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if ($header === '' && function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
        $header = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    }
    if (preg_match('/Bearer\s+(\S+)/i', $header, $m)) {
        return $m[1];
    }
    return null;
}

/** Devuelve el usuario autenticado (o null). */
function current_user(): ?array
{
    $token = bearer_token();
    if (!$token) {
        return null;
    }
    $stmt = ms_db()->prepare('SELECT * FROM users WHERE token = ? LIMIT 1');
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/** Exige un usuario autenticado; corta con 401 si no lo hay. */
function require_user(): array
{
    $user = current_user();
    if (!$user) {
        json_error('No autenticado', 401);
    }
    return $user;
}

/** Exige un rol concreto (o admin). */
function require_role(string $role): array
{
    $user = require_user();
    if ($user['role'] !== $role && $user['role'] !== 'admin') {
        json_error('No autorizado', 403);
    }
    return $user;
}

/** Convierte un string en slug URL-safe. */
function slugify(string $text): string
{
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim((string) $text, '-');
    return $text !== '' ? $text : 'evento-' . substr(md5((string) microtime(true)), 0, 6);
}

/** Decodifica de forma segura el campo JSON `data`. */
function decode_data($raw): array
{
    if (is_array($raw)) {
        return $raw;
    }
    if (!$raw) {
        return [];
    }
    $d = json_decode((string) $raw, true);
    return is_array($d) ? $d : [];
}
