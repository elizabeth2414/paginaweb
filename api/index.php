<?php
/**
 * Match Sport API — router principal.
 *
 * Todas las rutas cuelgan de /api/. Ejemplos:
 *   GET  /api/countries
 *   POST /api/auth/login
 *   GET  /api/events
 *   GET  /api/events/rally-costero
 *   POST /api/registrations
 *   POST /api/payouts
 *   GET  /api/export?type=registrations&event=ID
 */

declare(strict_types=1);

require_once __DIR__ . '/lib/helpers.php';

apply_cors();

// --- Resolver la ruta -------------------------------------------------------
$path = $_GET['path'] ?? ($_SERVER['PATH_INFO'] ?? '');
if ($path === '') {
    // Deriva la ruta desde REQUEST_URI quitando el prefijo /api.
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
    $uri = preg_replace('#^.*?/api#', '', $uri) ?? '';
    $path = $uri;
}
$path = '/' . trim($path, '/');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$segments = $path === '/' ? [] : explode('/', trim($path, '/'));

try {
    route($method, $segments);
    json_error('Ruta no encontrada: ' . $path, 404);
} catch (Throwable $e) {
    json_error('Error del servidor: ' . $e->getMessage(), 500);
}

function route(string $method, array $seg): void
{
    $resource = $seg[0] ?? '';

    switch ($resource) {
        case '':
        case 'health':
            json_out(['ok' => true, 'service' => 'match-sport-api', 'time' => now_iso()]);
            break;
        case 'countries':
            handle_countries($method);
            break;
        case 'auth':
            handle_auth($method, $seg[1] ?? '');
            break;
        case 'events':
            handle_events($method, $seg[1] ?? null);
            break;
        case 'registrations':
            handle_registrations($method, $seg[1] ?? null);
            break;
        case 'results':
            handle_results($method, $seg[1] ?? null);
            break;
        case 'coupons':
            handle_coupons($method, $seg[1] ?? null);
            break;
        case 'payouts':
            handle_payouts($method, $seg[1] ?? null);
            break;
        case 'export':
            handle_export();
            break;
        case 'admin':
            handle_admin($method, $seg[1] ?? '');
            break;
    }
}

// ============================================================
// COUNTRIES
// ============================================================
function handle_countries(string $method): void
{
    if ($method !== 'GET') {
        json_error('Método no permitido', 405);
    }
    $rows = ms_db()->query('SELECT * FROM countries WHERE enabled = 1 ORDER BY name')->fetchAll();
    $cfg = ms_config();
    foreach ($rows as &$r) {
        $r['tax_rate'] = (float) $r['tax_rate'];
    }
    json_out([
        'ok' => true,
        'countries' => $rows,
        'commission_rate' => $cfg['commission_rate'],
    ]);
}

