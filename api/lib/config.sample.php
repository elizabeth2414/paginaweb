<?php
/**
 * PLANTILLA de configuración para producción (Hostinger).
 *
 * 1. Copia este archivo como `config.local.php` en la misma carpeta.
 * 2. Reemplaza los valores con los datos reales de tu base de datos MySQL
 *    (los encuentras en hPanel → Bases de datos → MySQL).
 * 3. `config.local.php` está ignorado por git para no exponer credenciales.
 */

return [
    'db_driver' => 'mysql',
    'db_host'   => 'localhost',
    'db_port'   => '3306',
    'db_name'   => 'uXXXXXXXXX_matchsport',   // tu base de datos
    'db_user'   => 'uXXXXXXXXX_matchsport',   // tu usuario MySQL
    'db_pass'   => 'TU_PASSWORD_SEGURO',

    // 7% de comisión de Match Sport.
    'commission_rate' => 0.07,
    // IVA Chile (para el cálculo de impuestos de la comisión y las facturas).
    'iva_rate' => 0.19,

    // Clave para entrar al panel de administrador. ¡Cámbiala!
    'admin_key' => 'PON-UNA-CLAVE-LARGA-Y-SECRETA',

    // Secreto de la app (para firmar tokens). Genera una cadena aleatoria larga.
    'app_secret' => 'GENERA-UNA-CADENA-ALEATORIA-LARGA-AQUI',

    // Dominio permitido en producción.
    'cors_origins' => 'https://match-sport.com',
];
