-- ============================================================
-- Match Sport — Esquema de referencia (MySQL / MariaDB)
-- ------------------------------------------------------------
-- Este archivo es SOLO documentación. La aplicación crea estas
-- tablas automáticamente en la primera visita (ver api/lib/db.php).
-- Puedes ejecutarlo manualmente en phpMyAdmin si lo prefieres.
-- ============================================================

CREATE TABLE IF NOT EXISTS countries (
    code           VARCHAR(2)  PRIMARY KEY,
    name           VARCHAR(80) NOT NULL,
    currency       VARCHAR(3)  NOT NULL,
    currency_label VARCHAR(60) NOT NULL,
    flag           VARCHAR(12) NOT NULL DEFAULT '',
    tax_label      VARCHAR(30) NOT NULL DEFAULT '',
    tax_rate       DECIMAL(6,4) NOT NULL DEFAULT 0,
    enabled        TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(120) NOT NULL DEFAULT '',
    email         VARCHAR(190) NOT NULL,
    password_hash VARCHAR(255) NOT NULL DEFAULT '',
    role          VARCHAR(20)  NOT NULL DEFAULT 'organizador',
    provider      VARCHAR(30)  NOT NULL DEFAULT 'password',
    country_code  VARCHAR(2)   NOT NULL DEFAULT 'CL',
    token         VARCHAR(80)  NOT NULL DEFAULT '',
    created_at    VARCHAR(30)  NOT NULL DEFAULT '',
    UNIQUE KEY idx_users_email (email),
    KEY idx_users_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS events (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    slug         VARCHAR(120) NOT NULL,
    organizer_id INT NULL,
    nombre       VARCHAR(200) NOT NULL,
    deporte      VARCHAR(80)  NOT NULL DEFAULT '',
    descripcion  LONGTEXT NULL,
    fecha        VARCHAR(120) NOT NULL DEFAULT '',
    fecha_iso    VARCHAR(30)  NOT NULL DEFAULT '',
    ubicacion    VARCHAR(200) NOT NULL DEFAULT '',
    country_code VARCHAR(2)   NOT NULL DEFAULT 'CL',
    currency     VARCHAR(3)   NOT NULL DEFAULT 'CLP',
    lat          DECIMAL(10,6) NULL,
    lng          DECIMAL(10,6) NULL,
    estado       VARCHAR(20)  NOT NULL DEFAULT 'borrador',
    icon         VARCHAR(40)  NOT NULL DEFAULT 'ti-run',
    color        VARCHAR(20)  NOT NULL DEFAULT 'purple',
    precio       DECIMAL(12,2) NOT NULL DEFAULT 0,
    cupos        INT NOT NULL DEFAULT 0,
    data         LONGTEXT NULL,
    created_at   VARCHAR(30) NOT NULL DEFAULT '',
    updated_at   VARCHAR(30) NOT NULL DEFAULT '',
    UNIQUE KEY idx_events_slug (slug),
    KEY idx_events_org (organizer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS registrations (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    event_id       INT NOT NULL,
    nombre         VARCHAR(160) NOT NULL DEFAULT '',
    email          VARCHAR(190) NOT NULL DEFAULT '',
    documento      VARCHAR(60)  NOT NULL DEFAULT '',
    categoria      VARCHAR(120) NOT NULL DEFAULT '',
    currency       VARCHAR(3)   NOT NULL DEFAULT 'CLP',
    subtotal       DECIMAL(12,2) NOT NULL DEFAULT 0,
    commission     DECIMAL(12,2) NOT NULL DEFAULT 0,
    total          DECIMAL(12,2) NOT NULL DEFAULT 0,
    estado         VARCHAR(20)  NOT NULL DEFAULT 'pagado',
    payment_method VARCHAR(40)  NOT NULL DEFAULT '',
    ticket_code    VARCHAR(40)  NOT NULL DEFAULT '',
    data           LONGTEXT NULL,
    created_at     VARCHAR(30)  NOT NULL DEFAULT '',
    KEY idx_reg_event (event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS results (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    event_id   INT NOT NULL,
    posicion   INT NOT NULL DEFAULT 0,
    nombre     VARCHAR(160) NOT NULL DEFAULT '',
    categoria  VARCHAR(120) NOT NULL DEFAULT '',
    tiempo     VARCHAR(40)  NOT NULL DEFAULT '',
    created_at VARCHAR(30)  NOT NULL DEFAULT '',
    KEY idx_res_event (event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS coupons (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    event_id   INT NULL,
    code       VARCHAR(60) NOT NULL,
    descuento  DECIMAL(6,2) NOT NULL DEFAULT 0,
    tipo       VARCHAR(20) NOT NULL DEFAULT 'porcentaje',
    usos       INT NOT NULL DEFAULT 0,
    max_usos   INT NOT NULL DEFAULT 0,
    created_at VARCHAR(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Comprobantes de pago que el administrador transfiere al organizador.
CREATE TABLE IF NOT EXISTS payouts (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    organizer_id     INT NULL,
    event_id         INT NULL,
    monto            DECIMAL(12,2) NOT NULL DEFAULT 0,
    currency         VARCHAR(3) NOT NULL DEFAULT 'CLP',
    total_evento     DECIMAL(12,2) NOT NULL DEFAULT 0,
    comprobante_file VARCHAR(255) NOT NULL DEFAULT '',
    nota             VARCHAR(255) NOT NULL DEFAULT '',
    estado           VARCHAR(20) NOT NULL DEFAULT 'transferido',
    created_at       VARCHAR(30) NOT NULL DEFAULT '',
    KEY idx_payout_org (organizer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Países soportados (se insertan automáticamente si la tabla está vacía).
INSERT INTO countries (code, name, currency, currency_label, flag, tax_label, tax_rate, enabled) VALUES
    ('CL', 'Chile',     'CLP', 'Peso chileno (CLP)',    '🇨🇱', 'IVA', 0.19, 1),
    ('AR', 'Argentina', 'ARS', 'Peso argentino (ARS)',  '🇦🇷', 'IVA', 0.21, 1),
    ('BR', 'Brasil',    'BRL', 'Real brasileño (BRL)',  '🇧🇷', 'IVA', 0.17, 1),
    ('CO', 'Colombia',  'COP', 'Peso colombiano (COP)', '🇨🇴', 'IVA', 0.19, 1),
    ('EC', 'Ecuador',   'USD', 'Dólar (USD)',           '🇪🇨', 'IVA', 0.12, 1),
    ('PE', 'Perú',      'PEN', 'Sol peruano (PEN)',     '🇵🇪', 'IGV', 0.18, 1);