// ============================================================
// AUTH
// ============================================================
function handle_auth(string $method, string $action): void
{
    $db = ms_db();

    if ($action === 'register' && $method === 'POST') {
        $b = request_body();
        $email = strtolower(trim((string) ($b['email'] ?? '')));
        $password = (string) ($b['password'] ?? '');
        $name = trim((string) ($b['name'] ?? ''));
        $role = in_array(($b['role'] ?? ''), ['organizador', 'corredor'], true) ? $b['role'] : 'organizador';
        $country = strtoupper(substr((string) ($b['country_code'] ?? 'CL'), 0, 2));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            json_error('Email inválido o contraseña muy corta (mínimo 6 caracteres).');
        }
        $exists = $db->prepare('SELECT id FROM users WHERE email = ?');
        $exists->execute([$email]);
        if ($exists->fetch()) {
            json_error('Ya existe una cuenta con ese email.', 409);
        }
        $token = make_token();
        $stmt = $db->prepare(
            'INSERT INTO users (name, email, password_hash, role, provider, country_code, token, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role, 'password', $country, $token, now_iso()]);
        json_out(['ok' => true, 'token' => $token, 'user' => public_user($db, $email)], 201);
    }

    if ($action === 'login' && $method === 'POST') {
        $b = request_body();
        $email = strtolower(trim((string) ($b['email'] ?? '')));
        $password = (string) ($b['password'] ?? '');
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            json_error('Credenciales incorrectas.', 401);
        }
        $token = make_token();
        $db->prepare('UPDATE users SET token = ? WHERE id = ?')->execute([$token, $user['id']]);
        json_out(['ok' => true, 'token' => $token, 'user' => sanitize_user($user)]);
    }

    if ($action === 'admin' && $method === 'POST') {
        $b = request_body();
        $key = (string) ($b['key'] ?? '');
        if (!hash_equals(ms_config()['admin_key'], $key)) {
            json_error('Clave de administrador incorrecta.', 401);
        }
        // Usuario admin persistente.
        $admin = $db->query("SELECT * FROM users WHERE role = 'admin' LIMIT 1")->fetch();
        $token = make_token();
        if ($admin) {
            $db->prepare('UPDATE users SET token = ? WHERE id = ?')->execute([$token, $admin['id']]);
        } else {
            $db->prepare(
                'INSERT INTO users (name, email, role, provider, token, created_at)
                 VALUES (?, ?, ?, ?, ?, ?)'
            )->execute(['Administrador', 'admin@match-sport.com', 'admin', 'admin-key', $token, now_iso()]);
        }
        json_out(['ok' => true, 'token' => $token, 'user' => ['role' => 'admin', 'name' => 'Administrador']]);
    }

    if ($action === 'me' && $method === 'GET') {
        $user = current_user();
        json_out(['ok' => true, 'user' => $user ? sanitize_user($user) : null]);
    }

    if ($action === 'logout' && $method === 'POST') {
        $user = current_user();
        if ($user) {
            $db->prepare('UPDATE users SET token = ? WHERE id = ?')->execute(['', $user['id']]);
        }
        json_out(['ok' => true]);
    }

    json_error('Acción de auth no válida.', 404);
}

function public_user(PDO $db, string $email): array
{
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    return sanitize_user($stmt->fetch() ?: []);
}

function sanitize_user(array $u): array
{
    unset($u['password_hash'], $u['token']);
    return $u;
}

// ============================================================
// EVENTS
// ============================================================
function handle_events(string $method, ?string $id): void
{
    $db = ms_db();

    // Listado público (solo eventos que existen y están publicados por defecto).
    if ($method === 'GET' && $id === null) {
        $mine = isset($_GET['mine']);
        $all = isset($_GET['all']);
        if ($mine) {
            $user = require_user();
            $stmt = $db->prepare('SELECT * FROM events WHERE organizer_id = ? ORDER BY id DESC');
            $stmt->execute([$user['id']]);
            $rows = $stmt->fetchAll();
        } elseif ($all) {
            require_role('admin');
            $rows = $db->query('SELECT * FROM events ORDER BY id DESC')->fetchAll();
        } else {
            // Público: solo activos/finalizados (no borradores).
            $rows = $db->query("SELECT * FROM events WHERE estado IN ('activo','finalizado') ORDER BY id DESC")->fetchAll();
        }
        json_out(['ok' => true, 'events' => array_map('expand_event', $rows)]);
    }

    // Detalle. Si no existe -> 404 (arregla "detalle de eventos que no existen").
    if ($method === 'GET' && $id !== null) {
        $ev = find_event($db, $id);
        if (!$ev) {
            json_error('El evento no existe.', 404);
        }
        json_out(['ok' => true, 'event' => expand_event($ev)]);
    }

    // Crear.
    if ($method === 'POST' && $id === null) {
        $user = require_user();
        $b = request_body();
        $ev = save_event($db, null, $b, (int) $user['id']);
        json_out(['ok' => true, 'event' => expand_event($ev)], 201);
    }

    // Actualizar.
    if (($method === 'PUT' || $method === 'PATCH') && $id !== null) {
        $user = require_user();
        $existing = find_event($db, $id);
        if (!$existing) {
            json_error('El evento no existe.', 404);
        }
        if ($user['role'] !== 'admin' && (int) $existing['organizer_id'] !== (int) $user['id']) {
            json_error('No puedes editar este evento.', 403);
        }
        $b = request_body();
        $ev = save_event($db, (int) $existing['id'], $b, (int) $existing['organizer_id']);
        json_out(['ok' => true, 'event' => expand_event($ev)]);
    }

    // Eliminar.
    if ($method === 'DELETE' && $id !== null) {
        $user = require_user();
        $existing = find_event($db, $id);
        if (!$existing) {
            json_error('El evento no existe.', 404);
        }
        if ($user['role'] !== 'admin' && (int) $existing['organizer_id'] !== (int) $user['id']) {
            json_error('No puedes eliminar este evento.', 403);
        }
        $db->prepare('DELETE FROM events WHERE id = ?')->execute([$existing['id']]);
        json_out(['ok' => true]);
    }

    json_error('Método no permitido', 405);
}

