<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Devuelve una conexión PDO (singleton) a MySQL o SQLite según la config.
 */
function ms_db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = ms_config();
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    if ($cfg['db_driver'] === 'sqlite') {
        $path = $cfg['db_sqlite'];
        $dir = dirname($path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $pdo = new PDO('sqlite:' . $path, null, null, $options);
        $pdo->exec('PRAGMA foreign_keys = ON;');
    } else {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $cfg['db_host'],
            $cfg['db_port'],
            $cfg['db_name']
        );
        $pdo = new PDO($dsn, $cfg['db_user'], $cfg['db_pass'], $options);
    }

    ms_db_migrate($pdo, $cfg['db_driver']);
    ms_db_seed($pdo);

    return $pdo;
}

/**
 * Crea las tablas si no existen. SQL portable entre MySQL y SQLite.
 */
function ms_db_migrate(PDO $pdo, string $driver): void
{
    $isMysql = ($driver === 'mysql');
    $auto = $isMysql ? 'INT AUTO_INCREMENT PRIMARY KEY' : 'INTEGER PRIMARY KEY AUTOINCREMENT';
    $engine = $isMysql ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4' : '';
    $text = $isMysql ? 'LONGTEXT' : 'TEXT';

    $statements = [];

    $statements[] = "CREATE TABLE IF NOT EXISTS countries (
        code VARCHAR(2) PRIMARY KEY,
        name VARCHAR(80) NOT NULL,
        currency VARCHAR(3) NOT NULL,
        currency_label VARCHAR(60) NOT NULL,
        flag VARCHAR(12) NOT NULL DEFAULT '',
        tax_label VARCHAR(30) NOT NULL DEFAULT '',
        tax_rate DECIMAL(6,4) NOT NULL DEFAULT 0,
        enabled INTEGER NOT NULL DEFAULT 1
    ) $engine";

    $statements[] = "CREATE TABLE IF NOT EXISTS users (
        id $auto,
        name VARCHAR(120) NOT NULL DEFAULT '',
        email VARCHAR(190) NOT NULL,
        password_hash VARCHAR(255) NOT NULL DEFAULT '',
        role VARCHAR(20) NOT NULL DEFAULT 'organizador',
        provider VARCHAR(30) NOT NULL DEFAULT 'password',
        country_code VARCHAR(2) NOT NULL DEFAULT 'CL',
        token VARCHAR(80) NOT NULL DEFAULT '',
        created_at VARCHAR(30) NOT NULL DEFAULT ''
    ) $engine";
    $statements[] = "CREATE UNIQUE INDEX IF NOT EXISTS idx_users_email ON users(email)";
    $statements[] = "CREATE INDEX IF NOT EXISTS idx_users_token ON users(token)";

    $statements[] = "CREATE TABLE IF NOT EXISTS events (
        id $auto,
        slug VARCHAR(120) NOT NULL,
        organizer_id INTEGER NULL,
        nombre VARCHAR(200) NOT NULL,
        deporte VARCHAR(80) NOT NULL DEFAULT '',
        descripcion $text NULL,
        fecha VARCHAR(120) NOT NULL DEFAULT '',
        fecha_iso VARCHAR(30) NOT NULL DEFAULT '',
        ubicacion VARCHAR(200) NOT NULL DEFAULT '',
        country_code VARCHAR(2) NOT NULL DEFAULT 'CL',
        currency VARCHAR(3) NOT NULL DEFAULT 'CLP',
        lat DECIMAL(10,6) NULL,
        lng DECIMAL(10,6) NULL,
        estado VARCHAR(20) NOT NULL DEFAULT 'borrador',
        icon VARCHAR(40) NOT NULL DEFAULT 'ti-run',
        color VARCHAR(20) NOT NULL DEFAULT 'purple',
        precio DECIMAL(12,2) NOT NULL DEFAULT 0,
        cupos INTEGER NOT NULL DEFAULT 0,
        data $text NULL,
        created_at VARCHAR(30) NOT NULL DEFAULT '',
        updated_at VARCHAR(30) NOT NULL DEFAULT ''
    ) $engine";
    $statements[] = "CREATE UNIQUE INDEX IF NOT EXISTS idx_events_slug ON events(slug)";
    $statements[] = "CREATE INDEX IF NOT EXISTS idx_events_org ON events(organizer_id)";

    $statements[] = "CREATE TABLE IF NOT EXISTS registrations (
        id $auto,
        event_id INTEGER NOT NULL,
        nombre VARCHAR(160) NOT NULL DEFAULT '',
        email VARCHAR(190) NOT NULL DEFAULT '',
        documento VARCHAR(60) NOT NULL DEFAULT '',
        categoria VARCHAR(120) NOT NULL DEFAULT '',
        currency VARCHAR(3) NOT NULL DEFAULT 'CLP',
        subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
        commission DECIMAL(12,2) NOT NULL DEFAULT 0,
        total DECIMAL(12,2) NOT NULL DEFAULT 0,
        estado VARCHAR(20) NOT NULL DEFAULT 'pagado',
        payment_method VARCHAR(40) NOT NULL DEFAULT '',
        ticket_code VARCHAR(40) NOT NULL DEFAULT '',
        data $text NULL,
        created_at VARCHAR(30) NOT NULL DEFAULT ''
    ) $engine";
    $statements[] = "CREATE INDEX IF NOT EXISTS idx_reg_event ON registrations(event_id)";

    $statements[] = "CREATE TABLE IF NOT EXISTS results (
        id $auto,
        event_id INTEGER NOT NULL,
        posicion INTEGER NOT NULL DEFAULT 0,
        nombre VARCHAR(160) NOT NULL DEFAULT '',
        categoria VARCHAR(120) NOT NULL DEFAULT '',
        tiempo VARCHAR(40) NOT NULL DEFAULT '',
        created_at VARCHAR(30) NOT NULL DEFAULT ''
    ) $engine";
    $statements[] = "CREATE INDEX IF NOT EXISTS idx_res_event ON results(event_id)";

    $statements[] = "CREATE TABLE IF NOT EXISTS coupons (
        id $auto,
        event_id INTEGER NULL,
        code VARCHAR(60) NOT NULL,
        descuento DECIMAL(6,2) NOT NULL DEFAULT 0,
        tipo VARCHAR(20) NOT NULL DEFAULT 'porcentaje',
        usos INTEGER NOT NULL DEFAULT 0,
        max_usos INTEGER NOT NULL DEFAULT 0,
        created_at VARCHAR(30) NOT NULL DEFAULT ''
    ) $engine";

    // Comprobantes de pago que el admin sube al organizador (payouts).
    $statements[] = "CREATE TABLE IF NOT EXISTS payouts (
        id $auto,
        organizer_id INTEGER NULL,
        event_id INTEGER NULL,
        monto DECIMAL(12,2) NOT NULL DEFAULT 0,
        currency VARCHAR(3) NOT NULL DEFAULT 'CLP',
        total_evento DECIMAL(12,2) NOT NULL DEFAULT 0,
        comprobante_file VARCHAR(255) NOT NULL DEFAULT '',
        nota VARCHAR(255) NOT NULL DEFAULT '',
        estado VARCHAR(20) NOT NULL DEFAULT 'transferido',
        created_at VARCHAR(30) NOT NULL DEFAULT ''
    ) $engine";
    $statements[] = "CREATE INDEX IF NOT EXISTS idx_payout_org ON payouts(organizer_id)";

    foreach ($statements as $sql) {
        $pdo->exec($sql);
    }
}

