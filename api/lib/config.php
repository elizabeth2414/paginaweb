<?php
/**
 * Configuración de Match Sport API.
 *
 * En Hostinger (producción) crea un archivo `config.local.php` en esta misma
 * carpeta (api/lib/) devolviendo un array con tus credenciales reales de MySQL.
 * Nunca subas ese archivo a git. Si no existe, se usan variables de entorno
 * y, como último recurso, SQLite (ideal para desarrollo local).
 */

declare(strict_types=1);

function ms_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    // 1) Valores por defecto (desarrollo con SQLite).
    $defaults = [
        // Base de datos: 'mysql' en Hostinger, 'sqlite' para desarrollo.
        'db_driver'   => getenv('MS_DB_DRIVER') ?: 'sqlite',
        'db_host'     => getenv('MS_DB_HOST') ?: 'localhost',
        'db_port'     => getenv('MS_DB_PORT') ?: '3306',
        'db_name'     => getenv('MS_DB_NAME') ?: 'match_sport',
        'db_user'     => getenv('MS_DB_USER') ?: 'root',
        'db_pass'     => getenv('MS_DB_PASS') ?: '',
        'db_sqlite'   => getenv('MS_DB_SQLITE') ?: __DIR__ . '/../../data/match_sport.sqlite',

        // Negocio.
        'commission_rate' => (float) (getenv('MS_COMMISSION_RATE') ?: 0.07), // 7%
        'iva_rate'        => (float) (getenv('MS_IVA_RATE') ?: 0.19),        // IVA Chile 19%

        // Clave de administrador (cámbiala en producción).
        // Debe coincidir con la contraseña del panel /admin/login del frontend.
        'admin_key' => getenv('MS_ADMIN_KEY') ?: 'match2027',

        // Seguridad.
        'app_secret' => getenv('MS_APP_SECRET') ?: 'cambia-esta-clave-en-produccion',

        // CORS: dominios permitidos separados por coma. '*' permite todos.
        'cors_origins' => getenv('MS_CORS_ORIGINS') ?: '*',

        // Carpeta de subidas (comprobantes, etc.).
        'uploads_dir' => __DIR__ . '/../../uploads',
    ];

    // 2) Sobrescribir con config.local.php si existe.
    $localFile = __DIR__ . '/config.local.php';
    if (is_file($localFile)) {
        $local = require $localFile;
        if (is_array($local)) {
            $defaults = array_merge($defaults, $local);
        }
    }

    $config = $defaults;
    return $config;
}