function find_event(PDO $db, string $id): ?array
{
    if (ctype_digit($id)) {
        $stmt = $db->prepare('SELECT * FROM events WHERE id = ? OR slug = ? LIMIT 1');
        $stmt->execute([(int) $id, $id]);
    } else {
        $stmt = $db->prepare('SELECT * FROM events WHERE slug = ? LIMIT 1');
        $stmt->execute([$id]);
    }
    return $stmt->fetch() ?: null;
}

function save_event(PDO $db, ?int $id, array $b, int $organizerId): array
{
    $nombre = trim((string) ($b['nombre'] ?? $b['name'] ?? 'Evento sin nombre'));
    $data = $b['data'] ?? $b;
    $slug = trim((string) ($b['slug'] ?? ''));
    if ($slug === '') {
        $slug = slugify($nombre);
    }

    $fields = [
        'slug'         => unique_slug($db, $slug, $id),
        'organizer_id' => $organizerId ?: null,
        'nombre'       => $nombre,
        'deporte'      => (string) ($b['deporte'] ?? ''),
        'descripcion'  => (string) ($b['descripcion'] ?? $b['desc'] ?? ''),
        'fecha'        => (string) ($b['fecha'] ?? ''),
        'fecha_iso'    => (string) ($b['fecha_iso'] ?? ''),
        'ubicacion'    => (string) ($b['ubicacion'] ?? ''),
        'country_code' => strtoupper(substr((string) ($b['country_code'] ?? 'CL'), 0, 2)),
        'currency'     => strtoupper(substr((string) ($b['currency'] ?? 'CLP'), 0, 3)),
        'lat'          => isset($b['lat']) && $b['lat'] !== '' ? (float) $b['lat'] : null,
        'lng'          => isset($b['lng']) && $b['lng'] !== '' ? (float) $b['lng'] : null,
        'estado'       => (string) ($b['estado'] ?? 'activo'),
        'icon'         => (string) ($b['icon'] ?? 'ti-run'),
        'color'        => (string) ($b['color'] ?? 'purple'),
        'precio'       => (float) ($b['precio'] ?? 0),
        'cupos'        => (int) ($b['cupos'] ?? $b['total'] ?? 0),
        'data'         => json_encode($data, JSON_UNESCAPED_UNICODE),
        'updated_at'   => now_iso(),
    ];

    if ($id === null) {
        $fields['created_at'] = now_iso();
        $cols = implode(',', array_keys($fields));
        $ph = implode(',', array_fill(0, count($fields), '?'));
        $stmt = $db->prepare("INSERT INTO events ($cols) VALUES ($ph)");
        $stmt->execute(array_values($fields));
        $id = (int) $db->lastInsertId();
    } else {
        $set = implode(',', array_map(fn($k) => "$k = ?", array_keys($fields)));
        $stmt = $db->prepare("UPDATE events SET $set WHERE id = ?");
        $stmt->execute([...array_values($fields), $id]);
    }

    $stmt = $db->prepare('SELECT * FROM events WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function unique_slug(PDO $db, string $slug, ?int $exceptId): string
{
    $base = $slug;
    $i = 1;
    while (true) {
        $stmt = $db->prepare('SELECT id FROM events WHERE slug = ? AND (id <> ? OR ? IS NULL)');
        $stmt->execute([$slug, $exceptId ?? 0, $exceptId]);
        if (!$stmt->fetch()) {
            return $slug;
        }
        $slug = $base . '-' . (++$i);
    }
}

function expand_event(array $ev): array
{
    $ev['data'] = decode_data($ev['data'] ?? null);
    $ev['precio'] = (float) $ev['precio'];
    $ev['cupos'] = (int) $ev['cupos'];
    if (isset($ev['lat'])) $ev['lat'] = $ev['lat'] === null ? null : (float) $ev['lat'];
    if (isset($ev['lng'])) $ev['lng'] = $ev['lng'] === null ? null : (float) $ev['lng'];
    // Estadísticas reales de inscripciones.
    $db = ms_db();
    $stmt = $db->prepare('SELECT COUNT(*) c, COALESCE(SUM(total),0) t FROM registrations WHERE event_id = ?');
    $stmt->execute([$ev['id']]);
    $agg = $stmt->fetch();
    $ev['vendidos'] = (int) $agg['c'];
    $ev['recaudado'] = (float) $agg['t'];
    return $ev;
}

// ============================================================
// REGISTRATIONS (inscripciones)
// ============================================================
function handle_registrations(string $method, ?string $id): void
{
    $db = ms_db();
    $cfg = ms_config();

    if ($method === 'GET') {
        $eventId = $_GET['event'] ?? $_GET['event_id'] ?? null;
        if ($eventId !== null) {
            $ev = find_event($db, (string) $eventId);
            if (!$ev) {
                json_error('El evento no existe.', 404);
            }
            $stmt = $db->prepare('SELECT * FROM registrations WHERE event_id = ? ORDER BY id DESC');
            $stmt->execute([$ev['id']]);
        } else {
            require_role('admin');
            $stmt = $db->query('SELECT * FROM registrations ORDER BY id DESC');
        }
        $rows = array_map(function ($r) {
            $r['data'] = decode_data($r['data'] ?? null);
            return $r;
        }, $stmt->fetchAll());
        json_out(['ok' => true, 'registrations' => $rows]);
    }

    if ($method === 'POST') {
        $b = request_body();
        $eventId = (string) ($b['event_id'] ?? $b['eventId'] ?? '');
        $ev = find_event($db, $eventId);
        if (!$ev) {
            json_error('El evento no existe.', 404);
        }
        $subtotal = (float) ($b['subtotal'] ?? $b['precio'] ?? 0);
        $rate = $cfg['commission_rate'];
        $commission = round($subtotal * $rate, 2);
        $total = isset($b['total']) ? (float) $b['total'] : round($subtotal + $commission, 2);
        $ticket = 'MS-' . strtoupper(substr(md5(uniqid('', true)), 0, 8));

        $stmt = $db->prepare(
            'INSERT INTO registrations
             (event_id, nombre, email, documento, categoria, currency, subtotal, commission, total, estado, payment_method, ticket_code, data, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $ev['id'],
            (string) ($b['nombre'] ?? ''),
            (string) ($b['email'] ?? ''),
            (string) ($b['documento'] ?? ''),
            (string) ($b['categoria'] ?? ''),
            strtoupper(substr((string) ($b['currency'] ?? $ev['currency']), 0, 3)),
            $subtotal,
            $commission,
            $total,
            (string) ($b['estado'] ?? 'pagado'),
            (string) ($b['payment_method'] ?? ''),
            $ticket,
            json_encode($b['data'] ?? $b, JSON_UNESCAPED_UNICODE),
            now_iso(),
        ]);
        $rid = (int) $db->lastInsertId();
        $row = $db->query('SELECT * FROM registrations WHERE id = ' . $rid)->fetch();
        $row['data'] = decode_data($row['data'] ?? null);
        json_out(['ok' => true, 'registration' => $row, 'ticket_code' => $ticket, 'commission' => $commission], 201);
    }

    json_error('Método no permitido', 405);
}

// ============================================================
// RESULTS (solo resultados reales)
// ============================================================
function handle_results(string $method, ?string $id): void
{
    $db = ms_db();
    if ($method === 'GET') {
        $eventId = $_GET['event'] ?? null;
        if ($eventId !== null) {
            $ev = find_event($db, (string) $eventId);
            if (!$ev) json_error('El evento no existe.', 404);
            $stmt = $db->prepare('SELECT * FROM results WHERE event_id = ? ORDER BY posicion ASC');
            $stmt->execute([$ev['id']]);
            json_out(['ok' => true, 'results' => $stmt->fetchAll()]);
        }
        // Devuelve eventos finalizados que tengan resultados cargados.
        $rows = $db->query(
            "SELECT e.* FROM events e
             WHERE e.estado = 'finalizado'
               AND EXISTS (SELECT 1 FROM results r WHERE r.event_id = e.id)
             ORDER BY e.id DESC"
        )->fetchAll();
        json_out(['ok' => true, 'events' => array_map('expand_event', $rows)]);
    }

    if ($method === 'POST') {
        $user = require_user();
        $b = request_body();
        $ev = find_event($db, (string) ($b['event_id'] ?? ''));
        if (!$ev) json_error('El evento no existe.', 404);
        if ($user['role'] !== 'admin' && (int) $ev['organizer_id'] !== (int) $user['id']) {
            json_error('No autorizado.', 403);
        }
        $stmt = $db->prepare(
            'INSERT INTO results (event_id, posicion, nombre, categoria, tiempo, created_at) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $ev['id'],
            (int) ($b['posicion'] ?? 0),
            (string) ($b['nombre'] ?? ''),
            (string) ($b['categoria'] ?? ''),
            (string) ($b['tiempo'] ?? ''),
            now_iso(),
        ]);
        json_out(['ok' => true, 'id' => (int) $db->lastInsertId()], 201);
    }

    json_error('Método no permitido', 405);
}

// ============================================================
// COUPONS
// ============================================================
function handle_coupons(string $method, ?string $id): void
{
    $db = ms_db();
    if ($method === 'GET') {
        $eventId = $_GET['event'] ?? null;
        if ($eventId !== null) {
            $ev = find_event($db, (string) $eventId);
            if (!$ev) json_error('El evento no existe.', 404);
            $stmt = $db->prepare('SELECT * FROM coupons WHERE event_id = ? ORDER BY id DESC');
            $stmt->execute([$ev['id']]);
        } else {
            $stmt = $db->query('SELECT * FROM coupons ORDER BY id DESC');
        }
        json_out(['ok' => true, 'coupons' => $stmt->fetchAll()]);
    }
    if ($method === 'POST') {
        $user = require_user();
        $b = request_body();
        $eventId = null;
        if (!empty($b['event_id'])) {
            $ev = find_event($db, (string) $b['event_id']);
            $eventId = $ev ? (int) $ev['id'] : null;
        }
        $stmt = $db->prepare(
            'INSERT INTO coupons (event_id, code, descuento, tipo, max_usos, created_at) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $eventId,
            strtoupper(trim((string) ($b['code'] ?? ''))),
            (float) ($b['descuento'] ?? 0),
            (string) ($b['tipo'] ?? 'porcentaje'),
            (int) ($b['max_usos'] ?? 0),
            now_iso(),
        ]);
        json_out(['ok' => true, 'id' => (int) $db->lastInsertId()], 201);
    }
    json_error('Método no permitido', 405);
}

