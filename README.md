# Match Sport — Plataforma real (PHP + MySQL + JavaScript)

Plataforma para publicar eventos deportivos, inscribir deportistas, cobrar con
comisión del 7% y gestionar pagos a organizadores. Pensada para publicarse en
**Hostinger** (hosting compartido con PHP + MySQL).

Diseño inspirado en plataformas de eventos como Welcu, adaptado a Match Sport.

## Estructura del proyecto

```
index.php              La web (SPA) servida por PHP. Inyecta la URL de la API.
assets/
  api.js               Cliente JavaScript que conecta la web con la API real.
api/
  index.php            Router de la API REST (PHP puro, sin frameworks).
  .htaccess            Reescritura de rutas /api/* → index.php.
  lib/
    config.php         Configuración (lee config.local.php o variables de entorno).
    config.sample.php  Plantilla para crear tu config.local.php en producción.
    db.php             Conexión PDO + creación automática de tablas + países.
    helpers.php        Utilidades (JSON, CORS, auth por token, etc.).
uploads/
  comprobantes/        Comprobantes de transferencia subidos por el administrador.
sql/
  schema.sql           Esquema de referencia (se crea solo, esto es documentación).
```

## Qué incluye (resuelto del documento)

- **Frontend real conectado a la API**: al crear un evento o inscribirse, los
  datos se guardan de verdad en la base de datos (no solo en el navegador).
- **Comisión del 7%** calculada automáticamente en cada inscripción, con el
  **IVA de la comisión** en el panel de finanzas del administrador.
- **Configuración por países**: Chile, Argentina, Brasil, Colombia, Ecuador y
  Perú, cada uno con su moneda; el checkout permite pagar también en **USD**.
- **Roles**: organizador, corredor y administrador.
- **Sector de pagos a organizadores**: el administrador sube el **comprobante**
  de transferencia e indica **cuánto del total se transfirió**; el organizador lo
  ve en su panel.
- **Exportar datos** (CSV real y descargable, protegido con token).
- **No se muestran eventos, detalles ni resultados que no existen** (se eliminó
  la data de simulación; un evento inexistente muestra un aviso claro).
- **Logo más grande**, se quitó el texto "para Chile", y se corrigió el
  contraste de textos oscuros sobre fondos oscuros.
- Páginas de **Sobre nosotros**, **Contacto** y **Términos y condiciones**.

## Requisitos

- PHP 8.0+ con extensiones PDO (`pdo_mysql`) y `gd`.
- MySQL/MariaDB (incluido en Hostinger).

## Desarrollo local

Puedes usar SQLite (no requiere servidor de base de datos):

```bash
# Desde la raíz del proyecto
MS_DB_DRIVER=sqlite php -S 127.0.0.1:8000 router-dev.php
```

Crea un `router-dev.php` sencillo (solo para desarrollo) o usa el servidor con
la carpeta como raíz. La API responde en `http://127.0.0.1:8000/api/health`.

> En producción (Hostinger) no necesitas router de desarrollo: el archivo
> `api/.htaccess` se encarga del enrutamiento.

## Despliegue en Hostinger (paso a paso)

1. **Sube los archivos** a `public_html` (con el Administrador de archivos de
   hPanel o por FTP). Mantén la estructura de carpetas.

2. **Crea la base de datos MySQL** en hPanel → *Bases de datos → MySQL*.
   Anota el nombre de la base, el usuario y la contraseña.

3. **Configura las credenciales**: copia `api/lib/config.sample.php` a
   `api/lib/config.local.php` y completa tus datos:

   ```php
   return [
       'db_driver' => 'mysql',
       'db_host'   => 'localhost',
       'db_name'   => 'uXXXXXXXXX_matchsport',
       'db_user'   => 'uXXXXXXXXX_matchsport',
       'db_pass'   => 'TU_PASSWORD',
       'admin_key' => 'PON-UNA-CLAVE-LARGA-Y-SECRETA',
       'app_secret'=> 'CADENA-ALEATORIA-LARGA',
       'cors_origins' => 'https://match-sport.com',
   ];
   ```

   Las tablas y los países se crean **automáticamente** en la primera visita.

4. **Permisos de la carpeta `uploads/`**: debe permitir escritura (755/775) para
   guardar los comprobantes.

5. **Dominio y HTTPS**: apunta `match-sport.com` a Hostinger y activa el
   certificado SSL gratuito (hPanel → *SSL*).

6. Abre `https://match-sport.com`. Para entrar como administrador ve a
   `#/admin/login` y usa la contraseña definida en `admin_key` (por defecto
   `match2027` en desarrollo — **cámbiala**).

## Endpoints principales de la API

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/api/health` | Estado del servicio |
| GET | `/api/countries` | Países y monedas soportados |
| POST | `/api/auth/register` | Registro de organizador/corredor |
| POST | `/api/auth/login` | Inicio de sesión (devuelve token) |
| POST | `/api/auth/admin` | Login de administrador (con `admin_key`) |
| GET | `/api/events` | Eventos públicos (activos/finalizados) |
| GET | `/api/events/{id}` | Detalle (404 si no existe) |
| POST | `/api/events` | Crear evento (token de organizador) |
| POST | `/api/registrations` | Inscripción (calcula comisión 7%) |
| GET | `/api/payouts` | Comprobantes (admin: todos; organizador: los suyos) |
| POST | `/api/payouts` | Subir comprobante + monto (solo admin) |
| GET | `/api/admin/finance` | Resumen de comisiones e IVA (solo admin) |
| GET | `/api/export?type=registrations` | Descarga CSV (requiere token) |

## Lo que aún debe conectarse en producción (según el documento)

Estos puntos quedan preparados en el backend pero requieren **credenciales/cuentas
externas** que solo tú puedes generar:

- **Pasarela de pago real** (Webpay/Transbank, Mercado Pago, Flow o Khipu). Hoy el
  checkout registra la inscripción y calcula la comisión; falta conectar el cobro
  real con tus credenciales de comercio.
- **Envío de correos** (Resend, SendGrid, Amazon SES o SMTP de Hostinger) para
  confirmaciones y tickets.
- **Login con Google en producción** (regenerar el `client_secret` y autorizar el
  dominio en Google Cloud Console).
- **Integración tributaria (IVA/SII)**: el cálculo del IVA de la comisión ya se
  muestra; la emisión de documentos tributarios requiere integración con el SII.

## Seguridad

- Nunca subas `api/lib/config.local.php` a git (está en `.gitignore`).
- Cambia `admin_key`, `app_secret` y las credenciales por defecto.
- Mantén `DEBUG` desactivado y usa HTTPS.