/**
 * Inserta los países soportados si la tabla está vacía.
 */
function ms_db_seed(PDO $pdo): void
{
    $count = (int) $pdo->query('SELECT COUNT(*) FROM countries')->fetchColumn();
    if ($count > 0) {
        return;
    }

    $countries = [
        ['CL', 'Chile',     'CLP', 'Peso chileno (CLP)',    '🇨🇱', 'IVA', 0.19],
        ['AR', 'Argentina', 'ARS', 'Peso argentino (ARS)',  '🇦🇷', 'IVA', 0.21],
        ['BR', 'Brasil',    'BRL', 'Real brasileño (BRL)',  '🇧🇷', 'IVA', 0.17],
        ['CO', 'Colombia',  'COP', 'Peso colombiano (COP)', '🇨🇴', 'IVA', 0.19],
        ['EC', 'Ecuador',   'USD', 'Dólar (USD)',           '🇪🇨', 'IVA', 0.12],
        ['PE', 'Perú',      'PEN', 'Sol peruano (PEN)',     '🇵🇪', 'IGV', 0.18],
    ];

    $stmt = $pdo->prepare(
        'INSERT INTO countries (code, name, currency, currency_label, flag, tax_label, tax_rate, enabled)
         VALUES (?, ?, ?, ?, ?, ?, ?, 1)'
    );
    foreach ($countries as $c) {
        $stmt->execute($c);
    }
}