// ============================================================
// PAYOUTS (comprobantes que el admin transfiere al organizador)
// ============================================================
function handle_payouts(string $method, ?string $id): void
{
    $db = ms_db();

    if ($method === 'GET') {
        $user = require_user();
        if ($user['role'] === 'admin') {
            $rows = $db->query(
                'SELECT p.*, u.name AS organizer_name, u.email AS organizer_email, e.nombre AS event_name
                 FROM payouts p
                 LEFT JOIN users u ON u.id = p.organizer_id
                 LEFT JOIN events e ON e.id = p.event_id
                 ORDER BY p.id DESC'
            )->fetchAll();
        } else {
            // El organizador solo ve sus propios comprobantes.
            $stmt = $db->prepare(
                'SELECT p.*, e.nombre AS event_name FROM payouts p
                 LEFT JOIN events e ON e.id = p.event_id
                 WHERE p.organizer_id = ? ORDER BY p.id DESC'
            );
            $stmt->execute([$user['id']]);
            $rows = $stmt->fetchAll();
        }
        json_out(['ok' => true, 'payouts' => $rows]);
    }

    // Solo el admin sube comprobantes (multipart/form-data con archivo).
    if ($method === 'POST') {
        require_role('admin');
        $organizerId = (int) ($_POST['organizer_id'] ?? 0);
        $eventId = $_POST['event_id'] ?? null;
        if ($eventId !== null && $eventId !== '') {
            $ev = find_event($db, (string) $eventId);
            $eventId = $ev ? (int) $ev['id'] : null;
        } else {
            $eventId = null;
        }

        $comprobante = '';
        if (!empty($_FILES['comprobante']['tmp_name'])) {
            $comprobante = store_upload($_FILES['comprobante']);
        }

        $stmt = $db->prepare(
            'INSERT INTO payouts
             (organizer_id, event_id, monto, currency, total_evento, comprobante_file, nota, estado, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $organizerId ?: null,
            $eventId,
            (float) ($_POST['monto'] ?? 0),
            strtoupper(substr((string) ($_POST['currency'] ?? 'CLP'), 0, 3)),
            (float) ($_POST['total_evento'] ?? 0),
            $comprobante,
            (string) ($_POST['nota'] ?? ''),
            (string) ($_POST['estado'] ?? 'transferido'),
            now_iso(),
        ]);
        json_out(['ok' => true, 'id' => (int) $db->lastInsertId(), 'comprobante' => $comprobante], 201);
    }

    json_error('Método no permitido', 405);
}

function store_upload(array $file): string
{
    $cfg = ms_config();
    $dir = $cfg['uploads_dir'] . '/comprobantes';
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'webp'];
    if (!in_array($ext, $allowed, true)) {
        json_error('Formato de archivo no permitido (usa jpg, png, webp o pdf).', 422);
    }
    if ($file['size'] > 8 * 1024 * 1024) {
        json_error('El archivo supera los 8 MB.', 422);
    }
    $name = 'comp-' . date('Ymd-His') . '-' . substr(md5(uniqid('', true)), 0, 6) . '.' . $ext;
    $dest = $dir . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        // Fallback para entornos donde no aplica move_uploaded_file (tests).
        if (!@rename($file['tmp_name'], $dest)) {
            json_error('No se pudo guardar el archivo.', 500);
        }
    }
    return 'uploads/comprobantes/' . $name;
}

// ============================================================
// EXPORT (CSV real y descargable)
// ============================================================
function handle_export(): void
{
    $db = ms_db();
    $type = $_GET['type'] ?? 'registrations';

    if ($type === 'registrations') {
        $eventId = $_GET['event'] ?? null;
        if ($eventId !== null) {
            $ev = find_event($db, (string) $eventId);
            if (!$ev) json_error('El evento no existe.', 404);
            $stmt = $db->prepare('SELECT * FROM registrations WHERE event_id = ? ORDER BY id');
            $stmt->execute([$ev['id']]);
            $rows = $stmt->fetchAll();
            $filename = 'inscripciones-' . $ev['slug'] . '.csv';
        } else {
            $rows = $db->query('SELECT * FROM registrations ORDER BY id')->fetchAll();
            $filename = 'inscripciones.csv';
        }
        $headers = ['id', 'event_id', 'nombre', 'email', 'documento', 'categoria', 'currency', 'subtotal', 'commission', 'total', 'estado', 'payment_method', 'ticket_code', 'created_at'];
        emit_csv($filename, $headers, $rows);
    }

    if ($type === 'events') {
        $rows = $db->query('SELECT * FROM events ORDER BY id')->fetchAll();
        $headers = ['id', 'slug', 'nombre', 'deporte', 'fecha', 'ubicacion', 'country_code', 'currency', 'estado', 'precio', 'cupos', 'created_at'];
        emit_csv('eventos.csv', $headers, $rows);
    }

    if ($type === 'payouts') {
        $rows = $db->query('SELECT * FROM payouts ORDER BY id')->fetchAll();
        $headers = ['id', 'organizer_id', 'event_id', 'monto', 'currency', 'total_evento', 'comprobante_file', 'nota', 'estado', 'created_at'];
        emit_csv('comprobantes.csv', $headers, $rows);
    }

    json_error('Tipo de exportación no válido.', 400);
}

function emit_csv(string $filename, array $headers, array $rows): void
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $out = fopen('php://output', 'w');
    fprintf($out, "\xEF\xBB\xBF"); // BOM para Excel
    fputcsv($out, $headers);
    foreach ($rows as $row) {
        $line = [];
        foreach ($headers as $h) {
            $line[] = $row[$h] ?? '';
        }
        fputcsv($out, $line);
    }
    fclose($out);
    exit;
}

// ============================================================
// ADMIN (finanzas / comisiones)
// ============================================================
function handle_admin(string $method, string $action): void
{
    $db = ms_db();
    require_role('admin');
    $cfg = ms_config();

    if ($action === 'finance' && $method === 'GET') {
        $totals = $db->query(
            'SELECT COALESCE(SUM(subtotal),0) subtotal, COALESCE(SUM(commission),0) commission,
                    COALESCE(SUM(total),0) total, COUNT(*) inscripciones
             FROM registrations'
        )->fetch();
        $byCountry = $db->query(
            'SELECT e.country_code, COALESCE(SUM(r.total),0) total, COALESCE(SUM(r.commission),0) commission, COUNT(r.id) inscripciones
             FROM registrations r JOIN events e ON e.id = r.event_id
             GROUP BY e.country_code'
        )->fetchAll();
        $payouts = (float) $db->query('SELECT COALESCE(SUM(monto),0) FROM payouts')->fetchColumn();

        $commission = (float) $totals['commission'];
        $ivaComision = round($commission * $cfg['iva_rate'], 2);

        json_out([
            'ok' => true,
            'commission_rate' => $cfg['commission_rate'],
            'iva_rate' => $cfg['iva_rate'],
            'totales' => [
                'subtotal' => (float) $totals['subtotal'],
                'comision' => $commission,
                'iva_comision' => $ivaComision,
                'total_cobrado' => (float) $totals['total'],
                'inscripciones' => (int) $totals['inscripciones'],
                'transferido_a_organizadores' => $payouts,
            ],
            'por_pais' => $byCountry,
        ]);
    }

    if ($action === 'organizers' && $method === 'GET') {
        $rows = $db->query(
            "SELECT id, name, email, country_code, created_at,
                    (SELECT COUNT(*) FROM events e WHERE e.organizer_id = users.id) AS eventos
             FROM users WHERE role = 'organizador' ORDER BY id DESC"
        )->fetchAll();
        json_out(['ok' => true, 'organizers' => $rows]);
    }

    json_error('Acción de admin no válida.', 404);
}
