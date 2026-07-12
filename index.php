<?php
/**
 * Match Sport — página principal (frontend real conectado a la API PHP).
 * Servir este archivo con PHP (Hostinger). La API vive en /api.
 */
$__ms_base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
$__ms_api = ($__ms_base === '' ? '' : $__ms_base) . '/api';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Match Sport — Conectamos los deportes en una misma app</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
  window.MS_CONFIG = {
    apiBase: <?= json_encode($__ms_api) ?>,
    baseUrl: <?= json_encode($__ms_base === '' ? '.' : $__ms_base) ?>
  };
</script>
<script src="<?= htmlspecialchars($__ms_base) ?>/assets/api.js" defer></script>
<script src="<?= htmlspecialchars($__ms_base) ?>/assets/country.js" defer></script>
<style>
/* ============================================================
   ESTILOS COMPARTIDOS (assets/style.css)
   ============================================================ */
/* ========== MATCH SPORT - Sistema de diseño ========== */
:root {
  /* Marca principal */
  --purple-light: #A5F3EF;
  --purple-50: #ECFEFD;
  --purple-100: #D0FAF7;
  --purple-200: #A5F3EF;
  --purple-300: #6EE7E0;
  --purple-400: #34D6CE;
  --purple-500: #17BDB5;
  --purple-600: #0DA69E;
  --purple-700: #0B8B84;
  --purple-800: #0A6E69;
  --purple-900: #08514D;
  --purple-950: #063734;

  /* Acento amarillo/dorado */
  --amber-50: #FEF3C7;
  --amber-100: #FDE68A;
  --amber-400: #FBBF24;
  --amber-500: #F59E0B;
  --amber-600: #D97706;
  --amber-700: #B45309;
  --amber-800: #92400E;
  --amber-900: #78350F;

  /* Verde éxito */
  --green-50: #DCFCE7;
  --green-500: #22C55E;
  --green-600: #16A34A;
  --green-700: #15803D;

  /* Rojo error */
  --red-50: #FEE2E2;
  --red-500: #EF4444;
  --red-600: #DC2626;

  /* Azul info */
  --blue-50: #DBEAFE;
  --blue-500: #3B82F6;
  --blue-600: #2563EB;
  --blue-700: #1D4ED8;

  /* Neutros */
  --text: #1F1F1F;
  --text-secondary: #5F5E5A;
  --text-tertiary: #888780;
  --bg: #ffffff;
  --bg-secondary: #F2FEFD;
  --bg-tertiary: #ECFEFD;
  --border: rgba(0, 0, 0, 0.08);
  --border-strong: #D3D1C7;
  --border-purple: #A5F3EF;

  /* Radio de borde */
  --radius-sm: 6px;
  --radius-md: 8px;
  --radius-lg: 12px;
  --radius-xl: 16px;
  --radius-2xl: 20px;
  --radius-full: 999px;

  /* Sombras con tinte morado */
  --shadow-sm: 0 2px 8px rgba(11, 139, 132, 0.08);
  --shadow-md: 0 4px 16px rgba(11, 139, 132, 0.12);
  --shadow-lg: 0 8px 28px rgba(11, 139, 132, 0.18);
  --shadow-xl: 0 16px 40px rgba(11, 139, 132, 0.25);
  --shadow-amber: 0 6px 20px rgba(245, 158, 11, 0.35);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html, body {
  font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
  color: var(--text);
  background: var(--bg);
  font-size: 16px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

a { text-decoration: none; color: inherit; }
button { font-family: inherit; cursor: pointer; }
input, select, textarea { font-family: inherit; font-size: inherit; }

/* ========== LOGO ========== */
.logo {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}
.logo-icon {
  width: 38px;
  height: 38px;
  border-radius: 9px;
  background: white;
  border: 0.5px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--shadow-sm);
}
.logo-icon svg { width: 26px; height: 26px; }
.logo-text { display: flex; flex-direction: column; line-height: 1; }
.logo-text .name { font-size: 18px; font-weight: 700; color: var(--text); letter-spacing: -0.3px; }
.logo-text .tag { font-size: 12px; font-weight: 600; color: var(--purple-500); letter-spacing: 1.2px; margin-top: 2px; }

/* ========== NAV ========== */
.nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 32px;
  border-bottom: 0.5px solid var(--border);
  background: white;
  position: sticky;
  top: 0;
  z-index: 100;
}
.nav-links { display: flex; gap: 26px; align-items: center; }
.nav-links a {
  font-size: 15px;
  color: var(--text-secondary);
  font-weight: 500;
  transition: color 0.15s;
}
.nav-links a:hover, .nav-links a.active { color: var(--purple-700); }
.nav-actions { display: flex; gap: 12px; align-items: center; }

/* ========== BOTONES ========== */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 22px;
  border-radius: var(--radius-md);
  font-size: 15px;
  font-weight: 600;
  border: 1px solid transparent;
  transition: all 0.15s;
  cursor: pointer;
  white-space: nowrap;
}
.btn-primary {
  background: var(--purple-700);
  color: white;
  box-shadow: 0 4px 14px rgba(11, 139, 132, 0.3);
}
.btn-primary:hover {
  background: var(--purple-800);
  box-shadow: 0 6px 20px rgba(11, 139, 132, 0.4);
}
.btn-amber {
  background: var(--amber-500);
  color: white;
  box-shadow: var(--shadow-amber);
}
.btn-amber:hover { background: var(--amber-600); }

.btn-outline {
  background: white;
  border: 1px solid var(--border-strong);
  color: var(--text);
}
.btn-outline:hover { background: var(--bg-secondary); border-color: var(--purple-400); }

.btn-ghost {
  background: transparent;
  color: var(--text-secondary);
  border: none;
}
.btn-ghost:hover { color: var(--purple-700); }

.btn-lg { padding: 15px 28px; font-size: 16px; border-radius: 12px; }
.btn-sm { padding: 8px 14px; font-size: 13px; }
.btn-block { width: 100%; }

/* ========== INPUTS ========== */
.input, .select, .textarea {
  width: 100%;
  padding: 11px 14px;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  font-size: 14px;
  background: var(--bg);
  color: var(--text);
  transition: all 0.15s;
}
.input:focus, .select:focus, .textarea:focus {
  outline: none;
  border-color: var(--purple-500);
  box-shadow: 0 0 0 3px var(--purple-100);
}
.label {
  display: block;
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 6px;
  font-weight: 500;
}

/* ========== CARDS ========== */
.card {
  background: white;
  border: 0.5px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 20px;
}

/* ========== BADGES ========== */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 12px;
  padding: 4px 10px;
  border-radius: var(--radius-full);
  font-weight: 500;
}
.badge-purple { background: var(--purple-100); color: var(--purple-800); }
.badge-amber { background: var(--amber-50); color: var(--amber-800); }
.badge-green { background: var(--green-50); color: var(--green-700); }
.badge-red { background: var(--red-50); color: var(--red-600); }
.badge-blue { background: var(--blue-50); color: var(--blue-700); }

/* ========== LAYOUT GENERAL ========== */
.container { max-width: 1280px; margin: 0 auto; padding: 0 32px; }
.section { padding: 72px 0; }
.section-label {
  font-size: 12px;
  font-weight: 600;
  color: var(--purple-700);
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin-bottom: 12px;
}

h1 { font-size: 54px; font-weight: 700; line-height: 1.08; letter-spacing: -1.8px; }
h2 { font-size: 36px; font-weight: 700; line-height: 1.15; letter-spacing: -0.8px; }
h3 { font-size: 20px; font-weight: 600; line-height: 1.3; }
h4 { font-size: 16px; font-weight: 600; }

.muted { color: var(--text-secondary); }
.small { font-size: 13px; }

/* ========== DASHBOARD LAYOUT ========== */
.dashboard {
  display: grid;
  grid-template-columns: 220px 1fr;
  min-height: 100vh;
}
.sidebar {
  background: linear-gradient(180deg, var(--purple-900) 0%, var(--purple-950) 100%);
  padding: 20px 0;
}
.sidebar.org {
  background: white;
  border-right: 0.5px solid var(--border);
}
.sidebar-logo {
  padding: 0 20px 18px;
  border-bottom: 0.5px solid rgba(255,255,255,0.12);
  margin-bottom: 12px;
}
.sidebar.org .sidebar-logo { border-bottom-color: var(--border); }
.sidebar-role {
  font-size: 10px;
  color: var(--amber-500);
  margin-top: 10px;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  gap: 4px;
  font-weight: 600;
  text-transform: uppercase;
}
.sidebar.org .sidebar-role { color: var(--purple-700); }
.sidebar-section {
  font-size: 10px;
  color: rgba(255,255,255,0.45);
  padding: 14px 20px 6px;
  letter-spacing: 0.8px;
  font-weight: 600;
  text-transform: uppercase;
}
.sidebar.org .sidebar-section { color: var(--text-tertiary); }
.sidebar-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  font-size: 14px;
  color: rgba(255,255,255,0.75);
  cursor: pointer;
  border-left: 3px solid transparent;
  transition: all 0.15s;
}
.sidebar.org .sidebar-item { color: var(--text-secondary); }
.sidebar-item:hover { background: rgba(255,255,255,0.05); color: white; }
.sidebar.org .sidebar-item:hover { background: var(--purple-50); color: var(--purple-700); }
.sidebar-item.active {
  background: rgba(245,158,11,0.18);
  color: white;
  border-left-color: var(--amber-500);
  font-weight: 500;
}
.sidebar.org .sidebar-item.active {
  background: var(--purple-50);
  color: var(--purple-700);
  border-left-color: var(--purple-700);
  font-weight: 600;
}
.sidebar-item i { font-size: 17px; }
.sidebar-badge {
  background: rgba(23, 189, 181,0.4);
  color: white;
  font-size: 10px;
  padding: 1px 7px;
  border-radius: 4px;
  margin-left: auto;
  font-weight: 600;
}
.sidebar.org .sidebar-badge { background: var(--purple-100); color: var(--purple-700); }
.sidebar-badge.amber { background: var(--amber-500); color: white; }
.sidebar-badge.red { background: var(--red-600); color: white; }

.content { padding: 28px 32px; background: var(--bg-secondary); }
.content-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}
.content-header h1 { font-size: 24px; font-weight: 700; }

/* ========== MÉTRICAS ========== */
.metrics-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  margin-bottom: 18px;
}
.metric-card {
  background: white;
  border: 0.5px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 16px;
}
.metric-card .metric-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}
.metric-card .metric-label {
  font-size: 12px;
  color: var(--text-secondary);
  font-weight: 500;
}
.metric-icon {
  width: 26px;
  height: 26px;
  border-radius: 7px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.metric-icon.purple { background: var(--purple-50); color: var(--purple-700); }
.metric-icon.amber { background: var(--amber-50); color: var(--amber-700); }
.metric-icon.green { background: var(--green-50); color: var(--green-600); }
.metric-icon.blue { background: var(--blue-50); color: var(--blue-700); }
.metric-icon i { font-size: 14px; }

.metric-value {
  font-size: 26px;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -0.5px;
}
.metric-trend {
  font-size: 12px;
  margin-top: 4px;
  display: flex;
  align-items: center;
  gap: 3px;
}
.metric-trend.up { color: var(--green-600); }
.metric-trend.down { color: var(--red-600); }

/* ========== TABLA ========== */
.table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
.table th {
  text-align: left;
  color: var(--text-tertiary);
  font-weight: 600;
  font-size: 11px;
  padding: 12px 12px;
  border-bottom: 0.5px solid var(--border);
  letter-spacing: 0.5px;
  text-transform: uppercase;
}
.table td {
  padding: 14px 12px;
  border-bottom: 0.5px solid var(--border);
  color: var(--text);
  font-size: 13px;
}
.table tr:hover td { background: var(--purple-50); }

/* ========== AVATAR ========== */
.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
  font-size: 13px;
}
.avatar-sm { width: 28px; height: 28px; font-size: 11px; }
.avatar-lg { width: 48px; height: 48px; font-size: 15px; }

/* ========== UTILIDADES ========== */
.flex { display: flex; }
.flex-between { display: flex; justify-content: space-between; align-items: center; }
.flex-col { display: flex; flex-direction: column; }
.gap-1 { gap: 4px; } .gap-2 { gap: 8px; } .gap-3 { gap: 12px; } .gap-4 { gap: 16px; } .gap-6 { gap: 24px; }
.mb-1 { margin-bottom: 4px; } .mb-2 { margin-bottom: 8px; } .mb-3 { margin-bottom: 12px; } .mb-4 { margin-bottom: 16px; } .mb-6 { margin-bottom: 24px; } .mb-8 { margin-bottom: 32px; }
.mt-2 { margin-top: 8px; } .mt-4 { margin-top: 16px; } .mt-6 { margin-top: 24px; }
.text-center { text-align: center; }
.text-right { text-align: right; }

.divider { height: 0.5px; background: var(--border); margin: 24px 0; }

/* ========== TABS ========== */
.tabs {
  display: flex;
  gap: 0;
  border-bottom: 0.5px solid var(--border);
}
.tab {
  padding: 14px 18px;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  color: var(--text-secondary);
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
}
.tab.active {
  border-bottom-color: var(--purple-700);
  color: var(--purple-700);
  font-weight: 600;
}
.tab:hover:not(.active) {
  color: var(--text);
}

/* ========== RESPONSIVE ========== */
@media (max-width: 900px) {
  .nav { padding: 14px 16px; }
  .nav-links { display: none; }
  .container { padding: 0 16px; }
  .content { padding: 16px; }
  .dashboard { grid-template-columns: 1fr; }
  .sidebar { display: none; }
  .metrics-grid { grid-template-columns: repeat(2, 1fr); }
  h1 { font-size: 34px; letter-spacing: -1px; }
  h2 { font-size: 26px; }
}


/* ============================================================
   SPA SHELL
   ============================================================ */
.spa-page { display: none; }
.spa-page.active { display: block; }

/* Public shell uses standard <nav>, already styled. We inject our own nav. */
.spa-public-nav {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(255,255,255,0.96);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-bottom: 1px solid var(--border);
  padding: 16px 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.spa-public-nav .nav-links a {
  margin-right: 22px;
  text-decoration: none;
  color: var(--text);
  font-size: 14.5px;
  font-weight: 500;
  cursor: pointer;
}
.spa-public-nav .nav-links a.active {
  color: var(--purple-700);
}
.spa-public-nav .nav-actions { display: flex; gap: 10px; align-items: center; }
.spa-public-nav .logo { text-decoration: none; display: flex; align-items: center; gap: 10px; cursor: pointer; }

/* Org and Admin shells: emulan el grid original (sidebar 220px + content 1fr) */
.spa-shell-org, .spa-shell-admin {
  display: none;
}
.spa-shell-org.active, .spa-shell-admin.active {
  display: grid;
  grid-template-columns: 220px 1fr;
  min-height: 100vh;
  background: var(--bg-secondary);
}
/* El sidebar ya tiene sus estilos del .sidebar original, no tocar */
.spa-shell-org > .sidebar.org,
.spa-shell-admin > .sidebar.admin {
  position: sticky;
  top: 42px; /* respetar la barra del TOC arriba */
  align-self: start;
  max-height: calc(100vh - 42px);
  overflow-y: auto;
}
/* Área de contenido: fondo gris claro, sin padding propio
   (cada <main class="content"> de las páginas ya trae su padding) */
.spa-shell-org .spa-content,
.spa-shell-admin .spa-content {
  background: var(--bg-secondary);
  min-width: 0; /* permite que el grid se contraiga sin overflow horizontal */
  min-height: 100vh;
}

/* IMPORTANTÍSIMO: cada página de organizador/admin viene envuelta en
   <div class="dashboard"> que es a su vez display: grid 220px 1fr.
   Como ya estamos DENTRO del shell que hace ese grid, hay que neutralizar
   el grid interno y dejar que el <main class="content"> ocupe todo el ancho. */
.spa-shell-org .spa-page > .dashboard,
.spa-shell-admin .spa-page > .dashboard {
  display: block !important;
  grid-template-columns: none !important;
  min-height: 0 !important;
}
/* El sidebar interno duplicado (cada página original trae su propio sidebar)
   se esconde — el shell tiene EL sidebar. */
.spa-shell-org .spa-page > .dashboard > aside.sidebar,
.spa-shell-admin .spa-page > .dashboard > aside.sidebar {
  display: none !important;
}
/* El <main class="content"> interno: aplicar ancho completo */
.spa-shell-org .spa-page > .dashboard > main.content,
.spa-shell-admin .spa-page > .dashboard > main.content {
  width: 100% !important;
  max-width: 100% !important;
}

/* Móvil: stack vertical */
@media (max-width: 768px) {
  .spa-shell-org.active, .spa-shell-admin.active {
    grid-template-columns: 1fr;
  }
  .spa-shell-org > .sidebar.org,
  .spa-shell-admin > .sidebar.admin {
    position: relative;
    top: 0;
    max-height: none;
  }
}

/* Footer only on public */
.spa-footer { background: var(--text); color: white; padding: 56px 32px 24px; }
.spa-footer-inner { max-width: 1200px; margin: 0 auto; }
.spa-footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 32px; }
.spa-footer h4 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 14px; color: rgba(255,255,255,0.6); }
.spa-footer a { display: block; color: rgba(255,255,255,0.85); text-decoration: none; font-size: 14px; margin-bottom: 8px; cursor: pointer; }
.spa-footer a:hover { color: var(--amber-500); }
.spa-footer .copy { padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.15); font-size: 13px; color: rgba(255,255,255,0.6); display: flex; justify-content: space-between; }

/* Las páginas pueden traer su propio <nav> interno (ej. crear-evento wizard).
   No los escondemos, sólo aseguramos que no se peguen al top global. */
.spa-page > nav.nav { position: relative !important; top: auto !important; }

/* Toast pos */
@keyframes slideInToast { from {transform: translateX(20px); opacity: 0;} to {transform: translateX(0); opacity: 1;} }

/* ============================================================
   ESTILOS POR PÁGINA
   ============================================================ */

/* ===== index.html ===== */
/* ===== HERO ===== */
    .hero {
      padding: 60px 32px 50px;
      background: linear-gradient(135deg, #FFFFFF 0%, #ECFEFD 100%);
      position: relative;
      overflow: hidden;
      min-height: 580px;
    }
    .hero::before, .hero::after, .hero-blob {
      content: '';
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
    }
    .hero::before {
      top: -120px; left: -100px;
      width: 360px; height: 360px;
      background: #F59E0B; opacity: 0.20;
    }
    .hero::after {
      top: 100px; right: -80px;
      width: 280px; height: 280px;
      background: #17BDB5; opacity: 0.15;
    }
    .hero-blob {
      bottom: -150px; right: 300px;
      width: 400px; height: 400px;
      background: #0B8B84; opacity: 0.10;
    }
    .hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.05fr 1fr;
      gap: 36px;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: white;
      border: 0.5px solid var(--purple-200);
      color: var(--purple-700);
      font-size: 14px;
      padding: 8px 18px;
      border-radius: 999px;
      margin-bottom: 24px;
      font-weight: 600;
      box-shadow: 0 2px 10px rgba(23, 189, 181, 0.12);
    }
    .hero-badge .dot {
      width: 8px; height: 8px;
      background: var(--amber-500);
      border-radius: 50%;
    }
    .hero h1 {
      font-size: 54px;
      line-height: 1.08;
      letter-spacing: -1.8px;
      margin: 0 0 22px;
      color: var(--text);
      font-weight: 700;
    }
    .hero h1 .purple { color: var(--purple-700); }
    .hero-desc {
      font-size: 18px;
      line-height: 1.6;
      color: var(--text-secondary);
      margin: 0 0 32px;
      max-width: 500px;
    }
    .hero-ctas { display: flex; gap: 12px; margin-bottom: 36px; flex-wrap: wrap; }
    .hero-stats { display: flex; gap: 28px; align-items: center; }
    .hero-stat-value {
      font-size: 28px;
      font-weight: 700;
      letter-spacing: -0.5px;
      line-height: 1;
    }
    .hero-stat-label {
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 4px;
    }
    .hero-divider { width: 1px; height: 38px; background: var(--border-strong); }

    /* ===== HERO MOSAICO ===== */
    .hero-mosaic {
      position: relative;
      min-height: 500px;
    }
    .photo-card {
      position: absolute;
      border-radius: 20px;
      overflow: hidden;
    }
    .photo-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.85) contrast(1.1);
    }
    .photo-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, transparent 50%, rgba(46,16,101,0.85) 100%);
    }
    .photo-tint-purple {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(11, 139, 132,0.15) 0%, rgba(76,29,149,0.65) 100%);
      mix-blend-mode: multiply;
    }
    .photo-tint-amber {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(245,158,11,0.15) 0%, rgba(180,83,9,0.65) 100%);
      mix-blend-mode: multiply;
    }
    .photo-badge {
      position: absolute;
      top: 14px;
      font-size: 11px;
      padding: 5px 12px;
      border-radius: 999px;
      font-weight: 700;
      letter-spacing: 0.5px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .photo-info {
      position: absolute;
      bottom: 14px;
      left: 14px;
      right: 14px;
      color: white;
      z-index: 2;
    }
    .photo-card-1 {
      top: 0; left: 30px;
      width: 200px; height: 280px;
      box-shadow: 0 20px 50px rgba(11, 139, 132, 0.4);
      transform: rotate(-3deg);
      z-index: 2;
    }
    .photo-card-2 {
      top: 40px; right: 0;
      width: 200px; height: 260px;
      box-shadow: 0 20px 50px rgba(245, 158, 11, 0.5);
      transform: rotate(4deg);
      z-index: 3;
    }
    .photo-card-3 {
      bottom: 20px; left: 80px;
      width: 220px; height: 240px;
      box-shadow: 0 24px 60px rgba(76, 29, 149, 0.5);
      transform: rotate(-2deg);
      z-index: 4;
    }
    .floating-icon {
      position: absolute;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 26px rgba(245, 158, 11, 0.5);
      z-index: 5;
    }
    .toast-card {
      background: white;
      border-radius: 14px;
      padding: 12px 16px;
      border: 0.5px solid var(--purple-200);
      box-shadow: 0 12px 32px rgba(11, 139, 132, 0.25);
      position: absolute;
      bottom: -10px;
      right: -10px;
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 6;
    }

    /* ===== TRUSTED ===== */
    .trusted {
      background: white;
      padding: 24px 32px;
      border-top: 0.5px solid var(--border);
    }
    .trusted-label {
      font-size: 12px;
      color: var(--text-tertiary);
      letter-spacing: 1.2px;
      text-transform: uppercase;
      text-align: center;
      margin-bottom: 14px;
      font-weight: 600;
    }
    .trusted-list {
      display: flex;
      justify-content: space-around;
      align-items: center;
      opacity: 0.6;
      max-width: 1100px;
      margin: 0 auto;
      flex-wrap: wrap;
      gap: 20px;
    }
    .trusted-list span {
      font-size: 16px;
      color: var(--text-secondary);
      font-weight: 700;
    }

    /* ===== CATEGORIES ===== */
    .cat-section { padding: 72px 32px; background: white; }
    .cat-head { text-align: center; margin-bottom: 32px; }
    .cat-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
    }
    .cat-card {
      background: white;
      border: 0.5px solid var(--border-strong);
      border-radius: 14px;
      padding: 20px;
      cursor: pointer;
      transition: all 0.2s;
      position: relative;
      overflow: hidden;
    }
    .cat-card:hover {
      transform: translateY(-3px);
      border-color: var(--purple-400);
      box-shadow: var(--shadow-md);
    }
    .cat-card .blob {
      position: absolute;
      top: -12px;
      right: -12px;
      width: 64px;
      height: 64px;
      border-radius: 50%;
      opacity: 0.08;
    }
    .cat-icon-box {
      width: 44px;
      height: 44px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 14px;
    }
    .cat-card h4 {
      font-size: 16px;
      margin-bottom: 4px;
      color: var(--text);
    }
    .cat-card p {
      font-size: 12px;
      color: var(--text-secondary);
      line-height: 1.4;
      margin-bottom: 10px;
    }
    .cat-card .cat-link {
      font-size: 12px;
      font-weight: 600;
    }
    .cat-card-cta {
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      color: white;
    }
    .cat-card-cta .cat-icon-box {
      background: rgba(255,255,255,0.18);
      backdrop-filter: blur(10px);
    }
    .cat-card-cta .cat-icon-box i { color: white; }
    .cat-card-cta h4 { color: white; }
    .cat-card-cta p { color: rgba(255,255,255,0.85); }
    .cat-card-cta .cat-link { color: white; }

    /* ===== STEPS ===== */
    .steps-section {
      padding: 72px 32px;
      background: var(--bg-secondary);
    }
    .steps-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
    }
    .step-card {
      background: white;
      border-radius: 14px;
      padding: 22px;
      border: 0.5px solid var(--border);
      position: relative;
    }
    .step-card.featured {
      border: 2px solid var(--amber-500);
      position: relative;
    }
    .step-card.featured::before {
      content: 'EXCLUSIVO';
      position: absolute;
      top: -10px;
      right: 14px;
      background: var(--amber-500);
      color: white;
      font-size: 9px;
      padding: 2px 8px;
      border-radius: 4px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .step-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 14px;
    }
    .step-num {
      width: 40px;
      height: 40px;
      background: var(--purple-700);
      color: white;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      font-weight: 700;
    }
    .step-card.featured .step-num {
      background: var(--amber-500);
    }
    .step-icon {
      color: var(--purple-700);
      font-size: 24px;
      opacity: 0.4;
    }
    .step-card.featured .step-icon { color: var(--amber-500); }
    .step-card h4 {
      font-size: 15px;
      margin-bottom: 6px;
      color: var(--text);
    }
    .step-card p {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
    }

    /* ===== EVENTS ===== */
    .events-section {
      padding: 72px 32px;
      background: white;
    }
    .events-head {
      max-width: 1200px;
      margin: 0 auto 24px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }
    .events-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 360px));
      gap: 20px;
      justify-content: center;
    }
    .event-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.2s;
    }
    .event-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lg);
    }
    .event-img {
      height: 160px;
      position: relative;
      overflow: hidden;
    }
    .event-img img {
      width: 100%; height: 100%;
      object-fit: cover;
    }
    .event-img-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 100%);
    }
    .event-tag {
      position: absolute;
      top: 12px;
      left: 12px;
      background: white;
      font-size: 10px;
      padding: 4px 10px;
      border-radius: 5px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .event-progress {
      position: absolute;
      top: 12px;
      right: 12px;
      background: rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
      color: white;
      font-size: 11px;
      padding: 4px 10px;
      border-radius: 5px;
      font-weight: 600;
    }
    .event-body { padding: 16px; }
    .event-title {
      font-size: 15px;
      font-weight: 700;
      color: var(--text);
      line-height: 1.3;
      margin-bottom: 8px;
    }
    .event-meta {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 12px;
      color: var(--text-secondary);
      margin-bottom: 4px;
    }
    .event-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 12px;
      border-top: 0.5px solid var(--border);
      margin-top: 12px;
    }
    .event-price-label {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .event-price {
      font-size: 18px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: -0.3px;
    }

    /* ===== PRICING ===== */
    .pricing-section {
      padding: 72px 32px;
      background: var(--bg-secondary);
    }
    .pricing-head { text-align: center; margin-bottom: 32px; }
    .pricing-grid {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }
    .price-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 16px;
      padding: 32px 26px;
    }
    .price-card.featured {
      background: linear-gradient(160deg, var(--purple-700) 0%, var(--purple-900) 100%);
      color: white;
      transform: scale(1.03);
      box-shadow: 0 20px 50px rgba(11, 139, 132, 0.3);
      position: relative;
    }
    .price-card.featured::before {
      content: 'MÁS POPULAR';
      position: absolute;
      top: -10px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--amber-500);
      color: white;
      font-size: 10px;
      padding: 4px 14px;
      border-radius: 999px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .price-label {
      font-size: 13px;
      color: var(--text-secondary);
      font-weight: 600;
      margin-bottom: 10px;
    }
    .price-card.featured .price-label { color: rgba(255,255,255,0.85); }
    .price-amount {
      font-size: 42px;
      font-weight: 700;
      letter-spacing: -1.5px;
      line-height: 1;
      margin-bottom: 4px;
    }
    .price-card.featured .price-amount { color: white; }
    .price-card:not(.featured) .price-amount { color: var(--purple-700); }
    .price-sub {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 26px;
    }
    .price-card.featured .price-sub { color: rgba(255,255,255,0.85); }
    .price-features {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-bottom: 28px;
    }
    .pf {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
    }
    .pf i {
      font-size: 18px;
      color: var(--green-600);
      flex-shrink: 0;
    }
    .price-card.featured .pf i { color: var(--amber-400); }
    .pf.no { color: var(--text-tertiary); }
    .pf.no i { color: var(--text-tertiary); }

    /* ===== FOOTER ===== */
    .footer {
      padding: 60px 32px 30px;
      background: var(--purple-950);
      color: rgba(255,255,255,0.7);
    }
    .footer-grid {
      max-width: 1200px;
      margin: 0 auto 36px;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 40px;
    }
    .footer .logo-text .name { color: white; }
    .footer-col h4 {
      font-size: 13px;
      color: white;
      margin-bottom: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .footer-col a {
      display: block;
      font-size: 13px;
      color: rgba(255,255,255,0.65);
      margin-bottom: 10px;
      transition: color 0.15s;
    }
    .footer-col a:hover { color: var(--amber-400); }
    .footer-bottom {
      border-top: 0.5px solid rgba(255,255,255,0.1);
      padding-top: 22px;
      display: flex;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      font-size: 13px;
      color: rgba(255,255,255,0.5);
    }

    @media (max-width: 900px) {
      .hero { padding: 40px 16px; }
      .hero-inner { grid-template-columns: 1fr; }
      .hero h1 { font-size: 36px; letter-spacing: -1px; }
      .hero-mosaic { display: none; }
      .cat-grid, .steps-grid { grid-template-columns: repeat(2, 1fr); }
      .events-grid, .pricing-grid { grid-template-columns: 1fr; }
      .price-card.featured { transform: none; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
    }

/* ===== eventos.html ===== */
.explore-hero {
      background: linear-gradient(135deg, var(--purple-50) 0%, white 100%);
      padding: 48px 32px;
      position: relative;
      overflow: hidden;
    }
    .explore-hero::before {
      content: '';
      position: absolute;
      top: -100px; right: -80px;
      width: 280px; height: 280px;
      background: var(--amber-500); opacity: 0.15;
      border-radius: 50%;
    }
    .explore-hero-inner {
      max-width: 1100px;
      margin: 0 auto;
      text-align: center;
      position: relative;
    }
    .explore-hero h1 { font-size: 38px; margin-bottom: 12px; }
    .search-bar {
      max-width: 640px;
      margin: 24px auto 0;
      display: flex;
      gap: 8px;
      align-items: center;
      border: 0.5px solid var(--border-strong);
      border-radius: 14px;
      padding: 10px 14px;
      background: white;
      box-shadow: 0 4px 20px rgba(11, 139, 132, 0.08);
    }
    .search-bar input { flex: 1; border: none; outline: none; font-size: 15px; background: transparent; }

    .filter-chips {
      max-width: 1200px;
      margin: 24px auto 0;
      padding: 0 32px;
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }
    .chip {
      padding: 8px 16px;
      border-radius: 999px;
      border: 0.5px solid var(--border-strong);
      background: white;
      font-size: 13px;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.15s;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .chip.active {
      background: var(--purple-700);
      color: white;
      border-color: var(--purple-700);
      font-weight: 600;
    }
    .chip:hover:not(.active) { border-color: var(--purple-400); }

    .explore-body {
      max-width: 1200px;
      margin: 32px auto;
      padding: 0 32px;
      display: grid;
      grid-template-columns: 240px 1fr;
      gap: 32px;
    }
    .filters {
      position: sticky;
      top: 90px;
      align-self: start;
    }
    .filter-block { margin-bottom: 24px; }
    .filter-block h4 { font-size: 13px; margin-bottom: 12px; color: var(--text); }
    .filter-option {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px 0;
      cursor: pointer;
      font-size: 13px;
      color: var(--text-secondary);
    }
    .filter-option input {
      accent-color: var(--purple-700);
      width: 14px; height: 14px;
      cursor: pointer;
    }
    .filter-option .count { margin-left: auto; color: var(--text-tertiary); font-size: 12px; }

    .results-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 18px;
    }
    .events-list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
    .ev-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.2s;
    }
    .ev-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lg);
      border-color: var(--purple-200);
    }
    .ev-img {
      height: 140px;
      position: relative;
      overflow: hidden;
    }
    .ev-img img { width: 100%; height: 100%; object-fit: cover; }
    .ev-img-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.5));
    }
    .ev-tag {
      position: absolute;
      top: 12px; left: 12px;
      background: white;
      font-size: 10px;
      padding: 4px 10px;
      border-radius: 5px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .ev-badge {
      position: absolute;
      top: 12px; right: 12px;
      background: var(--amber-500);
      color: white;
      font-size: 10px;
      padding: 4px 10px;
      border-radius: 5px;
      font-weight: 600;
    }
    .ev-body { padding: 14px; }
    .ev-cat-line {
      font-size: 11px;
      color: var(--text-tertiary);
      letter-spacing: 0.5px;
      text-transform: uppercase;
      font-weight: 600;
      margin-bottom: 6px;
    }
    .ev-title {
      font-size: 14px;
      font-weight: 700;
      color: var(--text);
      line-height: 1.3;
      margin-bottom: 8px;
    }
    .ev-meta {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 12px;
      color: var(--text-secondary);
      margin-bottom: 3px;
    }
    .ev-price-row {
      margin-top: 10px;
      padding-top: 10px;
      border-top: 0.5px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .ev-price {
      font-size: 16px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: -0.3px;
    }

    @media (max-width: 900px) {
      .explore-body { grid-template-columns: 1fr; padding: 0 16px; }
      .events-list { grid-template-columns: 1fr; }
      .filters { position: static; }
    }

/* ===== evento.html ===== */
.event-hero {
      /* Solo la foto de portada, limpia y sin texto encima */
      height: 320px;
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      background-size: cover;
      background-position: center;
      position: relative;
      overflow: hidden;
    }
    /* Bloque de texto DEBAJO de la foto, con fondo blanco y letras oscuras */
    .event-hero-text {
      background: #fff;
      border-bottom: 1px solid var(--border);
      padding: 24px 32px 20px;
    }
    .event-hero-text-inner {
      max-width: 1100px;
      margin: 0 auto;
    }
    .breadcrumbs {
      display: flex;
      gap: 8px;
      align-items: center;
      font-size: 13px;
      color: #9CA3AF;
      margin-bottom: 14px;
      flex-wrap: wrap;
    }
    .breadcrumbs a { color: var(--purple-700); }
    .breadcrumbs .current { color: #5F5E5A; }
    .event-tags-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 14px;
      flex-wrap: wrap;
    }
    .event-tag-pill {
      font-size: 12px;
      padding: 5px 12px;
      border-radius: 999px;
      font-weight: 600;
      letter-spacing: 0.3px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .event-title {
      font-size: 34px;
      font-weight: 800;
      letter-spacing: -1px;
      margin-bottom: 12px;
      color: #1F1F1F;
    }
    .event-meta-row {
      display: flex;
      gap: 22px;
      color: #5F5E5A;
      font-size: 14px;
      flex-wrap: wrap;
    }
    .event-meta-row span {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .event-meta-row i { color: var(--purple-700); }

    /* TABS */
    .tabs-bar {
      background: white;
      border-bottom: 0.5px solid var(--border);
      padding: 4px 32px;
      position: relative;
      max-width: 1100px;
      margin-left: auto;
      margin-right: auto;
    }
    .tabs-inner { display: flex; gap: 10px; flex-wrap: wrap; padding: 12px 0; }
    .tab-item {
      padding: 10px 18px;
      cursor: pointer;
      border: 1.5px solid #E0DAF0;
      border-radius: 999px;
      background: #fff;
      color: var(--text-secondary);
      font-size: 14px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 7px;
      transition: all 0.18s;
    }
    .tab-item:hover:not(.active) {
      border-color: var(--purple-300);
      color: var(--purple-700);
      background: #F2FEFD;
    }
    .tab-item.active {
      border-color: var(--purple-700);
      background: var(--purple-700);
      color: #fff;
      font-weight: 700;
    }
    .tab-item.active .count {
      background: rgba(255,255,255,0.25);
      color: #fff;
    }
    .tab-item .count {
      background: var(--amber-500);
      color: white;
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 999px;
      font-weight: 700;
    }

    .event-body {
      max-width: 1100px;
      margin: 0 auto;
      padding: 24px 32px 40px;
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 32px;
    }

    /* TAB CONTENT */
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* El panel de Entradas es una tarjeta blanca (legible sobre el fondo oscuro) */
    #panel-tickets.tab-panel {
      background: #fff;
      border-radius: 16px;
      padding: 26px 28px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    #panel-tickets .welcu-tickets-head h3 { color: #1F1F1F; }
    #panel-tickets .welcu-currency .small.muted { color: #5F5E5A; }

    .info-card {
      background: var(--bg-secondary);
      padding: 14px 16px;
      border-radius: 10px;
      border-left: 3px solid var(--purple-700);
    }
    .info-card.amber { border-left-color: var(--amber-500); background: var(--amber-50); }
    .info-card .info-label {
      font-size: 10px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
      font-weight: 600;
    }
    .info-card .info-value {
      font-size: 14px;
      color: var(--text);
      font-weight: 600;
    }

    .feature-pill {
      background: white;
      border: 0.5px solid var(--border-strong);
      color: var(--text);
      font-size: 12px;
      padding: 6px 12px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    /* TICKET SIDEBAR */
    .ticket-sidebar {
      position: sticky;
      top: 90px;
      align-self: start;
    }
    .ticket-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 16px;
      padding: 20px;
      box-shadow: var(--shadow-md);
    }
    .price-from {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 6px;
    }
    .price-display {
      font-size: 32px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: -1px;
      margin-bottom: 14px;
    }
    .progress-row { margin-bottom: 18px; }
    .progress-bar-track {
      height: 6px;
      background: var(--purple-100);
      border-radius: 3px;
      margin-bottom: 6px;
      overflow: hidden;
    }
    .progress-bar-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--purple-700) 0%, var(--amber-500) 100%);
      border-radius: 3px;
    }
    .progress-info {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: var(--text-secondary);
    }
    .progress-info .left { color: var(--green-600); font-weight: 600; }

    .ticket-features {
      border-top: 0.5px solid var(--border);
      margin-top: 16px;
      padding-top: 14px;
    }
    .tf-row {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 12px;
      color: var(--text-secondary);
      margin-bottom: 6px;
    }
    .tf-row i { color: var(--green-600); font-size: 14px; }

    .tickets-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .ticket-option {
      border: 0.5px solid var(--border-strong);
      border-radius: 12px;
      padding: 14px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .ticket-option:hover { border-color: var(--purple-400); }
    .ticket-option.selected {
      border: 2px solid var(--purple-700);
      background: var(--purple-50);
    }
    .ticket-option .top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 6px;
    }
    .ticket-option .name { font-weight: 600; font-size: 14px; }
    .ticket-option .desc { font-size: 12px; color: var(--text-secondary); margin-bottom: 4px; }
    .ticket-option .price { font-size: 18px; font-weight: 700; color: var(--purple-700); }
    .ticket-option .stock { font-size: 11px; color: var(--text-tertiary); }

    @media (max-width: 900px) {
      .event-body { grid-template-columns: 1fr; padding: 16px; }
      .ticket-sidebar { position: static; }
      .event-title { font-size: 24px; }
      .tabs-bar { padding: 0 16px; overflow-x: auto; }
    }

/* ===== checkout.html ===== */
body { background: var(--bg-secondary); }

    .checkout-layout {
      max-width: 1080px;
      margin: 32px auto;
      padding: 0 32px;
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 24px;
    }

    .steps-bar {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0;
      margin-bottom: 28px;
    }
    .cstep {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--text-tertiary);
    }
    .cstep.done { color: var(--green-600); font-weight: 500; }
    .cstep.active { color: var(--purple-700); font-weight: 600; }
    .cstep-num {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: 1px solid var(--border-strong);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 600;
    }
    .cstep.done .cstep-num {
      background: var(--green-600);
      color: white;
      border-color: var(--green-600);
    }
    .cstep.active .cstep-num {
      background: var(--purple-700);
      color: white;
      border-color: var(--purple-700);
    }
    .cstep-line {
      width: 50px;
      height: 1px;
      background: var(--border-strong);
      margin: 0 12px;
    }
    .cstep-line.done { background: var(--green-600); }

    .section-block {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 22px;
      margin-bottom: 12px;
    }
    .section-block h3 {
      font-size: 16px;
      margin-bottom: 4px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 700;
    }
    .section-icon {
      width: 32px;
      height: 32px;
      border-radius: 9px;
      background: var(--purple-50);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .section-icon i { color: var(--purple-700); font-size: 18px; }
    .section-icon.amber { background: var(--amber-50); }
    .section-icon.amber i { color: var(--amber-700); }
    .section-block p.sub {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 18px;
      margin-left: 40px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 12px;
    }
    .form-group { margin-bottom: 12px; }

    .check-card {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 10px 14px;
      border-radius: 10px;
      margin-bottom: 8px;
      cursor: pointer;
      background: var(--bg-secondary);
      border-left: 2px solid var(--border-strong);
      transition: all 0.2s;
    }
    .check-card.checked {
      border-left-color: var(--green-600);
      background: var(--green-50);
    }
    .check-card input {
      margin-top: 2px;
      accent-color: var(--purple-700);
      width: 16px;
      height: 16px;
      flex-shrink: 0;
      cursor: pointer;
    }
    .check-card label {
      font-size: 13px;
      line-height: 1.5;
      cursor: pointer;
      flex: 1;
    }

    .legal-box {
      background: linear-gradient(135deg, var(--amber-50) 0%, #FEF9E7 100%);
      border: 0.5px solid var(--amber-200, #FCD34D);
      border-radius: 10px;
      padding: 14px;
      margin-top: 16px;
    }
    .legal-box .legal-head {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      margin-bottom: 10px;
    }
    .legal-box i { color: var(--amber-600); font-size: 18px; flex-shrink: 0; }
    .legal-box p {
      font-size: 12px;
      color: var(--amber-900);
      line-height: 1.5;
      margin: 0;
    }
    .legal-check {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      margin-top: 8px;
      padding-top: 10px;
      border-top: 0.5px solid var(--amber-200, #FCD34D);
    }
    .legal-check input { accent-color: var(--amber-600); margin-top: 3px; }
    .legal-check label {
      font-size: 13px;
      color: var(--amber-900);
      font-weight: 600;
      cursor: pointer;
    }

    .pay-method {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 16px;
      border: 0.5px solid var(--border-strong);
      border-radius: 10px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .pay-method:hover { border-color: var(--purple-400); }
    .pay-method.selected {
      border: 2px solid var(--purple-700);
      background: var(--purple-50);
    }
    .pay-radio {
      width: 18px; height: 18px;
      border-radius: 50%;
      border: 2px solid var(--border-strong);
      position: relative;
      flex-shrink: 0;
    }
    .pay-method.selected .pay-radio { border-color: var(--purple-700); }
    .pay-method.selected .pay-radio::after {
      content: '';
      position: absolute;
      top: 3px; left: 3px;
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--purple-700);
    }
    .pay-info { flex: 1; }
    .pay-name { font-size: 14px; font-weight: 600; margin-bottom: 2px; }
    .pay-desc { font-size: 12px; color: var(--text-secondary); }
    .pay-logos { display: flex; gap: 4px; align-items: center; }
    .pay-logo {
      padding: 3px 7px;
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 4px;
      font-size: 10px;
      font-weight: 700;
      color: var(--text-secondary);
    }

    .summary-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 20px;
      position: sticky;
      top: 90px;
      align-self: start;
    }
    .summary-row {
      display: flex;
      justify-content: space-between;
      padding: 6px 0;
      font-size: 13px;
    }
    .summary-row.total {
      border-top: 1px solid var(--text);
      margin-top: 12px;
      padding-top: 14px;
      font-weight: 700;
      font-size: 17px;
    }
    .ev-mini {
      display: flex;
      gap: 12px;
      padding-bottom: 14px;
      border-bottom: 0.5px solid var(--border);
      margin-bottom: 14px;
    }
    .ev-mini-img {
      width: 56px; height: 56px;
      border-radius: 10px;
      background: var(--purple-100);
      display: flex; align-items: center; justify-content: center;
      color: var(--purple-700);
      flex-shrink: 0;
    }

    .trust-box {
      background: var(--purple-50);
      padding: 14px;
      border-radius: 10px;
      margin-top: 16px;
    }
    .trust-box .head { font-size: 13px; font-weight: 600; color: var(--purple-800); margin-bottom: 6px; }
    .trust-box ul { list-style: none; padding: 0; margin: 0; }
    .trust-box li {
      display: flex; align-items: center; gap: 6px;
      font-size: 12px; color: var(--purple-800);
      margin-top: 5px;
    }

    @media (max-width: 900px) {
      .checkout-layout { grid-template-columns: 1fr; padding: 0 16px; }
      .form-row { grid-template-columns: 1fr; }
      .summary-card { position: static; }
    }

/* ===== ticket.html ===== */
body { background: var(--bg-secondary); }

    .success-hero {
      text-align: center;
      padding: 60px 32px 40px;
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      color: white;
      position: relative;
      overflow: hidden;
    }
    .success-hero::before {
      content: '';
      position: absolute;
      top: -100px; right: -80px;
      width: 280px; height: 280px;
      background: var(--amber-500);
      opacity: 0.2;
      border-radius: 50%;
    }
    .success-icon {
      width: 88px; height: 88px;
      border-radius: 50%;
      background: var(--green-500);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      box-shadow: 0 10px 30px rgba(34, 197, 94, 0.4);
      position: relative;
      z-index: 1;
    }
    .success-icon i { font-size: 44px; }
    .success-hero h1 {
      font-size: 30px;
      margin-bottom: 8px;
      font-weight: 700;
      letter-spacing: -0.5px;
      position: relative;
      z-index: 1;
    }
    .success-hero p {
      color: rgba(255,255,255,0.9);
      font-size: 15px;
      position: relative;
      z-index: 1;
    }

    .ticket-wrap {
      max-width: 540px;
      margin: -32px auto 30px;
      padding: 0 20px;
      position: relative;
      z-index: 2;
    }
    .ticket {
      background: white;
      border-radius: 20px;
      border: 0.5px solid var(--border);
      overflow: hidden;
      box-shadow: 0 16px 40px rgba(11, 139, 132, 0.15);
    }
    .ticket-top {
      padding: 24px 28px;
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      color: white;
      position: relative;
    }
    .ticket-top::before, .ticket-top::after {
      content: '';
      position: absolute;
      bottom: -10px;
      width: 20px; height: 20px;
      background: var(--bg-secondary);
      border-radius: 50%;
    }
    .ticket-top::before { left: -10px; }
    .ticket-top::after { right: -10px; }
    .ticket-top h3 {
      font-size: 17px;
      margin-bottom: 4px;
      font-weight: 700;
      letter-spacing: -0.3px;
    }
    .ticket-top .small {
      opacity: 0.9;
      font-size: 13px;
    }
    .ticket-body { padding: 28px; }
    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 24px;
    }
    .info-row .label {
      font-size: 11px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
      font-weight: 600;
    }
    .info-row .value {
      font-size: 14px;
      font-weight: 600;
      color: var(--text);
    }

    .qr-section {
      background: var(--bg-secondary);
      padding: 24px;
      border-radius: 14px;
      text-align: center;
      margin-bottom: 20px;
      border: 1px dashed var(--border-strong);
    }
    .qr-box {
      width: 200px; height: 200px;
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      margin: 0 auto 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      box-shadow: var(--shadow-sm);
    }
    .qr-id {
      font-family: 'Courier New', monospace;
      font-size: 13px;
      color: var(--purple-700);
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .qr-label {
      font-size: 12px;
      color: var(--text-secondary);
      margin-bottom: 14px;
      font-weight: 500;
    }

    .ticket-actions {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      padding: 16px 28px;
      border-top: 0.5px solid var(--border);
      background: var(--bg-secondary);
    }

    .next-steps {
      max-width: 540px;
      margin: 0 auto 40px;
      padding: 0 20px;
    }
    .next-steps h3 {
      margin-bottom: 14px;
      font-weight: 700;
    }
    .step-item {
      display: flex;
      gap: 14px;
      align-items: flex-start;
      padding: 16px;
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      margin-bottom: 10px;
    }
    .step-icon {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: var(--purple-100);
      color: var(--purple-700);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .step-icon.amber { background: var(--amber-50); color: var(--amber-700); }
    .step-icon.green { background: var(--green-50); color: var(--green-600); }
    .step-text h4 {
      font-size: 14px;
      margin-bottom: 4px;
      font-weight: 700;
    }
    .step-text p {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
    }

/* ===== resultados.html ===== */
.res-hero {
      background: linear-gradient(135deg, var(--purple-50) 0%, white 100%);
      padding: 56px 32px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .res-hero::before {
      content: '';
      position: absolute;
      top: -80px; right: -60px;
      width: 240px; height: 240px;
      background: var(--amber-500); opacity: 0.15;
      border-radius: 50%;
    }
    .res-hero::after {
      content: '';
      position: absolute;
      bottom: -80px; left: -60px;
      width: 200px; height: 200px;
      background: var(--purple-700); opacity: 0.12;
      border-radius: 50%;
    }
    .res-hero-inner { position: relative; max-width: 760px; margin: 0 auto; }
    .res-hero h1 { font-size: 38px; margin-bottom: 12px; }
    .res-hero p { font-size: 16px; color: var(--text-secondary); margin-bottom: 26px; }

    .search-big {
      background: white;
      border: 0.5px solid var(--border-strong);
      border-radius: 14px;
      padding: 12px;
      display: flex;
      gap: 8px;
      box-shadow: 0 6px 24px rgba(11, 139, 132, 0.1);
      max-width: 640px;
      margin: 0 auto;
    }
    .search-big input {
      flex: 1;
      border: none;
      outline: none;
      font-size: 15px;
      padding: 8px 12px;
      background: transparent;
    }

    .quick-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      max-width: 700px;
      margin: 32px auto 0;
      position: relative;
    }
    .qstat { text-align: center; }
    .qstat strong {
      display: block;
      font-size: 28px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: -0.5px;
    }
    .qstat small {
      font-size: 12px;
      color: var(--text-secondary);
    }

    .results-section {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 32px;
    }
    .section-head {
      margin-bottom: 24px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }

    .results-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
    .result-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 20px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .result-card:hover {
      border-color: var(--purple-400);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }
    .result-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 14px;
    }
    .result-icon {
      width: 44px; height: 44px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .result-title {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .result-meta {
      font-size: 12px;
      color: var(--text-secondary);
    }
    .result-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 8px;
      padding-top: 14px;
      border-top: 0.5px solid var(--border);
    }
    .rstat strong {
      display: block;
      font-size: 16px;
      font-weight: 700;
      color: var(--text);
    }
    .rstat strong.purple { color: var(--purple-700); }
    .rstat small {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .top-runners {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 24px;
      margin-top: 24px;
    }
    .runner-row {
      display: grid;
      grid-template-columns: 36px 1fr auto auto;
      gap: 14px;
      align-items: center;
      padding: 10px 0;
      border-bottom: 0.5px solid var(--border);
    }
    .runner-row:last-child { border-bottom: none; }
    .rank-badge {
      width: 32px; height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13px;
      color: white;
    }
    .rank-1 { background: linear-gradient(135deg, #F59E0B 0%, #B45309 100%); }
    .rank-2 { background: linear-gradient(135deg, #94A3B8 0%, #64748B 100%); }
    .rank-3 { background: linear-gradient(135deg, #C2410C 0%, #7C2D12 100%); }
    .rank-other { background: var(--purple-100); color: var(--purple-700); }
    .runner-time {
      font-family: 'Courier New', monospace;
      font-weight: 700;
      color: var(--purple-700);
      font-size: 15px;
    }

/* ===== como-funciona.html ===== */
body { background: white; }

    /* ===== HERO ===== */
    .cf-hero {
      padding: 70px 32px 60px;
      background: linear-gradient(135deg, #FFFFFF 0%, #ECFEFD 60%, #FFF7EB 100%);
      position: relative;
      overflow: hidden;
    }
    .cf-hero::before {
      content: '';
      position: absolute;
      top: -160px; left: -120px;
      width: 440px; height: 440px;
      background: var(--amber-500); opacity: 0.13;
      border-radius: 50%;
      filter: blur(20px);
    }
    .cf-hero::after {
      content: '';
      position: absolute;
      top: 60px; right: -120px;
      width: 360px; height: 360px;
      background: var(--purple-500); opacity: 0.16;
      border-radius: 50%;
      filter: blur(20px);
    }
    .cf-hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.05fr 1fr;
      gap: 48px;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    .cf-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: white;
      border: 0.5px solid var(--purple-200);
      color: var(--purple-700);
      padding: 7px 16px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 600;
      box-shadow: 0 2px 10px rgba(23, 189, 181,0.1);
      margin-bottom: 24px;
    }
    .cf-eyebrow .dot {
      width: 7px; height: 7px;
      background: var(--amber-500);
      border-radius: 50%;
    }
    .cf-hero h1 {
      font-size: 60px;
      line-height: 1.04;
      letter-spacing: -2.2px;
      margin-bottom: 22px;
    }
    .cf-hero h1 .accent { color: var(--purple-700); }
    .cf-hero p.lead {
      font-size: 18px;
      line-height: 1.6;
      color: var(--text-secondary);
      max-width: 540px;
      margin-bottom: 32px;
    }
    .cf-cta-row {
      display: flex;
      gap: 12px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }
    .cf-stat-row {
      display: flex;
      gap: 32px;
      align-items: center;
    }
    .cf-stat .v {
      font-size: 32px;
      font-weight: 700;
      letter-spacing: -0.8px;
      line-height: 1;
    }
    .cf-stat .l {
      font-size: 13px;
      color: var(--text-secondary);
      margin-top: 6px;
    }
    .cf-stat-divider { width: 1px; height: 40px; background: var(--border-strong); }

    /* Hero collage of phone/desktop cards */
    .cf-hero-visual {
      position: relative;
      height: 440px;
    }
    .cf-card-1, .cf-card-2, .cf-card-3 {
      position: absolute;
      background: white;
      border-radius: 18px;
      border: 0.5px solid var(--border);
      box-shadow: 0 26px 60px rgba(76,29,149,0.22);
      overflow: hidden;
    }
    .cf-card-1 { top: 0; left: 0; width: 260px; height: 360px; transform: rotate(-4deg); z-index: 1; }
    .cf-card-2 { top: 50px; left: 140px; width: 280px; height: 360px; transform: rotate(3deg); z-index: 2; }
    .cf-card-3 { top: 20px; right: 0; width: 240px; height: 320px; transform: rotate(6deg); z-index: 3; box-shadow: 0 30px 60px rgba(245,158,11,0.3); }
    .cf-toast {
      position: absolute;
      bottom: 10px;
      right: -10px;
      background: white;
      border-radius: 14px;
      padding: 12px 16px;
      border: 0.5px solid var(--purple-200);
      box-shadow: 0 16px 36px rgba(11, 139, 132, 0.28);
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 6;
    }
    .cv-head {
      height: 34px;
      display: flex;
      align-items: center;
      padding: 0 12px;
      gap: 5px;
      border-bottom: 0.5px solid var(--border);
    }
    .cv-head .d {
      width: 7px; height: 7px;
      background: var(--bg-tertiary);
      border-radius: 50%;
    }
    .cv-head .d:nth-child(1) { background: #FCA5A5; }
    .cv-head .d:nth-child(2) { background: #FCD34D; }
    .cv-head .d:nth-child(3) { background: #86EFAC; }
    .cv-body { padding: 16px; }
    .cv-tag {
      font-size: 9px;
      color: var(--purple-700);
      font-weight: 700;
      letter-spacing: 1.2px;
      margin-bottom: 8px;
    }
    .cv-title {
      font-size: 15px;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 12px;
    }
    .cv-line {
      height: 6px;
      background: var(--bg-tertiary);
      border-radius: 3px;
      margin-bottom: 6px;
    }
    .cv-line.short { width: 60%; }
    .cv-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      padding: 4px 9px;
      background: var(--amber-50);
      color: var(--amber-800);
      border-radius: 999px;
      font-weight: 700;
      margin-top: 10px;
    }
    .cf-card-3 .cv-tag { color: var(--amber-700); }

    /* ===== SECTION SHELL ===== */
    .cf-section {
      max-width: 1200px;
      margin: 0 auto;
      padding: 90px 32px;
    }
    .cf-section.tinted { background: var(--bg-secondary); max-width: none; padding-left: 0; padding-right: 0;}
    .cf-section.tinted > .inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 32px;
    }
    .cf-section.dark {
      background: linear-gradient(160deg, var(--purple-950) 0%, #04413D 100%);
      color: white;
      max-width: none;
      padding-left: 0; padding-right: 0;
      position: relative;
      overflow: hidden;
    }
    .cf-section.dark::before {
      content: '';
      position: absolute;
      top: 80px; right: -100px;
      width: 320px; height: 320px;
      background: var(--amber-500);
      opacity: 0.16; border-radius: 50%; filter: blur(10px);
    }
    .cf-section.dark > .inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 32px;
      position: relative;
      z-index: 1;
    }
    .cf-section.dark h2, .cf-section.dark .label { color: white; }
    .cf-section.dark .label { color: var(--amber-400); }
    .cf-section.dark .lead { color: rgba(255,255,255,0.78); }

    .cf-head {
      text-align: center;
      max-width: 700px;
      margin: 0 auto 56px;
    }
    .cf-head .label {
      display: inline-block;
      font-size: 12px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 14px;
    }
    .cf-head h2 {
      font-size: 44px;
      line-height: 1.08;
      letter-spacing: -1.5px;
      margin-bottom: 14px;
    }
    .cf-head .lead {
      font-size: 17px;
      line-height: 1.55;
      color: var(--text-secondary);
    }
    /* En secciones oscuras: texto claro y legible */
    .cf-section.dark .cf-head h2 { color: #FFFFFF; }
    .cf-section.dark .cf-head .lead { color: rgba(255,255,255,0.75); }
    .cf-section.dark .cf-head .label { color: var(--amber-400); }

    /* ===== SISTEMA (compact) ===== */
    .sis-grid {
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 24px;
      align-items: stretch;
    }
    .sis-card {
      background: white;
      border-radius: 20px;
      border: 0.5px solid var(--border);
      padding: 28px;
      box-shadow: var(--shadow-sm);
    }
    .sis-card.dark {
      background: linear-gradient(160deg, var(--purple-700) 0%, var(--purple-950) 100%);
      color: white;
      border: none;
      position: relative;
      overflow: hidden;
    }
    .sis-card.dark::before {
      content: '';
      position: absolute;
      bottom: -60px; right: -60px;
      width: 200px; height: 200px;
      background: var(--amber-500);
      opacity: 0.2; border-radius: 50%;
    }
    .sis-card h3 {
      font-size: 18px;
      margin-bottom: 4px;
    }
    .sis-card .sis-sub {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 20px;
    }
    .sis-card.dark .sis-sub { color: rgba(255,255,255,0.75); }

    .sis-swatch-row {
      display: grid;
      grid-template-columns: repeat(11, 1fr);
      gap: 4px;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 6px;
    }
    .sis-swatch {
      aspect-ratio: 1;
      position: relative;
    }
    .sis-stack-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 11px;
      color: var(--text-secondary);
      font-family: 'IBM Plex Mono', monospace;
      margin-bottom: 18px;
    }
    .sis-stack-meta span:first-child { font-weight: 700; color: var(--text); }

    .sis-type-list .type-item {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      padding: 10px 0;
      border-bottom: 0.5px solid var(--border);
    }
    .sis-type-list .type-item:last-child { border: 0; }
    .sis-type-list .ti-label {
      font-size: 11px;
      color: var(--text-tertiary);
      font-family: 'IBM Plex Mono', monospace;
      width: 70px;
    }
    .ti-h1 { font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 1; }
    .ti-h2 { font-size: 22px; font-weight: 700; letter-spacing: -0.5px; line-height: 1.1; }
    .ti-body { font-size: 15px; line-height: 1.5; }
    .ti-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--purple-700); }

    .sis-comp-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
      margin-top: 16px;
    }
    .sis-comp-card {
      background: white;
      border-radius: 14px;
      border: 0.5px solid var(--border);
      padding: 18px;
    }
    .sis-comp-card h4 {
      font-size: 12px;
      margin-bottom: 10px;
      color: var(--text-tertiary);
      letter-spacing: 0.5px;
      text-transform: uppercase;
      font-weight: 700;
    }
    .sis-comp-body {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      align-items: center;
    }
    .big-aa {
      font-size: 120px;
      font-weight: 700;
      line-height: 0.9;
      letter-spacing: -6px;
      color: white;
      position: relative;
      z-index: 1;
    }
    .big-aa span { color: var(--amber-400); }

    /* ===== HOW IT WORKS (steps) ===== */
    .how-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
    }
    .how-step {
      background: white;
      border-radius: 16px;
      border: 0.5px solid var(--border);
      padding: 24px;
      position: relative;
      transition: all 0.2s;
    }
    .how-step.featured {
      border: 2px solid var(--amber-500);
    }
    .how-step.featured::before {
      content: '⭐ EXCLUSIVO';
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--amber-500);
      color: white;
      font-size: 10px;
      padding: 4px 10px;
      border-radius: 999px;
      font-weight: 700;
      letter-spacing: 0.5px;
      white-space: nowrap;
    }
    .how-num {
      width: 38px;
      height: 38px;
      background: var(--purple-700);
      color: white;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 14px;
    }
    .how-step.featured .how-num { background: var(--amber-500); }
    .how-step h3 {
      font-size: 16px;
      margin-bottom: 6px;
    }
    .how-step p {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.5;
      margin-bottom: 14px;
    }
    .how-step .how-pages {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      padding-top: 12px;
      border-top: 0.5px dashed var(--border);
    }
    .how-step .how-page {
      font-size: 10px;
      padding: 3px 8px;
      background: var(--bg-tertiary);
      color: var(--purple-700);
      border-radius: 6px;
      font-family: 'IBM Plex Mono', monospace;
      font-weight: 600;
    }
    .how-step.featured .how-page {
      background: var(--amber-50);
      color: var(--amber-700);
    }

    /* ===== ROLE TABS ===== */
    .role-tabs {
      display: flex;
      gap: 8px;
      justify-content: center;
      margin-bottom: 32px;
      flex-wrap: wrap;
    }
    .role-tab {
      padding: 10px 22px;
      border-radius: 999px;
      font-size: 14px;
      font-weight: 600;
      border: 0.5px solid var(--border-strong);
      background: white;
      cursor: pointer;
      transition: all 0.2s;
      color: var(--text-secondary);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .role-tab i { font-size: 16px; }
    .role-tab:hover { border-color: var(--purple-400); }
    .role-tab.active {
      background: var(--purple-700);
      color: white;
      border-color: var(--purple-700);
      box-shadow: 0 4px 14px rgba(11, 139, 132,0.3);
    }
    .role-tab .count {
      background: rgba(255,255,255,0.25);
      padding: 2px 8px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
    }
    .role-tab:not(.active) .count {
      background: var(--bg-tertiary);
      color: var(--text-tertiary);
    }

    /* ===== ROLE PANEL ===== */
    .role-panel { display: none; }
    .role-panel.active { display: grid; }
    .role-panel {
      grid-template-columns: 1fr 1.6fr;
      gap: 32px;
      background: white;
      border-radius: 24px;
      border: 0.5px solid var(--border);
      overflow: hidden;
      box-shadow: var(--shadow-md);
    }
    .role-side {
      padding: 36px;
      background: linear-gradient(160deg, var(--purple-700) 0%, var(--purple-950) 100%);
      color: white;
      position: relative;
      overflow: hidden;
    }
    .role-side.amber {
      background: linear-gradient(160deg, var(--amber-500) 0%, var(--amber-800) 100%);
    }
    .role-side.dark {
      background: linear-gradient(160deg, #063734 0%, #0F0426 100%);
    }
    .role-side::before {
      content: '';
      position: absolute;
      top: -80px; right: -80px;
      width: 240px; height: 240px;
      background: rgba(255,255,255,0.08);
      border-radius: 50%;
    }
    .role-side-eyebrow {
      font-size: 11px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-weight: 700;
      color: rgba(255,255,255,0.7);
      margin-bottom: 10px;
    }
    .role-side h3 {
      font-size: 30px;
      line-height: 1.1;
      letter-spacing: -0.8px;
      margin-bottom: 14px;
    }
    .role-side p {
      font-size: 14px;
      line-height: 1.6;
      color: rgba(255,255,255,0.85);
      margin-bottom: 28px;
    }
    .role-flow-steps {
      position: relative;
      z-index: 1;
    }
    .rfs-item {
      display: flex;
      gap: 14px;
      align-items: flex-start;
      padding: 14px 0;
      border-top: 0.5px solid rgba(255,255,255,0.18);
    }
    .rfs-item:last-child { border-bottom: 0.5px solid rgba(255,255,255,0.18); }
    .rfs-num {
      width: 24px;
      height: 24px;
      background: rgba(255,255,255,0.18);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
      flex-shrink: 0;
    }
    .rfs-info strong {
      display: block;
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 2px;
    }
    .rfs-info span {
      font-size: 12px;
      color: rgba(255,255,255,0.7);
    }
    .role-main {
      padding: 36px;
      display: flex;
      flex-direction: column;
    }
    .role-main-head {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin-bottom: 18px;
    }
    .role-main-head h4 {
      font-size: 14px;
      font-weight: 700;
    }
    .role-main-head .count {
      font-size: 12px;
      color: var(--text-tertiary);
    }
    .role-pages-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .role-page-row {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 16px;
      background: var(--bg-secondary);
      border-radius: 12px;
      border: 0.5px solid transparent;
      transition: all 0.15s;
      text-decoration: none;
      color: var(--text);
    }
    .role-page-row:hover {
      background: white;
      border-color: var(--purple-300);
      transform: translateX(3px);
      box-shadow: 0 4px 12px rgba(76,29,149,0.08);
    }
    .role-page-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: white;
      color: var(--purple-700);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
      border: 0.5px solid var(--border);
    }
    .role-panel.org .role-page-icon { color: var(--amber-700); }
    .role-panel.admin .role-page-icon { color: var(--purple-900); }
    .role-page-info {
      flex: 1;
      min-width: 0;
    }
    .role-page-info strong {
      display: block;
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 2px;
    }
    .role-page-info span {
      font-size: 12px;
      color: var(--text-secondary);
    }
    .role-page-meta {
      display: flex;
      gap: 6px;
      align-items: center;
    }
    .role-page-star {
      font-size: 10px;
      background: var(--amber-500);
      color: white;
      padding: 3px 8px;
      border-radius: 999px;
      font-weight: 700;
    }
    .role-page-arrow {
      color: var(--purple-400);
      font-size: 18px;
    }

    /* ===== DIFERENCIADORES (dark) ===== */
    .diff-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 18px;
    }
    .diff-card {
      background: rgba(255,255,255,0.04);
      border: 0.5px solid rgba(255,255,255,0.12);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 32px 28px;
      transition: all 0.25s;
      position: relative;
      overflow: hidden;
    }
    .diff-card:hover {
      transform: translateY(-4px);
      background: rgba(255,255,255,0.06);
      border-color: rgba(255,255,255,0.22);
    }
    .diff-icon-box {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }
    .diff-card h3 {
      font-size: 22px;
      margin-bottom: 10px;
      color: white;
      letter-spacing: -0.3px;
    }
    .diff-card p {
      font-size: 14px;
      color: rgba(255,255,255,0.7);
      line-height: 1.6;
      margin-bottom: 22px;
    }
    .diff-stat {
      padding-top: 18px;
      border-top: 0.5px dashed rgba(255,255,255,0.18);
      display: flex;
      align-items: baseline;
      gap: 10px;
    }
    .diff-stat-v {
      font-size: 28px;
      font-weight: 700;
      letter-spacing: -0.8px;
      color: var(--amber-400);
    }
    .diff-stat-l {
      font-size: 12px;
      color: rgba(255,255,255,0.65);
    }

    /* ===== MODELO DE NEGOCIO ===== */
    .biz-flow {
      background: linear-gradient(160deg, #fff 0%, #F2FEFD 100%);
      border-radius: 24px;
      border: 0.5px solid var(--purple-200);
      padding: 44px 36px;
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-md);
    }
    .biz-track {
      display: grid;
      grid-template-columns: 1fr auto 1fr auto 1fr auto 1fr;
      gap: 14px;
      align-items: stretch;
      margin-bottom: 32px;
    }
    .biz-node {
      background: white;
      border-radius: 16px;
      border: 0.5px solid var(--border);
      padding: 22px 18px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(76,29,149,0.05);
    }
    .biz-node.highlight {
      background: linear-gradient(160deg, var(--purple-700) 0%, var(--purple-950) 100%);
      color: white;
      border: none;
      box-shadow: 0 12px 32px rgba(11, 139, 132,0.32);
    }
    .biz-node.highlight.amber {
      background: linear-gradient(160deg, var(--amber-500) 0%, var(--amber-700) 100%);
      box-shadow: 0 12px 32px rgba(245,158,11,0.38);
    }
    .biz-node .biz-icon {
      width: 44px;
      height: 44px;
      margin: 0 auto 14px;
      border-radius: 50%;
      background: var(--purple-50);
      color: var(--purple-700);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }
    .biz-node.highlight .biz-icon {
      background: rgba(255,255,255,0.2);
      color: white;
    }
    .biz-node .biz-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 6px;
      color: var(--text-tertiary);
    }
    .biz-node.highlight .biz-label { color: rgba(255,255,255,0.85); }
    .biz-node .biz-value {
      font-size: 24px;
      font-weight: 700;
      letter-spacing: -0.5px;
      margin-bottom: 6px;
    }
    .biz-node .biz-sub {
      font-size: 12px;
      color: var(--text-tertiary);
    }
    .biz-node.highlight .biz-sub { color: rgba(255,255,255,0.85); }
    .biz-arrow {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      color: var(--purple-300);
    }
    .biz-arrow .biz-cost {
      font-size: 10px;
      font-weight: 700;
      color: var(--red-600);
      margin-top: 4px;
      font-family: 'IBM Plex Mono', monospace;
      background: #FEE2E2;
      padding: 2px 8px;
      border-radius: 999px;
      white-space: nowrap;
    }
    .biz-arrow .biz-gain {
      font-size: 10px;
      font-weight: 700;
      color: var(--green-700);
      margin-top: 4px;
      font-family: 'IBM Plex Mono', monospace;
      background: var(--green-50);
      padding: 2px 8px;
      border-radius: 999px;
      white-space: nowrap;
    }
    .biz-footnote {
      padding-top: 24px;
      border-top: 0.5px dashed var(--purple-200);
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
    }
    .biz-foot-item strong {
      display: block;
      font-size: 14px;
      color: var(--text);
      margin-bottom: 6px;
      font-weight: 700;
    }
    .biz-foot-item {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.6;
    }

    /* ===== PANTALLAS PREVIEW ===== */
    .preview-filter {
      display: flex;
      gap: 8px;
      margin-bottom: 32px;
      flex-wrap: wrap;
      justify-content: center;
    }
    .pfilter-chip {
      padding: 9px 18px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 600;
      border: 0.5px solid var(--border-strong);
      background: white;
      cursor: pointer;
      transition: all 0.15s;
      color: var(--text-secondary);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .pfilter-chip:hover { border-color: var(--purple-400); }
    .pfilter-chip.active {
      background: var(--purple-700);
      color: white;
      border-color: var(--purple-700);
      box-shadow: 0 4px 14px rgba(11, 139, 132,0.3);
    }
    .pfilter-chip .count {
      background: rgba(255,255,255,0.25);
      padding: 1px 8px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
    }
    .pfilter-chip:not(.active) .count {
      background: var(--bg-tertiary);
      color: var(--text-tertiary);
    }
    .pfilter-chip .role-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      display: inline-block;
    }

    .preview-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    .preview-card {
      background: white;
      border-radius: 16px;
      border: 0.5px solid var(--border);
      overflow: hidden;
      transition: all 0.25s;
      text-decoration: none;
      color: var(--text);
      display: flex;
      flex-direction: column;
    }
    .preview-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(76,29,149,0.2);
      border-color: var(--purple-400);
    }
    .preview-frame-wrap {
      position: relative;
      width: 100%;
      height: 230px;
      overflow: hidden;
      background: var(--bg-tertiary);
      border-bottom: 0.5px solid var(--border);
    }
    .preview-frame {
      border: none;
      width: 1280px;
      height: 920px;
      transform: scale(0.31);
      transform-origin: 0 0;
      pointer-events: none;
    }
    .preview-shade {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, transparent 60%, rgba(0,0,0,0.06) 100%);
      pointer-events: none;
    }
    .preview-role-pill {
      position: absolute;
      top: 12px;
      left: 12px;
      background: white;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.5px;
      padding: 4px 10px;
      border-radius: 999px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .preview-role-pill .dot {
      width: 6px; height: 6px;
      border-radius: 50%;
    }
    .preview-role-pill.public { color: var(--purple-700); }
    .preview-role-pill.public .dot { background: var(--purple-700); }
    .preview-role-pill.org { color: var(--amber-700); }
    .preview-role-pill.org .dot { background: var(--amber-500); }
    .preview-role-pill.admin { color: var(--purple-900); }
    .preview-role-pill.admin .dot { background: var(--purple-950); }

    .preview-star {
      position: absolute;
      top: 12px;
      right: 12px;
      background: var(--amber-500);
      color: white;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 999px;
      box-shadow: 0 4px 12px rgba(245,158,11,0.4);
    }

    .preview-body {
      padding: 16px 18px 18px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .preview-body .pb-title {
      font-size: 15px;
      font-weight: 700;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
    }
    .preview-body .pb-arrow {
      color: var(--purple-700);
      font-size: 16px;
      transition: transform 0.15s;
    }
    .preview-card:hover .pb-arrow { transform: translateX(3px); }
    .preview-body .pb-desc {
      font-size: 13px;
      color: var(--text-secondary);
      line-height: 1.45;
    }
    .preview-body .pb-tags {
      display: flex;
      gap: 4px;
      margin-top: 10px;
      flex-wrap: wrap;
    }
    .preview-body .pb-tags .t {
      font-size: 10px;
      padding: 3px 8px;
      border-radius: 999px;
      background: var(--bg-tertiary);
      color: var(--text-secondary);
      font-family: 'IBM Plex Mono', monospace;
    }

    /* ===== CTA STRIP ===== */
    .cta-strip {
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-950) 100%);
      border-radius: 28px;
      padding: 52px 48px;
      color: white;
      position: relative;
      overflow: hidden;
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: 32px;
      align-items: center;
    }
    .cta-strip::before {
      content: '';
      position: absolute;
      top: -100px; left: -80px;
      width: 320px; height: 320px;
      background: var(--amber-500); opacity: 0.18;
      border-radius: 50%; filter: blur(12px);
    }
    .cta-strip::after {
      content: '';
      position: absolute;
      bottom: -120px; right: 80px;
      width: 280px; height: 280px;
      background: rgba(255,255,255,0.06);
      border-radius: 50%;
    }
    .cta-strip h2 {
      font-size: 38px;
      line-height: 1.1;
      letter-spacing: -1.2px;
      margin-bottom: 14px;
      position: relative;
      z-index: 1;
    }
    .cta-strip p {
      font-size: 15px;
      color: rgba(255,255,255,0.82);
      line-height: 1.6;
      max-width: 460px;
      position: relative;
      z-index: 1;
    }
    .cta-strip-right {
      display: flex;
      flex-direction: column;
      gap: 12px;
      position: relative;
      z-index: 1;
    }

    @media (max-width: 1000px) {
      .cf-hero h1 { font-size: 40px; letter-spacing: -1px; }
      .cf-hero-inner { grid-template-columns: 1fr; gap: 32px; }
      .cf-hero-visual { display: none; }
      .sis-grid { grid-template-columns: 1fr; }
      .how-grid { grid-template-columns: 1fr 1fr; }
      .role-panel { grid-template-columns: 1fr !important; }
      .biz-track { grid-template-columns: 1fr; gap: 10px; }
      .biz-arrow { transform: rotate(90deg); padding: 6px 0; }
      .biz-footnote { grid-template-columns: 1fr; gap: 18px; }
      .diff-grid { grid-template-columns: 1fr; }
      .preview-grid { grid-template-columns: 1fr; }
      .cta-strip { grid-template-columns: 1fr; padding: 36px 28px; }
      .cf-head h2 { font-size: 32px; }
      .cf-section { padding: 60px 24px; }
    }

/* ===== login.html ===== */
body { background: linear-gradient(135deg, #ECFEFD 0%, #FFFFFF 100%); }
    .login-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }
    .login-wrap::before {
      content: '';
      position: absolute;
      top: -120px; left: -100px;
      width: 360px; height: 360px;
      background: #F59E0B; opacity: 0.15;
      border-radius: 50%;
    }
    .login-wrap::after {
      content: '';
      position: absolute;
      bottom: -100px; right: -100px;
      width: 320px; height: 320px;
      background: #0B8B84; opacity: 0.12;
      border-radius: 50%;
    }
    .login-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 20px;
      padding: 40px;
      max-width: 440px;
      width: 100%;
      box-shadow: 0 20px 60px rgba(11, 139, 132, 0.15);
      position: relative;
      z-index: 1;
    }
    .login-logo { text-align: center; margin-bottom: 24px; }
    .login-card h2 { font-size: 24px; margin-bottom: 6px; text-align: center; font-weight: 700; }
    .login-card .sub { font-size: 14px; color: var(--text-secondary); text-align: center; margin-bottom: 24px; }
    .demo-info {
      background: linear-gradient(135deg, var(--amber-50) 0%, #FEF9E7 100%);
      border: 0.5px solid var(--amber-100);
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 22px;
      font-size: 12px;
      color: var(--amber-800);
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }
    .demo-info i { color: var(--amber-600); font-size: 16px; flex-shrink: 0; margin-top: 1px; }

    .role-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-top: 20px;
    }
    .role-card {
      padding: 16px 14px;
      border: 0.5px solid var(--border-strong);
      border-radius: 12px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s;
      text-decoration: none;
      color: var(--text);
    }
    .role-card:hover {
      border-color: var(--purple-500);
      background: var(--purple-50);
      transform: translateY(-2px);
    }
    .role-card .ricon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: var(--purple-100);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
    }
    .role-card.admin .ricon { background: var(--amber-50); }
    .role-card .ricon i { font-size: 20px; }
    .role-card .name { font-size: 13px; font-weight: 600; display: block; margin-bottom: 2px; }
    .role-card .desc { font-size: 11px; color: var(--text-tertiary); display: block; }

    /* Social login buttons (Welcu-style) */
    .social-btns {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 22px;
    }
    .social-btn {
      width: 100%;
      padding: 12px 14px;
      border: 0.5px solid var(--border-strong);
      background: white;
      border-radius: 11px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.15s;
      color: var(--text);
      text-decoration: none;
    }
    .social-btn:hover {
      transform: translateY(-1px);
      border-color: var(--purple-400);
      box-shadow: 0 4px 14px rgba(76,29,149,0.1);
    }
    .social-btn .s-icon {
      width: 22px;
      height: 22px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .social-btn .s-icon svg { width: 22px; height: 22px; }
    .social-btn .s-label { flex: 1; }
    .social-btn.google { background: white; }
    .social-btn.facebook { background: #1877F2; color: white; border-color: #1877F2; }
    .social-btn.facebook:hover { background: #166FE5; border-color: #166FE5; }
    .social-btn.instagram {
      background: linear-gradient(135deg, #F58529 0%, #DD2A7B 50%, #8134AF 100%);
      color: white;
      border: none;
    }
    .social-btn.instagram:hover { filter: brightness(1.08); }
    .social-btn.apple { background: #000; color: white; border-color: #000; }
    .social-btn.apple:hover { background: #111; }

    .divider-or {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 22px 0 18px;
      color: var(--text-tertiary);
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .divider-or::before,
    .divider-or::after {
      content: '';
      flex: 1;
      height: 0.5px;
      background: var(--border);
    }

    .ms-tag {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: var(--green-50);
      color: var(--green-700);
      font-size: 10px;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 999px;
      margin-left: 6px;
      letter-spacing: 0.3px;
    }

/* ===== organizador/dashboard.html ===== */
.featured-event-banner {
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      border-radius: 16px;
      padding: 22px;
      color: white;
      margin-bottom: 14px;
      position: relative;
      overflow: hidden;
    }
    .featured-event-banner::before {
      content: '';
      position: absolute;
      top: -50px; right: -50px;
      width: 200px; height: 200px;
      background: var(--amber-500);
      opacity: 0.2;
      border-radius: 50%;
    }
    .featured-event-banner::after {
      content: '';
      position: absolute;
      bottom: -60px; right: 120px;
      width: 120px; height: 120px;
      background: white;
      opacity: 0.05;
      border-radius: 50%;
    }
    .feb-inner {
      position: relative;
      z-index: 1;
      display: grid;
      grid-template-columns: 1.4fr 1fr 1fr 1fr;
      gap: 20px;
      align-items: center;
    }
    .feb-event-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: rgba(245,158,11,0.25);
      color: var(--amber-400);
      font-size: 11px;
      padding: 4px 10px;
      border-radius: 999px;
      font-weight: 600;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
    }
    .feb-title {
      font-size: 22px;
      font-weight: 700;
      letter-spacing: -0.5px;
      margin-bottom: 4px;
    }
    .feb-meta {
      font-size: 13px;
      opacity: 0.85;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .feb-stat-divider {
      border-left: 0.5px solid rgba(255,255,255,0.2);
      padding-left: 18px;
    }
    .feb-stat-label {
      font-size: 10px;
      opacity: 0.75;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 4px;
    }
    .feb-stat-value {
      font-size: 26px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }
    .feb-stat-trend {
      font-size: 11px;
      opacity: 0.85;
      margin-top: 2px;
    }

    .chart-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 12px;
    }
    .chart-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 18px;
    }
    .chart-card h3 {
      font-size: 14px;
      margin-bottom: 4px;
      font-weight: 700;
    }
    .chart-card .sub {
      font-size: 11px;
      color: var(--text-secondary);
      margin-bottom: 14px;
    }
    .chart-canvas-wrap {
      position: relative;
      height: 240px;
    }

    .activity-list { display: flex; flex-direction: column; gap: 8px; }
    .activity-item {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      padding: 8px;
      border-radius: 8px;
      transition: background 0.15s;
    }
    .activity-item:hover { background: var(--purple-50); }
    .activity-icon {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--purple-100);
      color: var(--purple-700);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .activity-icon.amber { background: var(--amber-50); color: var(--amber-700); }
    .activity-icon.green { background: var(--green-50); color: var(--green-600); }
    .activity-text { flex: 1; font-size: 12px; }
    .activity-text strong {
      display: block;
      margin-bottom: 2px;
      font-size: 13px;
      font-weight: 600;
    }
    .activity-text .time { color: var(--text-tertiary); font-size: 11px; }

    .events-table-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 18px;
    }
    .pill-status {
      display: inline-block;
      font-size: 11px;
      padding: 3px 10px;
      border-radius: 999px;
      font-weight: 500;
    }
    .pill-active { background: var(--green-50); color: var(--green-700); }
    .pill-draft { background: var(--bg-secondary); color: var(--text-secondary); }
    .pill-done { background: var(--blue-50); color: var(--blue-700); }
    .progress-bar-mini {
      width: 100px;
      height: 5px;
      background: var(--purple-100);
      border-radius: 3px;
      overflow: hidden;
    }
    .progress-fill-mini {
      height: 100%;
      background: linear-gradient(90deg, var(--purple-700) 0%, var(--amber-500) 100%);
    }

/* ===== organizador/mis-eventos.html ===== */
.event-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
    .event-tile {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 20px;
      transition: all 0.2s;
      color: inherit;
      display: block;
      position: relative;
    }
    .event-tile:hover {
      border-color: var(--purple-400);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }
    .event-tile .et-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }
    .et-actions {
      position: absolute;
      top: 14px;
      right: 14px;
      display: flex;
      gap: 4px;
      z-index: 2;
    }
    .et-action {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: white;
      border: 0.5px solid var(--border-strong);
      color: var(--text-tertiary);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s;
      padding: 0;
    }
    .et-action:hover {
      background: var(--purple-50);
      color: var(--purple-700);
      border-color: var(--purple-400);
    }
    .et-action.delete:hover {
      background: var(--red-50);
      color: var(--red-600);
      border-color: var(--red-500);
    }
    .et-action i { font-size: 14px; }
    .et-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 16px;
      padding-right: 80px;
    }
    .et-icon {
      width: 48px; height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .et-icon.purple { background: var(--purple-100); color: var(--purple-700); }
    .et-icon.amber { background: var(--amber-50); color: var(--amber-700); }
    .et-icon i { font-size: 24px; }
    .event-tile h3 { font-size: 17px; font-weight: 700; margin-bottom: 4px; }
    .event-tile .meta { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 5px; }
    .et-progress { margin-top: 16px; }
    .et-progress-bar {
      height: 6px;
      background: var(--purple-100);
      border-radius: 3px;
      overflow: hidden;
      margin: 6px 0;
    }
    .et-progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--purple-700) 0%, var(--amber-500) 100%);
    }
    .et-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      padding-top: 16px;
      border-top: 0.5px solid var(--border);
      margin-top: 16px;
    }
    .et-stat strong { display: block; font-size: 16px; font-weight: 700; color: var(--text); }
    .et-stat strong.purple { color: var(--purple-700); }
    .et-stat small { font-size: 11px; color: var(--text-secondary); }

    .filter-row {
      display: flex;
      gap: 8px;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }
    .filter-pill {
      padding: 7px 14px;
      border-radius: 999px;
      border: 0.5px solid var(--border-strong);
      background: white;
      font-size: 13px;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.15s;
    }
    .filter-pill.active {
      background: var(--purple-700);
      color: white;
      border-color: var(--purple-700);
      font-weight: 600;
    }

    /* Modal de confirmación */
    .confirm-modal {
      position: fixed;
      inset: 0;
      background: rgba(46,16,101,0.65);
      backdrop-filter: blur(6px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }
    .confirm-modal.open { display: flex; }
    .confirm-card {
      background: white;
      border-radius: 18px;
      padding: 32px;
      max-width: 420px;
      width: calc(100% - 40px);
      text-align: center;
      box-shadow: 0 24px 60px rgba(0,0,0,0.35);
    }
    .confirm-icon {
      width: 64px;
      height: 64px;
      margin: 0 auto 16px;
      background: var(--red-50);
      color: var(--red-600);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
    }
    .confirm-card h3 { font-size: 20px; margin-bottom: 6px; }
    .confirm-card p { color: var(--text-secondary); font-size: 14px; margin-bottom: 22px; line-height: 1.5; }
    .confirm-card .conf-name { font-weight: 700; color: var(--text); }
    .confirm-actions { display: flex; gap: 10px; }
    .confirm-actions .btn { flex: 1; }

    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border: 0.5px dashed var(--border-strong);
      border-radius: 16px;
      grid-column: 1 / -1;
    }
    .empty-state i { font-size: 48px; color: var(--purple-300); margin-bottom: 14px; display: block; }
    .empty-state h3 { font-size: 18px; margin-bottom: 6px; }
    .empty-state p { color: var(--text-secondary); font-size: 14px; margin-bottom: 18px; }

    /* Toast */
    .toast-notice {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: var(--text);
      color: white;
      padding: 12px 18px;
      border-radius: 12px;
      font-size: 13px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.25);
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.3s;
      z-index: 1100;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .toast-notice.show {
      transform: translateY(0);
      opacity: 1;
    }
    .toast-notice i { color: var(--green-500); font-size: 18px; }

/* ===== organizador/crear-evento.html ===== */
body { background: var(--bg-secondary); }

    /* ===== STEPPER ===== */
    .wiz-wrap {
      max-width: 900px;
      margin: 24px auto 60px;
      padding: 0 24px;
    }
    .stepper {
      display: flex;
      align-items: center;
      gap: 0;
      margin-bottom: 28px;
      background: white;
      padding: 14px 18px;
      border-radius: 14px;
      border: 0.5px solid var(--border);
      overflow-x: auto;
    }
    .step {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--text-tertiary);
      flex-shrink: 0;
      padding: 4px 6px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.15s;
    }
    .step:hover { background: var(--bg-secondary); }
    .step.active { color: var(--purple-700); font-weight: 600; }
    .step.done { color: var(--green-700); }
    .step-num {
      width: 26px; height: 26px;
      border-radius: 50%;
      border: 1px solid var(--border-strong);
      background: white;
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 700;
      flex-shrink: 0;
    }
    .step.active .step-num { background: var(--purple-700); color: white; border-color: var(--purple-700); }
    .step.done .step-num { background: var(--green-600); color: white; border-color: var(--green-600); }
    .step-line {
      width: 28px;
      height: 1px;
      background: var(--border-strong);
      margin: 0 6px;
      flex-shrink: 0;
    }
    .step-line.done { background: var(--green-600); }

    /* ===== PANEL ===== */
    .panel {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 18px;
      padding: 36px;
      box-shadow: var(--shadow-sm);
    }
    .panel-head { margin-bottom: 26px; }
    .panel h2 { font-size: 26px; margin-bottom: 6px; letter-spacing: -0.5px; }
    .panel .sub { font-size: 14px; color: var(--text-secondary); }

    /* ===== STEP 1: TIPO DE EVENTO ===== */
    .sport-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
      margin-bottom: 28px;
    }
    .sport-card {
      border: 1px solid var(--border-strong);
      border-radius: 14px;
      padding: 20px 16px;
      text-align: left;
      cursor: pointer;
      transition: all 0.15s;
      background: white;
      position: relative;
      overflow: hidden;
    }
    .sport-card:hover {
      border-color: var(--purple-400);
      transform: translateY(-2px);
      box-shadow: var(--shadow-sm);
    }
    .sport-card.sel {
      border: 2px solid var(--purple-700);
      background: var(--purple-50);
      padding: 19px 15px;
    }
    .sport-card.sel::after {
      content: '✓';
      position: absolute;
      top: 12px; right: 12px;
      width: 22px; height: 22px;
      background: var(--purple-700);
      color: white;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 700;
    }
    .sport-icon {
      width: 44px; height: 44px;
      border-radius: 12px;
      background: var(--bg-tertiary);
      display: flex; align-items: center; justify-content: center;
      font-size: 22px;
      color: var(--purple-700);
      margin-bottom: 14px;
    }
    .sport-card.sel .sport-icon { background: white; }
    .sport-card .sport-name {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 3px;
    }
    .sport-card .sport-desc {
      font-size: 12px;
      color: var(--text-secondary);
      line-height: 1.4;
    }

    .subtipo-row {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 8px;
    }
    .subtipo-chip {
      padding: 8px 14px;
      border-radius: 999px;
      border: 1px solid var(--border-strong);
      background: white;
      font-size: 13px;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.15s;
      font-weight: 500;
    }
    .subtipo-chip:hover { border-color: var(--purple-400); }
    .subtipo-chip.sel {
      background: var(--purple-700);
      color: white;
      border-color: var(--purple-700);
    }

    /* ===== STEP 2: DATOS ===== */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 14px;
    }
    .form-group { margin-bottom: 16px; }
    .field-hint {
      font-size: 11px;
      color: var(--text-tertiary);
      margin-top: 4px;
    }

    /* Toggle */
    .toggle-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 16px;
      background: var(--bg-secondary);
      border-radius: 12px;
      margin-bottom: 10px;
      gap: 16px;
    }
    .toggle-row.exclusive {
      background: linear-gradient(135deg, var(--amber-50) 0%, #FEF9E7 100%);
      border: 0.5px solid var(--amber-100);
    }
    .toggle-row.amber-active {
      background: linear-gradient(135deg, #FDE68A 0%, #FCD34D 30%, #FBBF24 100%);
      border: 0.5px solid var(--amber-400);
    }
    .toggle {
      width: 44px; height: 24px;
      background: var(--border-strong);
      border-radius: 999px;
      position: relative;
      cursor: pointer;
      transition: 0.2s;
      flex-shrink: 0;
    }
    .toggle.on { background: var(--purple-700); }
    .toggle.amber.on { background: var(--amber-700); }
    .toggle::after {
      content: '';
      position: absolute;
      width: 18px; height: 18px;
      border-radius: 50%;
      background: white;
      top: 3px;
      left: 3px;
      transition: 0.2s;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle.on::after { left: 23px; }
    .toggle-row .t-title { font-weight: 600; font-size: 14px; }
    .toggle-row .t-desc { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
    .toggle-row.exclusive .t-title { color: var(--amber-900); }
    .toggle-row.exclusive .t-desc { color: var(--amber-800); }

    /* Autoprogramar reveal */
    .reveal {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    .reveal.open { max-height: 400px; }
    .reveal-inner {
      padding: 16px;
      background: var(--purple-50);
      border-radius: 12px;
      margin-top: 8px;
      border: 0.5px solid var(--purple-200);
    }

    /* Upload */
    .upload-zone {
      border: 2px dashed var(--border-strong);
      border-radius: 12px;
      padding: 28px;
      text-align: center;
      background: var(--bg-secondary);
      cursor: pointer;
      transition: all 0.15s;
    }
    .upload-zone:hover {
      border-color: var(--purple-500);
      background: var(--purple-50);
    }
    .upload-zone i {
      font-size: 28px;
      color: var(--purple-500);
    }

    /* ===== STEP 3: DISTANCIAS + CATEGORIAS ===== */
    .item-list { display: flex; flex-direction: column; gap: 10px; }
    .item-row {
      background: var(--bg-secondary);
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 14px 16px;
      display: grid;
      grid-template-columns: auto 1fr 1fr 1fr auto;
      gap: 12px;
      align-items: center;
    }
    .item-row.dist {
      grid-template-columns: 36px 1.6fr 1fr 1fr auto;
    }
    .item-row.cat {
      grid-template-columns: 36px 1.6fr 1fr 1fr auto;
    }
    .item-handle {
      width: 28px; height: 28px;
      border-radius: 50%;
      background: var(--purple-700);
      color: white;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px;
      font-weight: 700;
      cursor: grab;
    }
    .item-row .input, .item-row .select {
      padding: 8px 10px;
      font-size: 13px;
    }
    .item-row .label { font-size: 11px; margin-bottom: 3px; }
    .item-del {
      width: 32px; height: 32px;
      border: none;
      background: transparent;
      color: var(--text-tertiary);
      cursor: pointer;
      border-radius: 8px;
      font-size: 18px;
      display: flex; align-items: center; justify-content: center;
    }
    .item-del:hover { background: var(--red-50); color: var(--red-600); }
    .add-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      width: 100%;
      padding: 12px;
      background: white;
      border: 1px dashed var(--purple-300);
      color: var(--purple-700);
      border-radius: 12px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.15s;
      margin-top: 12px;
    }
    .add-btn:hover { background: var(--purple-50); border-style: solid; }

    .sub-title {
      font-size: 16px;
      font-weight: 700;
      margin: 24px 0 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .sub-title i { color: var(--purple-700); }
    .sub-desc { font-size: 13px; color: var(--text-secondary); margin-bottom: 14px; }

    .preset-row {
      display: flex;
      gap: 8px;
      margin-bottom: 16px;
      flex-wrap: wrap;
    }
    .preset-chip {
      padding: 7px 12px;
      border: 0.5px solid var(--border-strong);
      background: white;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.15s;
    }
    .preset-chip:hover { background: var(--purple-50); border-color: var(--purple-400); color: var(--purple-700); }
    .preset-chip.applied { background: var(--green-50); border-color: var(--green-500); color: var(--green-700); }

    /* Chips de género (multi-select) */
    .genero-chips { display: flex; gap: 8px; flex-wrap: wrap; }
    .genero-chip {
      padding: 8px 16px;
      border: 1.5px solid var(--border-strong);
      background: white;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.15s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .genero-chip:hover { border-color: var(--purple-400); }
    .genero-chip.active {
      background: var(--purple-700);
      border-color: var(--purple-700);
      color: white;
    }
    .genero-chip i { font-size: 14px; }

    /* Formato del evento (Gratis/Pago + Presencial/Online) */
    .formato-block { display: flex; flex-direction: column; gap: 24px; margin-bottom: 8px; }
    .formato-group { }
    .formato-label { display: block; font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 12px; }
    .formato-options { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .formato-card {
      display: flex; align-items: center; gap: 12px;
      padding: 16px; border: 1.5px solid var(--border-strong);
      border-radius: 12px; background: white; cursor: pointer;
      text-align: left; transition: all 0.15s;
    }
    .formato-card:hover { border-color: var(--purple-400); }
    .formato-card.active { border-color: var(--purple-700); background: #F2FEFD; box-shadow: 0 0 0 3px rgba(13, 166, 158,0.08); }
    .formato-card i { font-size: 24px; color: var(--purple-700); flex-shrink: 0; }
    .formato-card strong { display: block; font-size: 14px; color: var(--text); }
    .formato-card span { display: block; font-size: 12px; color: var(--text-tertiary); margin-top: 2px; }
    @media (max-width: 640px) { .formato-options { grid-template-columns: 1fr; } }

    /* Reglamento upload (wizard) */
    .reglamento-upload {
      border: 1.5px dashed var(--border-strong);
      border-radius: 12px;
      padding: 18px;
      text-align: center;
      background: #FAFAFA;
    }
    /* Reglamento download (detalle del evento) */
    .reglamento-download {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 16px;
      border: 1px solid #D0FAF7;
      border-radius: 12px;
      background: #F2FEFD;
      text-decoration: none;
      transition: all 0.15s;
    }
    .reglamento-download:hover { border-color: var(--purple-400); background: #E6FCFA; }

    /* Video upload (wizard) */
    .video-upload {
      border: 1.5px dashed var(--border-strong);
      border-radius: 12px;
      padding: 18px;
      text-align: center;
      background: #FAFAFA;
    }
    /* Cronograma de texto libre en el detalle */
    .evento-crono-texto {
      white-space: pre-wrap;
      line-height: 1.8;
      color: var(--text-secondary);
      font-size: 14px;
      background: #F2FEFD;
      border: 1px solid #D0FAF7;
      border-radius: 12px;
      padding: 16px 18px;
    }
    /* Lista de GPX/KML y altimetrías (wizard) */
    .recorrido-item, .altimetria-item {
      display: flex; align-items: center; gap: 12px;
      padding: 12px; margin-bottom: 8px;
      border: 1px solid var(--border); border-radius: 12px; background: white;
    }
    .altimetria-thumb {
      width: 80px; height: 50px; object-fit: cover;
      border-radius: 8px; flex-shrink: 0; background: #F1F1F4;
    }
    /* Altimetría en el detalle del evento */
    .ev-altimetria-grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
    .ev-altimetria-card { border: 1px solid #D0FAF7; border-radius: 12px; overflow: hidden; background: white; }
    .ev-altimetria-card img { width: 100%; display: block; }
    .ev-altimetria-card .cap { padding: 8px 12px; font-size: 13px; font-weight: 600; color: var(--text); }
    .ev-gpx-link {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 10px 14px; margin: 4px 8px 4px 0;
      border: 1px solid #D0FAF7; border-radius: 10px; background: #F2FEFD;
      text-decoration: none; color: var(--purple-700); font-weight: 600; font-size: 13px;
    }
    .ev-gpx-link:hover { background: #E6FCFA; }

    /* Check-in: mensajes y listas */
    .ci-msg { padding: 10px 14px; border-radius: 10px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
    .ci-msg-ok { background: #DCFCE7; color: #15803D; }
    .ci-msg-warn { background: #FEF3C7; color: #B45309; }
    .ci-msg-err { background: #FEE2E2; color: #B91C1C; }
    .ci-inscrito-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: 8px 10px; border-bottom: 1px solid #F1F1F4;
    }
    .ci-inscrito-row:last-child { border-bottom: none; }
    .ci-pill { padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
    .ci-pill-ok { background: #DCFCE7; color: #15803D; }

    /* Tabla de corredores inscritos en el detalle */
    .inscritos-count {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 22px;
      height: 22px;
      padding: 0 7px;
      background: var(--purple-100);
      color: var(--purple-700);
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
    }
    .inscritos-table-wrap {
      border: 1px solid #D0FAF7;
      border-radius: 12px;
      overflow: hidden;
      overflow-x: auto;
    }
    .inscritos-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
    .inscritos-table thead th {
      background: #F2FEFD;
      color: #5F5E5A;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      font-weight: 700;
      text-align: left;
      padding: 10px 14px;
      border-bottom: 1px solid #D0FAF7;
    }
    .inscritos-table tbody td {
      padding: 11px 14px;
      border-bottom: 1px solid #F3F0FB;
      color: #1F1F1F;
    }
    .inscritos-table tbody tr:last-child td { border-bottom: none; }
    .inscritos-table tbody tr:hover { background: #F2FEFD; }
    .inscritos-empty {
      padding: 30px 16px;
      text-align: center;
      color: #9CA3AF;
      font-size: 13px;
    }

    /* Badges de vigencia en la tabla de compra */
    .buy-badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      vertical-align: middle;
      margin-left: 6px;
    }
    .buy-proximo { background: #FEF3C7; color: #B45309; }
    .buy-cerrado { background: #FEE2E2; color: #B91C1C; }
    .wt-periodo { font-size: 11px; color: #9CA3AF; margin-top: 2px; }
    .welcu-ticket-row.wt-disabled { opacity: 0.55; }
    .welcu-ticket-row.wt-disabled .wt-precio,
    .welcu-ticket-row.wt-disabled .wt-name { color: #9CA3AF; }

    /* ===== STEP 4: ENTRADAS + COMISIÓN ===== */
    .ticket-period-row {
      display: grid;
      grid-template-columns: 1fr 1fr auto;
      gap: 12px;
      margin-top: 10px;
      padding-top: 12px;
      border-top: 1px dashed #D0FAF7;
      align-items: start;
    }
    .ticket-period-badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
      white-space: nowrap;
    }
    .badge-vigente { background: #DCFCE7; color: #15803D; }
    .badge-proximo { background: #FEF3C7; color: #B45309; }
    .badge-cerrado { background: #FEE2E2; color: #B91C1C; }
    .ticket-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 10px;
    }
    .ticket-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }
    .ticket-head strong { font-size: 14px; }
    .ticket-fields {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr auto;
      gap: 10px;
      align-items: end;
    }
    .ticket-dist-row {
      margin-top: 10px;
      padding-top: 10px;
      border-top: 0.5px dashed var(--border);
    }
    .ticket-dist-row .label { margin-bottom: 6px; }
    .dist-tag-list { display: flex; flex-wrap: wrap; gap: 6px; }
    .dist-tag {
      padding: 5px 10px;
      border-radius: 999px;
      border: 1px solid var(--border-strong);
      background: white;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-secondary);
      cursor: pointer;
      transition: all 0.15s;
    }
    .dist-tag.on { background: var(--purple-700); color: white; border-color: var(--purple-700); }

    .comision-card {
      background: linear-gradient(135deg, #FFF7EB 0%, #FEF3C7 100%);
      border: 0.5px solid var(--amber-200);
      border-radius: 14px;
      padding: 18px;
      margin-top: 22px;
    }
    .comision-card h4 {
      font-size: 14px;
      margin-bottom: 4px;
      color: var(--amber-900);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .comision-card p.sub {
      font-size: 12px;
      color: var(--amber-800);
      margin-bottom: 14px;
    }
    .comision-options {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }
    .comision-opt {
      background: white;
      border: 1px solid var(--border-strong);
      border-radius: 12px;
      padding: 14px;
      cursor: pointer;
      transition: all 0.15s;
      position: relative;
    }
    .comision-opt:hover { border-color: var(--amber-400); }
    .comision-opt.sel {
      border: 2px solid var(--amber-600);
      background: linear-gradient(135deg, #FFFBEB 0%, white 100%);
      padding: 13px;
    }
    .comision-opt.sel::after {
      content: '✓';
      position: absolute;
      top: 8px; right: 8px;
      width: 20px; height: 20px;
      background: var(--amber-600);
      color: white;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 11px;
      font-weight: 700;
    }
    .comision-opt strong {
      display: block;
      font-size: 13px;
      margin-bottom: 4px;
      color: var(--text);
    }
    .comision-opt span.opt-desc {
      font-size: 11px;
      color: var(--text-secondary);
      display: block;
      line-height: 1.4;
    }
    .comision-opt .calc {
      margin-top: 10px;
      padding-top: 8px;
      border-top: 0.5px dashed var(--border);
      display: flex;
      justify-content: space-between;
      font-size: 11px;
    }
    .comision-opt .calc strong {
      font-size: 13px;
      color: var(--purple-700);
      display: inline;
    }

    /* ===== STEP 5: MAPA ===== */
    .map-type-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 22px;
    }
    .map-type-card {
      background: white;
      border: 1px solid var(--border-strong);
      border-radius: 12px;
      padding: 18px 16px;
      text-align: center;
      cursor: pointer;
      transition: all 0.15s;
    }
    .map-type-card:hover { border-color: var(--purple-400); }
    .map-type-card.sel {
      border: 2px solid var(--purple-700);
      background: var(--purple-50);
      padding: 17px 15px;
    }
    .map-type-card i {
      font-size: 26px;
      color: var(--purple-700);
      margin-bottom: 8px;
      display: block;
    }
    .map-type-card strong {
      display: block;
      font-size: 14px;
      margin-bottom: 2px;
    }
    .map-type-card small {
      font-size: 11px;
      color: var(--text-secondary);
    }

    .map-preview {
      background: linear-gradient(135deg, #E0F2FE 0%, #DBEAFE 50%, #A5F3EF 100%);
      height: 280px;
      border-radius: 14px;
      position: relative;
      overflow: hidden;
      border: 0.5px solid var(--border);
    }
    .map-preview svg { width: 100%; height: 100%; }
    .map-marker {
      position: absolute;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: var(--purple-700);
      border: 3px solid white;
      box-shadow: 0 4px 10px rgba(76,29,149,0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 11px;
      font-weight: 700;
      transform: translate(-50%, -50%);
    }
    .map-marker.start { background: var(--green-600); }
    .map-marker.end { background: var(--red-600); }
    .map-marker.hydra { background: var(--amber-500); width: 22px; height: 22px; font-size: 9px; }

    .preset-map-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 20px;
    }
    .preset-map-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 8px;
      cursor: pointer;
      transition: all 0.15s;
      overflow: hidden;
    }
    .preset-map-card:hover {
      border-color: var(--purple-400);
      transform: translateY(-2px);
    }
    .preset-map-card.sel {
      border: 2px solid var(--purple-700);
      padding: 7px;
    }
    .preset-map-thumb {
      height: 100px;
      border-radius: 8px;
      background: linear-gradient(135deg, #DBEAFE, #A5F3EF);
      position: relative;
      margin-bottom: 8px;
      overflow: hidden;
    }
    .preset-map-thumb svg { width: 100%; height: 100%; }
    .preset-map-card strong {
      font-size: 12px;
      display: block;
      padding: 0 4px 4px;
    }
    .preset-map-card small {
      font-size: 10px;
      color: var(--text-secondary);
      padding: 0 4px;
    }

    /* ===== STEP 6: RESUMEN ===== */
    .summary-card {
      background: linear-gradient(160deg, var(--purple-700) 0%, var(--purple-950) 100%);
      color: white;
      border-radius: 18px;
      padding: 28px;
      margin-bottom: 16px;
      position: relative;
      overflow: hidden;
    }
    .summary-card::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 200px; height: 200px;
      background: var(--amber-500);
      opacity: 0.18; border-radius: 50%;
    }
    .summary-card h3 {
      font-size: 22px;
      letter-spacing: -0.3px;
      margin-bottom: 6px;
      position: relative;
      z-index: 1;
    }
    .summary-card .summary-sub {
      font-size: 13px;
      color: rgba(255,255,255,0.75);
      margin-bottom: 18px;
      position: relative;
      z-index: 1;
    }
    .summary-meta-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
      position: relative;
      z-index: 1;
    }
    .summary-meta-row > div {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      border-radius: 10px;
      padding: 10px 12px;
    }
    .summary-meta-row strong {
      display: block;
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 2px;
    }
    .summary-meta-row span {
      font-size: 11px;
      color: rgba(255,255,255,0.7);
    }
    .summary-block {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 18px;
      margin-bottom: 10px;
    }
    .summary-block h4 {
      font-size: 13px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .summary-block h4 button {
      background: transparent;
      border: 0;
      color: var(--purple-700);
      font-size: 11px;
      font-weight: 700;
      cursor: pointer;
      letter-spacing: 0.3px;
    }
    .summary-list-item {
      padding: 8px 0;
      border-bottom: 0.5px dashed var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
    }
    .summary-list-item:last-child { border: 0; }
    .summary-list-item .si-name { font-weight: 600; }
    .summary-list-item .si-meta { font-size: 11px; color: var(--text-tertiary); }

    /* ===== NAVIGATION ===== */
    .nav-buttons {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 12px;
      margin-top: 30px;
      padding-top: 22px;
      border-top: 0.5px solid var(--border);
    }
    .auto-save {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 6px;
      margin-top: 14px;
      font-size: 12px;
      color: var(--text-tertiary);
    }
    .auto-save .dot {
      width: 6px; height: 6px;
      background: var(--green-500);
      border-radius: 50%;
      animation: pulse 2s ease infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .step-pane { display: none; }
    .step-pane.active { display: block; }

    /* Empty state */
    .empty {
      text-align: center;
      padding: 28px;
      color: var(--text-tertiary);
      background: var(--bg-secondary);
      border: 0.5px dashed var(--border-strong);
      border-radius: 12px;
    }
    .empty i { font-size: 32px; margin-bottom: 8px; display: block; color: var(--purple-300); }

    @media (max-width: 700px) {
      .stepper { padding: 12px; }
      .step span { display: none; }
      .step-line { width: 16px; margin: 0 4px; }
      .sport-grid { grid-template-columns: repeat(2, 1fr); }
      .form-grid { grid-template-columns: 1fr; }
      .item-row { grid-template-columns: 1fr; }
      .item-row .item-handle { display: none; }
      .comision-options { grid-template-columns: 1fr; }
      .map-type-grid, .preset-map-grid { grid-template-columns: 1fr; }
      .summary-meta-row { grid-template-columns: 1fr; }
      .panel { padding: 24px 20px; }
    }

/* ===== organizador/asistentes.html ===== */
.filter-row {
      display: flex;
      gap: 12px;
      margin-bottom: 16px;
      flex-wrap: wrap;
    }
    .search-mini { flex: 1; min-width: 220px; max-width: 320px; }
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      padding: 3px 10px;
      border-radius: 999px;
      font-weight: 500;
    }
    .s-ok { background: var(--green-50); color: var(--green-700); }
    .s-pend { background: var(--amber-50); color: var(--amber-700); }
    .s-no { background: var(--red-50); color: var(--red-600); }
    .action-btn {
      background: none;
      border: none;
      color: var(--text-secondary);
      cursor: pointer;
      padding: 4px 8px;
      font-size: 13px;
    }
    .action-btn:hover { color: var(--purple-700); }

/* ===== organizador/diplomas.html ===== */
.upload-zone {
      border: 2px dashed var(--purple-300, var(--border-strong));
      border-radius: 14px;
      padding: 40px;
      text-align: center;
      background: var(--purple-50);
      margin-bottom: 24px;
      cursor: pointer;
      transition: all 0.15s;
    }
    .upload-zone:hover {
      border-color: var(--purple-700);
      background: white;
    }
    .upload-zone i { font-size: 44px; color: var(--purple-700); margin-bottom: 12px; }
    .upload-zone h3 { margin-bottom: 6px; }

    .template-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 24px;
    }
    .template-card {
      border: 0.5px solid var(--border);
      border-radius: 10px;
      padding: 12px;
      cursor: pointer;
      transition: all 0.15s;
    }
    .template-card:hover { border-color: var(--purple-400); }
    .template-card.sel {
      border: 2px solid var(--purple-700);
      background: var(--purple-50);
    }
    .template-preview {
      height: 90px;
      border-radius: 6px;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .template-name { font-size: 13px; font-weight: 600; text-align: center; }
    .template-desc { font-size: 11px; color: var(--text-secondary); text-align: center; }

    .diploma-preview {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 16px;
      max-width: 540px;
      margin: 0 auto;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
    }
    .dpr-header {
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      padding: 28px;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .dpr-header::before {
      content: '';
      position: absolute;
      top: -30px; right: -30px;
      width: 120px; height: 120px;
      background: var(--amber-500);
      opacity: 0.25;
      border-radius: 50%;
    }
    .dpr-header .logo-text { color: white; position: relative; }
    .dpr-header p {
      font-size: 12px;
      opacity: 0.9;
      margin-top: 6px;
      position: relative;
    }

    .dpr-body { padding: 32px; text-align: center; }
    .dpr-label {
      font-size: 11px;
      letter-spacing: 1.5px;
      color: var(--text-tertiary);
      text-transform: uppercase;
      margin-bottom: 8px;
      font-weight: 600;
    }
    .dpr-name {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 6px;
      letter-spacing: -0.5px;
      color: var(--text);
    }
    .dpr-desc { font-size: 14px; color: var(--text-secondary); margin-bottom: 6px; }
    .dpr-event {
      font-size: 17px;
      font-weight: 700;
      margin-bottom: 4px;
      color: var(--purple-700);
    }
    .dpr-date {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 22px;
    }
    .dpr-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--amber-500);
      color: white;
      font-size: 13px;
      padding: 6px 16px;
      border-radius: 999px;
      margin-bottom: 18px;
      font-weight: 600;
    }
    .dpr-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 22px;
    }
    .dpr-stat {
      background: var(--purple-50);
      padding: 12px;
      border-radius: 10px;
    }
    .dpr-stat-val {
      font-size: 20px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: -0.3px;
    }
    .dpr-stat-lbl {
      font-size: 10px;
      color: var(--text-secondary);
      margin-top: 2px;
    }
    .dpr-footer {
      padding: 16px 28px;
      border-top: 0.5px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: var(--bg-secondary);
    }
    .qr-mini {
      width: 50px; height: 50px;
      border: 0.5px solid var(--border);
      border-radius: 6px;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .verify-info { font-size: 11px; color: var(--text-secondary); text-align: left; }

    .stats-row {
      display: flex;
      gap: 24px;
      padding: 18px;
      background: linear-gradient(135deg, var(--purple-50) 0%, white 100%);
      border-radius: 12px;
      margin-top: 22px;
      border: 0.5px solid var(--purple-200);
    }
    .stat-item strong {
      display: block;
      font-size: 22px;
      color: var(--purple-700);
      font-weight: 700;
    }
    .stat-item small {
      font-size: 12px;
      color: var(--purple-800);
    }

/* ===== organizador/descuentos.html ===== */
.coupon-card {
      display: grid;
      grid-template-columns: 1fr auto auto auto auto;
      gap: 16px;
      align-items: center;
      padding: 16px;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      margin-bottom: 10px;
      background: white;
    }
    .coupon-card:hover { border-color: var(--purple-400); }
    .coupon-code {
      font-family: 'Courier New', monospace;
      font-size: 14px;
      font-weight: 700;
      background: var(--purple-50);
      color: var(--purple-700);
      padding: 5px 14px;
      border-radius: 6px;
    }
    .coupon-info h4 { font-size: 14px; margin-bottom: 2px; }
    .coupon-info p { font-size: 12px; color: var(--text-secondary); }
    .coupon-stat { text-align: center; font-size: 12px; color: var(--text-secondary); }
    .coupon-stat strong { display: block; font-size: 16px; color: var(--text); margin-bottom: 2px; font-weight: 700; }

    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(46, 16, 101, 0.5);
      backdrop-filter: blur(4px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 200;
    }
    .modal-overlay.show { display: flex; }
    .modal {
      background: white;
      border-radius: 16px;
      padding: 28px;
      max-width: 480px;
      width: 90%;
      box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .modal h3 { margin-bottom: 20px; font-weight: 700; }

/* ===== organizador/checkin.html ===== */
.scanner-layout {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      max-width: 1000px;
      margin: 0 auto;
    }
    .scanner-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 16px;
      padding: 24px;
      text-align: center;
    }
    .scanner-frame {
      aspect-ratio: 1;
      max-width: 360px;
      margin: 16px auto;
      background: linear-gradient(135deg, var(--purple-900) 0%, #1F1F1F 100%);
      border-radius: 16px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .scanner-corners {
      position: absolute;
      top: 16%; left: 16%;
      right: 16%; bottom: 16%;
      border: 3px solid var(--amber-500);
      border-radius: 12px;
    }
    .scanner-corners::before, .scanner-corners::after {
      content: '';
      position: absolute;
      width: 30px; height: 30px;
      border: 4px solid white;
    }
    .scanner-corners::before {
      top: -4px; left: -4px;
      border-right: none;
      border-bottom: none;
      border-top-left-radius: 10px;
    }
    .scanner-corners::after {
      bottom: -4px; right: -4px;
      border-left: none;
      border-top: none;
      border-bottom-right-radius: 10px;
    }
    .scanner-line {
      position: absolute;
      left: 16%; right: 16%;
      height: 2px;
      background: var(--amber-500);
      top: 50%;
      box-shadow: 0 0 12px var(--amber-500);
      animation: scan 2s linear infinite;
    }
    @keyframes scan {
      0%, 100% { top: 20%; }
      50% { top: 80%; }
    }
    .scanner-text {
      color: white;
      opacity: 0.6;
      font-size: 13px;
    }

    .recent-checkin {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 16px;
      padding: 22px;
    }
    .recent-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      border-radius: 10px;
      transition: background 0.15s;
    }
    .recent-item:hover { background: var(--bg-secondary); }
    .check-icon {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: var(--green-50);
      color: var(--green-600);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .check-icon.warn { background: var(--amber-50); color: var(--amber-600); }
    .check-icon.err { background: var(--red-50); color: var(--red-600); }
    .check-info { flex: 1; }
    .check-name { font-weight: 600; font-size: 14px; }
    .check-meta { font-size: 12px; color: var(--text-secondary); }
    .check-time {
      font-size: 11px;
      color: var(--text-tertiary);
      font-family: 'Courier New', monospace;
      font-weight: 600;
    }

    .stat-cards {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 12px;
      margin-bottom: 24px;
    }
    .stat-card-mini {
      padding: 18px;
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      text-align: center;
    }
    .stat-card-mini.featured {
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);
      color: white;
      border: none;
    }
    .stat-num {
      font-size: 32px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }
    .stat-lbl {
      font-size: 12px;
      color: var(--text-secondary);
      margin-top: 4px;
    }
    .stat-card-mini.featured .stat-lbl { color: rgba(255,255,255,0.85); }

    .manual-search {
      background: var(--bg-secondary);
      padding: 16px;
      border-radius: 10px;
      margin-top: 16px;
    }
    .manual-search h4 { font-size: 13px; margin-bottom: 8px; font-weight: 700; }

/* ===== admin/login.html ===== */
.spa-shell-admin-login {
      background: linear-gradient(160deg, #04413D 0%, #063734 50%, #08514D 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      color: white;
    }
    .spa-shell-admin-login::before {
      content: '';
      position: fixed;
      top: 10%; left: -100px;
      width: 280px; height: 280px;
      background: #F59E0B; opacity: 0.15;
      border-radius: 50%; filter: blur(10px);
    }
    .spa-shell-admin-login::after {
      content: '';
      position: fixed;
      bottom: 10%; right: -100px;
      width: 360px; height: 360px;
      background: #17BDB5; opacity: 0.2;
      border-radius: 50%; filter: blur(10px);
    }

    .admin-card {
      background: rgba(255,255,255,0.06);
      backdrop-filter: blur(16px);
      border: 0.5px solid rgba(255,255,255,0.15);
      border-radius: 22px;
      padding: 48px 40px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 30px 80px rgba(0,0,0,0.5);
      position: relative;
      z-index: 1;
    }
    .admin-icon {
      width: 64px; height: 64px;
      background: linear-gradient(135deg, var(--amber-500), var(--amber-700));
      border-radius: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      color: white;
      margin: 0 auto 22px;
      box-shadow: 0 10px 30px rgba(245,158,11,0.4);
    }
    .admin-card h1 {
      font-size: 26px;
      text-align: center;
      letter-spacing: -0.4px;
      margin-bottom: 6px;
    }
    .admin-card .sub {
      font-size: 14px;
      color: rgba(255,255,255,0.65);
      text-align: center;
      margin-bottom: 28px;
    }
    .admin-card label {
      font-size: 12px;
      color: rgba(255,255,255,0.75);
      letter-spacing: 0.3px;
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
      margin-top: 14px;
    }
    .admin-input {
      width: 100%;
      background: rgba(0,0,0,0.25);
      border: 0.5px solid rgba(255,255,255,0.18);
      border-radius: 10px;
      padding: 12px 14px;
      color: white;
      font-size: 14px;
      transition: all 0.15s;
    }
    .admin-input:focus {
      outline: none;
      border-color: var(--amber-400);
      background: rgba(0,0,0,0.4);
    }
    .admin-input::placeholder { color: rgba(255,255,255,0.35); }
    .admin-btn {
      width: 100%;
      background: linear-gradient(135deg, var(--amber-500), var(--amber-700));
      color: white;
      border: none;
      border-radius: 12px;
      padding: 14px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.2s;
      box-shadow: 0 6px 18px rgba(245,158,11,0.35);
    }
    .admin-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 26px rgba(245,158,11,0.5);
    }
    .admin-error {
      margin-top: 12px;
      padding: 10px 14px;
      background: rgba(239,68,68,0.18);
      border: 0.5px solid rgba(252,165,165,0.4);
      border-radius: 10px;
      font-size: 13px;
      color: #FCA5A5;
      display: none;
      align-items: center;
      gap: 8px;
    }
    .admin-error.show { display: flex; }
    .admin-hint {
      margin-top: 22px;
      text-align: center;
      font-size: 11px;
      color: rgba(255,255,255,0.45);
    }
    .admin-hint code {
      background: rgba(255,255,255,0.1);
      padding: 3px 8px;
      border-radius: 5px;
      color: var(--amber-400);
      font-family: monospace;
      font-weight: 700;
    }
    .footer-link {
      margin-top: 24px;
      text-align: center;
      font-size: 12px;
      color: rgba(255,255,255,0.45);
    }
    .footer-link a {
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      font-weight: 500;
    }
    .footer-link a:hover { color: white; }

/* ===== admin/dashboard.html ===== */
.income-banner {
      background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-950) 100%);
      border-radius: 16px;
      padding: 24px;
      color: white;
      margin-bottom: 14px;
      position: relative;
      overflow: hidden;
    }
    .income-banner::before {
      content: '';
      position: absolute;
      top: -50px; right: -50px;
      width: 220px; height: 220px;
      background: var(--amber-500);
      opacity: 0.2;
      border-radius: 50%;
    }
    .income-banner::after {
      content: '';
      position: absolute;
      bottom: -60px; right: 140px;
      width: 130px; height: 130px;
      background: var(--purple-500);
      opacity: 0.3;
      border-radius: 50%;
    }
    .ib-inner {
      position: relative;
      z-index: 1;
      display: grid;
      grid-template-columns: 1.4fr 1fr 1fr 1fr;
      gap: 22px;
      align-items: center;
    }
    .ib-label {
      font-size: 11px;
      opacity: 0.8;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .ib-label i { color: var(--amber-400); font-size: 13px; }
    .ib-value-big {
      font-size: 38px;
      font-weight: 700;
      letter-spacing: -1px;
      margin-bottom: 4px;
    }
    .ib-trend {
      font-size: 13px;
      opacity: 0.9;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .ib-trend .pill {
      background: rgba(245,158,11,0.25);
      color: var(--amber-400);
      padding: 2px 8px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 11px;
    }
    .ib-stat-divider {
      border-left: 0.5px solid rgba(255,255,255,0.2);
      padding-left: 18px;
    }
    .ib-stat-label {
      font-size: 10px;
      opacity: 0.75;
      text-transform: uppercase;
      margin-bottom: 4px;
    }
    .ib-stat-value {
      font-size: 22px;
      font-weight: 700;
    }
    .ib-stat-sub {
      font-size: 11px;
      opacity: 0.85;
    }

    .chart-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 12px;
    }
    .chart-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 18px;
    }
    .chart-card h3 {
      font-size: 14px;
      margin-bottom: 4px;
      font-weight: 700;
    }
    .chart-card .sub {
      font-size: 11px;
      color: var(--text-secondary);
      margin-bottom: 14px;
    }
    .chart-canvas-wrap {
      position: relative;
      height: 240px;
    }

    .top-org-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px;
      border-radius: 8px;
      transition: background 0.15s;
    }
    .top-org-item:hover { background: var(--purple-50); }
    .org-rank {
      width: 24px; height: 24px;
      border-radius: 50%;
      color: white;
      font-weight: 700;
      font-size: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .org-rank-1 { background: linear-gradient(135deg, #F59E0B 0%, #B45309 100%); }
    .org-rank-2 { background: linear-gradient(135deg, #94A3B8 0%, #64748B 100%); }
    .org-rank-3 { background: linear-gradient(135deg, #C2410C 0%, #7C2D12 100%); }
    .org-rank-other { background: var(--purple-100); color: var(--purple-700); }
    .org-info { flex: 1; min-width: 0; }
    .org-info strong { display: block; font-size: 12px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .org-info .small { font-size: 11px; color: var(--text-secondary); }
    .org-stat strong { color: var(--purple-700); font-size: 13px; font-weight: 700; }

    .alert-card {
      border-radius: 10px;
      padding: 12px;
      display: flex;
      gap: 10px;
      align-items: flex-start;
      margin-bottom: 8px;
    }
    .alert-card.warn { background: var(--amber-50); border: 0.5px solid var(--amber-100); }
    .alert-card.danger { background: var(--red-50); border: 0.5px solid #FCA5A5; }
    .alert-card.info { background: var(--blue-50); border: 0.5px solid #BFDBFE; }
    .alert-card strong {
      display: block;
      font-size: 12px;
      margin-bottom: 2px;
    }
    .alert-card.warn strong { color: var(--amber-800); }
    .alert-card.danger strong { color: var(--red-600); }
    .alert-card.info strong { color: var(--blue-700); }
    .alert-card p { font-size: 11px; margin: 0; }
    .alert-card.warn p { color: var(--amber-800); }
    .alert-card.danger p { color: var(--red-600); }
    .alert-card.info p { color: var(--blue-700); }

/* ===== admin/eventos.html ===== */
.cat-icon-mini {
      width: 32px; height: 32px;
      border-radius: 9px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      vertical-align: middle;
      margin-right: 10px;
    }
    .table tbody tr { transition: background 0.15s; }
    .table tbody tr:hover { background: var(--bg-secondary); }
    .row-actions {
      display: flex;
      gap: 4px;
      justify-content: flex-end;
    }
    .row-action {
      width: 28px;
      height: 28px;
      border-radius: 7px;
      background: white;
      border: 0.5px solid var(--border-strong);
      color: var(--text-tertiary);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s;
      padding: 0;
    }
    .row-action:hover { background: var(--purple-50); color: var(--purple-700); border-color: var(--purple-400); }
    .row-action.delete:hover { background: var(--red-50); color: var(--red-600); border-color: var(--red-500); }
    .row-action i { font-size: 13px; }

    /* Confirm modal */
    .confirm-modal {
      position: fixed;
      inset: 0;
      background: rgba(46,16,101,0.65);
      backdrop-filter: blur(6px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }
    .confirm-modal.open { display: flex; }
    .confirm-card {
      background: white;
      border-radius: 18px;
      padding: 32px;
      max-width: 440px;
      width: calc(100% - 40px);
      box-shadow: 0 24px 60px rgba(0,0,0,0.35);
    }
    .confirm-icon {
      width: 64px; height: 64px;
      margin: 0 auto 16px;
      background: var(--red-50);
      color: var(--red-600);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
    }
    .confirm-card h3 { font-size: 20px; margin-bottom: 6px; text-align: center; }
    .confirm-card p { color: var(--text-secondary); font-size: 14px; margin-bottom: 22px; line-height: 1.5; text-align: center; }
    .confirm-card .conf-name { font-weight: 700; color: var(--text); }
    .confirm-warning {
      background: var(--amber-50);
      border: 0.5px solid var(--amber-100);
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 12px;
      color: var(--amber-800);
      margin-bottom: 18px;
      display: flex;
      gap: 8px;
      align-items: flex-start;
    }
    .confirm-warning i { color: var(--amber-600); font-size: 16px; flex-shrink: 0; margin-top: 1px; }
    .confirm-actions { display: flex; gap: 10px; }
    .confirm-actions .btn { flex: 1; }

    /* Toast */
    .toast-notice {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: var(--text);
      color: white;
      padding: 12px 18px;
      border-radius: 12px;
      font-size: 13px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.25);
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.3s;
      z-index: 1100;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .toast-notice.show { transform: translateY(0); opacity: 1; }
    .toast-notice i { color: var(--green-500); font-size: 18px; }

    /* Empty state */
    .empty-row td {
      text-align: center;
      padding: 60px 20px !important;
      color: var(--text-tertiary);
    }
    .empty-row i { font-size: 40px; color: var(--purple-300); margin-bottom: 10px; display: block; }
    .empty-row h3 { color: var(--text); font-size: 16px; margin-bottom: 4px; }

/* ===== admin/finanzas.html ===== */
.finance-flow {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 14px;
      padding: 24px;
      margin-bottom: 14px;
    }
    .flow-grid {
      display: grid;
      grid-template-columns: 1fr auto 1fr auto 1fr;
      gap: 16px;
      align-items: center;
    }
    .flow-box {
      padding: 22px 18px;
      background: var(--bg-secondary);
      border-radius: 12px;
      text-align: center;
    }
    .flow-box .label {
      font-size: 12px;
      color: var(--text-secondary);
      margin-bottom: 6px;
      font-weight: 500;
    }
    .flow-box .amount {
      font-size: 24px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }
    .flow-arrow {
      color: var(--text-tertiary);
      font-size: 24px;
    }
    .flow-box.primary {
      background: linear-gradient(135deg, var(--purple-50) 0%, var(--purple-100) 100%);
      border: 0.5px solid var(--purple-200);
    }
    .flow-box.primary .amount { color: var(--purple-800); }
    .flow-box.danger {
      background: linear-gradient(135deg, var(--red-50) 0%, #FEE2E2 100%);
    }
    .flow-box.danger .amount { color: var(--red-600); }
    .flow-box.amber {
      background: linear-gradient(135deg, var(--amber-50) 0%, #FEF3C7 100%);
      border: 0.5px solid var(--amber-100);
    }
    .flow-box.amber .amount { color: var(--amber-700); }

    .margin-final {
      text-align: center;
      margin-top: 22px;
      padding-top: 22px;
      border-top: 0.5px dashed var(--border-strong);
    }
    .margin-final .label {
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 8px;
    }
    .margin-final .amount {
      font-size: 40px;
      font-weight: 700;
      color: var(--purple-700);
      letter-spacing: -1.5px;
    }

    .chart-card {
      background: white;
      border: 0.5px solid var(--border);
      border-radius: 12px;
      padding: 18px;
    }
/* ============================================================
   CORRECTIVE OVERRIDES (fixes confirmados)
   1. Hero: títulos en negro, acento en violeta
   2. Login: fondo blanco/claro (no violeta oscuro)
   3. Cómo funciona: textos legibles (negro/violeta)
   4. Sección de planes: visible y legible
   ============================================================ */

/* FIX 1 — Hero: forzar color de texto correcto */
[data-route="/"] .hero,
.spa-page[data-route="/"] .hero {
  background: linear-gradient(135deg, #FFFFFF 0%, #ECFEFD 100%) !important;
}
[data-route="/"] .hero h1,
.spa-page[data-route="/"] .hero h1 {
  color: #1F1F1F !important;
  font-weight: 700 !important;
}
[data-route="/"] .hero h1 .purple,
.spa-page[data-route="/"] .hero h1 .purple,
[data-route="/"] .hero h1 span,
.spa-page[data-route="/"] .hero h1 span {
  color: #0B8B84 !important;
}
[data-route="/"] .hero-desc,
.spa-page[data-route="/"] .hero-desc {
  color: #5F5E5A !important;
}
[data-route="/"] .hero-badge,
.spa-page[data-route="/"] .hero-badge {
  color: #0B8B84 !important;
  background: white !important;
}
[data-route="/"] .hero-stat-label,
.spa-page[data-route="/"] .hero-stat-label {
  color: #5F5E5A !important;
}

/* FIX 2 — Login: fondo blanco, sin morado oscuro */
.spa-page[data-route="/login"],
.spa-page[data-route="/admin/login"] {
  background: #F2FEFD !important;
}
.spa-page[data-route="/login"] .auth-bg,
.spa-page[data-route="/login"] .login-bg,
.spa-page[data-route="/login"] > div:first-child,
.spa-page[data-route="/admin/login"] .auth-bg,
.spa-page[data-route="/admin/login"] .login-bg {
  background: #F2FEFD !important;
}
/* Esconder cualquier blob morado oscuro de fondo */
.spa-page[data-route="/login"] [style*="background: #063734"],
.spa-page[data-route="/login"] [style*="background:#063734"],
.spa-page[data-route="/login"] [style*="purple-950"],
.spa-page[data-route="/admin/login"] [style*="background: #063734"] {
  background: transparent !important;
}

/* FIX 3 — Cómo funciona: textos legibles */
.spa-page[data-route="/como-funciona"] {
  background: #F2FEFD !important;
}
.spa-page[data-route="/como-funciona"] h1,
.spa-page[data-route="/como-funciona"] h2,
.spa-page[data-route="/como-funciona"] h3,
.spa-page[data-route="/como-funciona"] h4 {
  color: #1F1F1F !important;
}
.spa-page[data-route="/como-funciona"] h1 .accent,
.spa-page[data-route="/como-funciona"] h2 .accent,
.spa-page[data-route="/como-funciona"] .accent,
.spa-page[data-route="/como-funciona"] .purple,
.spa-page[data-route="/como-funciona"] h1 span:not([style]),
.spa-page[data-route="/como-funciona"] h2 span:not([style]) {
  color: #0B8B84 !important;
}
.spa-page[data-route="/como-funciona"] p,
.spa-page[data-route="/como-funciona"] li,
.spa-page[data-route="/como-funciona"] .step-card p,
.spa-page[data-route="/como-funciona"] .cf-text {
  color: #1F1F1F !important;
}
.spa-page[data-route="/como-funciona"] .muted,
.spa-page[data-route="/como-funciona"] .text-secondary {
  color: #5F5E5A !important;
}
/* Si hay textos blancos sobre fondo oscuro que queremos cambiar a fondo claro */
.spa-page[data-route="/como-funciona"] [style*="color: white"]:not(.btn-primary):not(.btn-amber),
.spa-page[data-route="/como-funciona"] [style*="color:#fff"]:not(.btn-primary):not(.btn-amber),
.spa-page[data-route="/como-funciona"] [style*="color: #fff"]:not(.btn-primary):not(.btn-amber) {
  color: #1F1F1F !important;
}
/* Secciones con fondo oscuro en cómo funciona: convertir a fondo claro */
.spa-page[data-route="/como-funciona"] section[style*="background: var(--purple-9"],
.spa-page[data-route="/como-funciona"] section[style*="background: #063734"],
.spa-page[data-route="/como-funciona"] section[style*="background:#063734"],
.spa-page[data-route="/como-funciona"] section[style*="background: #08514D"],
.spa-page[data-route="/como-funciona"] [style*="background: linear-gradient(135deg, var(--purple-9"],
.spa-page[data-route="/como-funciona"] [style*="background: linear-gradient(160deg, var(--purple-7"] {
  background: white !important;
  color: #1F1F1F !important;
  border: 0.5px solid rgba(0,0,0,0.08) !important;
}

/* FIX 4 — Sección Precios (Simple y transparente): asegurar visibilidad */
.pricing-section {
  background: #F2FEFD !important;
  padding: 72px 32px !important;
  display: block !important;
}
.pricing-grid {
  display: grid !important;
  grid-template-columns: repeat(3, 1fr) !important;
  gap: 16px !important;
  max-width: 1100px !important;
  margin: 0 auto !important;
}
.price-card {
  display: block !important;
  background: white !important;
  border-radius: 16px !important;
  padding: 32px 26px !important;
}
.price-card.featured {
  background: linear-gradient(160deg, #0B8B84 0%, #08514D 100%) !important;
  color: white !important;
}
.price-card.featured .price-label,
.price-card.featured .price-sub,
.price-card.featured .pf {
  color: white !important;
}
.price-card.featured .price-amount {
  color: white !important;
}
.price-card:not(.featured) .price-amount {
  color: #0B8B84 !important;
}
@media (max-width: 900px) {
  .pricing-grid { grid-template-columns: 1fr !important; }
}

/* FIX checkmarks de los planes — fallback visual si Tabler Icons no carga.
   Ocultamos el <i> y dibujamos un check con SVG inline puro CSS. */
.price-features .pf i.ti.ti-circle-check,
.price-features .pf i.ti.ti-x {
  display: inline-block !important;
  width: 20px !important;
  height: 20px !important;
  flex-shrink: 0 !important;
  position: relative !important;
  font-family: "tabler-icons" !important;
  font-style: normal !important;
  font-weight: 400 !important;
  line-height: 1 !important;
  font-size: 18px !important;
  background: transparent !important;
  border: none !important;
  border-radius: 0 !important;
}
/* Si la fuente Tabler falla, mostramos un check verde con SVG mask */
.price-features .pf i.ti.ti-circle-check::before {
  font-family: "tabler-icons" !important;
  content: "\eb6a" !important; /* unicode tabler-icons.ti-circle-check */
  font-style: normal !important;
}
.price-features .pf i.ti.ti-x::before {
  font-family: "tabler-icons" !important;
  content: "\eb55" !important;
  font-style: normal !important;
}
/* Doble respaldo: si la fuente NO cargó (caracter aparece como □),
   los siguientes pseudoelementos dibujan un check de color con SVG inline.
   Esto se superpone al texto unicode pero es indistinguible. */
.price-features .pf i.ti.ti-circle-check {
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2316A34A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='9'/><path d='m9 12 2 2 4-4'/></svg>") !important;
  background-repeat: no-repeat !important;
  background-position: center !important;
  background-size: contain !important;
  color: transparent !important;
}
.price-card.featured .price-features .pf i.ti.ti-circle-check {
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23FBBF24' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='9'/><path d='m9 12 2 2 4-4'/></svg>") !important;
}
.price-features .pf.no i.ti.ti-x {
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23888780' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M18 6 6 18M6 6l12 12'/></svg>") !important;
  background-repeat: no-repeat !important;
  background-position: center !important;
  background-size: contain !important;
  color: transparent !important;
}
.price-features .pf i.ti.ti-circle-check::before,
.price-features .pf i.ti.ti-x::before {
  content: "" !important; /* Oculta el texto unicode original, el SVG hace el trabajo */
}

/* Spin animation para botón de carga del login */
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* ============================================================
   TARJETA DE USUARIO + MENÚ DESPLEGABLE (sidebar org y admin)
   ============================================================ */
.user-card {
  position: relative;
  margin: 14px 12px 18px;
}
.user-card-trigger {
  width: 100%;
  display: flex; align-items: center; gap: 10px;
  padding: 10px 12px;
  background: var(--bg-secondary, #FAFAF9);
  border: 1px solid var(--border, rgba(0,0,0,0.08));
  border-radius: 12px;
  cursor: pointer;
  text-align: left;
  font-family: inherit;
  transition: background 0.15s, border-color 0.15s;
}
.user-card-trigger:hover {
  background: var(--purple-50, #ECFEFD);
  border-color: var(--purple-200, #6EE7E0);
}
.sidebar.org .user-card-trigger {
  background: #FAFAF9;
  border-color: rgba(0,0,0,0.08);
}
.sidebar.admin .user-card-trigger {
  background: rgba(255,255,255,0.06);
  border-color: rgba(255,255,255,0.12);
  color: #fff;
}
.sidebar.admin .user-card-trigger:hover {
  background: rgba(255,255,255,0.10);
  border-color: rgba(245,158,11,0.5);
}
.user-avatar {
  flex-shrink: 0;
  width: 38px; height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #17BDB5 0%, #0B8B84 100%);
  color: #fff;
  font-weight: 700;
  font-size: 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.user-avatar.user-avatar-club {
  background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
  border-radius: 8px; /* clubes con esquinas menos redondeadas (más "institucional") */
}
.user-avatar.user-avatar-admin {
  background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
  border: 1.5px solid #F59E0B;
}
.user-info {
  flex: 1; min-width: 0;
  display: flex; flex-direction: column;
  line-height: 1.2;
}
.user-name {
  font-size: 13.5px;
  font-weight: 600;
  color: var(--text, #1F1F1F);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.sidebar.admin .user-name { color: #fff; }
.user-role {
  font-size: 10.5px;
  color: var(--text-secondary, #5F5E5A);
  margin-top: 2px;
  display: flex; align-items: center; gap: 4px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.sidebar.admin .user-role { color: #F59E0B; }
.user-chevron {
  transition: transform 0.2s;
  flex-shrink: 0;
}
.user-card.open .user-chevron { transform: rotate(180deg); }
.sidebar.admin .user-chevron { color: #fff; }

/* === Menú desplegable === */
.user-menu {
  position: absolute;
  top: calc(100% + 6px);
  left: 0;
  right: 0;
  background: #fff;
  border: 1px solid rgba(0,0,0,0.08);
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.15);
  padding: 6px;
  z-index: 1000;
  opacity: 0;
  transform: translateY(-4px);
  pointer-events: none;
  transition: opacity 0.15s, transform 0.15s;
}
.user-card.open .user-menu {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}
.user-menu-header {
  padding: 10px 12px 12px;
  border-bottom: 1px solid rgba(0,0,0,0.06);
  margin-bottom: 4px;
}
.user-menu-name {
  font-size: 14px;
  font-weight: 600;
  color: #1F1F1F;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.user-menu-email {
  font-size: 11.5px;
  color: #5F5E5A;
  margin-top: 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.user-menu-section { padding: 2px 0; }
.user-menu-item {
  width: 100%;
  display: flex; align-items: center; gap: 10px;
  padding: 9px 12px;
  background: transparent;
  border: 0;
  border-radius: 8px;
  cursor: pointer;
  text-align: left;
  font-size: 13.5px;
  font-family: inherit;
  color: #1F1F1F;
  text-decoration: none;
}
.user-menu-item i { font-size: 16px; opacity: 0.7; }
.user-menu-item:hover {
  background: var(--purple-50, #ECFEFD);
  color: var(--purple-700, #0B8B84);
}
.user-menu-item:hover i { opacity: 1; }
.user-menu-divider {
  height: 1px;
  background: rgba(0,0,0,0.06);
  margin: 4px 0;
}
.user-menu-danger {
  color: #DC2626;
}
.user-menu-danger:hover {
  background: #FEE2E2;
  color: #B91C1C;
}
.user-menu-danger:hover i { color: #B91C1C; opacity: 1; }

/* ============================================================
   SEGURIDAD DE CONTRASTE — texto oscuro en tarjetas de fondo claro
   Garantiza que NUNCA haya texto blanco sobre fondo blanco.
   Solo afecta a contenedores con fondo claro; las tarjetas con
   gradiente/color (featured, dark, hero) conservan su texto blanco.
   ============================================================ */

/* Planes de precio NO destacados (fondo blanco) → texto oscuro */
.price-card:not(.featured) .price-label { color: #5F5E5A !important; }
.price-card:not(.featured) .price-sub { color: #5F5E5A !important; }
.price-card:not(.featured) .pf {
  color: #1F1F1F !important;
}
.price-card:not(.featured) .pf.no {
  color: #9CA3AF !important;
}
.price-card:not(.featured) .price-amount { color: #0B8B84 !important; }

/* El plan destacado (featured) mantiene su texto blanco sobre morado */
.price-card.featured .price-label,
.price-card.featured .price-sub { color: rgba(255,255,255,0.88) !important; }
.price-card.featured .pf { color: #FFFFFF !important; }
.price-card.featured .price-amount { color: #FFFFFF !important; }

/* Encabezados de sección del checkout (fondo blanco) → oscuro */
.section-block h3 { color: #1F1F1F !important; }
.pay-name { color: #1F1F1F !important; }
.pay-desc { color: #5F5E5A !important; }

/* Resultados (tarjetas blancas) → texto oscuro */
.result-title { color: #1F1F1F !important; }

/* Tarjetas flotantes claras en "cómo funciona" cuyo fondo es blanco */
.cv-title { color: #1F1F1F !important; }

/* Regla de respaldo general: cualquier <li class="pf"> sin contexto de color
   que NO esté dentro de un contenedor featured/dark, va oscuro */
.pricing-grid .price-card:not(.featured) li {
  color: #1F1F1F !important;
}

/* ============================================================
   SEGURIDAD ADICIONAL — Headers de paneles (organizador y admin)
   El fondo del <main class="content"> es claro (#FAFAF9 o blanco).
   Todos los h1/h2/h3 de allí deben ser oscuros, sin excepción.
   ============================================================ */
.content-header h1,
.content-header h2,
.content h1,
.content h2,
.content h3,
.content-header > div > h1,
main.content h1,
main.content h2,
main.content h3 {
  color: #1F1F1F !important;
}

/* ============================================================
   SEGURIDAD DE CONTRASTE — Títulos de secciones públicas (landing)
   Estos <h2> van sobre fondo claro y deben ser oscuros.
   Cubre: "Cómo funciona", "Eventos destacados", "Precios".
   NO afecta títulos sobre fondo oscuro (hero, CTA morado).
   ============================================================ */
.cat-head h2,
.pricing-head h2,
.events-head h2,
.section-label + h2,
.cf-section h2:not(.cta-strip h2) {
  color: #1F1F1F !important;
}
/* El subtítulo bajo el section-label también legible */
.cat-head p,
.pricing-head p,
.events-head p {
  color: #5F5E5A !important;
}

/* ============================================================
   SEGURIDAD DE CONTRASTE — Página "Explorar eventos"
   El hero, los filtros laterales y los contadores van sobre fondo
   claro y deben verse oscuros.
   ============================================================ */
.explore-hero h1 {
  color: #1F1F1F !important;
}
.explore-hero p,
.explore-hero .muted {
  color: #5F5E5A !important;
}
.filters h4,
.filter-block h4 {
  color: #0B8B84 !important;
}
.filters .filter-option,
.filter-block label,
.filter-option {
  color: #1F1F1F !important;
}
.filters .count,
.filter-option .count {
  color: #9CA3AF !important;
}
/* Contador de resultados ("X eventos de Y") y el select de orden */
.results-info,
.results-info .muted,
.explore-body .results-count {
  color: #5F5E5A !important;
}

/* ============================================================
   SEGURIDAD DE CONTRASTE — Panel organizador/admin (wizard, descuentos, etc.)
   Todo el contenido del panel va sobre fondo claro. Forzamos texto
   oscuro en títulos y encabezados, EXCEPTO dentro de zonas oscuras
   marcadas (banners morados, botones primarios, tarjetas featured).
   ============================================================ */
.spa-shell-org .panel-head h2,
.spa-shell-org .panel-head h3,
.spa-shell-org .sub-title,
.spa-shell-org .panel h2,
.spa-shell-org .panel h3,
.spa-shell-org .card h2,
.spa-shell-org .card h3,
.spa-shell-admin .panel-head h2,
.spa-shell-admin .panel-head h3,
.spa-shell-admin .sub-title,
.spa-shell-admin .panel h2,
.spa-shell-admin .panel h3 {
  color: #1F1F1F !important;
}
/* Subtítulos / descripciones bajo los títulos del panel */
.spa-shell-org .panel-head .sub,
.spa-shell-org .sub-desc,
.spa-shell-admin .panel-head .sub {
  color: #5F5E5A !important;
}
/* Excepción: dentro de banners/tarjetas oscuras, el texto vuelve a claro */
.spa-shell-org .summary-card h2,
.spa-shell-org .summary-card h3,
.spa-shell-org .featured-event-banner h2,
.spa-shell-org .featured-event-banner h3,
.spa-shell-org [class*="banner"] h2,
.spa-shell-org [class*="banner"] h3 {
  color: white !important;
}
/* Los bloques de resumen (CATEGORÍAS, DISTANCIAS, etc.) van sobre fondo claro */
.spa-shell-org .summary-block h4,
.spa-shell-org .summary-block .si-name,
.spa-shell-org .summary-list-item .si-name {
  color: #1F1F1F !important;
}

/* Selección de texto: que se vea bien, sin tapar el contenido */
::selection {
  background: #A5F3EF;
  color: #1F1F1F;
}
::-moz-selection {
  background: #A5F3EF;
  color: #1F1F1F;
}

/* ============================================================
   COMPARACIÓN DE EVENTOS — Dashboard organizador
   Toggle, selector y tarjeta de métricas con variación %.
   ============================================================ */
.chart-card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 8px;
}
.compare-toggle { flex-shrink: 0; }
.compare-switch {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  user-select: none;
  font-size: 13px;
  color: #5F5E5A;
  font-weight: 500;
}
.compare-switch input[type="checkbox"] {
  position: absolute;
  opacity: 0;
  pointer-events: none;
  width: 0; height: 0;
}
.compare-slider {
  position: relative;
  width: 36px; height: 20px;
  background: #E5E5E0;
  border-radius: 999px;
  transition: background 0.2s;
  flex-shrink: 0;
}
.compare-slider::after {
  content: '';
  position: absolute;
  top: 2px; left: 2px;
  width: 16px; height: 16px;
  background: #fff;
  border-radius: 50%;
  transition: transform 0.2s;
  box-shadow: 0 1px 3px rgba(0,0,0,0.15);
}
.compare-switch input:checked + .compare-slider {
  background: #0B8B84;
}
.compare-switch input:checked + .compare-slider::after {
  transform: translateX(16px);
}
.compare-switch:hover .compare-slider { background: #D4D4D4; }
.compare-switch input:checked:hover + .compare-slider { background: #0A6E69; }

.compare-selector {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  background: #ECFEFD;
  border: 1px solid #A5F3EF;
  border-radius: 10px;
  margin-bottom: 12px;
  flex-wrap: wrap;
}
.compare-selector-label {
  font-size: 13px;
  color: #0A6E69;
  font-weight: 600;
}
.compare-select {
  flex: 1;
  min-width: 200px;
  padding: 8px 12px;
  border: 1px solid #A5F3EF;
  border-radius: 8px;
  background: #fff;
  color: #1F1F1F;
  font-size: 14px;
  font-family: inherit;
  cursor: pointer;
}
.compare-select:focus {
  outline: none;
  border-color: #0B8B84;
  box-shadow: 0 0 0 3px rgba(11, 139, 132,0.15);
}

.compare-metrics {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
  margin-bottom: 14px;
  padding: 12px;
  background: linear-gradient(135deg, #F2FEFD 0%, #ECFEFD 100%);
  border: 1px solid #D0FAF7;
  border-radius: 12px;
}
@media (max-width: 768px) {
  .compare-metrics { grid-template-columns: repeat(2, 1fr); }
}
.cmp-metric {
  padding: 10px 12px;
  background: #fff;
  border-radius: 8px;
  border: 1px solid rgba(0,0,0,0.04);
}
.cmp-metric-label {
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #5F5E5A;
  font-weight: 600;
  margin-bottom: 6px;
}
.cmp-metric-row {
  display: flex;
  align-items: baseline;
  gap: 6px;
  flex-wrap: wrap;
}
.cmp-metric-now {
  font-size: 18px;
  font-weight: 700;
  color: #1F1F1F;
}
.cmp-metric-vs {
  font-size: 11px;
  color: #9CA3AF;
}
.cmp-metric-delta {
  font-size: 12px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 999px;
  margin-left: auto;
}
.cmp-metric-delta.cmp-up {
  background: #DCFCE7;
  color: #15803D;
}
.cmp-metric-delta.cmp-down {
  background: #FEE2E2;
  color: #B91C1C;
}
.cmp-metric-delta.cmp-flat {
  background: #F3F4F6;
  color: #6B7280;
}

/* ============================================================
   UPLOAD ZONE — Drag & drop con preview funcional
   ============================================================ */
.upload-zone {
  position: relative;
  cursor: pointer;
}
.upload-zone.dragging {
  background: linear-gradient(135deg, #ECFEFD 0%, #D0FAF7 100%) !important;
  border-color: #0B8B84 !important;
  border-style: solid !important;
  transform: scale(1.01);
  transition: all 0.15s;
}
.upload-zone.has-file .upload-empty { display: none; }
.upload-zone.has-file { padding: 14px !important; cursor: default; }

.upload-empty {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  pointer-events: none; /* la zona entera maneja el click */
}

.upload-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  width: 100%;
}
.upload-preview-img {
  max-width: 100%;
  max-height: 280px;
  border-radius: 10px;
  object-fit: contain;
  background: #FAFAF9;
  border: 1px solid rgba(0,0,0,0.06);
}
.upload-file-pill {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 18px;
  background: #F0FDF4;
  border: 1px solid #BBF7D0;
  border-radius: 12px;
  width: 100%;
  max-width: 420px;
}
.upload-file-info {
  flex: 1;
  min-width: 0;
}
.upload-file-name {
  font-weight: 600;
  color: #14532D;
  font-size: 14px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.upload-file-size {
  font-size: 12px;
  margin-top: 2px;
}
.upload-preview-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  justify-content: center;
}
.upload-preview-actions button {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  background: white;
  border: 1px solid var(--border-strong, #D4D4D4);
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  color: #1F1F1F;
  cursor: pointer;
  font-family: inherit;
  transition: all 0.15s;
}
.upload-preview-actions button:hover {
  background: #ECFEFD;
  border-color: #0B8B84;
  color: #0B8B84;
}
.upload-preview-actions .upload-btn-remove:hover {
  background: #FEE2E2;
  border-color: #DC2626;
  color: #DC2626;
}
.upload-preview-meta {
  font-size: 11px;
  color: #5F5E5A;
}

/* Thumbnail de portada en las tarjetas de "Mis eventos" */
.et-icon-img {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  background-color: #ECFEFD;
  border: 1px solid rgba(0,0,0,0.06);
}

/* ============================================================
   CATEGORÍA AUTOCALCULADA — checkout
   ============================================================ */
.category-auto {
  display: flex; align-items: center; gap: 10px;
  padding: 14px 16px;
  background: linear-gradient(135deg, #F2FEFD, #ECFEFD);
  border: 1px solid #A5F3EF; border-radius: 10px;
  font-size: 14px; color: #5F5E5A;
}
.category-auto.resolved {
  background: linear-gradient(135deg, #F0FDF4, #DCFCE7);
  border-color: #BBF7D0; color: #14532D; font-weight: 600;
}
.category-auto.resolved #ck-categoria-text { color: #14532D; }

/* ============================================================
   TABLA DE TICKETS estilo Welcu — pestaña Entradas
   ============================================================ */
.welcu-tickets-head {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 18px; flex-wrap: wrap; gap: 10px;
}
.welcu-tickets-head h3 { font-size: 18px; font-weight: 800; color: #1F1F1F; }
.welcu-currency { display: flex; align-items: center; gap: 8px; }

/* Encabezado de columnas */
.welcu-ticket-header {
  display: grid;
  grid-template-columns: 1fr 120px 110px 120px 150px;
  gap: 12px; padding: 0 4px 10px;
  border-bottom: 2px solid #D0FAF7;
  font-size: 12px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.4px; color: #9CA3AF;
}
.welcu-ticket-header .col-precio,
.welcu-ticket-header .col-fee,
.welcu-ticket-header .col-total { text-align: right; }
.welcu-ticket-header .col-cant { text-align: center; }

/* Fila de ticket */
.welcu-ticket-row {
  display: grid;
  grid-template-columns: 1fr 120px 110px 120px 150px;
  gap: 12px; padding: 18px 4px;
  border-bottom: 1px solid #F0EFEA;
  align-items: start;
}
.welcu-ticket-row .wt-name { font-weight: 700; color: #1F1F1F; font-size: 15px; }
.welcu-ticket-row .wt-moreinfo {
  background: none; border: none; color: var(--purple-700);
  font-size: 12px; cursor: pointer; padding: 4px 0; margin-top: 4px;
  display: inline-flex; align-items: center; gap: 3px; font-weight: 600;
}
.welcu-ticket-row .wt-moreinfo:hover { text-decoration: underline; }
.welcu-ticket-row .wt-desc {
  font-size: 13px; color: #5F5E5A; line-height: 1.5; margin-top: 8px;
  display: none; padding: 10px 12px; background: #FAFAF8; border-radius: 8px;
}
.welcu-ticket-row .wt-desc.open { display: block; }
.welcu-ticket-row .wt-precio { text-align: right; font-weight: 700; color: #1F1F1F; }
.welcu-ticket-row .wt-fee { text-align: right; color: #9CA3AF; font-size: 13px; }
.welcu-ticket-row .wt-total { text-align: right; font-weight: 700; color: var(--purple-700); }
.welcu-ticket-row .wt-cant {
  display: flex; align-items: center; justify-content: center; gap: 8px;
}
.welcu-qty-btn {
  width: 32px; height: 32px; border-radius: 8px; border: 1px solid #A5F3EF;
  background: #ECFEFD; color: #0B8B84; font-size: 18px; cursor: pointer;
  display: flex; align-items: center; justify-content: center; font-weight: 700;
}
.welcu-qty-btn:hover { background: #D0FAF7; }
.welcu-qty-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.welcu-qty-val { min-width: 26px; text-align: center; font-weight: 700; color: #1F1F1F; }

/* Código promocional */
.welcu-promo { margin-top: 18px; }
.welcu-promo-toggle {
  background: none; border: none; color: var(--purple-700);
  font-size: 14px; cursor: pointer; font-weight: 600;
  display: inline-flex; align-items: center; gap: 6px;
}
.welcu-promo-toggle:hover { text-decoration: underline; }
.welcu-promo-input { display: flex; gap: 8px; margin-top: 10px; max-width: 420px; }
.welcu-promo-input .input { flex: 1; }

/* Total general */
.welcu-total-row {
  display: flex; justify-content: flex-end; align-items: baseline; gap: 12px;
  margin-top: 18px; padding-top: 16px; border-top: 2px solid #D0FAF7;
  font-size: 16px; color: #5F5E5A; font-weight: 600;
}
.welcu-total-amount { font-size: 26px; font-weight: 800; color: #1F1F1F; }

/* Logos de pago */
.welcu-paylogos {
  display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
  margin-top: 18px; justify-content: center;
}
.welcu-paylogos .paylogo {
  font-size: 11px; font-weight: 700; color: #6B7280;
  background: #F3F4F6; padding: 4px 10px; border-radius: 6px;
  border: 1px solid #E5E7EB;
}

/* Responsive: en móvil, las filas se apilan */
@media (max-width: 720px) {
  .welcu-ticket-header { display: none; }
  .welcu-ticket-row {
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }
  .welcu-ticket-row .wt-info { grid-column: 1 / -1; }
  .welcu-ticket-row .wt-precio::before { content: 'Precio: '; color: #9CA3AF; font-weight: 400; font-size: 11px; }
  .welcu-ticket-row .wt-fee::before { content: 'Fee: '; font-size: 11px; }
  .welcu-ticket-row .wt-total::before { content: 'Total: '; color: #9CA3AF; font-weight: 400; font-size: 11px; }
  .welcu-ticket-row .wt-cant { grid-column: 1 / -1; justify-content: flex-start; margin-top: 6px; }
}

/* ============================================================
   GALERÍA DE FOTOS — miniaturas en el wizard
   ============================================================ */
.gallery-thumbs {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
  gap: 8px;
  margin-top: 10px;
}
.gallery-thumb {
  position: relative;
  aspect-ratio: 1;
  border-radius: 8px;
  overflow: hidden;
  border: 1px solid rgba(0,0,0,0.08);
}
.gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }
.gallery-thumb-remove {
  position: absolute; top: 4px; right: 4px;
  width: 22px; height: 22px; border-radius: 50%;
  background: rgba(0,0,0,0.6); color: white; border: none;
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  font-size: 12px;
}
.gallery-thumb-remove:hover { background: #DC2626; }

/* ============================================================
   DETALLE DEL EVENTO — galería, video, tickets de compra
   ============================================================ */
/* Portada más legible: overlay oscuro consistente para que el texto blanco
   se lea sobre cualquier imagen (incluso fotos claras). */
.event-hero.has-cover::after {
  content: '';
  position: absolute; inset: 0;
  background:
    linear-gradient(to top, rgba(0,0,0,0.88) 0%, rgba(0,0,0,0.45) 35%, rgba(0,0,0,0.25) 60%, rgba(0,0,0,0.4) 100%),
    linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 55%, rgba(0,0,0,0) 100%);
  z-index: 1;
}
/* Velo morado adicional para asegurar contraste de marca */
.event-hero.has-cover::before {
  content: '';
  position: absolute; inset: 0;
  background: rgba(46, 16, 90, 0.45);
  z-index: 1;
}
.event-hero.has-cover .event-hero-inner { position: relative; z-index: 2; }
.event-hero.has-cover .event-title,
.event-hero.has-cover .event-meta-row,
.event-hero.has-cover .event-meta-row span,
.event-hero.has-cover .breadcrumbs,
.event-hero.has-cover .breadcrumbs a,
.event-hero.has-cover .breadcrumbs .current {
  color: #fff !important;
  text-shadow: 0 2px 12px rgba(0,0,0,0.9), 0 1px 3px rgba(0,0,0,0.8);
}

.ev-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 10px;
  margin: 16px 0;
}
.ev-gallery img {
  width: 100%; aspect-ratio: 4/3; object-fit: cover;
  border-radius: 10px; cursor: pointer; transition: transform 0.15s;
  border: 1px solid rgba(0,0,0,0.06);
}
.ev-gallery img:hover { transform: scale(1.03); }

.ev-video-wrap {
  position: relative; width: 100%; aspect-ratio: 16/9;
  border-radius: 12px; overflow: hidden; margin: 16px 0;
  background: #000;
}
.ev-video-wrap iframe { width: 100%; height: 100%; border: 0; }

/* Lightbox simple para galería */
#ev-lightbox {
  position: fixed; inset: 0; background: rgba(0,0,0,0.9);
  z-index: 99995; display: none; align-items: center; justify-content: center;
  padding: 20px; cursor: zoom-out;
}
#ev-lightbox.open { display: flex; }
#ev-lightbox img { max-width: 95%; max-height: 90%; border-radius: 8px; }
#ev-lightbox .lb-close {
  position: absolute; top: 20px; right: 24px; color: white;
  background: rgba(255,255,255,0.15); border: none; width: 42px; height: 42px;
  border-radius: 50%; font-size: 22px; cursor: pointer;
}

/* Tickets de compra en el detalle */
.buy-ticket-list { display: flex; flex-direction: column; gap: 10px; margin: 14px 0; }
.buy-ticket {
  display: flex; align-items: center; gap: 14px;
  padding: 14px 16px; border: 1px solid #E5E5E0; border-radius: 12px;
  background: #fff; transition: border-color 0.15s;
}
.buy-ticket:hover { border-color: #6EE7E0; }
.buy-ticket-info { flex: 1; min-width: 0; }
.buy-ticket-name { font-weight: 700; color: #1F1F1F; font-size: 15px; }
.buy-ticket-desc { font-size: 12px; color: #5F5E5A; margin-top: 2px; }
.buy-ticket-price { font-weight: 700; color: #0B8B84; font-size: 15px; white-space: nowrap; }
.buy-ticket-qty { display: flex; align-items: center; gap: 8px; }
.buy-qty-btn {
  width: 30px; height: 30px; border-radius: 8px; border: 1px solid #A5F3EF;
  background: #ECFEFD; color: #0B8B84; font-size: 18px; cursor: pointer;
  display: flex; align-items: center; justify-content: center; font-weight: 700;
}
.buy-qty-btn:hover { background: #D0FAF7; }
.buy-qty-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.buy-qty-val { min-width: 24px; text-align: center; font-weight: 700; color: #1F1F1F; }
.buy-total-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 16px; border-top: 2px solid #D0FAF7; margin-top: 8px;
}
.buy-total-row .buy-total-label { font-size: 15px; color: #5F5E5A; }
.buy-total-row .buy-total-amount { font-size: 24px; font-weight: 800; color: #1F1F1F; }

/* Botones de polera Sí/No en el wizard */
.polera-opt {
  flex: 1;
  padding: 12px 16px;
  border: 1.5px solid #E0DAF0;
  border-radius: 10px;
  background: #fff;
  color: #5F5E5A;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.15s;
}
.polera-opt:hover { border-color: var(--purple-400); }
.polera-opt.active {
  border-color: var(--purple-700);
  background: #ECFEFD;
  color: var(--purple-700);
}

/* Filas del cronograma en el wizard */
.crono-row {
  display: grid;
  grid-template-columns: 1.1fr 0.8fr 0.8fr 1.5fr auto;
  gap: 8px;
  align-items: start;
  padding: 12px;
  border: 1px solid #D0FAF7;
  border-radius: 10px;
  margin-bottom: 8px;
  background: #fff;
}
.crono-row .crono-field label {
  font-size: 10px;
  color: #9CA3AF;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  display: block;
  margin-bottom: 3px;
}
.crono-row input {
  width: 100%;
  padding: 7px 9px;
  border: 1px solid #E5E5E0;
  border-radius: 7px;
  font-size: 13px;
}
.crono-row .crono-del {
  align-self: center;
  background: #FEF2F2;
  border: none;
  color: #DC2626;
  width: 32px; height: 32px;
  border-radius: 7px;
  cursor: pointer;
  margin-top: 16px;
}
.crono-row .crono-del:hover { background: #FEE2E2; }
@media (max-width: 768px) {
  .crono-row { grid-template-columns: 1fr 1fr; }
}

/* Cronograma en el detalle del evento (estilo Welcu) */
.evento-crono { margin-top: 22px; }
.evento-crono-day {
  font-size: 14px;
  font-weight: 700;
  color: var(--purple-700);
  margin: 18px 0 10px;
  padding-bottom: 6px;
  border-bottom: 2px solid #D0FAF7;
}
.evento-crono-item {
  display: grid;
  grid-template-columns: 130px 1fr;
  gap: 16px;
  padding: 10px 0;
  border-bottom: 1px solid #F0F0F0;
}
.evento-crono-time {
  font-size: 13px;
  color: #6B7280;
  font-weight: 600;
}
.evento-crono-act { }
.evento-crono-act .act-name { font-size: 14px; font-weight: 600; color: #1F1F1F; }
.evento-crono-act .act-detail { font-size: 12px; color: #6B7280; margin-top: 2px; }
@media (max-width: 600px) {
  .evento-crono-item { grid-template-columns: 100px 1fr; gap: 10px; }
}

/* Estado vacío de Eventos destacados */
.featured-empty {
  text-align: center;
  padding: 50px 24px;
  background: #F2FEFD;
  border: 2px dashed #A5F3EF;
  border-radius: 18px;
  max-width: 560px;
  margin: 0 auto;
}
.featured-empty i { font-size: 44px; color: #34D6CE; }
.featured-empty h3 { font-size: 19px; color: #1F1F1F; margin: 14px 0 8px; }
.featured-empty p { color: #5F5E5A; font-size: 14px; margin-bottom: 20px; line-height: 1.5; }

/* ============================================================
   DETALLE DEL EVENTO — fondo claro y textos oscuros
   (antes heredaba fondo morado del body de admin login)
   ============================================================ */
#page-evento {
  background: #F2FEFD !important;
}
#page-evento .event-body {
  background: #F2FEFD;
}
/* Títulos y textos del contenido sobre fondo claro */
#page-evento .tab-panel h3,
#page-evento .tab-panel h4,
#page-evento .section-title,
#page-evento .about-title,
#page-evento .info-card .label,
#page-evento .info-card .value {
  color: #1F1F1F !important;
}
#page-evento .tab-panel p,
#page-evento .about-text,
#page-evento .tab-panel .muted {
  color: #5F5E5A !important;
}
/* Las cajas de info (Largada, Distancias, Categorías, Kits) como tarjetas claras */
#page-evento .info-card {
  background: #fff !important;
  border: 1px solid #D0FAF7;
}
/* Pills de "Incluye" */
#page-evento .feature-pill {
  background: #fff;
  border: 1px solid #E5E5E0;
  color: #1F1F1F;
}

/* ============================================================
   PAGO — modal de procesando + vista previa de correo
   ============================================================ */
#pago-procesando {
  position: fixed; inset: 0; background: rgba(30, 20, 60, 0.6);
  backdrop-filter: blur(4px); z-index: 99996;
  display: none; align-items: center; justify-content: center; padding: 20px;
}
#pago-procesando.show { display: flex; }
#pago-procesando .pago-card {
  background: #fff; border-radius: 18px; padding: 40px 36px;
  text-align: center; max-width: 360px; width: 100%;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
#pago-procesando .pago-card h3 { font-size: 19px; color: #1F1F1F; margin: 18px 0 6px; }
.pago-spinner {
  width: 54px; height: 54px; margin: 0 auto;
  border: 5px solid #D0FAF7; border-top-color: #0B8B84;
  border-radius: 50%; animation: pagospin 0.8s linear infinite;
}
@keyframes pagospin { to { transform: rotate(360deg); } }
.pago-check {
  width: 54px; height: 54px; margin: 0 auto; border-radius: 50%;
  background: linear-gradient(135deg, #22C55E, #16A34A); color: #fff;
  display: flex; align-items: center; justify-content: center; font-size: 30px;
  animation: pagopop 0.4s ease;
}
@keyframes pagopop { 0% { transform: scale(0); } 70% { transform: scale(1.15); } 100% { transform: scale(1); } }

/* Vista previa del correo */
#correo-preview {
  position: fixed; inset: 0; background: rgba(0,0,0,0.55);
  z-index: 99996; display: none; align-items: flex-start; justify-content: center;
  padding: 30px 16px; overflow-y: auto;
}
#correo-preview.show { display: flex; }
.correo-card {
  background: #fff; border-radius: 14px; max-width: 480px; width: 100%;
  overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin: auto;
}
.correo-toolbar {
  display: flex; justify-content: space-between; align-items: center;
  padding: 12px 16px; background: #F3F4F6; border-bottom: 1px solid #E5E7EB;
  font-size: 12px; color: #6B7280;
}
.correo-toolbar button {
  background: none; border: none; font-size: 20px; cursor: pointer; color: #6B7280;
}
.correo-header {
  background: linear-gradient(135deg, #0B8B84, #08514D); color: #fff;
  padding: 28px 24px; text-align: center;
}
.correo-header .logo { font-size: 13px; letter-spacing: 1px; opacity: 0.85; margin-bottom: 10px; font-weight: 700; }
.correo-header h2 { font-size: 22px; margin: 0; }
.correo-body { padding: 24px; color: #374151; font-size: 14px; line-height: 1.6; }
.correo-body .saludo { font-weight: 600; color: #1F1F1F; margin-bottom: 12px; }
.correo-detalle {
  background: #F2FEFD; border: 1px solid #D0FAF7; border-radius: 10px;
  padding: 16px; margin: 16px 0;
}
.correo-detalle .row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 13px; }
.correo-detalle .row .k { color: #6B7280; }
.correo-detalle .row .v { color: #1F1F1F; font-weight: 600; }
.correo-footer {
  text-align: center; padding: 18px; background: #F9FAFB;
  font-size: 11px; color: #9CA3AF; border-top: 1px solid #F0F0F0;
}

/* ============================================================
   CUPONES — barra de progreso de usos
   ============================================================ */
.coupon-usage {
  width: 100%;
  margin-top: 8px;
}
.coupon-usage-bar {
  height: 6px;
  background: #D0FAF7;
  border-radius: 999px;
  overflow: hidden;
}
.coupon-usage-fill {
  height: 100%;
  border-radius: 999px;
  background: linear-gradient(90deg, #17BDB5, #0B8B84);
  transition: width 0.3s;
}
.coupon-usage-fill.high { background: linear-gradient(90deg, #F59E0B, #DC2626); }
.coupon-usage-fill.full { background: #DC2626; }
.coupon-usage-text {
  font-size: 11px;
  color: #5F5E5A;
  margin-top: 3px;
  display: flex;
  justify-content: space-between;
}
.coupon-usage-text .agotado { color: #DC2626; font-weight: 700; }


/* ============================================================
   LEGIBILIDAD MÓVIL — CHECKOUT / INSCRIPCIÓN
   Los deportistas se inscriben desde el celular, así que el
   texto y los controles deben ser grandes y cómodos de tocar.
   ============================================================ */

/* Base: agrandar checkboxes de salud y su texto en TODAS las pantallas */
.check-card {
  padding: 14px 16px !important;
  margin-bottom: 10px !important;
  border-left-width: 3px !important;
  align-items: center !important;
  gap: 14px !important;
}
.check-card input[type="checkbox"] {
  width: 22px !important;
  height: 22px !important;
  margin-top: 0 !important;
  accent-color: var(--purple-700) !important;
}
.check-card label {
  font-size: 15px !important;
  line-height: 1.55 !important;
  color: #1F1F1F !important;   /* contraste fuerte, nunca gris claro */
}
.check-card.checked label {
  color: #14532D !important;   /* verde oscuro legible sobre fondo verde claro */
}

/* Declaración legal: subir tamaño y contraste */
.legal-box p {
  font-size: 14px !important;
  line-height: 1.6 !important;
  color: #78350F !important;   /* ámbar oscuro, alto contraste */
}
.legal-box i { font-size: 22px !important; }
.legal-check { padding-top: 14px !important; margin-top: 12px !important; }
.legal-check input[type="checkbox"] {
  width: 22px !important;
  height: 22px !important;
  margin-top: 0 !important;
}
.legal-check label {
  font-size: 15px !important;
  color: #78350F !important;
  font-weight: 700 !important;
}

/* Etiquetas de formulario e inputs del checkout más grandes */
.section-block .label,
.section-block label.label {
  font-size: 14px !important;
  font-weight: 600 !important;
  color: #1F1F1F !important;
  margin-bottom: 7px !important;
}
.section-block .input,
.section-block input.input,
.section-block input[type="text"],
.section-block input[type="email"],
.section-block input[type="tel"],
.section-block select,
.section-block textarea {
  font-size: 16px !important;   /* 16px evita el zoom automático en iOS al enfocar */
  padding: 13px 15px !important;
  min-height: 48px !important;   /* área táctil cómoda */
}
.section-block h3 { font-size: 18px !important; }
.section-block .sub { font-size: 14px !important; }

/* Título de "Declaración de salud" */
.section-block p[style*="font-size: 13px"][style*="font-weight: 600"] {
  font-size: 16px !important;
}

/* ==== AJUSTES SOLO MÓVIL (≤ 640px) ==== */
@media (max-width: 640px) {
  .check-card label { font-size: 16px !important; }
  .legal-box p { font-size: 15px !important; }
  .legal-check label { font-size: 16px !important; }
  .section-block .label { font-size: 15px !important; }
  .section-block h3 { font-size: 19px !important; }

  /* Checkboxes aún más grandes en móvil para tocar bien */
  .check-card input[type="checkbox"],
  .legal-check input[type="checkbox"] {
    width: 24px !important;
    height: 24px !important;
  }
  .check-card { padding: 16px !important; }

  /* Métodos de pago: tarjetas en columna en móvil */
  .pay-methods, .payment-methods {
    grid-template-columns: 1fr !important;
  }
}

/* ============================================================
   ANTI-ZOOM iOS + LEGIBILIDAD — GLOBAL
   En iOS Safari, cualquier <input>/<select>/<textarea> con
   font-size menor a 16px provoca un zoom automático al enfocarlo,
   haciendo que la pantalla "salte" (se agranda y achica).
   Forzamos 16px mínimo en TODOS los campos de todo el sitio.
   ============================================================ */
input:not([type="checkbox"]):not([type="radio"]):not([type="range"]),
select,
textarea,
.input, .select, .textarea {
  font-size: 16px !important;
}

/* Evitar que el navegador reescale el texto solo al rotar/zoom */
html {
  -webkit-text-size-adjust: 100%;
  text-size-adjust: 100%;
}

/* ============================================================
   LEGIBILIDAD — WIZARD CREAR EVENTO
   ============================================================ */
.spa-page[data-route="/organizador/crear-evento"] .panel h2 {
  font-size: 24px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .panel .sub {
  font-size: 15px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .label,
.spa-page[data-route="/organizador/crear-evento"] .field .label {
  font-size: 14px !important;
  color: #1F1F1F !important;
}
.spa-page[data-route="/organizador/crear-evento"] .field-hint {
  font-size: 12.5px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .step {
  font-size: 14px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .sport-card .sport-desc {
  font-size: 13px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .subtipo-chip {
  font-size: 14px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .item-row .input,
.spa-page[data-route="/organizador/crear-evento"] .item-row .select {
  font-size: 16px !important;
}
.spa-page[data-route="/organizador/crear-evento"] .item-row .label {
  font-size: 12.5px !important;
}

/* ============================================================
   ESTABILIDAD DE ANCHO — evitar que el wizard "salte" entre pasos
   Reservamos el espacio del scrollbar para que el ancho no cambie
   cuando un paso tiene más contenido (scroll) que otro.
   ============================================================ */
html {
  scrollbar-gutter: stable;
}
/* El contenedor del wizard mantiene ancho fijo entre pasos */
.spa-page[data-route="/organizador/crear-evento"] .wiz-wrap,
.spa-page[data-route="/organizador/crear-evento"] .panel {
  max-width: 900px;
  width: 100%;
  box-sizing: border-box;
}
/* Las imágenes y mapas dentro del wizard nunca exceden su contenedor */
.spa-page[data-route="/organizador/crear-evento"] img,
.spa-page[data-route="/organizador/crear-evento"] .map-preview,
.spa-page[data-route="/organizador/crear-evento"] iframe {
  max-width: 100% !important;
  height: auto;
}

/* En móvil, el wizard usa todo el ancho con padding cómodo */
@media (max-width: 640px) {
  .spa-page[data-route="/organizador/crear-evento"] .wiz-wrap {
    padding: 0 14px !important;
  }
  .spa-page[data-route="/organizador/crear-evento"] .panel {
    padding: 20px 16px !important;
  }
  .spa-page[data-route="/organizador/crear-evento"] .panel h2 {
    font-size: 21px !important;
  }
  .spa-page[data-route="/organizador/crear-evento"] .label {
    font-size: 15px !important;
  }
  /* Grid de deportes en 2 columnas en móvil (no 3 apretadas) */
  .spa-page[data-route="/organizador/crear-evento"] .sport-grid {
    grid-template-columns: repeat(2, 1fr) !important;
  }
}

/* ============================================================
   FIX GLOBAL DE CONTRASTE (solicitado en el documento)
   Evita "letras negras sobre fondos oscuros": fuerza texto claro
   en cualquier sección con fondo oscuro (morados intensos / verdes).
   Se respeta el color propio de elementos que ya lo definen inline.
   ============================================================ */
[style*="var(--purple-9"]:not(.badge):not(.btn):not(.btn-primary):not(.btn-amber),
[style*="var(--purple-8"]:not(.badge):not(.btn):not(.btn-primary):not(.btn-amber),
[style*="#063734"], [style*="#08514D"], [style*="#0A6E69"], [style*="#08514d"] {
  color: #ffffff;
}
[style*="var(--purple-9"] h1, [style*="var(--purple-9"] h2, [style*="var(--purple-9"] h3,
[style*="var(--purple-9"] h4, [style*="var(--purple-9"] p, [style*="var(--purple-9"] li,
[style*="var(--purple-9"] span:not([style*="color"]), [style*="var(--purple-9"] label,
[style*="var(--purple-8"] h1, [style*="var(--purple-8"] h2, [style*="var(--purple-8"] h3,
[style*="var(--purple-8"] h4, [style*="var(--purple-8"] p, [style*="var(--purple-8"] li,
[style*="#063734"] h1, [style*="#063734"] h2, [style*="#063734"] h3, [style*="#063734"] h4,
[style*="#063734"] p, [style*="#063734"] li,
[style*="#08514D"] h1, [style*="#08514D"] h2, [style*="#08514D"] h3, [style*="#08514D"] p {
  color: rgba(255, 255, 255, 0.94) !important;
}
[style*="var(--purple-9"] .muted, [style*="var(--purple-8"] .muted,
[style*="#063734"] .muted, [style*="#08514D"] .muted {
  color: rgba(255, 255, 255, 0.72) !important;
}

</style>
</head>
<body>

<!-- ===== PUBLIC SHELL NAV ===== -->
<div id="shell-public" class="spa-shell-public">
  <nav class="spa-public-nav">
    <div style="display: flex; align-items: center; gap: 28px;">
      <a class="logo" data-route="/">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK4AAAB4CAYAAABra8ncAAAgGklEQVR4nO2debglRXm436+WPss9d1ZmWGRxQWQbEIEAIjpA2MaBuPwiKG4ICnFDJErUGIlJ3GIWDT4xLiQRVECMRKMhGHBAglFBEyKbBAVBUUFmhpm5957TXfX9/qjuc869M6gkMDOQep+n55zbS3V11VdffUv1GchkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwms/Vh6i2TeUwggNvSlchkHg62+dJut3f2vvuM+k/ZQvV5XJOns0cGC4SJiYml3nfODZVcr6qN5s2Cm9kqcQBF0XuBs517veupd53L62NZMWS2ShyAb897sacIvphUb7vB2uI4kqa1v/zyTGbz4wH85KJXONDWU3Yvi133qBzmZvbf35NNhMxWiANoTS46xeO02OXJYeLdf9z3rY66onPm+DmZzNZC0rTd3qnOd7Q9b3618NrrKn/Qs9TDA5O77764Pi9r3MxWQxLaVu80X0yoF1PteN03QuuCz5YO1HcXfqQ+L9u2ma2GWmi7rypak2qg2vvTnw0Lp8soS7ePhS1Kv3DhXvW5OZqQ2SpIQuu7pxbtSQWqZ/zZX4RlqpFz3lkWoK4zP4fAMlsVtdC2Tm115itQLXvnueEY1ei+/8PoFyyuvG2rLTrH1+dnpyyzxWk07WmtzgIFqqe+4cxwoqpuoxrlDWdVBahrz7sNKEgOWXbK/o9iSFrLPsTm+NXTcXPeQ5Xx62xJaE1rKLS7vPjk8DJV3acKkZv/O7YmJkvvu+qK9tvrOrX+l/fc2re5bfyrtv8zg/jh2IebahR5mGX8UrxvvaZoJ/Ng+988JrykqnTlzCA61ehPeXXwEF173v1A75G6Z+bXY2saEQKo9939RePKiOyqGr2IQTWqiFFARMw9IuUnBoPBbc0149cDONd+lqocK8JOQKGKiNTnaf3MohakvjZK3RRCBERjVJlwRWtFOfOgLtr36br86lWmNzGh/yKWn37vZlq/cYBGNUZV7yfGVYDBgKoGMIiogGi6a4T0HEgaV1rXONVZ62+jI+MoqgYzboZImHO2zDp/TnuoRhExoBEFFRFDxGJQkECMghhVIqoIiBiQyFALCKKDKrTPgLVrALztvEdFn6qqpWDM8G7pSSJRvXFy4WAwfRn1IqRf1vkPl61FcA0Qve98EOybAUG1bnpJPSu1vCEo4QFjwv79fv8uZguvd7b1cTH+5em8WmJ19Anp7DQKmvI2lhYxlqq/QXu77Mzya7/Owh134PbpAde1HK2TTiZ+7iJoz4cQpCk/la2p4HGafVrffPgszTjSh6zHxhWrpX3sNsPidXjK7NvHiBiTnr958I3uJXVZcfQsY8c0DL5cxf7xgHY6nSdUpdyTBqPW9xtdk9pZUQ3HhtD/Fx4Fwd0aPGALBOc6rxXs2QBRw6dE9PIY41pqh8cYK7HSV2HtSsEsipW+Hvhd0jNEIDrX/oxgX1iX8XmR+HlCXBtn38+AVCDvFnH7qWhAx+03RYwlVH38/El3yBf/kckdd2DdoOTGTqGtNetg1TWCFEoM6QIItdhY1XC+iL1SJM7Q9KbUj5kUpYz60dYjFGlEeNyQDGlAlyK6Y4z6LjBL0BAVrhKNVxtrfygio/sMP63OkhNbK3ZVKyJVCOGpGvkjEIPE9zhnv0NQi0VAYijD81XsSaAViIEYxcZziEnaq74egTEK8VrV6n2qGEAsrlLD80BORfVHIfRX1TWY0wWPfZrpr+Nd987CT4bCdz/yS85f6l13XeEng7PtnwDzaFZo+fZHvZ9U7ybU2s77f8V9W8517vO+p77oBe976n0vet+LvphUX/SitV6Xf/Vf9UWq+tLBID6x0uiqoD3V2DrqWPUQfXte9L4XnZsove+pt+2PPjLNMruu3nauK3xPne38l7Wt5f/bAo1pneZcT73rPggsnHvcufbnU5tMzBS+p851vtTUBcDa1sXe9dS51ukbX9u5wPueWtu6oN71uMwiWgBrW0d6P6HeTwyKongaSdMUzPZQWwDetz9c+J56N6Het15ZX//+IgmfWml9oC7bsXFkoQU449snp/v1yqLoxUZwi6IXi/b8CMTf+Pgn9CTVeHI50MOCRhM0TgwGcUI1tt/9J+pAfWdBI7jRu4lQFMUe4/f5X2y+LqNtbefawk+q951VwIL62cz/sNwCsM51rvJ+Ur3vfo2kOHy9Wehu51x3Xd0mVeF7lffd/cf6bMLa9i+c65atVmvX+nmbvlqcFMKEetN+xVg/POJsaVNBAAzyfMGoEm4cDAa3k6bfwZxzFRBr+WAI8RTETKDmFc60JsS4twLEGD4YtP9W0nMFNuXqQDAqKxDROWUj1tGfXiN7veOd+uTTTtWqKonG8Z0I3oFGIwIqhz5TBQMxQvK8rGr4zzI5jAr0H8bzK6OpvqmTA/rWts41xh4aNdxdtcyLKFlDErCyvuZh240TTGzbR/cDEI1fq+/ZbMHa6mAR3yO1f6ExXFOG6Z8ATwJKY/xzROwi0fDtfr9/x9hzhMJ2D1aRbUCnbMGqcoa6fR5fNJ3VcrZze1FMqvedd9f7HmpAWQDv2+f5pHVL77ta+J5a2/mzsXM2lQho/p7nXOdntUYJRTEZvZ+Irc6CCMRdXvxSfZFqfF5ZxperxicNQqQM2o2qnRB0QjVO3H9/LBZvF7201BeTA+8m1Ln2H4zXcRM8rDCd936Zc51+0l5pZqGOLc95NluX/atiqi3AGNM+sW676Fz70LEyHIC17Y/WbTNIs0l3nXOdKec60851ppztzHg3Ea1tjfdVY659KJlc3X/bRD0fUbakxjVAcK59oGB2VY2qypfrYw/lXisgxugHYwivErFWEUIs/zyE/tmkDohQh2Q2cb+i6D5bVZaCBhCjqoj1DKbXsPSQQ3nG+R/XfghMOMMdVeSH3lAkxxxjDBoidvFiZN990Ku+qpi20xgVzCsL131hRE1TBwMRTIBYYOScwWDqK4wEOxRF54Uxmt8X0QFgiaCiIiIRZTsRU2gMt1ex/+m6/lX9GVuu8wZFXh1VWwy9em3CZTpS5IqqitRhB0UWpobUe6tq5rtj7RoBD3LEWHshYubEqFUVFZHwlTnXWlVZbgTRqFfVx2xd50ecLSm4qblVThAjRA23VtX0d+pjzRRoGAnxsIH6/f6d1hZ/a8W+NsbwpyH038ocoV0CvftgmjnTaYz6vBQT1ghqxDrCYIrujrtw4KWfg3YbFwIzAW4A3E9/LjzwAOyxO8SIxKhYgznsUOJVVzSxJxExT1JAxuJUw9GngpFw29hzSF2Xk4yYpw/DYGZMRUlzJReRTAPHcDpvHa7Gfpg6Kjw7ELwxs8Nhw1pdB0wxGkjRe7+3quw61mZzC40KBvTOqqq+O7Zfvfe7o7IHKCr6r2PP+qiwJVcyBcApPDf1tX6VUQcZSIkE54pzSA3QNHBj634kxPIDIUyPC60FonOdgx6wrXfW5xpG9mAH5Gia98HEoDFgvOWAiy+ivcP2lFVFx1q+MxOYcUbM6Wdg/v5TSRZDHAoqhxySitHY9G5Mg4GY7qURKAUiqv9W24ONTRuACUEOrc+r6mvqjXqLosK4ZkuBNTGnqBIV7Ssa0HS+qkZNAzKkRMiwvFh/j3UbIxL+pS53aFap2qPrvIMFtfU1FcQKjSUa+6BBVP+ZZMe75npVdwRifFS9u6pmrmfYJo8OW0rj1rFbt7+QRmmM2oRcGmGLwGFg3wH8NbCOMRNgMBjcDJzDSCgdUHn8vsAVYuzvhkBkTFM51z5QRHZqzAQxQjmzjmd86kJZ8syDtV+W9Lznrg0D7pwo8J+5BP3iF9D2S9KoEUFMkly7375UC7aBB9eBdQAyzMqNqJNP8cqx52605oGI2V5HAw6Ggq0KYjTqj6ow/Z9j7RKAroocDhhJA39c+Ugt3nNrMp5xcBBLEb16rI7NaUfXjuZ9MeqZzsXvkDJtcXRuy/T77ucwQ12fps5H15/XARuaPuZRYksJbm0m2N/CGNEY7g6h/436WBweF3kW2I61rbeE0P/9ur7VWBmGcaH1fj+N7goR03Yufrksh+XV9pocX2eoojhnBtNr2O0tv8fOLztZpwclrcIzKCuu9wXme7cirz0DNR699VYIAXFWU6ojiixditl3GfHqr6G+QGKUWemrhFEUFWnW6o4iCIbjUl0IJKer8eypn8kgXE0yd4YOn2u3D5BodlRNeeS5+baU2q7rMZaWaHLbiFjVeHNZDv6bkbYNExMT2/b7eoRquNq5eGpV9e8YzI3rAJsImEQmJxczHQ5JiUhpzIRHNSu7pUyFAFjFrCCljK5iNEohCdtSVZ4JRMGc2Wq1nkjToYlGAzmgcq7zG6r+ChG7DVFvmJ6evpfZU7NVZUWyM7wpp9ew3YoT2PUD76VfVeAsHSLX92G66uNOOUV07VowBfzwLvRnP6+TpTEJMWAOe1aq/niKdPQ1ChjV+KOqmmls99qMQETNMSkGh5l9tUBdoohePlZqGsxBjqq/DtN2m2KUhh1L3iVPDVW9ipH5FQAzGFRvEol/GcL04bVZ05gBZmyTWYXW/VX0q2eLyGIlThsTGsF9VMNgW0JwLaDed/cVkb1RFaN8sT7WNBTWFs8SMfNASxHbC8H8IbNjnjAU2vZzROQKEbO4drrGO8YA2vXdfUTMHmKsVjPrTW/Xp7HXBX9HiJEgho4x3PFgxY96Tvw5b0Ov/3elMw+MQdetVr31tiQLsfbQAQ6to0ljayCG6xFSxymwiqSmmjCdFkWxm4jsVStC0ywxaB5KwKnGqdLJ+HReT7tyVL1vtonAqAr1pzQVGqlyMfW+K0aXLp70vv2iGLmiLGfOGiu7YuQQN1tzr1njRVWPlrRg6YZ+v38nm47qPKJsCcGtPerwW2Csarx/EKZX1ccamwmDOSaFdTCgUZCXeO+XMZr6PVBZ2zoSzFfAzKcOF2ly9GBM0CvheDFWYiwr223ztEsugkULpQyRwhoenBpwfa/AXngJct5fQHeBoHXmwSBy4421FxIVk5rN7vd0ZMESdDBo3JvxHq1Vp3557G8DSIz2CBCnaIWOacP0kTpc9btMT/+YsRmmDTsBe9eDU1K7DJ3CJGRJp0Z0TOC0HkSKQXV1L7S/2bT3okUqrZb7VxH7Jms7t1nT/p61nf+ytnPTaGvfZE3nZmtb34beovraRri9qixPOl7HbflHlS0huAEwglmZnAi9BniA0cNWQAFyZB2XtICKGKdq30PqIA+URdF9rhH7TyKmm7xfvGr4WVXN3FCXNZyaQVZiBC2nzJM++Ula+z2dflmqeAdlxbelIHz3JnGv/x3UddCpB9GZdeiG9WiMxK/XMXWRtMWI2XapsM/eoDNgzHCiT3UUqxrXe2+uGXvupPxEjgZBkkkwnsJrNBxAIwTNFE1pW08TZCJpTjEgtt5G07mIEcSmSFlzfOjsguq/r2Xt6rpdzQMPPPBgv9/fRcScYIzdTYzd0ww3N/q0dg+DVVh//3idvPf7CLIbRKwOBfdRC4M1bG7nrF6+6JeB7JPMQ/0yI7vJAMH77p4oT2akMY1CEMxKa1vLQ+ivMqZ9oqpciIhLGicVEVW/Dqxn5MFrURS7i/P7VVNrdPE5bzfdk17EVFnS9h4fAzfNiKze8KC2XvlSdO0DKp352H33QVKoHabWIRs2YEIkWJf8nxDAGMwzDyFe8zUQ0TFfvokUfGtqauqnjOLRAZiH6qH1RD5XcYxsWRiPJkRAQnA3Gon/jOoeMSUVRiaCghKNqCFlH4ZRZVSDEXVLEBzEr47di3SSPTYZ71qBuuH0QRz5CIpTif8w1o/1fe0RImJU9e6Z2bb8o8oWEVxVu9KIcZGwvirNFYw6J62yVj289lkqEDfUSWIQ4u95316qai6qlVWsNU4UUazl8rSEYCgEVWxNrJB1q137uJVl8b4/cRvKkrb1OOCn6wM/8IX6N5yBfu8/VNsT0rvoAjUnHD9MJaiClgNUmjB/0roCag45JNWtyQFo/RegxMaWHAquta1DRMwSmuhJrXLHYwDpoczqsXarG2DDz8uKFaT07UN57eM2qAGic24Zaq9DJIjVKxvd22yqcpQYDDrUzvXx4cJdk2Y/GU8sNPc4Itm38Vo2QxisYXObCskTVo4HUYFvwvQ9jKayZqQeO2t1ctK7KaSFPRrsxaPl1Om9AxCnqoPS8LW6jNT/r3hFm3VrX22e+GT1n/pb0w+B0loVA+XUgJvbBfaP3y1y6Weh3aX7uYuxJxxPrCqiKkGVKKgWRdK+KUaqaayA3f8ZyORCGAxowqggFo0qEhrBHYb4DPLcWrZibVrMde1qbRnnsfF7W82s1CcFUje1TW+8zx+MWKcaby3L8ubx9ul0OjsYkQPrfZuSh6S6iT+sqlkx5TgxMbEU5CBAVKR51kc1DNawOQXXkKbtPYyYZygqmrzbZrld/UNxE0sROWSj+jXjO9mYMcnIcKqMdaTnJvr9H9VlOUSi/+zFHzKt1tO46KIw2GYbE6zFhCjtQcktrYLy/L/HveddqPW0L7gAu/K5VFPTKT1aVWgVoCyhrKCqoKyEskorwwYlst22yLJlaKzt3FpIFf1BWZa3MPvlTq/DqEAt+cPnGv2brN/4Akaaa3yJ5sNZ0ujT+XpMciz12vqOrfqYrSpdjphunX3blNClOmi8luR/NNe6cqY8TDALlThjTPj6qC8efTa34BKjOQ4xBRqmq0o+Q2qMGVIqMlgbDxFkMqUspTG25jappHejhnsVwBi9rC6vBPq+NXmSDGZew9/9fRUPOtCUP7mX8hPny3YP3M+9hWftP31VijedgW67nbavvBL7/16AgppuB7xHvE/Om/cpuuAd4l29z6GFR6zFHHUko5k1dZwol9XPVTVbURRPRmQ3mjlExxyzkTtjk3FpT3audcb49f+DrU7LykGgRPQSkiD26y2oyjEb1WA2ktS8vaR+tubaSo05on657r/6/f4P2AxhsIbNaePWHSonAKhyX1GwH3Sfng6rAak0curQ6mvSPzKcg4fMCiFpepVQVY0tuissGPVuPtMbPiKnnR7jU55k5Kw3S7zkczz1rz7M2m234+5rrpfilJM0lgF35FHofT9n8Mnzwfk0kcvozbDGQ1SRtFkLzoMxSKuAQakiFmKsp/Jk4hZFdyVoHS2RSpXnSoqlpvd2Zo+78S+SkmLy19aal0K80hi5AxiISMBaJQTqd3JmUa8EU1U1IhIg7hWjbJO0ouyE7a6wqAWJoD5GObK+dFyJjYWDcaqxwoQlBcVxWOtAAmgnRlYYQXQUNx/PbD6qbBZ7hNqGbbfbO4VgbkWlqPe7kQUwqyqhltn6H5U6wJ2cBSGtU5JRx9cOvaN5cVE1Cdb226r86G6ptK9P+cAHmXzL2Xz3O7dhV/6myL0/U9oT6MwG6rUndWlDxh2d4c1kThBesSK+o6jWr/VKnWUbq139sqQy5uPNioTNuXMiRSfmlJZe/Gz21Z7d+Mug9e6mkpqkOTQ/7z9yH2ofktr0UkTrFU/jvVGX62a/kClJn2i1trRxPzZT4qFhc2lcA8RYcaKIdMcc75ErPXayKrbuYpA0nzYvyTa2g8pIF9ZtPVsxCxUxGvnxvVJqX5e87JX03nI2N992F+bFz0fu/YlqexJCBUULbJfxcTEW2hrt1NmVHO6Ldfy/EZjmFe1aMGVo62ht3mxUmGwsxKPwIDJy7sZf4R26p6P2HN5E05fGJHFS9/XodG3aVFAdSxjMtsFmV3P8uAbg3x2cXfb7P2Q8VrwZ2FwaVwB1rnOg0bALECHU7fOQSZam/VMd7ejNWACtKkn7hufWHW3FmDg/Bvlzcb6I/Q20ly2Tnb95XbznF+tk6pijMDf9JzqxGEL9BswsIQxJHsbWV4mR5HiNO4jNu94xNjKQ6gWItWORpGangEY0NK9/DzVzqr+1TdRYRzdBCdVYQWmfGJPU9pgGrJMiQow6NoDS4RijomeqDn4G1thRu25qsDBnvzTmB6AhBLC2ahl351Q59R/1OZtVaMcr+rjCuc7pYt1HNYbKtb19wg3fZvW2T9C1Rx0l9lvXoZ0F6PQamK3IU2f53rgaS9oxlKDDVVGNxKlgBN+tf+ijjtyJQLl+GAPeSDpcL80Rw6hvEjgNU7OHRXO+7YgYMxJwRCmnUOKmOk8oJrW5WqBCxKuWf1WWM2/8n7foL2WzCy1sfsFtUpOJ5zwnfa5fn+qxf/0y6erVv7xeCxfO1hQf+9hIM8+bN+mnq1uxfonOrI1LP/8FmVm5kgeXH4n5xjVJaGc2MHHWmRTHr6R+G0LEOfSuu1hz6uloVSfijBEtp7XYa28m//QDaLebZEqVeN99TP3lhxlcdx24lkhURYxouYHWC3+bzqtfBa0WtaMkunatznzsE9K//J9VXCdpRyNKFTC9rkz+zUfU7LRTysgBDAb0v/ktpt77fuhXSZytFe2v1+6LX0LnjNOJUxvQmRlkchLjPeGWW2Tta9+g2ILhz9eo3jPo+WWsXj3Fsccadt45/trte8MNo329nnL11c1fTcx5i70IubkzZ+NJBsYaIjHeUA+ftFJsanCq+M6SML26mjzn7Xbwgufx4GHLMd+4RultI7r+fibf+S6673gba177OrQ/qBWjUVm3Di1LMK527iwaK2m95jUqy/aSta9/PeLaEAMLL70Y7fcZXHs1YropcjvYgD/0MBZeehHr3v+nVD/+sYoviOWMTr7lrUy8/730v/Il6p/QqcvfgDviuRQnncjqk1+e4sVa0l55PPPe8Tb6f3ehVP99m0prAjSmX9j5yU9Y/+kLsTvtTO8db2PdH5xLvO9+9O57UkvUpoyAGMeZrF69FoDLL3+otnvMscXeOfvtSy6xNx188HwWLSpKERvLshOj7caisKYoXKS0mkTIaBOYr4hBCQZi8ARUlRI23P2D23+xxx7rWbRoHhvKs+L0au0cu8L49/0Ja488GnPt1dBdCOUAjMEdeSTaatE98USwDh0MNNx4Ixve/vvpjrXTImWJ+Dbu+b8l4eZbcGWpVIjdeUcVoP+5S6kXr5F+jijQPfvNlN/6Nut/763DqSWCTL76NVRXX1MHACStLydFHFovPhG95x7Mg2uSR9Wfoth9d+lffz3VD76PFB1EYzK8bYty1dcJq66kd/Y56O23M/1HfziaOotJIcZSRHzU8Pn+zNQXAPu0W+7rVk+Zv1sKIWBtalfjktkjAVQqgnE+RKUy5YZYONc3MzN94+f3w7qfVeanuv7Gp2+/YXPLyqbYYoJ705572rIoFlj1XQWPjfPF+4Xi8OigsOBFxEcoFGOFaNWkd/7AqKSFsRokysSGDff+AtYVpb4m9qe290/etWyf/0n/4IqVylVfRTsLkXKApl8TYs2xK/EHHySy7VJ0ZkrbJxzPvHPewsynLpTy5ptUWl1EjGp/nRQHHYrbblvCmtX0zjtPFFVm+rLuzLO0f9k/iviualSVMMBOLsT/5uGsf+NZTfNKpKI4+DD8sr158OWnMMxQGxEd9NX0FlI8+1nEqSm6530It8uTMMD0J89nw7vORaTO+tZ2q6oi7Q5moHRe/ztMXfiZFPbrLUb7fYghCsaohtXO6RvLgQoisdrebxsjy8VQCZhkIseoxkQC6ixRhUp1UAl2JhpfVv1qujBmzcAN1hvXnYEfKOkFy4dKVmQeNnvu2fOmuKfozYsLvvTlqn3sCnUQi+6i6H0vFp35wYuN8087I2636uqw5LIvxiWX/WNccumlcYc774qLL7o4FmKjLybTTzG150cHcdFlX9Ttbrkl/XINPnps9BAdpPP8RHRFTx0utnfbU3dQ1aV33KFLVq3Spdf+my5dtSo+Ye3auM0/fEEdRptrfHu+Ooi9018Xn6CqxYLF0ULsPPPZcQfVOO+1r0v36CyI3k/E5hd3iva86DGxe9jhcUfV2N5jn+iwsWjPr+vT6xfFpPpW61V1yzwufwJpy0YVtIlrDtm4PqtWCcuXj/1d/7N8eRr1b3yj47zz+kW7+ybgL+zrXl/pt75lwzVfg84CJFQp2mWNajlD6/kvEL/PMmIMwyB69f3v07/kc2maNrVGRCAMaJ92KvH7tzP4+jXg2ilmK6aOsNZp/DoBgAb84c8Rf8ABivPSPGC49Vb6l30RVUTFpPCqGAh9iuOOwyxayMynLoSiA4MNtF72cuzChUz9zcdTooVh6EswRqlm1B1woBQH7M/URz8G4lSMxDrR4CFcPBhMncT4Si1VYdUqy/LlyqpVAsuBVTwHuBpG7bmJXgLgXOBcdM4vAG0xHuvhsFT/PZdM+FseuEV222M7nIt60384OvOFqhpmmZqXCONg3ez4cP3d+F4d+Kyj7JqSvlquBwQperXQbhzqHK1/BK02bQKKmxgFusYyewzWpT0pjJXuOViXIr++19xnGEhNMm809qdEqJRiUpj1gx/xC+W2i07mnnv6jLz/xx2PdcF1QFW44o1I8SGNMcVcW+1RWGluys3YRopTKFVIWi2mFxR0bjdbWydFw6zcrw7LnBOpNaZZJTYaGVqXvwkRapIVWo2l+F39Rn01WtY6+p3fVLKKpGurClVdbYQblfjxspz59Hg1f92GfKzxWBZcAeh2u9uWpd6RnGT9pop8idi/TkRGiw9KRr+61fzN2L7yIb6TVjT65txyPFGxcXmlR3w52uVHZWpzfenBl2PH0/3SMCg3ndGaW308lOlcvCe0Wq2frl+//r7xdplbRmbrwQAU3e5xRdF+c7vd3nlLV2gLIzxOHbFN8VjWuJui6bzH3U9b/goet7bs4xnh1/svpDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwm8zjm/wM2ec9J+AJIXQAAAABJRU5ErkJggg==" alt="Match Sport" style="height:100px; width:auto; display:block;">
      </a>
      <select class="select ms-country-select" title="Selecciona tu país" style="width:auto; padding:6px 10px; margin-left:8px;"></select>
      <div class="nav-links">
        <a data-route="/">Inicio</a>
        <a data-route="/eventos">Explorar eventos</a>
        <a data-route="/como-funciona">Cómo funciona</a>
        <a data-route="/resultados">Resultados</a>
      </div>
    </div>
    <div class="nav-actions" id="public-nav-actions">
      <!-- Filled dynamically based on auth state -->
    </div>
  </nav>

<section class="spa-page" data-route="/" data-shell="public" id="page-index">


<!-- NAV -->
<!-- HERO -->
<section class="hero">
  <div class="hero-blob"></div>
  <div class="hero-inner">
    <div>
      <div class="hero-badge">
        <span class="dot"></span>
        Plataforma de eventos deportivos en Latinoamérica
      </div>
      <h1>Conectamos los deportes<br><span class="purple">en una misma app.</span></h1>
      <p class="hero-desc">Desde tu carrera de trail hasta el torneo de fútbol del barrio. Inscripciones, ficha médica y diplomas verificables, con pagos locales en tu país.</p>
      <div class="hero-ctas">
        <a href="#/login" class="btn btn-primary btn-lg">
          Empezar gratis <i class="ti ti-arrow-right" style="font-size: 18px;"></i>
        </a>
        <a href="#/como-funciona" class="btn btn-outline btn-lg">
          <i class="ti ti-player-play" style="font-size: 17px; color: var(--amber-500);"></i> Ver demo 2 min
        </a>
      </div>
      <div class="hero-stats">
        <div>
          <div class="hero-stat-value" style="color: var(--purple-700);" id="hero-eventos-count">0</div>
          <div class="hero-stat-label">eventos activos</div>
        </div>
        <div class="hero-divider"></div>
        <div>
          <div class="hero-stat-value" style="color: var(--amber-500);" id="hero-tickets-count">0</div>
          <div class="hero-stat-label">tickets vendidos</div>
        </div>
        <div class="hero-divider"></div>
        <div>
          <div class="hero-stat-value" style="color: var(--text);">7%</div>
          <div class="hero-stat-label">comisión simple</div>
        </div>
      </div>
    </div>

    <div class="hero-mosaic">

      <div class="photo-card photo-card-1">
        <img src="https://images.unsplash.com/photo-1486218119243-13883505764c?w=500&h=700&fit=crop&q=85" alt="Running"/>
        <div class="photo-tint-purple"></div>
        <div class="photo-overlay"></div>
        <span class="photo-badge" style="left: 14px; background: rgba(245,158,11,0.95); color: white;">
          <i class="ti ti-run" style="font-size: 13px;"></i> RUNNING
        </span>
        <div class="photo-info">
          <div style="font-size: 18px; font-weight: 700; line-height: 1.2;">Trail · Maratón<br>10K · Cross</div>
        </div>
      </div>

      <div class="photo-card photo-card-2">
        <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=500&h=700&fit=crop&q=85" alt="Básquet"/>
        <div class="photo-tint-amber"></div>
        <div class="photo-overlay" style="background: linear-gradient(180deg, transparent 50%, rgba(120,53,15,0.85) 100%);"></div>
        <span class="photo-badge" style="left: 14px; background: rgba(255,255,255,0.95); color: var(--amber-700);">
          <i class="ti ti-ball-basketball" style="font-size: 13px;"></i> BÁSQUET
        </span>
        <div class="photo-info">
          <div style="font-size: 18px; font-weight: 700; line-height: 1.2;">Ligas · Torneos<br>3x3 · Clínicas</div>
        </div>
      </div>

      <div class="photo-card photo-card-3">
        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?w=600&h=600&fit=crop&q=85" alt="Fútbol"/>
        <div class="photo-tint-purple" style="background: linear-gradient(135deg, rgba(11, 139, 132,0.4) 0%, rgba(46,16,101,0.75) 100%);"></div>
        <div class="photo-overlay" style="background: linear-gradient(180deg, transparent 45%, rgba(30,10,70,0.9) 100%);"></div>
        <span class="photo-badge" style="right: 14px; background: rgba(245,158,11,0.95); color: white;">
          <i class="ti ti-ball-football" style="font-size: 13px;"></i> FÚTBOL
        </span>
        <div class="photo-info">
          <div style="font-size: 18px; font-weight: 700; line-height: 1.2;">Ligas barriales<br>Babyfútbol · Senior</div>
        </div>
      </div>

      <div class="floating-icon" style="top: 10px; right: 220px; width: 56px; height: 56px; border: 3px solid var(--amber-500); box-shadow: 0 10px 26px rgba(245, 158, 11, 0.5);">
        <i class="ti ti-bike" style="color: var(--amber-700); font-size: 28px;"></i>
      </div>
      <div class="floating-icon" style="bottom: 280px; right: 30px; width: 52px; height: 52px; border: 3px solid var(--purple-700); box-shadow: 0 10px 26px rgba(11, 139, 132, 0.45);">
        <i class="ti ti-swimming" style="color: var(--purple-700); font-size: 26px;"></i>
      </div>
      <div class="floating-icon" style="bottom: 10px; right: 0; width: 48px; height: 48px; border: 3px solid var(--purple-500); box-shadow: 0 8px 22px rgba(76, 29, 149, 0.45);">
        <i class="ti ti-mountain" style="color: var(--purple-700); font-size: 24px;"></i>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORÍAS -->
<section class="cat-section">
  <div class="cat-head">
    <div class="section-label">EXPLORA POR DEPORTE</div>
    <h2>¿Qué evento estás organizando?</h2>
    <p class="muted mt-2" style="font-size: 16px;">Match Sport se adapta a cualquier deporte</p>
  </div>

  <div class="cat-grid">
    <a href="#/eventos" class="cat-card" data-sport-filter="running">
      <div class="blob" style="background: #0B8B84;"></div>
      <div class="cat-icon-box" style="background: var(--purple-100);">
        <i class="ti ti-run" style="color: var(--purple-700); font-size: 22px;"></i>
      </div>
      <h4>Running</h4>
      <p>Trail, maratón, 10K, cross country</p>
      <span class="cat-link" style="color: var(--purple-700);" data-sport-count="running">0 eventos →</span>
    </a>

    <a href="#/eventos" class="cat-card" data-sport-filter="futbol">
      <div class="blob" style="background: #F59E0B;"></div>
      <div class="cat-icon-box" style="background: var(--amber-50);">
        <i class="ti ti-ball-football" style="color: var(--amber-700); font-size: 22px;"></i>
      </div>
      <h4>Fútbol</h4>
      <p>Ligas barriales, babyfútbol, senior</p>
      <span class="cat-link" style="color: var(--amber-700);" data-sport-count="futbol">0 eventos →</span>
    </a>

    <a href="#/eventos" class="cat-card" data-sport-filter="basquet">
      <div class="blob" style="background: #0B8B84;"></div>
      <div class="cat-icon-box" style="background: var(--purple-100);">
        <i class="ti ti-ball-basketball" style="color: var(--purple-700); font-size: 22px;"></i>
      </div>
      <h4>Básquet</h4>
      <p>Torneos, 3x3, clínicas, ligas</p>
      <span class="cat-link" style="color: var(--purple-700);" data-sport-count="basquet">0 eventos →</span>
    </a>

    <a href="#/eventos" class="cat-card" data-sport-filter="ciclismo">
      <div class="blob" style="background: #F59E0B;"></div>
      <div class="cat-icon-box" style="background: var(--amber-50);">
        <i class="ti ti-bike" style="color: var(--amber-700); font-size: 22px;"></i>
      </div>
      <h4>Ciclismo</h4>
      <p>MTB, ruta, gravel, urbano</p>
      <span class="cat-link" style="color: var(--amber-700);" data-sport-count="ciclismo">0 eventos →</span>
    </a>

    <a href="#/eventos" class="cat-card" data-sport-filter="natacion">
      <div class="blob" style="background: #0B8B84;"></div>
      <div class="cat-icon-box" style="background: var(--purple-100);">
        <i class="ti ti-swimming" style="color: var(--purple-700); font-size: 22px;"></i>
      </div>
      <h4>Natación</h4>
      <p>Aguas abiertas, piscina, triatlón</p>
      <span class="cat-link" style="color: var(--purple-700);" data-sport-count="natacion">0 eventos →</span>
    </a>

    <a href="#/eventos" class="cat-card" data-sport-filter="outdoor">
      <div class="blob" style="background: #F59E0B;"></div>
      <div class="cat-icon-box" style="background: var(--amber-50);">
        <i class="ti ti-mountain" style="color: var(--amber-700); font-size: 22px;"></i>
      </div>
      <h4>Outdoor</h4>
      <p>Trekking, escalada, kayak</p>
      <span class="cat-link" style="color: var(--amber-700);" data-sport-count="outdoor">0 eventos →</span>
    </a>

    <a href="#/eventos" class="cat-card" data-sport-filter="fitness">
      <div class="blob" style="background: #0B8B84;"></div>
      <div class="cat-icon-box" style="background: var(--purple-100);">
        <i class="ti ti-yoga" style="color: var(--purple-700); font-size: 22px;"></i>
      </div>
      <h4>Fitness</h4>
      <p>Crossfit, yoga, funcional</p>
      <span class="cat-link" style="color: var(--purple-700);" data-sport-count="fitness">0 eventos →</span>
    </a>

    <a href="#/login" class="cat-card cat-card-cta">
      <div class="cat-icon-box">
        <i class="ti ti-plus" style="font-size: 22px;"></i>
      </div>
      <h4>Crea el tuyo</h4>
      <p>Otra disciplina o evento único</p>
      <span class="cat-link">Empezar gratis →</span>
    </a>
  </div>
</section>

<!-- CÓMO FUNCIONA -->
<section class="steps-section" id="como-funciona">
  <div class="cat-head">
    <div class="section-label">CÓMO FUNCIONA</div>
    <h2>De idea a evento publicado en 5 minutos</h2>
  </div>

  <div class="steps-grid">
    <div class="step-card">
      <div class="step-head">
        <div class="step-num">1</div>
        <i class="ti ti-edit step-icon"></i>
      </div>
      <h4>Crea tu evento</h4>
      <p>Nombre, fecha, lugar y tipos de ticket. El wizard te guía paso a paso.</p>
    </div>

    <div class="step-card">
      <div class="step-head">
        <div class="step-num">2</div>
        <i class="ti ti-share step-icon"></i>
      </div>
      <h4>Comparte el link</h4>
      <p>Tu página pública lista para WhatsApp, Instagram y todas tus redes.</p>
    </div>

    <div class="step-card">
      <div class="step-head">
        <div class="step-num">3</div>
        <i class="ti ti-cash step-icon"></i>
      </div>
      <h4>Recibe inscritos</h4>
      <p>Pagos automáticos por tarjeta, Webpay y Mercado Pago. Dinero a tu cuenta.</p>
    </div>

    <div class="step-card featured">
      <div class="step-head">
        <div class="step-num">4</div>
        <i class="ti ti-certificate step-icon"></i>
      </div>
      <h4>Cierra con diplomas</h4>
      <p>Sube resultados y genera diplomas únicos verificables con QR.</p>
    </div>
  </div>
</section>

<!-- EVENTOS DESTACADOS -->
<section class="events-section">
  <div class="events-head">
    <div>
      <div class="section-label">EVENTOS DESTACADOS</div>
      <h2>Inscríbete a lo que está pasando</h2>
    </div>
    <a href="#/eventos" class="muted" style="color: var(--purple-700); font-weight: 600; font-size: 14px;">Ver todos los eventos →</a>
  </div>

  <div class="events-grid" id="featured-grid">
    <!-- Las tarjetas se inyectan dinámicamente desde los eventos creados -->
  </div>
  <div id="featured-empty" class="featured-empty" style="display:none;">
    <i class="ti ti-calendar-star"></i>
    <h3>Aún no hay eventos publicados</h3>
    <p>Sé el primero en crear un evento deportivo. Aparecerá aquí para que la gente se inscriba.</p>
    <a href="#/organizador/crear-evento" class="btn btn-primary">Crear mi evento</a>
  </div>
</section>

<!-- PRECIOS -->
<section class="pricing-section" id="precios">
  <div class="pricing-head">
    <div class="section-label">PRECIOS</div>
    <h2>Simple y transparente</h2>
    <p class="muted mt-2" style="font-size: 16px;">Sin letra chica. Sin sorpresas.</p>
  </div>

  <div class="pricing-grid">

    <div class="price-card">
      <div class="price-label">Gratuito</div>
      <div class="price-amount">$0</div>
      <div class="price-sub">Para empezar</div>
      <ul class="price-features">
        <li class="pf"><i class="ti ti-circle-check"></i> 1 evento activo</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Hasta 30 inscritos</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Check-in QR</li>
        <li class="pf no"><i class="ti ti-x"></i> Ficha médica</li>
        <li class="pf no"><i class="ti ti-x"></i> Diplomas automáticos</li>
      </ul>
      <a href="#/login" class="btn btn-outline btn-block">Empezar gratis</a>
    </div>

    <div class="price-card featured">
      <div class="price-label">Estándar</div>
      <div class="price-amount">7%</div>
      <div class="price-sub">por ticket vendido · sin costo fijo</div>
      <ul class="price-features">
        <li class="pf"><i class="ti ti-circle-check"></i> Eventos ilimitados</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Inscritos ilimitados</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Ficha médica digital</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Diplomas automáticos</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Soporte por WhatsApp</li>
      </ul>
      <a href="#/login" class="btn btn-amber btn-block">Crear evento</a>
    </div>

    <div class="price-card">
      <div class="price-label">Corporativo</div>
      <div class="price-amount">A convenir</div>
      <div class="price-sub">Para grandes eventos</div>
      <ul class="price-features">
        <li class="pf"><i class="ti ti-circle-check"></i> Todo lo de Estándar</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Marca personalizada</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Integraciones a medida</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Ejecutivo dedicado</li>
        <li class="pf"><i class="ti ti-circle-check"></i> Facturación empresa</li>
      </ul>
      <a href="mailto:contacto@match-sport.com" class="btn btn-outline btn-block">Contactar</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-grid">
    <div>
      <a href="#/" class="logo">
        <img src="data:image/png;base64,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" alt="Match Sport" style="height:100px; width:auto; display:block;">
      </a>
      <p style="font-size: 13px; max-width: 260px; line-height: 1.6; margin-top: 14px;">Conectamos los deportes en una misma app. Hecho para Latinoamérica.</p>
    </div>
    <div class="footer-col">
      <h4>Plataforma</h4>
      <a href="#/login">Crear evento</a>
      <a href="#/eventos">Explorar</a>
      <a href="#/">Precios</a>
      <a href="#/como-funciona">Cómo funciona</a>
    </div>
    <div class="footer-col">
      <h4>Organizadores</h4>
      <a href="#/organizador">Dashboard</a>
      <a href="#/organizador/asistentes">Fichas médicas</a>
      <a href="#/organizador/diplomas">Diplomas</a>
      <a href="#/organizador/checkin">Check-in QR</a>
    </div>
    <div class="footer-col">
      <h4>Empresa</h4>
      <a href="#/sobre-nosotros">Sobre nosotros</a>
      <a href="#/contacto">Contacto</a>
      <a href="#/terminos">Términos y condiciones</a>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2027 Match Sport · Latinoamérica</p>
    <p>match-sport.com</p>
  </div>
</footer>



</section>

<!-- ===== SOBRE NOSOTROS ===== -->
<section class="spa-page" data-route="/sobre-nosotros" data-shell="public" id="page-sobre-nosotros">
  <div style="max-width:820px;margin:64px auto;padding:0 24px;">
    <h1 style="font-size:32px;margin-bottom:16px;">Sobre nosotros</h1>
    <p style="color:var(--text-secondary);line-height:1.7;margin-bottom:16px;">
      Match Sport es la plataforma que conecta a organizadores y deportistas de toda Latinoamérica.
      Creamos una forma simple de publicar eventos deportivos, gestionar inscripciones, cobrar de forma
      segura y entregar tickets con código QR y diplomas verificables.
    </p>
    <p style="color:var(--text-secondary);line-height:1.7;margin-bottom:16px;">
      Operamos en Chile, Argentina, Brasil, Colombia, Ecuador y Perú, con precios en la moneda local
      de cada país y también en dólares. Cobramos una comisión del 7% por inscripción para mantener y
      mejorar la plataforma.
    </p>
    <div class="card" style="margin-top:24px;">
      <h3 style="font-size:16px;margin-bottom:10px;">Nuestra misión</h3>
      <p style="color:var(--text-secondary);line-height:1.7;">
        Que cualquier persona pueda organizar y vivir el deporte sin fricción: menos papeleo, más comunidad.
      </p>
    </div>
  </div>
</section>

<!-- ===== CONTACTO ===== -->
<section class="spa-page" data-route="/contacto" data-shell="public" id="page-contacto">
  <div style="max-width:820px;margin:64px auto;padding:0 24px;">
    <h1 style="font-size:32px;margin-bottom:16px;">Contacto</h1>
    <p style="color:var(--text-secondary);line-height:1.7;margin-bottom:24px;">
      ¿Tienes dudas o quieres publicar tu evento? Escríbenos y te respondemos a la brevedad.
    </p>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
      <div class="card">
        <div class="muted small">Correo</div>
        <a href="mailto:contacto@match-sport.com" style="font-weight:600;color:var(--purple-700);">contacto@match-sport.com</a>
      </div>
      <div class="card">
        <div class="muted small">Soporte a organizadores</div>
        <a href="mailto:soporte@match-sport.com" style="font-weight:600;color:var(--purple-700);">soporte@match-sport.com</a>
      </div>
      <div class="card">
        <div class="muted small">WhatsApp</div>
        <a href="https://wa.me/56900000000" target="_blank" style="font-weight:600;color:var(--purple-700);">+56 9 0000 0000</a>
      </div>
    </div>
    <div class="card" style="margin-top:16px;">
      <h3 style="font-size:16px;margin-bottom:12px;">Envíanos un mensaje</h3>
      <form onsubmit="event.preventDefault(); this.reset(); if(window.toast) toast('¡Mensaje enviado! Te responderemos pronto.');" style="display:grid;gap:12px;">
        <input class="input" placeholder="Tu nombre" required>
        <input class="input" type="email" placeholder="Tu correo" required>
        <textarea class="textarea" rows="4" placeholder="¿En qué te ayudamos?" required></textarea>
        <button class="btn btn-primary" type="submit">Enviar</button>
      </form>
    </div>
  </div>
</section>

<!-- ===== TÉRMINOS Y CONDICIONES ===== -->
<section class="spa-page" data-route="/terminos" data-shell="public" id="page-terminos">
  <div style="max-width:820px;margin:64px auto;padding:0 24px;">
    <h1 style="font-size:32px;margin-bottom:8px;">Términos y condiciones de compra</h1>
    <p class="muted small" style="margin-bottom:24px;">Última actualización: 2027</p>
    <div style="color:var(--text-secondary);line-height:1.7;display:grid;gap:18px;">
      <div><h3 style="color:var(--text);font-size:16px;margin-bottom:6px;">1. Objeto</h3>
        <p>Match Sport es un intermediario que permite a los organizadores publicar eventos deportivos y a los deportistas inscribirse y pagar en línea.</p></div>
      <div><h3 style="color:var(--text);font-size:16px;margin-bottom:6px;">2. Comisión</h3>
        <p>Match Sport cobra una comisión del 7% sobre el valor de cada inscripción. Esta comisión se muestra de forma transparente durante la compra.</p></div>
      <div><h3 style="color:var(--text);font-size:16px;margin-bottom:6px;">3. Pagos e impuestos</h3>
        <p>Los pagos se procesan mediante pasarelas locales según el país. Los impuestos aplicables (IVA / IGV) sobre la comisión de Match Sport y sobre los ingresos del organizador se calculan de acuerdo a la legislación de cada país.</p></div>
      <div><h3 style="color:var(--text);font-size:16px;margin-bottom:6px;">4. Reembolsos</h3>
        <p>Las políticas de reembolso las define cada organizador para su evento. Ante cualquier problema, contáctanos y mediaremos entre las partes.</p></div>
      <div><h3 style="color:var(--text);font-size:16px;margin-bottom:6px;">5. Transferencias a organizadores</h3>
        <p>Match Sport transfiere al organizador el total recaudado menos la comisión. Cada transferencia queda registrada con su comprobante, visible en el panel del organizador.</p></div>
      <div><h3 style="color:var(--text);font-size:16px;margin-bottom:6px;">6. Datos personales</h3>
        <p>Tratamos tus datos conforme a la normativa vigente. Solo usamos la información necesaria para gestionar tu inscripción y el evento.</p></div>
    </div>
  </div>
</section>

<section class="spa-page" data-route="/eventos" data-shell="public" id="page-eventos">


<section class="explore-hero">
  <div class="explore-hero-inner">
    <h1>Encuentra tu próximo deporte</h1>
    <p class="muted" style="font-size: 16px;"><span id="explore-eventos-count">0</span> eventos activos · todos los deportes</p>
    <div class="search-bar">
      <i class="ti ti-search" style="font-size: 20px; color: var(--text-tertiary);"></i>
      <input placeholder="Busca por nombre, deporte o ciudad...">
      <button class="btn btn-primary btn-sm">Buscar</button>
    </div>
  </div>
</section>

<div class="filter-chips">
  <span class="chip active" data-filter="all"><i class="ti ti-sparkles" style="font-size: 14px;"></i> Todos</span>
  <span class="chip" data-filter="running"><i class="ti ti-run" style="font-size: 14px;"></i> Running</span>
  <span class="chip" data-filter="futbol"><i class="ti ti-ball-football" style="font-size: 14px;"></i> Fútbol</span>
  <span class="chip" data-filter="basquet"><i class="ti ti-ball-basketball" style="font-size: 14px;"></i> Básquet</span>
  <span class="chip" data-filter="ciclismo"><i class="ti ti-bike" style="font-size: 14px;"></i> Ciclismo</span>
  <span class="chip" data-filter="natacion"><i class="ti ti-swimming" style="font-size: 14px;"></i> Natación</span>
  <span class="chip" data-filter="outdoor"><i class="ti ti-mountain" style="font-size: 14px;"></i> Outdoor</span>
  <span class="chip" data-filter="fitness"><i class="ti ti-yoga" style="font-size: 14px;"></i> Fitness</span>
</div>

<div class="explore-body">

  <aside class="filters">
    <div class="filter-block">
      <h4>UBICACIÓN</h4>
      <label class="filter-option"><input type="checkbox"> Santiago <span class="count">18</span></label>
      <label class="filter-option"><input type="checkbox" checked> Los Lagos <span class="count">8</span></label>
      <label class="filter-option"><input type="checkbox"> Valparaíso <span class="count">5</span></label>
      <label class="filter-option"><input type="checkbox"> Biobío <span class="count">3</span></label>
      <label class="filter-option"><input type="checkbox"> Online <span class="count">5</span></label>
    </div>
    <div class="filter-block">
      <h4>PRECIO</h4>
      <label class="filter-option"><input type="checkbox"> Gratuito <span class="count">8</span></label>
      <label class="filter-option"><input type="checkbox" checked> $1 - $20.000 <span class="count">22</span></label>
      <label class="filter-option"><input type="checkbox" checked> $20.000 - $50.000 <span class="count">11</span></label>
      <label class="filter-option"><input type="checkbox"> $50.000+ <span class="count">6</span></label>
    </div>
    <div class="filter-block">
      <h4>CUÁNDO</h4>
      <label class="filter-option"><input type="radio" name="when" checked> Cualquier fecha</label>
      <label class="filter-option"><input type="radio" name="when"> Este mes</label>
      <label class="filter-option"><input type="radio" name="when"> Próximos 3 meses</label>
      <label class="filter-option"><input type="radio" name="when"> Este año</label>
    </div>
    <button class="btn btn-outline btn-block btn-sm">Limpiar filtros</button>
  </aside>

  <div>
    <div class="results-info">
      <p class="muted" id="explore-count">0 eventos encontrados</p>
      <select class="select" style="max-width: 200px;">
        <option>Más recientes</option>
        <option>Más populares</option>
        <option>Próximos primero</option>
        <option>Precio menor a mayor</option>
      </select>
    </div>

    <div class="events-list" id="explore-events-grid">
      <!-- Eventos reales inyectados dinámicamente -->
    </div>
    <div id="explore-empty" class="featured-empty" style="display:none; margin-top:20px;">
      <i class="ti ti-calendar-search"></i>
      <h3>No hay eventos publicados todavía</h3>
      <p>Cuando se publique un evento, aparecerá aquí.</p>
      <a href="#/organizador/crear-evento" class="btn btn-primary">Crear un evento</a>
    </div>


    <div class="text-center mt-6">
      <button class="btn btn-outline">Cargar más eventos →</button>
    </div>
  </div>
</div>



</section>

<section class="spa-page" data-route="/evento" data-shell="public" id="page-evento">


<section class="event-hero" id="ev-hero-photo">
  <!-- Foto de portada limpia (sin texto encima) -->
</section>
<div class="event-hero-text">
  <div class="event-hero-text-inner">
    <div class="breadcrumbs">
      <a href="#/eventos">Eventos</a>
      <i class="ti ti-chevron-right" style="font-size: 12px;"></i>
      <a href="#/eventos" id="ev-breadcrumb-sport">Running</a>
      <i class="ti ti-chevron-right" style="font-size: 12px;"></i>
      <span class="current" id="ev-breadcrumb-name">Rally Costero Purranque</span>
    </div>

    <div class="event-tags-row">
      <span class="event-tag-pill" id="ev-pill-sport" style="background: var(--purple-100); color: var(--purple-700);">
        <i class="ti ti-run" id="ev-pill-icon" style="font-size: 12px;"></i> <span id="ev-pill-label">Running · Trail</span>
      </span>
      <span class="event-tag-pill" style="background: var(--amber-500); color: white;">
        <i class="ti ti-shield-check" style="font-size: 12px;"></i> Ficha médica
      </span>
      <span class="event-tag-pill" style="background: var(--green-500); color: white;">
        <i class="ti ti-certificate" style="font-size: 12px;"></i> Con diploma
      </span>
    </div>

    <h1 class="event-title" id="ev-detail-title">Rally Costero Purranque RCP 2027</h1>

    <div class="event-meta-row">
      <span id="ev-detail-date"><i class="ti ti-calendar" style="font-size: 15px;"></i> <span>Domingo 16 mayo 2027</span></span>
      <span id="ev-detail-time"><i class="ti ti-clock" style="font-size: 15px;"></i> <span>08:00 hrs</span></span>
      <span id="ev-detail-place"><i class="ti ti-map-pin" style="font-size: 15px;"></i> <span>Purranque, Los Lagos</span></span>
    </div>
  </div>
</div>

<div class="tabs-bar">
  <div class="tabs-inner">
    <div class="tab-item active" onclick="showTab('info', event)">
      <i class="ti ti-info-circle" style="font-size: 15px;"></i> Información
    </div>
    <div class="tab-item" onclick="showTab('tickets', event)">
      <i class="ti ti-ticket" style="font-size: 15px;"></i> Entradas
      <span class="count">3</span>
    </div>
    <div class="tab-item" onclick="showTab('recorrido', event)">
      <i class="ti ti-route" style="font-size: 15px;"></i> Recorrido
    </div>
    <div class="tab-item" onclick="showTab('organizador', event)">
      <i class="ti ti-building-store" style="font-size: 15px;"></i> Organizador
    </div>
    <div class="tab-item" onclick="showTab('faq', event)">
      <i class="ti ti-help" style="font-size: 15px;"></i> Preguntas
    </div>
  </div>
</div>

<div class="event-body">
  <div>

    <div class="tab-panel active" id="panel-info">
      <h3 style="margin-bottom: 12px;" id="ev-detail-section-title">Sobre la carrera</h3>
      <p class="muted" id="ev-detail-desc" style="line-height: 1.7; margin-bottom: 18px;">
        La cuarta edición del Rally Costero Purranque recorre los paisajes más espectaculares del sur de Chile. Dos distancias, cronometraje oficial, hidratación cada 4 km y ambulancia en ruta.
      </p>

      <!-- Cronograma del evento (se llena dinámicamente) -->
      <div id="ev-cronograma-wrap" style="display:none; margin-bottom: 22px;">
        <h4 style="margin-bottom: 12px; display:flex; align-items:center; gap:6px;"><i class="ti ti-calendar-event" style="color: var(--purple-700);"></i> Cronograma</h4>
        <div class="evento-crono" id="ev-cronograma"></div>
      </div>

      <!-- Altimetría y recorrido (GPX) -->
      <div id="ev-recorrido-wrap" style="display:none; margin-bottom: 22px;">
        <h4 style="margin-bottom: 12px; display:flex; align-items:center; gap:6px;"><i class="ti ti-chart-line" style="color: var(--purple-700);"></i> Recorrido y altimetría</h4>
        <div class="ev-altimetria-grid" id="ev-altimetria-grid"></div>
        <div id="ev-gpx-links" style="margin-top: 12px;"></div>
      </div>

      <!-- Reglamento descargable -->
      <div id="ev-reglamento-wrap" style="display:none; margin-bottom: 22px;">
        <a id="ev-reglamento-link" href="#" download class="reglamento-download">
          <i class="ti ti-file-text" style="font-size: 22px; color: var(--purple-700);"></i>
          <div style="flex:1;">
            <div style="font-weight:600; color:var(--text); font-size:14px;">Reglamento del evento</div>
            <div class="small muted" id="ev-reglamento-nombre" style="font-size:12px;"></div>
          </div>
          <span class="btn btn-outline btn-sm"><i class="ti ti-download"></i> Descargar</span>
        </a>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 22px;">
        <div class="info-card">
          <div class="info-label">Largada</div>
          <div class="info-value">Plaza de Armas Purranque</div>
        </div>
        <div class="info-card amber">
          <div class="info-label">Distancias</div>
          <div class="info-value">8 km · 16 km</div>
        </div>
        <div class="info-card">
          <div class="info-label">Categorías</div>
          <div class="info-value">Open · 40+ · 50+ · Junior</div>
        </div>
        <div class="info-card">
          <div class="info-label">Entrega de kits</div>
          <div class="info-value">06:30 - 07:45</div>
        </div>
      </div>

      <h4 style="margin-bottom: 10px;">Incluye</h4>
      <div class="flex" style="flex-wrap: wrap; gap: 6px;">
        <span class="feature-pill"><i class="ti ti-medal" style="font-size: 14px; color: var(--purple-700);"></i> Medalla finisher</span>
        <span class="feature-pill"><i class="ti ti-droplet" style="font-size: 14px; color: var(--purple-700);"></i> Hidratación cada 4km</span>
        <span class="feature-pill"><i class="ti ti-stopwatch" style="font-size: 14px; color: var(--purple-700);"></i> Cronometraje oficial</span>
        <span class="feature-pill"><i class="ti ti-certificate" style="font-size: 14px; color: var(--amber-600);"></i> Diploma digital</span>
        <span class="feature-pill"><i class="ti ti-ambulance" style="font-size: 14px; color: var(--red-600);"></i> Asistencia médica</span>
        <span class="feature-pill" id="ev-pill-polera"><i class="ti ti-shirt" style="font-size: 14px; color: var(--purple-700);"></i> Polera oficial (Premium)</span>
      </div>

      <!-- Galería de fotos (se llena dinámicamente si el evento tiene fotos) -->
      <div id="ev-detail-gallery-wrap" style="display:none; margin-top: 24px;">
        <h4 style="margin-bottom: 10px;">Galería</h4>
        <div class="ev-gallery" id="ev-detail-gallery"></div>
      </div>

      <!-- Video de YouTube (se llena dinámicamente si el evento tiene video) -->
      <div id="ev-detail-video-wrap" style="display:none; margin-top: 24px;">
        <h4 style="margin-bottom: 10px;">Video</h4>
        <div class="ev-video-wrap" id="ev-detail-video"></div>
      </div>

      <!-- Listado de corredores inscritos -->
      <div id="ev-inscritos-wrap" style="margin-top: 28px;">
        <h4 style="margin-bottom: 12px; display:flex; align-items:center; gap:6px;">
          <i class="ti ti-users" style="color: var(--purple-700);"></i> Corredores inscritos
          <span id="ev-inscritos-count" class="inscritos-count">0</span>
        </h4>
        <div class="inscritos-table-wrap">
          <table class="inscritos-table" id="ev-inscritos-table">
            <thead>
              <tr><th>Nombre</th><th>Distancia</th><th>Categoría</th><th>Ciudad</th><th>Club</th></tr>
            </thead>
            <tbody id="ev-inscritos-body"></tbody>
          </table>
          <div id="ev-inscritos-empty" class="inscritos-empty" style="display:none;">
            Aún no hay inscritos. ¡Sé el primero en inscribirte!
          </div>
        </div>
      </div>
    </div>

    <div class="tab-panel" id="panel-tickets">
      <div class="welcu-tickets-head">
        <h3>Selecciona tus entradas</h3>
        <div class="welcu-currency">
          <span class="small muted">Moneda:</span>
          <select class="select" id="ev-currency" style="width:auto; padding:6px 10px;">
            <option value="CLP">Peso chileno (CLP)</option>
            <option value="ARS">Peso argentino (ARS)</option>
            <option value="BRL">Real brasileño (BRL)</option>
            <option value="COP">Peso colombiano (COP)</option>
            <option value="PEN">Sol peruano (PEN)</option>
            <option value="USD">Dólar (USD)</option>
          </select>
        </div>
      </div>

      <!-- Encabezado de columnas (desktop) -->
      <div class="welcu-ticket-header">
        <span class="col-ticket">Ticket</span>
        <span class="col-precio">Precio</span>
        <span class="col-fee">Fee</span>
        <span class="col-total">Total</span>
        <span class="col-cant">Cantidad</span>
      </div>

      <!-- Las filas de tickets se generan dinámicamente aquí -->
      <div id="ev-buy-tickets"></div>

      <!-- Código promocional -->
      <div class="welcu-promo">
        <button type="button" class="welcu-promo-toggle" id="ev-promo-toggle">
          <i class="ti ti-tag" style="font-size:15px;"></i> Aplicar código promocional
        </button>
        <div class="welcu-promo-input" id="ev-promo-box" style="display:none;">
          <input class="input" id="ev-promo-code" placeholder="¿Tienes un código promocional?">
          <button class="btn btn-outline" id="ev-promo-apply">Aplicar</button>
        </div>
        <p class="small" id="ev-promo-msg" style="display:none; margin-top:6px;"></p>
      </div>

      <!-- Total general -->
      <div class="welcu-total-row">
        <span>Total:</span>
        <span class="welcu-total-amount" id="ev-grand-total">$0 CLP</span>
      </div>

      <button class="btn btn-primary btn-block btn-lg" style="margin-top: 16px;" onclick="continuarInscripcion()">
        Continuar con la inscripción <i class="ti ti-arrow-right" style="font-size: 16px;"></i>
      </button>
      <p class="small muted" style="text-align:center; margin-top: 8px;">Siguiente: tus datos y ficha médica</p>

      <!-- Medios de pago -->
      <div class="welcu-paylogos">
        <span class="small muted">Pago seguro con:</span>
        <span class="paylogo">Webpay</span>
        <span class="paylogo">Redcompra</span>
        <span class="paylogo">Visa</span>
        <span class="paylogo">Mastercard</span>
        <span class="paylogo">Amex</span>
        <span class="paylogo">Transferencia</span>
      </div>
    </div>

    <div class="tab-panel" id="panel-recorrido">
      <h3 style="margin-bottom: 12px;">Recorrido del evento</h3>
      <div style="background: var(--bg-secondary); border-radius: 12px; padding: 60px; text-align: center; color: var(--text-tertiary);">
        <i class="ti ti-map-2" style="font-size: 48px; color: var(--purple-400);"></i>
        <p class="mt-4">Mapa interactivo del recorrido</p>
        <p class="small">8 km y 16 km a lo largo de la costa</p>
      </div>
      <h4 style="margin-top: 20px; margin-bottom: 12px;">Puntos clave</h4>
      <ul style="list-style: none; padding: 0; font-size: 14px; color: var(--text-secondary); line-height: 1.8;">
        <li>🏁 <strong>Largada:</strong> Plaza de Armas Purranque · 08:00</li>
        <li>💧 <strong>Hidratación 1:</strong> Km 4 · Costanera</li>
        <li>💧 <strong>Hidratación 2:</strong> Km 8 · Mirador (también meta 8K)</li>
        <li>💧 <strong>Hidratación 3:</strong> Km 12 · Caleta</li>
        <li>🏆 <strong>Meta:</strong> Plaza de Armas · Premiación 11:30</li>
      </ul>
    </div>

    <div class="tab-panel" id="panel-organizador">
      <h3 style="margin-bottom: 16px;">Organiza este evento</h3>
      <div style="display: flex; gap: 16px; padding: 18px; background: var(--bg-secondary); border-radius: 12px; align-items: center;">
        <div class="avatar avatar-lg" style="background: var(--purple-700);">CC</div>
        <div style="flex: 1;">
          <div style="font-weight: 700; font-size: 16px; margin-bottom: 2px;">Club Cumbres de Purranque</div>
          <div class="small muted">12 eventos organizados en Match Sport · 4.9 ★</div>
        </div>
        <button class="btn btn-outline btn-sm">Ver perfil</button>
      </div>
      <p class="muted mt-4" style="line-height: 1.6;">
        Club deportivo con más de 10 años organizando eventos en la región de Los Lagos. Especializado en running, trail y carreras de montaña.
      </p>
    </div>

    <div class="tab-panel" id="panel-faq">
      <h3 style="margin-bottom: 16px;">Preguntas frecuentes</h3>
      <div style="display: flex; flex-direction: column; gap: 12px;">
        <div style="background: var(--bg-secondary); padding: 16px; border-radius: 10px;">
          <strong style="font-size: 14px; display: block; margin-bottom: 4px;">¿Puedo cambiar de distancia después?</strong>
          <span class="small muted">Sí, puedes cambiar hasta 7 días antes del evento sin costo adicional.</span>
        </div>
        <div style="background: var(--bg-secondary); padding: 16px; border-radius: 10px;">
          <strong style="font-size: 14px; display: block; margin-bottom: 4px;">¿Qué pasa si llueve?</strong>
          <span class="small muted">El evento se realiza con cualquier clima, salvo emergencia ambiental.</span>
        </div>
        <div style="background: var(--bg-secondary); padding: 16px; border-radius: 10px;">
          <strong style="font-size: 14px; display: block; margin-bottom: 4px;">¿Reembolsos?</strong>
          <span class="small muted">100% si el evento se cancela. 50% si cancelas tú hasta 14 días antes.</span>
        </div>
      </div>
    </div>
  </div>

  <aside class="ticket-sidebar">
    <div class="ticket-card">
      <button class="btn btn-primary btn-block btn-lg" style="margin-bottom: 8px;" onclick="irAEntradas()">
        Comprar entrada <i class="ti ti-arrow-right" style="font-size: 17px;"></i>
      </button>
      <button class="btn btn-outline btn-block">
        <i class="ti ti-heart" style="font-size: 15px;"></i> Guardar evento
      </button>

      <div class="ticket-features">
        <div class="tf-row"><i class="ti ti-lock"></i> Pago seguro Mercado Pago</div>
        <div class="tf-row"><i class="ti ti-credit-card"></i> Crédito, débito, Webpay</div>
        <div class="tf-row"><i class="ti ti-arrow-back-up"></i> Reembolso si se cancela</div>
        <div class="tf-row"><i class="ti ti-qrcode"></i> Ticket con QR único</div>
      </div>
    </div>

    <div class="card mt-4">
      <h4 style="font-size: 14px; margin-bottom: 12px;">Compartir evento</h4>
      <div class="flex gap-2">
        <button class="btn btn-outline btn-sm" style="flex: 1;"><i class="ti ti-brand-whatsapp"></i></button>
        <button class="btn btn-outline btn-sm" style="flex: 1;"><i class="ti ti-brand-instagram"></i></button>
        <button class="btn btn-outline btn-sm" style="flex: 1;"><i class="ti ti-brand-facebook"></i></button>
        <button class="btn btn-outline btn-sm" style="flex: 1;"><i class="ti ti-copy"></i></button>
      </div>
    </div>
  </aside>
</div>




</section>

<section class="spa-page" data-route="/checkout" data-shell="public" id="page-checkout">


<div class="checkout-layout">
  <div>
    <div class="steps-bar">
      <div class="cstep done"><div class="cstep-num"><i class="ti ti-check" style="font-size: 13px;"></i></div><span>Tus datos</span></div>
      <div class="cstep-line done"></div>
      <div class="cstep active"><div class="cstep-num">2</div><span>Ficha médica</span></div>
      <div class="cstep-line"></div>
      <div class="cstep"><div class="cstep-num">3</div><span>Pago</span></div>
    </div>

    <div class="section-block">
      <h3>
        <span class="section-icon"><i class="ti ti-user"></i></span>
        Datos del comprador
      </h3>
      <p class="sub">Para enviarte el ticket por correo</p>

      <div class="form-row">
        <div class="form-group">
          <label class="label">Nombre</label>
          <input class="input" placeholder="Nombre" value="Cristian">
        </div>
        <div class="form-group">
          <label class="label">Apellido</label>
          <input class="input" placeholder="Apellido" value="Almuna">
        </div>
      </div>
      <div class="form-group">
        <label class="label">Email <span style="color:var(--red-600);">*</span></label>
        <input type="email" class="input" id="ck-email" placeholder="tu@email.com">
      </div>
      <div class="form-group">
        <label class="label">Confirmar email <span style="color:var(--red-600);">*</span></label>
        <input type="email" class="input" id="ck-email-confirm" placeholder="Repite tu correo">
        <p class="small" id="ck-email-error" style="display:none; color:var(--red-600); margin-top:4px;">Los correos no coinciden</p>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="label">Teléfono</label>
          <input class="input" placeholder="+56 9 XXXX XXXX">
        </div>
        <div class="form-group">
          <label class="label">RUT</label>
          <input class="input" placeholder="12.345.678-9">
        </div>
      </div>
    </div>

    <div class="section-block">
      <h3>
        <span class="section-icon amber"><i class="ti ti-heart-rate-monitor"></i></span>
        Datos del participante y ficha médica
      </h3>
      <p class="sub">Requerida por el organizador · Confidencial</p>

      <div class="form-row">
        <div class="form-group">
          <label class="label">Fecha de nacimiento <span style="color:var(--red-600);">*</span></label>
          <input type="date" class="input" id="ck-fnac">
        </div>
        <div class="form-group">
          <label class="label">Sexo <span style="color:var(--red-600);">*</span></label>
          <select class="select" id="ck-sexo">
            <option value="">Seleccionar...</option>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
          </select>
        </div>
      </div>

      <!-- Documento de identidad estructurado -->
      <div class="form-group">
        <label class="label">Documento de identidad <span style="color:var(--red-600);">*</span></label>
        <div style="display:grid; grid-template-columns: 1fr 1fr 1.5fr; gap: 8px;">
          <select class="select" id="ck-doc-pais">
            <option value="">País</option>
            <option value="CL" selected>Chile</option>
            <option value="AR">Argentina</option>
            <option value="BR">Brasil</option>
            <option value="CO">Colombia</option>
            <option value="EC">Ecuador</option>
            <option value="PE">Perú</option>
            <option value="otro">Otro</option>
          </select>
          <select class="select" id="ck-doc-tipo">
            <option value="cedula">Cédula</option>
            <option value="rut">RUT</option>
            <option value="dni">DNI</option>
            <option value="cpf">CPF</option>
            <option value="pasaporte">Pasaporte</option>
          </select>
          <input class="input" id="ck-doc-numero" placeholder="Número">
        </div>
      </div>

      <!-- Categoría autocalculada -->
      <div class="form-group">
        <label class="label">Categoría <span class="small muted">(se calcula automáticamente)</span></label>
        <div id="ck-categoria-box" class="category-auto">
          <i class="ti ti-category" style="font-size:18px; color:var(--purple-700);"></i>
          <span id="ck-categoria-text">Ingresa tu fecha de nacimiento y sexo para ver tu categoría</span>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="label">Nacionalidad <span style="color:var(--red-600);">*</span></label>
          <input class="input" id="ck-nacionalidad" placeholder="Chilena" value="Chilena">
        </div>
        <div class="form-group" id="ck-talla-group">
          <label class="label">Talla de polera <span style="color:var(--red-600);">*</span></label>
          <select class="select" id="ck-talla">
            <option value="">Seleccionar...</option>
            <option>XS</option><option>S</option><option>M</option>
            <option>L</option><option>XL</option><option>XXL</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="label">Grupo sanguíneo <span style="color:var(--red-600);">*</span></label>
          <select class="select" id="ck-sangre">
            <option value="">Seleccionar...</option>
            <option>O+</option><option>O-</option>
            <option>A+</option><option>A-</option>
            <option>B+</option><option>B-</option>
            <option>AB+</option><option>AB-</option>
            <option>No lo sé</option>
          </select>
        </div>
        <div class="form-group">
          <label class="label">Seguro / Sociedad médica <span style="color:var(--red-600);">*</span></label>
          <input class="input" id="ck-seguro" placeholder="Ej: Fonasa, Isapre, particular">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="label">¿Enfermedad crónica? <span style="color:var(--red-600);">*</span></label>
          <select class="select" id="ck-cronica-sel">
            <option value="">Seleccionar...</option>
            <option value="no">No</option>
            <option value="si">Sí</option>
          </select>
        </div>
        <div class="form-group">
          <label class="label">¿Eres celíaco/a? <span style="color:var(--red-600);">*</span></label>
          <select class="select" id="ck-celiaco">
            <option value="">Seleccionar...</option>
            <option value="no">No</option>
            <option value="si">Sí</option>
          </select>
        </div>
      </div>

      <div class="form-group" id="ck-cronica-detalle-wrap" style="display:none;">
        <label class="label">Indica tu enfermedad crónica</label>
        <input class="input" id="ck-cronica-detalle" placeholder="Describe brevemente">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="label">¿Consumes algún medicamento de forma permanente? <span style="color:var(--red-600);">*</span></label>
          <select class="select" id="ck-medicamentos-sel">
            <option value="">Seleccionar...</option>
            <option value="no">No</option>
            <option value="si">Sí</option>
          </select>
        </div>
        <div class="form-group" id="ck-medicamentos-detalle-wrap" style="display:none;">
          <label class="label">¿Cuál(es)? <span style="color:var(--red-600);">*</span></label>
          <input class="input" id="ck-medicamentos-detalle" placeholder="Nombre del medicamento y dosis">
        </div>
      </div>

      <p style="font-size: 13px; font-weight: 700; color: var(--text); margin: 18px 0 10px;">Contacto de emergencia</p>
      <div class="form-row">
        <div class="form-group">
          <label class="label">Nombre completo <span style="color:var(--red-600);">*</span></label>
          <input class="input" id="ck-emer-nombre" placeholder="Nombre y apellido">
        </div>
        <div class="form-group">
          <label class="label">Parentesco</label>
          <input class="input" id="ck-emer-parentesco" placeholder="Ej: Madre, pareja, amigo">
        </div>
      </div>
      <div class="form-group">
        <label class="label">Teléfono de emergencia <span style="color:var(--red-600);">*</span></label>
        <input class="input" id="ck-emer-telefono" placeholder="+56 9 XXXX XXXX">
      </div>

      <p style="font-size: 13px; font-weight: 700; color: var(--text); margin: 18px 0 10px;">Otros campos</p>
      <div class="form-row">
        <div class="form-group">
          <label class="label">Ciudad / Comuna <span style="color:var(--red-600);">*</span></label>
          <input class="input" id="ck-ciudad" placeholder="Ej: Puerto Montt">
        </div>
        <div class="form-group">
          <label class="label">¿Perteneces a algún club/equipo? <span class="small muted">(opcional)</span></label>
          <input class="input" id="ck-equipo" placeholder="Nombre de tu club o equipo">
        </div>
      </div>
      <div class="form-group">
        <label class="label">Observaciones <span class="small muted">(opcional)</span></label>
        <textarea class="textarea" id="ck-observaciones" rows="3" placeholder="Cualquier observación que creas necesaria"></textarea>
      </div>

      <p style="font-size: 13px; font-weight: 600; color: var(--text); margin: 16px 0 10px;">Declaración de salud</p>

      <div class="check-card checked">
        <input type="checkbox" id="c1" checked>
        <label for="c1">No tengo condición cardíaca diagnosticada que impida la actividad física intensa</label>
      </div>
      <div class="check-card checked">
        <input type="checkbox" id="c2" checked>
        <label for="c2">No he tenido desmayos ni pérdida de conciencia durante el ejercicio en los últimos 12 meses</label>
      </div>
      <div class="check-card">
        <input type="checkbox" id="c3">
        <label for="c3">Cuento con autorización médica para participar en actividad física de alta intensidad</label>
      </div>

      <div class="legal-box">
        <div class="legal-head">
          <i class="ti ti-shield-check"></i>
          <p><strong>Declaración legal con respaldo:</strong> al firmar declaras que la información es verídica. Match Sport registra timestamp + IP del firmante como respaldo legal ante la organización.</p>
        </div>
        <div class="legal-check">
          <input type="checkbox" id="legal">
          <label for="legal">Acepto y firmo esta declaración, y los términos y condiciones del evento</label>
        </div>
      </div>
    </div>

    <div class="section-block">
      <h3>
        <span class="section-icon"><i class="ti ti-credit-card"></i></span>
        Método de pago
      </h3>
      <p class="sub">Pago seguro procesado por Mercado Pago</p>

      <div class="pay-method selected" onclick="selectPay(this)">
        <div class="pay-radio"></div>
        <div class="pay-info">
          <div class="pay-name">Tarjeta de crédito o débito</div>
          <div class="pay-desc">Visa, Mastercard, American Express, Diners, Magna</div>
        </div>
        <div class="pay-logos">
          <span class="pay-logo">VISA</span>
          <span class="pay-logo">MC</span>
          <span class="pay-logo">AMEX</span>
        </div>
      </div>

      <div class="pay-method" onclick="selectPay(this)">
        <div class="pay-radio"></div>
        <div class="pay-info">
          <div class="pay-name">Webpay Plus</div>
          <div class="pay-desc">Transbank · Crédito y Redcompra · Todos los bancos</div>
        </div>
        <div class="pay-logos">
          <span class="pay-logo" style="background: var(--purple-100); color: var(--purple-700);">WEBPAY</span>
        </div>
      </div>

      <div class="pay-method" onclick="selectPay(this)">
        <div class="pay-radio"></div>
        <div class="pay-info">
          <div class="pay-name">Transferencia bancaria</div>
          <div class="pay-desc">Banco Estado, Santander, BCI, Chile · Confirmación 24-48h</div>
        </div>
      </div>

      <div class="pay-method" onclick="selectPay(this)">
        <div class="pay-radio"></div>
        <div class="pay-info">
          <div class="pay-name">Mercado Pago Wallet</div>
          <div class="pay-desc">Saldo MP o cuotas sin interés</div>
        </div>
        <div class="pay-logos">
          <span class="pay-logo" style="background: #009EE3; color: white;">MP</span>
        </div>
      </div>

      <div style="background: var(--purple-50); padding: 12px; border-radius: 10px; margin-top: 12px; display: flex; align-items: center; gap: 10px;">
        <i class="ti ti-lock" style="color: var(--purple-700); font-size: 18px;"></i>
        <span style="font-size: 13px; color: var(--purple-800); font-weight: 500;">Tus datos están protegidos. Conexión cifrada SSL.</span>
      </div>
    </div>

    <button class="btn btn-primary btn-lg btn-block" onclick="completarCompra()">
      <i class="ti ti-lock" style="font-size: 17px;"></i> Pagar $15.000 de forma segura
    </button>
  </div>

  <div>
    <div class="summary-card">
      <h4 style="font-size: 13px; color: var(--text-tertiary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">RESUMEN DE COMPRA</h4>

      <div class="ev-mini">
        <div class="ev-mini-img"><i class="ti ti-run" style="font-size: 26px;"></i></div>
        <div>
          <div id="ck-resumen-evento" style="font-weight: 700; font-size: 14px; margin-bottom: 4px; line-height: 1.3;">Rally Costero Purranque 2027</div>
          <div class="small muted" id="ck-resumen-sub">16 mayo · Purranque · 8 km</div>
        </div>
      </div>

      <div id="ck-resumen-items">
        <div class="summary-row">
          <span>Ticket General 8km × 1</span>
          <span>$15.000</span>
        </div>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span style="color: var(--purple-700);" id="ck-resumen-total">$15.000</span>
      </div>

      <div class="trust-box">
        <div class="head">¿Por qué confiar en Match Sport?</div>
        <ul>
          <li><i class="ti ti-check" style="color: var(--green-600);"></i> Reembolso si el evento se cancela</li>
          <li><i class="ti ti-check" style="color: var(--green-600);"></i> Ticket válido con QR único</li>
          <li><i class="ti ti-check" style="color: var(--green-600);"></i> Soporte por WhatsApp</li>
          <li><i class="ti ti-check" style="color: var(--green-600);"></i> Diploma incluido al finalizar</li>
        </ul>
      </div>
    </div>
  </div>
</div>




</section>

<section class="spa-page" data-route="/ticket" data-shell="public" id="page-ticket">


<section class="success-hero">
  <div class="success-icon"><i class="ti ti-check"></i></div>
  <h1>¡Pago confirmado!</h1>
  <p>Tu ticket fue enviado a <span id="tk-email">calmuna1979@gmail.com</span></p>
</section>

<div class="ticket-wrap">
  <div class="ticket">
    <div class="ticket-top">
      <h3 id="tk-evento">Rally Costero Purranque RCP 2027</h3>
      <p class="small" id="tk-fecha">Domingo 16 mayo 2027 · 08:00 hrs</p>
    </div>
    <div class="ticket-body">
      <div class="info-grid">
        <div class="info-row">
          <div class="label">Asistente</div>
          <div class="value" id="tk-asistente">Cristian Almuna</div>
        </div>
        <div class="info-row">
          <div class="label">Ticket</div>
          <div class="value" id="tk-ticket">General 8 km</div>
        </div>
        <div class="info-row">
          <div class="label">Ubicación</div>
          <div class="value" id="tk-lugar">Plaza de Armas Purranque</div>
        </div>
        <div class="info-row">
          <div class="label">Categoría</div>
          <div class="value" id="tk-categoria">Open +40 M</div>
        </div>
      </div>

      <div class="qr-section">
        <div class="qr-label">Presenta este código en la entrada</div>
        <div class="qr-box">
          <svg viewBox="0 0 100 100" width="180" height="180">
            <rect width="100" height="100" fill="white"/>
            <g fill="#1F1F1F">
              <rect x="5" y="5" width="20" height="20"/>
              <rect x="10" y="10" width="10" height="10" fill="white"/>
              <rect x="75" y="5" width="20" height="20"/>
              <rect x="80" y="10" width="10" height="10" fill="white"/>
              <rect x="5" y="75" width="20" height="20"/>
              <rect x="10" y="80" width="10" height="10" fill="white"/>
              <rect x="30" y="5" width="5" height="5"/>
              <rect x="40" y="5" width="5" height="5"/>
              <rect x="50" y="10" width="5" height="5"/>
              <rect x="35" y="20" width="5" height="5"/>
              <rect x="45" y="20" width="5" height="5"/>
              <rect x="55" y="20" width="5" height="5"/>
              <rect x="65" y="20" width="5" height="5"/>
              <rect x="30" y="30" width="5" height="5"/>
              <rect x="45" y="30" width="5" height="5"/>
              <rect x="60" y="30" width="5" height="5"/>
              <rect x="70" y="30" width="5" height="5"/>
              <rect x="85" y="30" width="5" height="5"/>
              <rect x="35" y="40" width="5" height="5"/>
              <rect x="50" y="40" width="5" height="5"/>
              <rect x="65" y="40" width="5" height="5"/>
              <rect x="75" y="40" width="5" height="5"/>
              <rect x="30" y="50" width="5" height="5"/>
              <rect x="40" y="50" width="5" height="5"/>
              <rect x="55" y="50" width="5" height="5"/>
              <rect x="70" y="50" width="5" height="5"/>
              <rect x="85" y="50" width="5" height="5"/>
              <rect x="35" y="60" width="5" height="5"/>
              <rect x="50" y="60" width="5" height="5"/>
              <rect x="60" y="60" width="5" height="5"/>
              <rect x="75" y="60" width="5" height="5"/>
              <rect x="40" y="70" width="5" height="5"/>
              <rect x="55" y="70" width="5" height="5"/>
              <rect x="65" y="70" width="5" height="5"/>
              <rect x="80" y="70" width="5" height="5"/>
              <rect x="30" y="80" width="5" height="5"/>
              <rect x="45" y="80" width="5" height="5"/>
              <rect x="60" y="80" width="5" height="5"/>
              <rect x="75" y="80" width="5" height="5"/>
              <rect x="40" y="90" width="5" height="5"/>
              <rect x="55" y="90" width="5" height="5"/>
              <rect x="70" y="90" width="5" height="5"/>
              <rect x="85" y="90" width="5" height="5"/>
            </g>
          </svg>
        </div>
        <div class="qr-id" id="tk-orden">MS-RCP2027-0247</div>
      </div>
    </div>
    <div class="ticket-actions">
      <button class="btn btn-outline" onclick="descargarTicketPDF()"><i class="ti ti-download"></i> Descargar PDF</button>
      <button class="btn btn-outline" onclick="verCorreoConfirmacion()"><i class="ti ti-mail"></i> Ver correo</button>
    </div>
  </div>
</div>

<div class="next-steps">
  <h3>Próximos pasos</h3>

  <div class="step-item">
    <div class="step-icon"><i class="ti ti-mail"></i></div>
    <div class="step-text">
      <h4>Revisa tu correo</h4>
      <p>Te enviamos el ticket y todos los detalles. Si no lo ves, revisa la carpeta de spam.</p>
    </div>
  </div>

  <div class="step-item">
    <div class="step-icon amber"><i class="ti ti-calendar-plus"></i></div>
    <div class="step-text">
      <h4>Agrega a tu calendario</h4>
      <p>Domingo 16 de mayo a las 08:00 hrs. Llega temprano para retiro de kit (desde 06:30).</p>
    </div>
  </div>

  <div class="step-item">
    <div class="step-icon green"><i class="ti ti-certificate"></i></div>
    <div class="step-text">
      <h4>Recibirás tu diploma</h4>
      <p>Después del evento, te llegará tu diploma oficial verificable con tu tiempo y posición.</p>
    </div>
  </div>

  <div class="step-item">
    <div class="step-icon"><i class="ti ti-share"></i></div>
    <div class="step-text">
      <h4>Comparte que vas</h4>
      <p>Cuéntale a tus amigos. Pueden inscribirse al mismo evento desde tu link.</p>
    </div>
  </div>
</div>



</section>

<section class="spa-page" data-route="/resultados" data-shell="public" id="page-resultados">


<section class="res-hero">
  <div class="res-hero-inner">
    <h1>Resultados deportivos</h1>
    <p>Busca tu tiempo, posición y diploma de cualquier evento organizado con Match Sport</p>

    <div class="search-big">
      <i class="ti ti-search" style="font-size: 22px; color: var(--text-tertiary); margin-left: 4px;"></i>
      <input placeholder="Busca por nombre, RUT, evento o ciudad...">
      <button class="btn btn-primary">Buscar</button>
    </div>

    <div class="quick-stats">
      <div class="qstat">
        <strong id="res-resultados">0</strong>
        <small>resultados registrados</small>
      </div>
      <div class="qstat">
        <strong id="res-eventos">0</strong>
        <small>eventos en base</small>
      </div>
      <div class="qstat">
        <strong id="res-deportistas">0</strong>
        <small>deportistas únicos</small>
      </div>
      <div class="qstat">
        <strong id="res-qr">100%</strong>
        <small>verificables con QR</small>
      </div>
    </div>
  </div>
</section>

<div class="results-section">
  <div class="section-head">
    <div>
      <div class="section-label">EVENTOS RECIENTES</div>
      <h2>Últimos resultados publicados</h2>
    </div>
    <a href="#" style="color: var(--purple-700); font-weight: 600; font-size: 14px;">Ver todos →</a>
  </div>

  <div class="results-grid">
    <div class="result-card">
      <div class="result-head">
        <div class="result-icon" style="background: var(--purple-100); color: var(--purple-700);">
          <i class="ti ti-run" style="font-size: 22px;"></i>
        </div>
        <span class="badge badge-purple">Running</span>
      </div>
      <div class="result-title">Maratón Osorno 2026</div>
      <div class="result-meta">12 octubre 2026 · Osorno, Los Lagos · Club Cumbres</div>
      <div class="result-stats">
        <div class="rstat"><strong class="purple">456</strong><small>Finishers</small></div>
        <div class="rstat"><strong>03:42:18</strong><small>Mejor tiempo</small></div>
        <div class="rstat"><strong>5</strong><small>Categorías</small></div>
      </div>
    </div>

    <div class="result-card">
      <div class="result-head">
        <div class="result-icon" style="background: var(--amber-50); color: var(--amber-700);">
          <i class="ti ti-ball-football" style="font-size: 22px;"></i>
        </div>
        <span class="badge badge-amber">Fútbol</span>
      </div>
      <div class="result-title">Liga Barrial Osorno 2026</div>
      <div class="result-meta">15 dic 2026 · 16 equipos · Liga Osorno</div>
      <div class="result-stats">
        <div class="rstat"><strong class="purple">16</strong><small>Equipos</small></div>
        <div class="rstat"><strong>240</strong><small>Jugadores</small></div>
        <div class="rstat"><strong>120</strong><small>Partidos</small></div>
      </div>
    </div>

    <div class="result-card">
      <div class="result-head">
        <div class="result-icon" style="background: var(--purple-100); color: var(--purple-700);">
          <i class="ti ti-bike" style="font-size: 22px;"></i>
        </div>
        <span class="badge badge-purple">Ciclismo</span>
      </div>
      <div class="result-title">MTB Puyehue 2026</div>
      <div class="result-meta">8 noviembre 2026 · Puyehue · BikeFest</div>
      <div class="result-stats">
        <div class="rstat"><strong class="purple">189</strong><small>Finishers</small></div>
        <div class="rstat"><strong>01:24:09</strong><small>Mejor tiempo</small></div>
        <div class="rstat"><strong>3</strong><small>Distancias</small></div>
      </div>
    </div>

    <div class="result-card">
      <div class="result-head">
        <div class="result-icon" style="background: var(--amber-50); color: var(--amber-700);">
          <i class="ti ti-ball-basketball" style="font-size: 22px;"></i>
        </div>
        <span class="badge badge-amber">Básquet</span>
      </div>
      <div class="result-title">Torneo 3x3 Plaza Armas 2026</div>
      <div class="result-meta">22 nov 2026 · 12 equipos · Osorno</div>
      <div class="result-stats">
        <div class="rstat"><strong class="purple">12</strong><small>Equipos</small></div>
        <div class="rstat"><strong>36</strong><small>Jugadores</small></div>
        <div class="rstat"><strong>21</strong><small>Partidos</small></div>
      </div>
    </div>
  </div>

  <div class="top-runners">
    <h3 style="font-size: 16px; margin-bottom: 14px; font-weight: 700;">🏆 Top finishers — Maratón Osorno 2026 · Categoría Open M</h3>

    <div class="runner-row">
      <div class="rank-badge rank-1">1</div>
      <div>
        <div style="font-weight: 700; font-size: 14px;">Diego Lagos</div>
        <div class="small muted">Osorno · Club Andino</div>
      </div>
      <div class="runner-time">03:42:18</div>
      <button class="btn btn-outline btn-sm"><i class="ti ti-certificate" style="font-size: 13px;"></i> Diploma</button>
    </div>

    <div class="runner-row">
      <div class="rank-badge rank-2">2</div>
      <div>
        <div style="font-weight: 700; font-size: 14px;">Felipe Arenas</div>
        <div class="small muted">Puerto Montt</div>
      </div>
      <div class="runner-time">03:45:52</div>
      <button class="btn btn-outline btn-sm"><i class="ti ti-certificate" style="font-size: 13px;"></i> Diploma</button>
    </div>

    <div class="runner-row">
      <div class="rank-badge rank-3">3</div>
      <div>
        <div style="font-weight: 700; font-size: 14px;">Pedro Soto</div>
        <div class="small muted">Frutillar</div>
      </div>
      <div class="runner-time">03:48:03</div>
      <button class="btn btn-outline btn-sm"><i class="ti ti-certificate" style="font-size: 13px;"></i> Diploma</button>
    </div>

    <div class="runner-row">
      <div class="rank-badge rank-other">4</div>
      <div>
        <div style="font-weight: 700; font-size: 14px;">Javier Vargas</div>
        <div class="small muted">Osorno</div>
      </div>
      <div class="runner-time">03:51:27</div>
      <button class="btn btn-outline btn-sm"><i class="ti ti-certificate" style="font-size: 13px;"></i> Diploma</button>
    </div>

    <div class="runner-row">
      <div class="rank-badge rank-other">5</div>
      <div>
        <div style="font-weight: 700; font-size: 14px;">Cristian Almuna</div>
        <div class="small muted">Osorno</div>
      </div>
      <div class="runner-time">03:54:11</div>
      <button class="btn btn-outline btn-sm"><i class="ti ti-certificate" style="font-size: 13px;"></i> Diploma</button>
    </div>

    <div class="text-center mt-4">
      <a href="#" style="color: var(--purple-700); font-weight: 600; font-size: 13px;">Ver los 456 finishers →</a>
    </div>
  </div>

  <div style="background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%); border-radius: 16px; padding: 32px; text-align: center; color: white; margin-top: 40px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -30px; width: 200px; height: 200px; background: var(--amber-500); opacity: 0.2; border-radius: 50%;"></div>
    <div style="position: relative;">
      <i class="ti ti-certificate" style="font-size: 40px; color: var(--amber-400); margin-bottom: 10px;"></i>
      <h2 style="color: white; margin-bottom: 8px;">¿Eres organizador?</h2>
      <p style="opacity: 0.9; margin-bottom: 20px; font-size: 16px;">Publica tus resultados gratis en Match Sport. Mayor visibilidad para tu evento, diplomas verificables para tus participantes.</p>
      <a href="#/organizador/crear-evento" class="btn btn-amber btn-lg">Crear evento gratis →</a>
    </div>
  </div>
</div>


</section>

<section class="spa-page" data-route="/como-funciona" data-shell="public" id="page-como-funciona">


<!-- ========== NAV ========== -->
<!-- ========== HERO ========== -->
<section class="cf-hero">
  <div class="cf-hero-inner">
    <div>
      <div class="cf-eyebrow">
        <span class="dot"></span>
        Plataforma de eventos deportivos en Latinoamérica
      </div>
      <h1>Todo lo que necesitas<br>para tu evento, <span class="accent">en una sola app.</span></h1>
      <p class="lead">Desde la inscripción con ficha médica hasta el diploma con QR. Conectamos a deportistas, organizadores y resultados públicos en un solo lugar.</p>
      <div class="cf-cta-row">
        <a href="#/login" class="btn btn-primary btn-lg">
          Crear mi primer evento <i class="ti ti-arrow-right" style="font-size: 18px;"></i>
        </a>
      </div>
      <div class="cf-stat-row">
        <div class="cf-stat">
          <div class="v" style="color: var(--purple-700);">+47</div>
          <div class="l">Eventos activos</div>
        </div>
        <div class="cf-stat-divider"></div>
        <div class="cf-stat">
          <div class="v" style="color: var(--amber-500);">3.247</div>
          <div class="l">Tickets vendidos</div>
        </div>
        <div class="cf-stat-divider"></div>
        <div class="cf-stat">
          <div class="v">2027</div>
          <div class="l">En toda Latinoamérica</div>
        </div>
      </div>
    </div>

    <div class="cf-hero-visual">
      <div class="cf-card-1">
        <div class="cv-head"><span class="d"></span><span class="d"></span><span class="d"></span></div>
        <div class="cv-body">
          <div class="cv-tag">DEPORTISTA</div>
          <div class="cv-title">Rally Costero Purranque</div>
          <div class="cv-line"></div>
          <div class="cv-line"></div>
          <div class="cv-line short"></div>
          <div class="cv-pill"><i class="ti ti-run" style="font-size: 11px;"></i> RUNNING · 16 KM</div>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px; padding-top: 12px; border-top: 0.5px solid var(--border);">
            <span style="font-size: 11px; color: var(--text-tertiary);">Desde</span>
            <span style="font-size: 20px; font-weight: 700; color: var(--purple-700);">$15.000</span>
          </div>
        </div>
      </div>
      <div class="cf-card-2">
        <div class="cv-head"><span class="d"></span><span class="d"></span><span class="d"></span></div>
        <div class="cv-body">
          <div class="cv-tag">ORGANIZADOR</div>
          <div class="cv-title">$920.000 este mes</div>
          <div style="display: flex; gap: 4px; align-items: flex-end; height: 60px; margin: 14px 0;">
            <div style="flex:1; height: 30%; background: var(--purple-300); border-radius: 3px 3px 0 0;"></div>
            <div style="flex:1; height: 45%; background: var(--purple-400); border-radius: 3px 3px 0 0;"></div>
            <div style="flex:1; height: 60%; background: var(--purple-500); border-radius: 3px 3px 0 0;"></div>
            <div style="flex:1; height: 75%; background: var(--purple-600); border-radius: 3px 3px 0 0;"></div>
            <div style="flex:1; height: 90%; background: var(--purple-700); border-radius: 3px 3px 0 0;"></div>
            <div style="flex:1; height: 100%; background: var(--amber-500); border-radius: 3px 3px 0 0;"></div>
          </div>
          <div style="font-size: 11px; color: var(--green-600); display: flex; align-items: center; gap: 4px; font-weight: 600;">
            <i class="ti ti-arrow-up-right" style="font-size: 13px;"></i> +42% vs abril
          </div>
          <div class="cv-line short" style="margin-top: 10px;"></div>
        </div>
      </div>
      <div class="cf-card-3">
        <div class="cv-head" style="background: var(--amber-50);"><span class="d"></span><span class="d"></span><span class="d"></span></div>
        <div class="cv-body">
          <div class="cv-tag">DIPLOMA · QR</div>
          <div class="cv-title">Felipe Reyes</div>
          <div style="background: #1F1F1F; aspect-ratio: 1; max-width: 100px; margin: 0 auto 12px; border-radius: 8px; padding: 8px; display: grid; grid-template-columns: repeat(8, 1fr); gap: 1px;">
            <!-- Faux QR -->
            
          </div>
          <div style="text-align: center; font-size: 11px; color: var(--text-secondary);">Verificable · match-sport.com/d/8fk2</div>
        </div>
      </div>

      <div class="cf-toast">
        <div style="width: 36px; height: 36px; background: var(--green-50); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
          <i class="ti ti-check" style="color: var(--green-600); font-size: 20px;"></i>
        </div>
        <div>
          <div style="font-size: 13px; font-weight: 700;">Nueva inscripción</div>
          <div style="font-size: 11px; color: var(--text-tertiary);">$15.000 · Mercado Pago</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== HOW IT WORKS ========== -->
<section class="cf-section tinted">
  <div class="inner">
    <div class="cf-head">
      <div class="label">CÓMO FUNCIONA</div>
      <h2>De idea a evento publicado<br>en 5 minutos.</h2>
      <p class="lead">Un flujo simple, pensado para que cualquier organizador deportivo —desde un club de barrio hasta una productora grande— pueda lanzar y cobrar sin trabas.</p>
    </div>

    <div class="how-grid">
      <div class="how-step">
        <div class="how-num">1</div>
        <h3>Crea tu evento</h3>
        <p>Nombre, fecha, lugar y tipos de ticket. El wizard te guía paso a paso.</p>
        <div class="how-pages">
          <span class="how-page">crear-evento</span>
        </div>
      </div>
      <div class="how-step">
        <div class="how-num">2</div>
        <h3>Comparte el link</h3>
        <p>Tu página pública lista para WhatsApp, Instagram y todas tus redes.</p>
        <div class="how-pages">
          <span class="how-page">evento</span>
          <span class="how-page">eventos</span>
        </div>
      </div>
      <div class="how-step">
        <div class="how-num">3</div>
        <h3>Recibe inscritos</h3>
        <p>Pagos automáticos por tarjeta, Webpay y Mercado Pago. Dinero a tu cuenta.</p>
        <div class="how-pages">
          <span class="how-page">checkout</span>
          <span class="how-page">ticket</span>
        </div>
      </div>
      <div class="how-step featured">
        <div class="how-num">4</div>
        <h3>Cierra con diplomas</h3>
        <p>Sube resultados en Excel y genera diplomas únicos verificables con QR.</p>
        <div class="how-pages">
          <span class="how-page">diplomas</span>
          <span class="how-page">resultados</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== PARA CADA ROL ========== -->
<section class="cf-section" id="roles">
  <div class="cf-head">
    <div class="label">DISEÑADO PARA TI</div>
    <h2>Tres roles, tres experiencias.</h2>
    <p class="lead">Cada usuario ve sólo lo que necesita. Sin sobrecarga, sin pantallas que sobran.</p>
  </div>

  <div class="role-tabs">
    <button class="role-tab active" data-role="deportista">
      <i class="ti ti-run"></i> Deportista <span class="count">7</span>
    </button>
    <button class="role-tab" data-role="organizador">
      <i class="ti ti-building-store"></i> Organizador <span class="count">7</span>
    </button>
    <button class="role-tab" data-role="admin">
      <i class="ti ti-crown"></i> Super admin <span class="count">4</span>
    </button>
  </div>

  <!-- Deportista panel -->
  <div class="role-panel active" data-panel="deportista">
    <div class="role-side">
      <div class="role-side-eyebrow">EL USUARIO PÚBLICO</div>
      <h3>Encontrar y participar de eventos deportivos en 90 segundos.</h3>
      <p>Sin registrarse para explorar. Sólo se pide login cuando va a pagar. Inscripción con ficha médica integrada y ticket con QR al instante.</p>

      <div class="role-flow-steps">
        <div class="rfs-item">
          <div class="rfs-num">1</div>
          <div class="rfs-info">
            <strong>Descubre eventos</strong>
            <span>Landing + filtros por deporte y ciudad</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">2</div>
          <div class="rfs-info">
            <strong>Revisa el evento</strong>
            <span>5 tabs: info, entradas, recorrido, organizador, FAQ</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">3</div>
          <div class="rfs-info">
            <strong>Paga con ficha médica</strong>
            <span>Mercado Pago + declaración legal firmada</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">4</div>
          <div class="rfs-info">
            <strong>Recibe ticket con QR</strong>
            <span>Listo para mostrar el día del evento</span>
          </div>
        </div>
      </div>
    </div>
    <div class="role-main">
      <div class="role-main-head">
        <h4>Pantallas públicas</h4>
        <span class="count">7 pantallas · sin login</span>
      </div>
      <div class="role-pages-list">
        <a href="#/" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-home"></i></div>
          <div class="role-page-info">
            <strong>Landing principal</strong>
            <span>Hero · categorías · eventos destacados · precios</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/eventos" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-calendar-search"></i></div>
          <div class="role-page-info">
            <strong>Explorador de eventos</strong>
            <span>Filtros, búsqueda, chips por deporte</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/evento" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-calendar-event"></i></div>
          <div class="role-page-info">
            <strong>Página del evento</strong>
            <span>Tabs · ticket sidebar sticky · CTA fijo</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/checkout" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-credit-card"></i></div>
          <div class="role-page-info">
            <strong>Checkout con ficha médica</strong>
            <span>Datos · ficha legal · Mercado Pago</span>
          </div>
          <div class="role-page-meta">
            <span class="role-page-star">⭐ Único</span>
            <div class="role-page-arrow">→</div>
          </div>
        </a>
        <a href="#/ticket" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-qrcode"></i></div>
          <div class="role-page-info">
            <strong>Ticket confirmado</strong>
            <span>QR único · descarga PDF</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/resultados" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-trophy"></i></div>
          <div class="role-page-info">
            <strong>Resultados públicos</strong>
            <span>Histórico SEO · perfil del deportista</span>
          </div>
          <div class="role-page-meta">
            <span class="role-page-star">⭐ Único</span>
            <div class="role-page-arrow">→</div>
          </div>
        </a>
        <a href="#/login" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-login"></i></div>
          <div class="role-page-info">
            <strong>Login magic link</strong>
            <span>Selector de rol · sin contraseñas</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
      </div>
    </div>
  </div>

  <!-- Organizador panel -->
  <div class="role-panel org" data-panel="organizador">
    <div class="role-side amber">
      <div class="role-side-eyebrow">EL CLIENTE</div>
      <h3>Publicar, cobrar y cerrar tu evento sin papeleos.</h3>
      <p>Todo lo que un club o productora deportiva necesita: wizard de creación, control de inscritos con ficha médica, descuentos, check-in QR y diplomas automáticos.</p>

      <div class="role-flow-steps">
        <div class="rfs-item">
          <div class="rfs-num">1</div>
          <div class="rfs-info">
            <strong>Crea el evento</strong>
            <span>Wizard guiado · sin onboarding</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">2</div>
          <div class="rfs-info">
            <strong>Promociona</strong>
            <span>Cupones, descuentos, redes sociales</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">3</div>
          <div class="rfs-info">
            <strong>Gestiona inscritos</strong>
            <span>Tabla con fichas médicas exportables</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">4</div>
          <div class="rfs-info">
            <strong>Check-in &amp; diplomas</strong>
            <span>Scanner QR el día y diplomas al cierre</span>
          </div>
        </div>
      </div>
    </div>
    <div class="role-main">
      <div class="role-main-head">
        <h4>Panel del organizador</h4>
        <span class="count">/organizador · 7 pantallas</span>
      </div>
      <div class="role-pages-list">
        <a href="#/organizador" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-chart-pie"></i></div>
          <div class="role-page-info">
            <strong>Dashboard del evento</strong>
            <span>Métricas + gráficos en tiempo real</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/organizador/mis-eventos" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-calendar"></i></div>
          <div class="role-page-info">
            <strong>Mis eventos</strong>
            <span>Grid con todos los eventos activos</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/login" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-plus"></i></div>
          <div class="role-page-info">
            <strong>Crear evento (wizard)</strong>
            <span>Flujo paso a paso · 5 minutos</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/organizador/asistentes" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-users"></i></div>
          <div class="role-page-info">
            <strong>Asistentes con ficha médica</strong>
            <span>Tabla descargable + fichas firmadas</span>
          </div>
          <div class="role-page-meta">
            <span class="role-page-star">⭐ Único</span>
            <div class="role-page-arrow">→</div>
          </div>
        </a>
        <a href="#/organizador/diplomas" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-certificate"></i></div>
          <div class="role-page-info">
            <strong>Diplomas automáticos</strong>
            <span>Excel → diplomas con QR verificable</span>
          </div>
          <div class="role-page-meta">
            <span class="role-page-star">⭐ Único</span>
            <div class="role-page-arrow">→</div>
          </div>
        </a>
        <a href="#/organizador/descuentos" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-discount"></i></div>
          <div class="role-page-info">
            <strong>Descuentos &amp; cupones</strong>
            <span>Códigos promocionales con modal</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/organizador/checkin" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-scan"></i></div>
          <div class="role-page-info">
            <strong>Check-in QR</strong>
            <span>Scanner animado el día del evento</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
      </div>
    </div>
  </div>

  <!-- Admin panel -->
  <div class="role-panel admin" data-panel="admin">
    <div class="role-side dark">
      <div class="role-side-eyebrow">SOLO PARA TI</div>
      <h3>El panel privado para administrar tu negocio.</h3>
      <p>No es visible para deportistas ni organizadores. Es tu vista de pájaro: GMV total, top organizadores, alertas y el flujo completo de la plata.</p>

      <div class="role-flow-steps">
        <div class="rfs-item">
          <div class="rfs-num">1</div>
          <div class="rfs-info">
            <strong>Resumen general</strong>
            <span>GMV + tu comisión + proyección</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">2</div>
          <div class="rfs-info">
            <strong>Quién está vendiendo</strong>
            <span>Top organizadores por GMV mensual</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">3</div>
          <div class="rfs-info">
            <strong>Qué requiere atención</strong>
            <span>Alertas, reembolsos, moderación</span>
          </div>
        </div>
        <div class="rfs-item">
          <div class="rfs-num">4</div>
          <div class="rfs-info">
            <strong>Cuánto entró</strong>
            <span>Flujo de caja del mes</span>
          </div>
        </div>
      </div>
    </div>
    <div class="role-main">
      <div class="role-main-head">
        <h4>Tu panel super admin</h4>
        <span class="count">/admin · 4 pantallas</span>
      </div>
      <div class="role-pages-list">
        <a href="#/admin" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-chart-pie"></i></div>
          <div class="role-page-info">
            <strong>Resumen general</strong>
            <span>GMV $18.4M · tu ingreso $920K</span>
          </div>
          <div class="role-page-meta">
            <span class="role-page-star">⭐ Vista clave</span>
            <div class="role-page-arrow">→</div>
          </div>
        </a>
        <a href="#/admin/organizadores" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-users-group"></i></div>
          <div class="role-page-info">
            <strong>Organizadores</strong>
            <span>23 clientes activos · ranking GMV</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/admin/eventos" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-calendar"></i></div>
          <div class="role-page-info">
            <strong>Eventos globales</strong>
            <span>47 eventos en plataforma · filtros</span>
          </div>
          <div class="role-page-arrow">→</div>
        </a>
        <a href="#/admin/finanzas" class="role-page-row">
          <div class="role-page-icon"><i class="ti ti-cash"></i></div>
          <div class="role-page-info">
            <strong>Finanzas</strong>
            <span>Flujo GMV → MP → Match → organizador</span>
          </div>
          <div class="role-page-meta">
            <span class="role-page-star">⭐ Vista clave</span>
            <div class="role-page-arrow">→</div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ========== DIFERENCIADORES (dark) ========== -->
<section class="cf-section dark" id="diferenciadores">
  <div class="inner">
    <div class="cf-head">
      <div class="label">DIFERENCIADORES</div>
      <h2>Lo que ninguna ticketera<br>genérica te da.</h2>
      <p class="lead">Tres funciones únicas, pensadas específicamente para el deporte chileno.</p>
    </div>

    <div class="diff-grid">
      <div class="diff-card">
        <div class="diff-icon-box" style="background: rgba(23, 189, 181,0.2); color: var(--purple-400);">
          <i class="ti ti-shield-check" style="font-size: 28px;"></i>
        </div>
        <h3>Ficha médica digital</h3>
        <p>Integrada al checkout con declaración legal firmada. Timestamp e IP del usuario. El organizador descarga PDFs por inscrito.</p>
        <div class="diff-stat">
          <div class="diff-stat-v">100%</div>
          <div class="diff-stat-l">Inscritos con ficha firmada</div>
        </div>
      </div>

      <div class="diff-card">
        <div class="diff-icon-box" style="background: rgba(245,158,11,0.2); color: var(--amber-400);">
          <i class="ti ti-certificate" style="font-size: 28px;"></i>
        </div>
        <h3>Diplomas con QR verificable</h3>
        <p>Subes un Excel con resultados y la plataforma genera diplomas únicos. Cada QR enlaza al perfil público del deportista.</p>
        <div class="diff-stat">
          <div class="diff-stat-v">&lt; 60s</div>
          <div class="diff-stat-l">Para 500 diplomas generados</div>
        </div>
      </div>

      <div class="diff-card">
        <div class="diff-icon-box" style="background: rgba(34,197,94,0.18); color: #86EFAC;">
          <i class="ti ti-trophy" style="font-size: 28px;"></i>
        </div>
        <h3>Base pública de resultados</h3>
        <p>Cada deportista tiene su histórico indexable en Google. SEO orgánico que atrae nuevos usuarios sin pagar publicidad.</p>
        <div class="diff-stat">
          <div class="diff-stat-v">SEO</div>
          <div class="diff-stat-l">Tráfico orgánico mensual</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== MODELO DE NEGOCIO ========== -->
<section class="cf-section" id="precios">
  <div class="cf-head">
    <div class="label">CÓMO SE MUEVE LA PLATA</div>
    <h2>Comisión simple, sin sorpresas.</h2>
    <p class="lead">7% por ticket vendido. Sin costo fijo. Mercado Pago acredita en 48 hrs y nosotros liquidamos al organizador.</p>
  </div>

  <div class="biz-flow">
    <div class="biz-track">
      <div class="biz-node">
        <div class="biz-icon"><i class="ti ti-run"></i></div>
        <div class="biz-label">Deportista</div>
        <div class="biz-value" style="color: var(--purple-700);">$15.000</div>
        <div class="biz-sub">Paga 100% del ticket</div>
      </div>
      <div class="biz-arrow">
        →
        <span class="biz-cost">−3.5%</span>
      </div>
      <div class="biz-node">
        <div class="biz-icon" style="background: var(--blue-50); color: var(--blue-700);"><i class="ti ti-credit-card"></i></div>
        <div class="biz-label">Mercado Pago</div>
        <div class="biz-value" style="color: var(--blue-700);">−$525</div>
        <div class="biz-sub">Comisión procesador</div>
      </div>
      <div class="biz-arrow">
        →
        <span class="biz-gain">+7% Match</span>
      </div>
      <div class="biz-node highlight">
        <div class="biz-icon"><i class="ti ti-coin"></i></div>
        <div class="biz-label">Match Sport</div>
        <div class="biz-value">$1.050</div>
        <div class="biz-sub">7% comisión bruta</div>
      </div>
      <div class="biz-arrow">
        →
        <span class="biz-gain">~89.5%</span>
      </div>
      <div class="biz-node highlight amber">
        <div class="biz-icon"><i class="ti ti-building-store"></i></div>
        <div class="biz-label">Organizador</div>
        <div class="biz-value">$13.425</div>
        <div class="biz-sub">Recibe en su cuenta</div>
      </div>
    </div>

    <div class="biz-footnote">
      <div class="biz-foot-item">
        <strong>Margen neto Match Sport</strong>
        ~3.5% del GMV total después de costos operativos (procesador de pagos). Sin costo fijo para el organizador, todo es variable.
      </div>
      <div class="biz-foot-item">
        <strong>Procesamiento de pagos</strong>
        Mercado Pago acredita en 48 hrs. Match Sport transfiere al organizador semanalmente o al cierre del evento.
      </div>
      <div class="biz-foot-item">
        <strong>Proyección 2027</strong>
        Con 47 eventos activos y GMV de $18.4M/mes, el ingreso para Match Sport es <strong style="color: var(--purple-700);">$920K/mes</strong>.
      </div>
    </div>
  </div>
</section>

<!-- ========== CTA STRIP ========== -->
<section class="cf-section">
  <div class="cta-strip">
    <div>
      <h2>Listo para conectar tu deporte<br>con toda Latinoamérica.</h2>
      <p>Crear tu primer evento toma 5 minutos. Sin costo fijo, sin contratos. Sólo pagas el 5% si vendes.</p>
    </div>
    <div class="cta-strip-right">
      <a href="#/login" class="btn btn-amber btn-lg btn-block">
        Crear mi primer evento <i class="ti ti-arrow-right" style="font-size: 18px;"></i>
      </a>
      <a href="#/eventos" class="btn btn-outline btn-lg btn-block" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.3); color: white;">
        Explorar eventos como deportista
      </a>
    </div>
  </div>
</section>

<!-- ========== FOOTER ========== -->

</section>

<section class="spa-page" data-route="/login" data-shell="public" id="page-login">


<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo">
      <a href="#/" class="logo">
        <img src="data:image/png;base64,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" alt="Match Sport" style="height:100px; width:auto; display:block;">
      </a>
    </div>

    <h2>Crea tu evento en 1 minuto</h2>
    <p class="sub">Ingresa o crea tu cuenta de organizador. Elige tu forma favorita.</p>

    <!-- ===== SOCIAL LOGIN ===== -->
    <div class="social-btns">
      <button class="social-btn google" onclick="loginSocial('google')">
        <span class="s-icon">
          <svg viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84A10.99 10.99 0 0 0 12 23z"/><path fill="#FBBC05" d="M5.84 14.09a6.6 6.6 0 0 1 0-4.18V7.07H2.18a10.99 10.99 0 0 0 0 9.86l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84C6.71 7.31 9.14 5.38 12 5.38z"/></svg>
        </span>
        <span class="s-label">Continuar con Google</span>
        <span class="ms-tag">Recomendado</span>
      </button>

      <button class="social-btn facebook" onclick="loginSocial('facebook')">
        <span class="s-icon">
          <svg viewBox="0 0 24 24" fill="white"><path d="M24 12.07C24 5.41 18.63 0 12 0S0 5.41 0 12.07C0 18.09 4.39 23.09 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.96.93-1.96 1.89v2.26h3.33l-.53 3.49h-2.8V24C19.61 23.09 24 18.09 24 12.07z"/></svg>
        </span>
        <span class="s-label">Continuar con Facebook</span>
      </button>

      <button class="social-btn instagram" onclick="loginSocial('instagram')">
        <span class="s-icon">
          <svg viewBox="0 0 24 24" fill="white"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.43.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23a3.7 3.7 0 0 1-.9 1.38c-.42.42-.82.68-1.38.9-.43.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.43-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.43-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63a5.86 5.86 0 0 0-2.12 1.38A5.86 5.86 0 0 0 .63 4.14C.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91a5.86 5.86 0 0 0 1.38 2.12 5.86 5.86 0 0 0 2.12 1.38c.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.86 5.86 0 0 0 2.12-1.38 5.86 5.86 0 0 0 1.38-2.12c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.86 5.86 0 0 0-1.38-2.12A5.86 5.86 0 0 0 19.86.63C19.1.33 18.22.13 16.95.07 15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zm0 10.16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
        </span>
        <span class="s-label">Continuar con Instagram</span>
      </button>

      <button class="social-btn apple" onclick="loginSocial('apple')">
        <span class="s-icon">
          <svg viewBox="0 0 24 24" fill="white"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
        </span>
        <span class="s-label">Continuar con Apple</span>
      </button>
    </div>

    <div class="divider-or">O CON TU CORREO</div>

    <form id="formOrg" onsubmit="event.preventDefault(); ingresarOrg()">
      <input type="email" id="orgEmail" class="input" placeholder="tu@club.cl" required>
      <p class="small muted" style="font-size: 11px; margin-top: 6px;">Ingresa con tu correo, sin contraseñas.</p>
      <button type="submit" class="btn btn-outline btn-block" style="margin-top: 14px;">
        <i class="ti ti-login" style="font-size: 16px;"></i> Ingresar
      </button>
    </form>

    <div class="divider"></div>

    <p class="small muted text-center" style="font-size: 12px;">
      ¿Eres deportista buscando un evento?<br>
      <a href="#/eventos" style="color: var(--purple-700); font-weight: 600;">Explora sin registrarte →</a>
    </p>

    <p class="small muted text-center mt-6" style="font-size: 11px;">
      Al continuar aceptas los <a href="#" style="color: var(--purple-700);">términos</a> y la <a href="#" style="color: var(--purple-700);">política de privacidad</a>.
    </p>
  </div>
</div>




</section>

<section class="spa-page" data-route="/logo" data-shell="public" id="page-logo">
<!-- Componente del logo Match Sport -->
<!-- Pegar este SVG donde necesites el logo -->

<svg width="38" height="38" viewBox="0 0 40 40">
  <defs>
    <linearGradient id="logoGrad" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#17BDB5"/>
      <stop offset="100%" stop-color="#0B8B84"/>
    </linearGradient>
  </defs>
  <rect x="0" y="0" width="40" height="40" rx="9" fill="white" stroke="#E5E2DC" stroke-width="0.5"/>
  <path d="M 26 12 Q 14 12, 14 19 Q 14 24, 22 22 Q 30 20, 30 25 Q 30 30, 18 30" 
        stroke="url(#logoGrad)" stroke-width="4.5" fill="none" stroke-linecap="round"/>
</svg>

</section>

</div>

<!-- ===== ORGANIZER SHELL ===== -->
<div id="shell-org" class="spa-shell-org">
  <aside class="sidebar org">
    <div class="sidebar-logo">
      <a class="logo" data-route="/" style="cursor:pointer;">
        <img src="data:image/png;base64,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" alt="Match Sport" style="height:100px; width:auto; display:block;">
      </a>
    </div>

    <!-- === Tarjeta de usuario con menú desplegable === -->
    <div class="user-card" id="org-user-card">
      <button class="user-card-trigger" id="org-user-trigger" aria-haspopup="true" aria-expanded="false">
        <span class="user-avatar" id="org-user-avatar">
          <!-- iniciales o ícono según tipo de cuenta -->
          <span class="user-avatar-text">··</span>
        </span>
        <span class="user-info">
          <span class="user-name" id="org-user-name">Cargando...</span>
          <span class="user-role" id="org-user-role">
            <i class="ti ti-building-store" style="font-size:10px;"></i>
            <span>Organizador</span>
          </span>
        </span>
        <i class="ti ti-chevron-down user-chevron" style="font-size: 14px; opacity: 0.5;"></i>
      </button>

      <!-- Menú desplegable -->
      <div class="user-menu" id="org-user-menu" role="menu" aria-hidden="true">
        <div class="user-menu-header">
          <div class="user-menu-name" id="org-menu-name">—</div>
          <div class="user-menu-email" id="org-menu-email">—</div>
        </div>
        <div class="user-menu-section">
          <button class="user-menu-item" id="org-toggle-account-type">
            <i class="ti ti-user-cog"></i>
            <span>Cambiar a <span id="org-other-type">club</span></span>
          </button>
          <button class="user-menu-item" data-route="/organizador">
            <i class="ti ti-layout-dashboard"></i> Mi panel
          </button>
        </div>
        <div class="user-menu-divider"></div>
        <button class="user-menu-item user-menu-danger" id="org-logout">
          <i class="ti ti-logout"></i> Cerrar sesión
        </button>
      </div>
    </div>

    <div class="sidebar-section">PRINCIPAL</div>
    <a class="sidebar-item" data-route="/organizador"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
    <a class="sidebar-item" data-route="/organizador/mis-eventos"><i class="ti ti-calendar-event"></i> Mis eventos</a>
    <a class="sidebar-item" data-route="/organizador/crear-evento"><i class="ti ti-plus"></i> Crear evento</a>
    <div class="sidebar-section">HERRAMIENTAS</div>
    <a class="sidebar-item" data-route="/organizador/asistentes"><i class="ti ti-users"></i> Asistentes</a>
    <a class="sidebar-item" data-route="/organizador/diplomas"><i class="ti ti-certificate"></i> Diplomas</a>
    <a class="sidebar-item" data-route="/organizador/descuentos"><i class="ti ti-discount"></i> Descuentos</a>
    <div class="sidebar-section">DÍA DEL EVENTO</div>
    <a class="sidebar-item" data-route="/organizador/checkin"><i class="ti ti-qrcode"></i> Check-in QR</a>
  </aside>
  <div class="spa-content">

<section class="spa-page" data-route="/organizador" data-shell="org" id="page-organizador-dashboard">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <div class="small muted" style="font-size: 12px; margin-bottom: 4px;">Buenos días 👋</div>
        <h1>Dashboard</h1>
      </div>
      <div class="flex gap-2">
        <button class="btn btn-outline btn-sm" onclick="msExport('registrations')"><i class="ti ti-download" style="font-size: 14px;"></i> Exportar</button>
        <a href="#/organizador/crear-evento" class="btn btn-primary btn-sm"><i class="ti ti-plus" style="font-size: 14px;"></i> Crear evento</a>
      </div>
    </div>

    <!-- ===== TRANSFERENCIAS RECIBIDAS (comprobantes del administrador) ===== -->
    <div class="card" id="org-payouts-card" style="margin-bottom:20px;display:none;">
      <h3 style="font-size:15px;margin-bottom:6px;font-weight:700;"><i class="ti ti-cash"></i> Transferencias recibidas</h3>
      <p class="muted small" style="margin-bottom:14px;">Pagos que Match Sport te ha transferido, con su comprobante.</p>
      <div style="overflow-x:auto;">
        <table class="table" style="width:100%;">
          <thead><tr>
            <th style="text-align:left;">Fecha</th><th style="text-align:left;">Evento</th>
            <th style="text-align:right;">Monto</th><th style="text-align:right;">Total evento</th>
            <th style="text-align:left;">Estado</th><th style="text-align:left;">Comprobante</th>
          </tr></thead>
          <tbody id="org-payouts-list"></tbody>
        </table>
      </div>
    </div>

    <div class="featured-event-banner" id="dash-banner">
      <div class="feb-inner">
        <div>
          <span class="feb-event-tag">EVENTO ACTIVO PRINCIPAL</span>
          <div class="feb-title" id="dash-banner-title">Rally Costero Purranque 2027</div>
          <div class="feb-meta"><i class="ti ti-calendar" style="font-size: 13px;"></i> <span id="dash-banner-meta">Domingo 16 mayo · 08:00 · Purranque</span></div>
        </div>
        <div>
          <div class="feb-stat-label">TICKETS VENDIDOS</div>
          <div class="feb-stat-value" id="dash-banner-vendidos">0</div>
          <div class="feb-stat-trend" id="dash-banner-vendidos-sub">inscritos reales</div>
        </div>
        <div class="feb-stat-divider">
          <div class="feb-stat-label">RECAUDADO</div>
          <div class="feb-stat-value" id="dash-banner-recaudado">$0</div>
          <div class="feb-stat-trend">total de inscripciones</div>
        </div>
        <div class="feb-stat-divider">
          <div class="feb-stat-label">CUPO RESTANTE</div>
          <div class="feb-stat-value" style="color: var(--amber-400);" id="dash-banner-cupo">—</div>
          <div class="feb-stat-trend" id="dash-banner-cupo-sub">cupos disponibles</div>
        </div>
      </div>
    </div>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Conversión visita → ticket</div>
          <div class="metric-icon purple"><i class="ti ti-target-arrow"></i></div>
        </div>
        <div class="metric-value">68%</div>
        <div class="metric-trend up"><i class="ti ti-arrow-up-right" style="font-size: 11px;"></i> +5pp este mes</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Fichas médicas listas</div>
          <div class="metric-icon green"><i class="ti ti-heart-rate-monitor"></i></div>
        </div>
        <div class="metric-value"><span id="dash-fichas">0</span> <span style="font-size: 14px; color: var(--text-tertiary); font-weight: 500;">/ <span id="dash-fichas-total">0</span></span></div>
        <div class="metric-trend"><span style="color: var(--green-700);">Completas al inscribir</span></div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Total inscritos</div>
          <div class="metric-icon purple"><i class="ti ti-users"></i></div>
        </div>
        <div class="metric-value" id="dash-total-inscritos">0</div>
        <div class="metric-trend">en todos tus eventos</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Recaudado total</div>
          <div class="metric-icon amber"><i class="ti ti-cash"></i></div>
        </div>
        <div class="metric-value" id="dash-recaudado-total">$0</div>
        <div class="metric-trend">comisión incluida</div>
      </div>
    </div>

    <div class="chart-grid mb-4">
      <div class="chart-card">
        <div class="chart-card-header">
          <div>
            <h3>Evolución de ventas — últimos 30 días</h3>
            <p class="sub" id="ventasChartSub">Tickets vendidos por día · Rally Costero Purranque 2027</p>
          </div>
          <div class="compare-toggle">
            <label class="compare-switch" title="Comparar con un evento anterior">
              <input type="checkbox" id="toggleCompare">
              <span class="compare-slider"></span>
              <span class="compare-label">Comparar con evento anterior</span>
            </label>
          </div>
        </div>

        <!-- Selector de evento anterior (oculto por defecto) -->
        <div class="compare-selector" id="compareSelector" style="display: none;">
          <label class="compare-selector-label" for="compareEvent">Evento anterior:</label>
          <select id="compareEvent" class="compare-select">
            <option value="rally-2026">Rally Costero Purranque 2026</option>
            <option value="rally-2025">Rally Costero Purranque 2025</option>
          </select>
        </div>

        <!-- Tarjeta de variaciones (oculta por defecto) -->
        <div class="compare-metrics" id="compareMetrics" style="display: none;">
          <div class="cmp-metric">
            <div class="cmp-metric-label">Tickets vendidos</div>
            <div class="cmp-metric-row">
              <span class="cmp-metric-now" id="cmpTicketsNow">247</span>
              <span class="cmp-metric-vs">vs <span id="cmpTicketsPrev">198</span></span>
              <span class="cmp-metric-delta cmp-up" id="cmpTicketsDelta">+24.7%</span>
            </div>
          </div>
          <div class="cmp-metric">
            <div class="cmp-metric-label">Recaudado</div>
            <div class="cmp-metric-row">
              <span class="cmp-metric-now" id="cmpMontoNow">$3.7M</span>
              <span class="cmp-metric-vs">vs <span id="cmpMontoPrev">$2.9M</span></span>
              <span class="cmp-metric-delta cmp-up" id="cmpMontoDelta">+27.6%</span>
            </div>
          </div>
          <div class="cmp-metric">
            <div class="cmp-metric-label">Conversión</div>
            <div class="cmp-metric-row">
              <span class="cmp-metric-now" id="cmpConvNow">68%</span>
              <span class="cmp-metric-vs">vs <span id="cmpConvPrev">61%</span></span>
              <span class="cmp-metric-delta cmp-up" id="cmpConvDelta">+7pp</span>
            </div>
          </div>
          <div class="cmp-metric">
            <div class="cmp-metric-label">% vendido a esta altura</div>
            <div class="cmp-metric-row">
              <span class="cmp-metric-now" id="cmpPctNow">62%</span>
              <span class="cmp-metric-vs">vs <span id="cmpPctPrev">52%</span></span>
              <span class="cmp-metric-delta cmp-up" id="cmpPctDelta">+10pp</span>
            </div>
          </div>
        </div>

        <div class="chart-canvas-wrap">
          <canvas id="ventasChart"></canvas>
        </div>
      </div>

      <div class="chart-card">
        <h3>Tipos de ticket</h3>
        <p class="sub">Distribución de las 247 ventas</p>
        <div class="chart-canvas-wrap">
          <canvas id="ticketsChart"></canvas>
        </div>
      </div>
    </div>

    <div class="chart-grid">
      <div class="events-table-card">
        <div class="flex-between mb-4">
          <h3 style="font-size: 14px; font-weight: 700;">Todos mis eventos</h3>
          <a href="#/organizador/mis-eventos" class="small" style="color: var(--purple-700); font-weight: 600;">Ver todos →</a>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>Evento</th>
              <th>Fecha</th>
              <th>Vendidos</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="dash-eventos-body">
            <!-- Se llena dinámicamente con los eventos reales -->
          </tbody>
        </table>
        <div id="dash-eventos-empty" class="inscritos-empty" style="display:none;">
          Aún no has creado eventos. <a href="#/organizador/crear-evento" style="color:var(--purple-700); font-weight:600;">Crea el primero →</a>
        </div>
      </div>

      <div class="chart-card">
        <h3>Actividad reciente</h3>
        <p class="sub">Últimas inscripciones</p>
        <div class="activity-list mt-4" id="dash-actividad">
          <!-- Se llena dinámicamente con inscripciones reales -->
        </div>
        <div id="dash-actividad-empty" class="small muted" style="display:none; padding:16px 0;">
          Aún no hay actividad. Las inscripciones aparecerán aquí.
        </div>
      </div>
    </div>
  </main>
</div>




</section>

<section class="spa-page" data-route="/organizador/mis-eventos" data-shell="org" id="page-organizador-mis-eventos">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Mis eventos</h1>
        <p class="muted">Gestiona todos tus eventos en un solo lugar</p>
      </div>
      <a href="#/organizador/crear-evento" class="btn btn-primary"><i class="ti ti-plus"></i> Crear nuevo evento</a>
    </div>

    <div class="filter-row" id="filterRow"></div>

    <div class="event-grid" id="eventGrid"></div>
  </main>
</div>

<!-- Confirm delete modal -->
<div class="confirm-modal" id="confirmModal">
  <div class="confirm-card">
    <div class="confirm-icon"><i class="ti ti-trash"></i></div>
    <h3>¿Eliminar este evento?</h3>
    <p>Se eliminará <span class="conf-name" id="confName">—</span> permanentemente. Esta acción no se puede deshacer.</p>
    <div class="confirm-actions">
      <button class="btn btn-outline" onclick="cancelDelete()">Cancelar</button>
      <button class="btn" id="confirmBtn" onclick="confirmDelete()" style="background: var(--red-600); color: white;">
        <i class="ti ti-trash"></i> Sí, eliminar
      </button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-notice" id="toastNotice">
  <i class="ti ti-circle-check"></i>
  <span id="toastMsg">Evento eliminado</span>
</div>




</section>

<section class="spa-page" data-route="/organizador/crear-evento" data-shell="org" id="page-organizador-crear-evento">


<nav class="nav">
  <a href="#/" class="logo">
        <img src="data:image/png;base64,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" alt="Match Sport" style="height:100px; width:auto; display:block;">
      </a>
  <div class="flex gap-2" style="align-items: center;">
    <span class="small muted" id="autoSaveTop" style="display: none;">
      <i class="ti ti-circle-check" style="font-size: 14px; color: var(--green-600);"></i> Guardado
    </span>
    <a href="#/organizador/mis-eventos" class="btn btn-ghost"><i class="ti ti-x"></i> Cancelar</a>
  </div>
</nav>

<div class="wiz-wrap">

  <!-- STEPPER -->
  <div class="stepper" id="stepper">
    <!-- rendered by JS -->
  </div>

  <!-- ============ STEP 1: TIPO DE EVENTO ============ -->
  <div class="step-pane active" data-pane="1">
    <div class="panel">
      <div class="panel-head">
        <h2>Empecemos por el formato</h2>
        <p class="sub">Define cómo será tu evento. Esto ajusta los pasos siguientes.</p>
      </div>

      <!-- Formato del evento: precio y modalidad (estilo Welcu) -->
      <div class="formato-block">
        <div class="formato-group">
          <label class="formato-label">¿El evento es gratis o de pago?</label>
          <div class="formato-options">
            <button type="button" class="formato-card" data-formato="precio" data-value="pago" onclick="setFormato('precio','pago')">
              <i class="ti ti-cash"></i>
              <div>
                <strong>De pago</strong>
                <span>Los corredores pagan su inscripción</span>
              </div>
            </button>
            <button type="button" class="formato-card" data-formato="precio" data-value="gratis" onclick="setFormato('precio','gratis')">
              <i class="ti ti-gift"></i>
              <div>
                <strong>Gratis</strong>
                <span>Inscripción sin costo</span>
              </div>
            </button>
          </div>
        </div>

        <div class="formato-group">
          <label class="formato-label">¿Dónde se realiza?</label>
          <div class="formato-options">
            <button type="button" class="formato-card" data-formato="modalidad" data-value="presencial" onclick="setFormato('modalidad','presencial')">
              <i class="ti ti-map-pin"></i>
              <div>
                <strong>Presencial</strong>
                <span>Con un lugar físico de encuentro</span>
              </div>
            </button>
            <button type="button" class="formato-card" data-formato="modalidad" data-value="online" onclick="setFormato('modalidad','online')">
              <i class="ti ti-world"></i>
              <div>
                <strong>Online / Virtual</strong>
                <span>Cada quien corre por su cuenta</span>
              </div>
            </button>
          </div>
        </div>
      </div>

      <div class="panel-head" style="margin-top: 32px;">
        <h2>¿Qué tipo de evento estás creando?</h2>
        <p class="sub">Selecciona el deporte. Cada uno tiene plantillas con distancias y categorías pre-cargadas para ahorrarte tiempo.</p>
      </div>

      <div class="sport-grid" id="sportGrid"></div>

      <div id="subtipoBlock" style="display: none;">
        <h3 class="sub-title"><i class="ti ti-tag"></i> Modalidad específica</h3>
        <p class="sub-desc">Opcional, pero ayuda a que tu evento aparezca en filtros más relevantes.</p>
        <div class="subtipo-row" id="subtipoRow"></div>
      </div>

      <div class="nav-buttons">
        <button class="btn btn-outline" disabled style="opacity: 0.4;">← Volver</button>
        <button class="btn btn-primary" id="next1" disabled style="opacity: 0.5;">Continuar a datos <i class="ti ti-arrow-right"></i></button>
      </div>
    </div>
    <div class="auto-save"><span class="dot"></span> Paso 1 de 6 · Tus cambios se guardan automáticamente</div>
  </div>

  <!-- ============ STEP 2: DATOS ============ -->
  <div class="step-pane" data-pane="2">
    <div class="panel">
      <div class="panel-head">
        <h2>Información básica</h2>
        <p class="sub">Lo que el deportista verá en la página pública del evento.</p>
      </div>

      <div class="form-group">
        <label class="label">Nombre del evento *</label>
        <input class="input" id="f-nombre" placeholder="Ej: Rally Costero Purranque 2027">
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="label">Fecha del evento *</label>
          <input type="date" class="input" id="f-fecha">
        </div>
        <div class="form-group">
          <label class="label">Hora de inicio *</label>
          <input type="time" class="input" id="f-hora" value="08:00">
        </div>
      </div>

      <div class="form-group">
        <label class="label">Ubicación *</label>
        <input class="input" id="f-lugar" placeholder="Plaza de Armas, Purranque, Los Lagos">
      </div>

      <div class="form-group">
        <label class="label">Descripción</label>
        <textarea class="textarea" id="f-desc" rows="3" placeholder="Cuenta de qué se trata..."></textarea>
      </div>

      <div class="form-group">
        <label class="label">¿El evento incluye polera oficial?</label>
        <div style="display:flex; gap:10px; margin-top:6px;">
          <button type="button" class="polera-opt active" id="polera-si" onclick="setPolera(true)">
            <i class="ti ti-shirt"></i> Sí, incluye polera
          </button>
          <button type="button" class="polera-opt" id="polera-no" onclick="setPolera(false)">
            <i class="ti ti-x"></i> No incluye
          </button>
        </div>
        <p class="small muted" style="font-size:11px; margin-top:6px;">Si la incluye, se pedirá la talla a cada inscrito en su ficha.</p>
      </div>

      <div class="form-group">
        <label class="label">Imagen de portada</label>
        <div class="upload-zone" id="evCoverUploadZone" data-upload-target="evCoverInput" data-upload-type="image" data-upload-field="cover">
          <input type="file" id="evCoverInput" accept="image/jpeg,image/png,image/webp" style="display:none;">
          <div class="upload-empty">
            <i class="ti ti-photo"></i>
            <p style="margin-top: 8px; font-weight: 600;">Arrastra una imagen o haz click</p>
            <p class="small muted" style="font-size: 11px;">JPG, PNG · Máx 5MB · 1200×600px</p>
          </div>
          <div class="upload-preview" style="display:none;">
            <img class="upload-preview-img" alt="Vista previa">
            <div class="upload-preview-actions">
              <button type="button" class="upload-btn-change">
                <i class="ti ti-photo-edit" style="font-size:14px;"></i> Cambiar
              </button>
              <button type="button" class="upload-btn-remove">
                <i class="ti ti-x" style="font-size:14px;"></i> Quitar
              </button>
            </div>
            <div class="upload-preview-meta"></div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="label">Galería de fotos <span class="small muted">(opcional · hasta 6 fotos)</span></label>
        <div class="upload-zone" id="evGalleryUploadZone" data-upload-target="evGalleryInput" data-upload-type="gallery" data-upload-field="gallery" style="padding: 24px;">
          <input type="file" id="evGalleryInput" accept="image/jpeg,image/png,image/webp" multiple style="display:none;">
          <div class="upload-empty">
            <i class="ti ti-photo-plus"></i>
            <p style="margin-top: 8px; font-weight: 600;">Agrega fotos del evento</p>
            <p class="small muted" style="font-size: 11px;">Ediciones anteriores, lugar, ambiente · JPG/PNG</p>
          </div>
        </div>
        <div id="evGalleryThumbs" class="gallery-thumbs" style="display:none;"></div>
      </div>

      <div class="form-group">
        <label class="label">Video del evento <span class="small muted">(opcional)</span></label>
        <p class="small muted" style="font-size: 12px; margin-bottom: 8px;">Pega un enlace de YouTube/Vimeo o sube un archivo de video.</p>
        <input class="input" id="f-youtube" type="url" placeholder="https://www.youtube.com/watch?v=..." style="margin-bottom: 10px;">

        <div class="video-upload" id="videoBox">
          <input type="file" id="f-video" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" style="display:none;" onchange="onVideoUpload(this)">
          <div id="video-empty">
            <i class="ti ti-video" style="font-size: 26px; color: var(--purple-400);"></i>
            <p style="margin: 6px 0 10px; font-size: 13px; color: var(--text-secondary);">O sube un archivo de video (MP4, WebM, MOV · máx 50MB)</p>
            <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('f-video').click()">
              <i class="ti ti-upload"></i> Seleccionar video
            </button>
          </div>
          <div id="video-loaded" style="display:none; align-items:center; gap:10px; justify-content:space-between;">
            <span style="display:flex; align-items:center; gap:8px;">
              <i class="ti ti-video" style="font-size:22px; color: var(--green-600);"></i>
              <span id="video-nombre" style="font-size:13px; font-weight:600; color:var(--text);"></span>
            </span>
            <button type="button" class="item-del" onclick="removeVideo()"><i class="ti ti-trash"></i></button>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="label">Reglamento del evento <span class="small muted">(PDF o Word)</span></label>
        <div class="reglamento-upload" id="reglamentoBox">
          <input type="file" id="f-reglamento" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" style="display:none;" onchange="onReglamentoUpload(this)">
          <div id="reglamento-empty">
            <i class="ti ti-file-text" style="font-size: 28px; color: var(--purple-400);"></i>
            <p style="margin: 6px 0 10px; font-size: 13px; color: var(--text-secondary);">Sube el reglamento en PDF o Word</p>
            <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('f-reglamento').click()">
              <i class="ti ti-upload"></i> Seleccionar archivo
            </button>
          </div>
          <div id="reglamento-loaded" style="display:none; align-items:center; gap:10px; justify-content:space-between;">
            <span style="display:flex; align-items:center; gap:8px;">
              <i class="ti ti-file-check" style="font-size:22px; color: var(--green-600);"></i>
              <span id="reglamento-nombre" style="font-size:13px; font-weight:600; color:var(--text);"></span>
            </span>
            <button type="button" class="item-del" onclick="removeReglamento()"><i class="ti ti-trash"></i></button>
          </div>
        </div>
        <p class="small muted" style="font-size: 11px; margin-top: 4px;">Los corredores podrán descargarlo desde la página del evento.</p>
      </div>

      <h3 class="sub-title" style="margin-top: 26px;"><i class="ti ti-calendar-time"></i> Autoprogramación</h3>
      <p class="sub-desc">Mantén el evento como borrador y publícalo automáticamente en una fecha/hora específica.</p>

      <div class="toggle-row" id="autoprogToggle">
        <div>
          <div class="t-title">Programar publicación automática</div>
          <div class="t-desc">El evento será visible sólo a partir de la fecha indicada</div>
        </div>
        <div class="toggle" data-toggle="autoprogramar"></div>
      </div>

      <div class="reveal" id="autoprogReveal">
        <div class="reveal-inner">
          <div class="form-grid">
            <div class="form-group" style="margin: 0;">
              <label class="label">Publicar el día</label>
              <input type="date" class="input" id="f-pub-fecha">
            </div>
            <div class="form-group" style="margin: 0;">
              <label class="label">A la hora</label>
              <input type="time" class="input" id="f-pub-hora" value="09:00">
            </div>
          </div>
          <div class="form-group" style="margin-top: 12px;">
            <label class="label">Inscripciones cerrarán</label>
            <input type="datetime-local" class="input" id="f-cierre">
            <div class="field-hint">Por defecto: 24 hrs antes del evento. Puedes cambiarlo aquí.</div>
          </div>
        </div>
      </div>

      <h3 class="sub-title" style="margin-top: 26px;"><i class="ti ti-star"></i> Funciones exclusivas Match Sport</h3>

      <div class="toggle-row exclusive">
        <div>
          <div class="t-title">⚡ Ficha médica obligatoria</div>
          <div class="t-desc">Declaración de salud con firma digital al momento de la compra</div>
        </div>
        <div class="toggle on amber" data-toggle="ficha"></div>
      </div>

      <div class="toggle-row exclusive">
        <div>
          <div class="t-title">⚡ Diplomas automáticos con QR</div>
          <div class="t-desc">Sube resultados en Excel y genera diplomas únicos verificables</div>
        </div>
        <div class="toggle on amber" data-toggle="diplomas"></div>
      </div>

      <div class="toggle-row">
        <div>
          <div class="t-title">Lista de espera</div>
          <div class="t-desc">Captura emails cuando se agoten los tickets</div>
        </div>
        <div class="toggle on" data-toggle="listaEspera"></div>
      </div>

      <div class="nav-buttons">
        <button class="btn btn-outline" onclick="go(1)">← Volver</button>
        <button class="btn btn-primary" onclick="go(3)">Continuar a categorías <i class="ti ti-arrow-right"></i></button>
      </div>
    </div>
    <div class="auto-save"><span class="dot"></span> Paso 2 de 6 · Guardado automáticamente</div>
  </div>

  <!-- ============ STEP 3: DISTANCIAS + CATEGORÍAS ============ -->
  <div class="step-pane" data-pane="3">
    <div class="panel">
      <div class="panel-head">
        <h2>Distancias y categorías por edad</h2>
        <p class="sub">Define las distancias del recorrido y las categorías de competencia. Puedes usar las plantillas o crear las tuyas.</p>
      </div>

      <!-- DISTANCIAS -->
      <h3 class="sub-title"><i class="ti ti-route"></i> Distancias del recorrido</h3>
      <p class="sub-desc">Puedes ofrecer múltiples distancias en el mismo evento (ej: 5K, 10K, 21K).</p>

      <div class="preset-row">
        <span style="font-size: 11px; color: var(--text-tertiary); align-self: center; margin-right: 4px;">PLANTILLAS:</span>
        <button class="preset-chip" onclick="applyDistPreset('running')">Running clásico</button>
        <button class="preset-chip" onclick="applyDistPreset('trail')">Trail running</button>
        <button class="preset-chip" onclick="applyDistPreset('mtb')">MTB</button>
        <button class="preset-chip" onclick="applyDistPreset('triatlon')">Triatlón</button>
      </div>

      <div class="item-list" id="distList"></div>
      <button class="add-btn" onclick="addDist()"><i class="ti ti-plus"></i> Agregar distancia</button>

      <!-- CATEGORÍAS -->
      <h3 class="sub-title" style="margin-top: 30px;"><i class="ti ti-users-group"></i> Categorías por edad</h3>
      <p class="sub-desc">Define los grupos para premiación. Match Sport calcula automáticamente la edad del corredor al día del evento.</p>

      <!-- Selector de géneros: genera categorías por separado -->
      <div style="background:#F2FEFD; border:1px solid #D0FAF7; border-radius:12px; padding:14px 16px; margin-bottom:16px;">
        <label class="label" style="display:block; margin-bottom:8px;">¿En qué géneros se premia? <span class="small muted">(genera las categorías por separado)</span></label>
        <div class="genero-chips" id="generoChips">
          <button type="button" class="genero-chip active" data-genero="M" onclick="toggleGenero('M')"><i class="ti ti-gender-male"></i> Masculino</button>
          <button type="button" class="genero-chip active" data-genero="F" onclick="toggleGenero('F')"><i class="ti ti-gender-female"></i> Femenino</button>
          <button type="button" class="genero-chip" data-genero="mixto" onclick="toggleGenero('mixto')"><i class="ti ti-users"></i> Mixto</button>
        </div>
        <p class="small muted" id="genero-preview" style="margin-top:10px; font-size:12px;"></p>
      </div>

      <div class="preset-row">
        <span style="font-size: 11px; color: var(--text-tertiary); align-self: center; margin-right: 4px;">PLANTILLAS:</span>
        <button class="preset-chip" onclick="applyCatPreset('basico')">Open + Junior + Senior</button>
        <button class="preset-chip" onclick="applyCatPreset('completo')">Categorías oficiales FIDC</button>
      </div>

      <div class="item-list" id="catList"></div>
      <button class="add-btn" onclick="addCat()"><i class="ti ti-plus"></i> Agregar categoría</button>

      <div class="nav-buttons">
        <button class="btn btn-outline" onclick="go(2)">← Volver</button>
        <button class="btn btn-primary" onclick="go(4)">Continuar a entradas <i class="ti ti-arrow-right"></i></button>
      </div>
    </div>
    <div class="auto-save"><span class="dot"></span> Paso 3 de 6 · Guardado automáticamente</div>
  </div>

  <!-- ============ STEP 4: ENTRADAS + COMISIÓN ============ -->
  <div class="step-pane" data-pane="4">
    <div class="panel">
      <div class="panel-head">
        <h2>Entradas y comisión</h2>
        <p class="sub">Crea los tipos de ticket y define quién absorbe la comisión del 7%.</p>
      </div>

      <h3 class="sub-title"><i class="ti ti-ticket"></i> Tipos de ticket</h3>
      <p class="sub-desc">Asocia cada ticket a una o más distancias creadas en el paso anterior.</p>

      <div id="ticketList"></div>
      <button class="add-btn" onclick="addTicket()"><i class="ti ti-plus"></i> Agregar tipo de ticket</button>

      <!-- COMISIÓN -->
      <div class="comision-card">
        <h4><i class="ti ti-coin"></i> ¿Quién paga la comisión del 7%?</h4>
        <p class="sub">Match Sport cobra un 7% por ticket vendido. Tú decides quién absorbe ese costo.</p>

        <div class="comision-options" id="comisionOpts">
          <div class="comision-opt sel" data-val="corredor">
            <strong>El corredor</strong>
            <span class="opt-desc">El precio que ve el deportista incluye la comisión. Tú recibes el monto íntegro que pones aquí.</span>
            <div class="calc">
              <span class="muted">Pones $15.000 → corredor paga</span>
              <strong>$15.750</strong>
            </div>
          </div>
          <div class="comision-opt" data-val="organizador">
            <strong>El organizador (tú)</strong>
            <span class="opt-desc">El precio que ve el deportista es exactamente el que pones. Tú recibes el monto menos la comisión.</span>
            <div class="calc">
              <span class="muted">Pones $15.000 → tú recibes</span>
              <strong style="color: var(--amber-700);">$14.250</strong>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-buttons">
        <button class="btn btn-outline" onclick="go(3)">← Volver</button>
        <button class="btn btn-primary" onclick="go(5)">Continuar a mapa <i class="ti ti-arrow-right"></i></button>
      </div>
    </div>
    <div class="auto-save"><span class="dot"></span> Paso 4 de 6 · Guardado automáticamente</div>
  </div>

  <!-- ============ STEP 5: MAPA / RECORRIDO ============ -->
  <div class="step-pane" data-pane="5">
    <div class="panel">
      <div class="panel-head">
        <h2>Mapa y recorrido</h2>
        <p class="sub">Muestra el recorrido a los deportistas. Puedes usar una plantilla, subir un GPX o dibujarlo tú mismo.</p>
      </div>

      <h3 class="sub-title"><i class="ti ti-route"></i> Recorrido del evento</h3>
      <p class="sub-desc">Sube el archivo GPX/KML de cada circuito. Si tu evento tiene varios recorridos (ej: 21K, 10K), agrega uno por cada uno.</p>

      <!-- GPX / KML múltiples -->
      <div class="recorrido-list" id="gpxList"></div>
      <button type="button" class="add-btn" onclick="addGpx()"><i class="ti ti-plus"></i> Agregar otro GPX / KML</button>

      <!-- Fotos de altimetría múltiples -->
      <h3 class="sub-title" style="margin-top: 28px;"><i class="ti ti-chart-line"></i> Altimetría (fotos)</h3>
      <p class="sub-desc">Sube una foto del perfil de altimetría por cada circuito (opcional pero recomendado).</p>

      <div class="altimetria-list" id="altimetriaList"></div>
      <button type="button" class="add-btn" onclick="addAltimetria()"><i class="ti ti-plus"></i> Agregar otra foto de altimetría</button>

      <!-- ============ CRONOGRAMA (texto libre) ============ -->
      <h3 class="sub-title" style="margin-top: 30px;"><i class="ti ti-calendar-time"></i> Cronograma del evento <span style="color:var(--red-600);">*</span></h3>
      <p class="sub-desc">Obligatorio. Escribe las actividades (retiro de kits, largadas, premiación, etc.). Es lo que verán los deportistas para organizarse.</p>

      <div class="form-group">
        <textarea class="textarea" id="f-cronograma" rows="6" placeholder="Ej:&#10;Sábado 15 - 18:00 a 20:00 · Retiro de kits en Plaza de Armas&#10;Domingo 16 - 08:00 · Largada 21K&#10;Domingo 16 - 08:30 · Largada 10K&#10;Domingo 16 - 12:00 · Premiación" oninput="updateCronogramaTexto(this.value)"></textarea>
      </div>
      <p class="small" id="crono-error" style="display:none; color:var(--red-600); margin-top:8px;"><i class="ti ti-alert-triangle"></i> Debes escribir el cronograma para publicar.</p>

      <div class="nav-buttons">
        <button class="btn btn-outline" onclick="go(4)">← Volver</button>
        <button class="btn btn-primary" onclick="renderSummary(); go(6)">Ir al resumen final <i class="ti ti-arrow-right"></i></button>
      </div>
    </div>
    <div class="auto-save"><span class="dot"></span> Paso 5 de 6 · Guardado automáticamente</div>
  </div>

  <!-- ============ STEP 6: RESUMEN Y PUBLICACIÓN ============ -->
  <div class="step-pane" data-pane="6">
    <div class="panel">
      <div class="panel-head">
        <h2>Resumen y publicación</h2>
        <p class="sub">Revisa todo antes de publicar. Podrás editar cualquier sección después.</p>
      </div>

      <div id="summary"></div>

      <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 12px; padding: 14px 16px; margin: 16px 0; display: flex; gap: 10px; align-items: center;">
        <i class="ti ti-info-circle" style="color: #16A34A; font-size: 20px;"></i>
        <span style="font-size: 13px; color: #14532D;">Al publicar, tu evento aparecerá <strong>de inmediato en la página de inicio</strong> y en "Explorar eventos" para que los deportistas se inscriban.</span>
      </div>

      <div class="nav-buttons" style="grid-template-columns: 1fr 1fr 2fr;">
        <button class="btn btn-outline" onclick="go(5)">← Volver</button>
        <button class="btn btn-outline" onclick="saveDraft()">
          <i class="ti ti-device-floppy"></i> Guardar borrador
        </button>
        <button class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #16A34A, #15803D); border: none;" onclick="publish()">
          <i class="ti ti-rocket"></i> Publicar evento ahora
        </button>
      </div>
    </div>
    <div class="auto-save"><span class="dot"></span> Paso 6 de 6 · Listo para publicar</div>
  </div>
</div>



</section>

<section class="spa-page" data-route="/organizador/asistentes" data-shell="org" id="page-organizador-asistentes">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Asistentes</h1>
        <p class="muted" id="asist-subtitle">Selecciona un evento — 0 inscritos</p>
      </div>
      <div class="flex gap-2">
        <button class="btn btn-outline btn-sm"><i class="ti ti-mail"></i> Enviar email</button>
        <button class="btn btn-outline btn-sm" onclick="msExport('registrations')"><i class="ti ti-download"></i> Exportar Excel</button>
      </div>
    </div>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Total inscritos</div>
          <div class="metric-icon purple"><i class="ti ti-users"></i></div>
        </div>
        <div class="metric-value" id="asist-total">0</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Fichas completas</div>
          <div class="metric-icon green"><i class="ti ti-check"></i></div>
        </div>
        <div class="metric-value" id="asist-fichas">0</div>
        <div class="metric-trend" id="asist-fichas-pct">—</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Recaudado</div>
          <div class="metric-icon amber"><i class="ti ti-cash"></i></div>
        </div>
        <div class="metric-value" id="asist-recaudado" style="color: var(--purple-700);">$0</div>
        <div class="metric-trend">Total de inscripciones</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Check-in</div>
          <div class="metric-icon" style="background: var(--green-50); color: var(--green-600);"><i class="ti ti-qrcode"></i></div>
        </div>
        <div class="metric-value" id="asist-checkin" style="color: var(--green-600);">0</div>
        <div class="metric-trend">Acreditados el día del evento</div>
      </div>
    </div>

    <div class="card">
      <div class="filter-row">
        <input class="input search-mini" id="asist-search" placeholder="🔍 Buscar por nombre o email...">
      </div>

      <table class="table">
        <thead>
          <tr>
            <th>Asistente</th>
            <th>Distancia</th>
            <th>Categoría</th>
            <th>Ciudad</th>
            <th>Club</th>
            <th>Pago</th>
          </tr>
        </thead>
        <tbody id="asist-tbody">
        </tbody>
      </table>
      <div id="asist-empty" class="inscritos-empty" style="display:none;">
        Aún no hay inscritos en este evento.
      </div>
    </div>
  </main>
</div>
</section>
<!-- FIN asistentes dinámico -->

<section class="spa-page" data-route="/organizador/diplomas" data-shell="org" id="page-organizador-diplomas">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Diplomas digitales</h1>
        <p class="muted">Genera y envía diplomas verificables a tus asistentes</p>
      </div>
      <button class="btn btn-primary"><i class="ti ti-send"></i> Enviar diplomas</button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <div>
        <div class="card">
          <h3 style="font-size: 16px; margin-bottom: 16px;">1. Subir resultados</h3>
          <div class="upload-zone" id="evExcelUploadZone" data-upload-target="evExcelInput" data-upload-type="excel" data-upload-field="resultados">
            <input type="file" id="evExcelInput" accept=".xlsx,.xls,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv" style="display:none;">
            <div class="upload-empty">
              <i class="ti ti-file-spreadsheet"></i>
              <h3>Sube el Excel de resultados</h3>
              <p class="small muted">Columnas: RUT, Nombre, Tiempo, Categoría, Posición</p>
              <button type="button" class="btn btn-outline mt-4 upload-btn-select">Seleccionar archivo</button>
            </div>
            <div class="upload-preview" style="display:none;">
              <div class="upload-file-pill">
                <i class="ti ti-file-spreadsheet" style="font-size: 32px; color: var(--green-600);"></i>
                <div class="upload-file-info">
                  <div class="upload-file-name">resultados.xlsx</div>
                  <div class="upload-file-size small muted">—</div>
                </div>
              </div>
              <div class="upload-preview-actions">
                <button type="button" class="upload-btn-change">
                  <i class="ti ti-refresh" style="font-size:14px;"></i> Cambiar archivo
                </button>
                <button type="button" class="upload-btn-remove">
                  <i class="ti ti-x" style="font-size:14px;"></i> Quitar
                </button>
              </div>
            </div>
          </div>
          <div style="background: var(--blue-50); padding: 12px; border-radius: 10px; display: flex; gap: 10px;">
            <i class="ti ti-info-circle" style="color: var(--blue-700); font-size: 18px; flex-shrink: 0;"></i>
            <div class="small" style="color: var(--blue-700);">
              <strong>¿Primera vez?</strong> Descarga la <a href="#" style="text-decoration: underline; font-weight: 600;">plantilla Excel</a> con el formato correcto.
            </div>
          </div>
        </div>

        <div class="card mt-4">
          <h3 style="font-size: 16px; margin-bottom: 16px;">2. Elige una plantilla</h3>
          <div class="template-grid">
            <div class="template-card sel">
              <div class="template-preview" style="background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%);">
                <i class="ti ti-run" style="font-size: 36px; color: white;"></i>
              </div>
              <div class="template-name">Running</div>
              <div class="template-desc">Morado · deportivo</div>
            </div>
            <div class="template-card">
              <div class="template-preview" style="background: linear-gradient(135deg, var(--amber-500) 0%, var(--amber-800) 100%);">
                <i class="ti ti-ball-football" style="font-size: 36px; color: white;"></i>
              </div>
              <div class="template-name">Fútbol</div>
              <div class="template-desc">Amarillo · campo</div>
            </div>
            <div class="template-card">
              <div class="template-preview" style="background: linear-gradient(135deg, var(--purple-500) 0%, var(--purple-700) 100%);">
                <i class="ti ti-ball-basketball" style="font-size: 36px; color: white;"></i>
              </div>
              <div class="template-name">Básquet</div>
              <div class="template-desc">Morado · cancha</div>
            </div>
            <div class="template-card">
              <div class="template-preview" style="background: linear-gradient(135deg, var(--blue-500) 0%, var(--blue-700) 100%);">
                <i class="ti ti-bike" style="font-size: 36px; color: white;"></i>
              </div>
              <div class="template-name">Ciclismo</div>
              <div class="template-desc">Azul · ruta</div>
            </div>
          </div>
        </div>

        <div class="card mt-4">
          <h3 style="font-size: 16px; margin-bottom: 16px;">3. Personalizar texto</h3>
          <div class="form-group">
            <label class="label">Texto del diploma</label>
            <textarea class="textarea" rows="3">{nombre} completó la {evento} en {tiempo}, finalizando {posicion}° en la categoría {categoria}.</textarea>
            <p class="small muted mt-2">Los campos entre llaves se reemplazan automáticamente</p>
          </div>
          <div class="form-group">
            <label class="label">Firma del director</label>
            <input class="input" placeholder="Ej: Juan Pérez, Director" value="Cristian Almuna, Presidente Club Cumbres">
          </div>
        </div>
      </div>

      <div>
        <h3 style="font-size: 16px; margin-bottom: 16px;">Vista previa</h3>
        <div class="diploma-preview">
          <div class="dpr-header">
            <div class="logo"><img src="data:image/png;base64,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" alt="Match Sport" style="height:100px; width:auto; display:block;"></div>
            </div>
            <p>Certificado oficial de participación</p>
          </div>
          <div class="dpr-body">
            <p class="dpr-label">Este certificado acredita que</p>
            <p class="dpr-name">Cristian Almuna</p>
            <p class="dpr-desc">completó exitosamente la carrera</p>
            <p class="dpr-event">Rally Costero Purranque RCP 2027</p>
            <p class="dpr-date">16 de mayo de 2027 · Purranque, Chile</p>
            <div class="dpr-badge">🥈 2° lugar · Categoría +40M</div>
            <div class="dpr-stats">
              <div class="dpr-stat">
                <div class="dpr-stat-val">1:42:33</div>
                <div class="dpr-stat-lbl">Tiempo oficial</div>
              </div>
              <div class="dpr-stat">
                <div class="dpr-stat-val">2°</div>
                <div class="dpr-stat-lbl">Posición categoría</div>
              </div>
              <div class="dpr-stat">
                <div class="dpr-stat-val">47°</div>
                <div class="dpr-stat-lbl">Posición general</div>
              </div>
            </div>
          </div>
          <div class="dpr-footer">
            <div class="flex gap-3" style="align-items: center;">
              <div class="qr-mini"><i class="ti ti-qrcode" style="font-size: 26px;"></i></div>
              <div class="verify-info">
                <strong style="font-size: 12px; color: var(--text); display: block; font-weight: 700;">Verificable en match-sport.com</strong>
                ID: MS-RCP2027-0047
              </div>
            </div>
          </div>
        </div>

        <div class="stats-row">
          <div class="stat-item">
            <strong>247</strong>
            <small>Diplomas a generar</small>
          </div>
          <div class="stat-item">
            <strong>~3 min</strong>
            <small>Tiempo estimado</small>
          </div>
          <div class="stat-item">
            <strong>247</strong>
            <small>Emails a enviar</small>
          </div>
        </div>

        <button class="btn btn-primary btn-block btn-lg mt-4">
          <i class="ti ti-certificate"></i> Generar y enviar 247 diplomas
        </button>
        <p class="small muted text-center mt-2">Los asistentes recibirán un email con su diploma único</p>
      </div>
    </main>
  </div>
</section>

<section class="spa-page" data-route="/organizador/descuentos" data-shell="org" id="page-organizador-descuentos">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Códigos de descuento</h1>
        <p class="muted">Crea cupones para promociones y early bird</p>
      </div>
      <button class="btn btn-primary" onclick="openCouponModal()"><i class="ti ti-plus"></i> Crear cupón</button>
    </div>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Cupones activos</div>
          <div class="metric-icon purple"><i class="ti ti-discount"></i></div>
        </div>
        <div class="metric-value" id="cup-activos">0</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Usos totales</div>
          <div class="metric-icon green"><i class="ti ti-shopping-cart"></i></div>
        </div>
        <div class="metric-value" id="cup-usos">0</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Descuento aplicado</div>
          <div class="metric-icon amber"><i class="ti ti-cash"></i></div>
        </div>
        <div class="metric-value" id="cup-descuento">$0</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Total cupones</div>
          <div class="metric-icon blue"><i class="ti ti-ticket"></i></div>
        </div>
        <div class="metric-value" id="cup-total">0</div>
      </div>
    </div>

    <div class="card">
      <h3 style="font-size: 15px; margin-bottom: 16px; font-weight: 700;">Mis cupones de descuento</h3>
      <div id="couponsList"></div>
    </div>

    <div class="card mt-4" style="background: linear-gradient(135deg, var(--purple-50) 0%, white 100%); border-color: var(--purple-200);">
      <h3 style="font-size: 15px; margin-bottom: 8px; color: var(--purple-800);">💡 Tips para tus cupones</h3>
      <ul style="list-style: none; padding: 0; font-size: 13px; color: var(--text-secondary); line-height: 1.8;">
        <li>✓ Los <strong>early bird</strong> con 20-30% descuento generan urgencia y aumentan ventas iniciales</li>
        <li>✓ Cupones para <strong>grupos</strong> (5+ personas) ayudan a viralizar tu evento</li>
        <li>✓ Códigos para tu <strong>comunidad</strong> (club, redes) fidelizan a tus seguidores</li>
        <li>✓ Limitar el número de usos crea sensación de exclusividad</li>
      </ul>
    </div>
  </main>
</div>

<div class="modal-overlay" id="modal">
  <div class="modal">
    <h3 id="couponModalTitle">Crear nuevo cupón</h3>
    <input type="hidden" id="couponEditId" value="">
    <div class="form-group" style="margin-bottom: 16px;">
      <label class="label">Código del cupón</label>
      <input class="input" id="couponCode" placeholder="Ej: VERANO25" style="text-transform: uppercase; font-family: monospace;">
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
      <div>
        <label class="label">Tipo de descuento</label>
        <select class="select" id="couponType">
          <option value="pct">Porcentaje (%)</option>
          <option value="fijo">Monto fijo ($)</option>
        </select>
      </div>
      <div>
        <label class="label">Valor</label>
        <input class="input" id="couponValue" placeholder="20" type="number">
      </div>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
      <div>
        <label class="label">Usos máximos <span class="small muted">(vacío = ilimitado)</span></label>
        <input class="input" id="couponMax" placeholder="100" type="number">
      </div>
      <div>
        <label class="label">Vencimiento <span class="small muted">(opcional)</span></label>
        <input type="date" class="input" id="couponExpiry">
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 20px;">
      <label class="label">Descripción interna</label>
      <input class="input" id="couponDesc" placeholder="Ej: Campaña de Instagram">
    </div>
    <div class="flex gap-2">
      <button class="btn btn-outline" style="flex: 1;" onclick="closeCouponModal()">Cancelar</button>
      <button class="btn btn-primary" style="flex: 2;" id="couponSaveBtn" onclick="saveCoupon()">Crear cupón</button>
    </div>
  </div>
</div>



</section>

<section class="spa-page" data-route="/organizador/checkin" data-shell="org" id="page-organizador-checkin">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Check-in QR</h1>
        <p class="muted">Rally Costero Purranque RCP 2027 — En vivo</p>
      </div>
      <span class="badge badge-green" style="font-size: 13px;"><i class="ti ti-circle-filled" style="font-size: 8px;"></i> En vivo</span>
    </div>

    <div class="stat-cards">
      <div class="stat-card-mini featured">
        <div class="stat-num" id="ci-acreditados">0</div>
        <div class="stat-lbl">Acreditados</div>
      </div>
      <div class="stat-card-mini">
        <div class="stat-num" id="ci-total">0</div>
        <div class="stat-lbl">Total inscritos</div>
      </div>
      <div class="stat-card-mini">
        <div class="stat-num" style="color: var(--amber-600);" id="ci-porllegar">0</div>
        <div class="stat-lbl">Por llegar</div>
      </div>
    </div>

    <div class="scanner-layout">
      <div>
        <div class="scanner-card">
          <h3 style="margin-bottom: 4px;">Verificar entrada</h3>
          <p class="small muted">Ingresa el código del ticket (ej: MS-A1B2C3) para acreditar al corredor</p>
          <div style="margin-top: 16px;">
            <input class="input" id="ci-codigo" placeholder="MS-XXXXXX" style="text-transform: uppercase; font-size: 16px; letter-spacing: 1px; text-align: center;" onkeydown="if(event.key==='Enter') verificarCheckin()">
            <button class="btn btn-primary btn-block" style="margin-top: 10px;" onclick="verificarCheckin()">
              <i class="ti ti-qrcode"></i> Verificar y acreditar
            </button>
          </div>
          <div id="ci-resultado" style="margin-top: 14px;"></div>
        </div>

        <div class="manual-search">
          <h4>Buscar por nombre</h4>
          <input class="input" id="ci-buscar" placeholder="Nombre del corredor" oninput="filtrarInscritosCheckin(this.value)">
          <div id="ci-lista-inscritos" style="margin-top: 12px; max-height: 240px; overflow-y: auto;"></div>
        </div>
      </div>

      <div class="recent-checkin">
        <div class="flex-between mb-3">
          <h3 style="font-size: 16px; font-weight: 700;">Últimos acreditados</h3>
          <button class="btn btn-outline btn-sm" onclick="renderCheckin()"><i class="ti ti-refresh"></i></button>
        </div>
        <div id="ci-recientes">
          <!-- Se llena dinámicamente -->
        </div>
        <div id="ci-recientes-empty" class="small muted" style="display:none; padding:20px 0; text-align:center;">
          Aún nadie se ha acreditado. Verifica un código para empezar.
        </div>
      </div>
    </div>
  </main>
</div>
</section>
</div><!-- cierre de .spa-content -->
</div><!-- cierre de #shell-org -->
<!-- ===== FIN ORGANIZER SHELL ===== -->

<!-- ===== ADMIN LOGIN (standalone) ===== -->

<section class="spa-page" data-route="/admin/login" data-shell="admin-login" id="page-admin-login">


<div class="admin-card">
  <div class="admin-icon"><i class="ti ti-crown"></i></div>
  <h1>Panel de control</h1>
  <p class="sub">Acceso privado para administradores</p>

  <form onsubmit="event.preventDefault(); ingresar()">
    <label>Correo</label>
    <input type="email" class="admin-input" id="email" placeholder="admin@match-sport.com" required>

    <label>Contraseña</label>
    <input type="password" class="admin-input" id="pass" placeholder="••••••••••" required>

    <button type="submit" class="admin-btn">
      Acceder <i class="ti ti-arrow-right"></i>
    </button>

    <div class="admin-error" id="err">
      <i class="ti ti-alert-circle"></i> Credenciales incorrectas
    </div>
  </form>

  <p class="admin-hint">Demo · clave: <code>match2027</code></p>

  <p class="footer-link">
    <a href="#/">← Volver al sitio público</a>
  </p>
</div>



</section>

<!-- ===== ADMIN SHELL ===== -->
<div id="shell-admin" class="spa-shell-admin">
  <aside class="sidebar admin">
    <div class="sidebar-logo">
      <a class="logo" data-route="/" style="cursor:pointer;">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK4AAAB4CAYAAABra8ncAAAgGklEQVR4nO2debglRXm436+WPss9d1ZmWGRxQWQbEIEAIjpA2MaBuPwiKG4ICnFDJErUGIlJ3GIWDT4xLiQRVECMRKMhGHBAglFBEyKbBAVBUUFmhpm5957TXfX9/qjuc869M6gkMDOQep+n55zbS3V11VdffUv1GchkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwms/Vh6i2TeUwggNvSlchkHg62+dJut3f2vvuM+k/ZQvV5XJOns0cGC4SJiYml3nfODZVcr6qN5s2Cm9kqcQBF0XuBs517veupd53L62NZMWS2ShyAb897sacIvphUb7vB2uI4kqa1v/zyTGbz4wH85KJXONDWU3Yvi133qBzmZvbf35NNhMxWiANoTS46xeO02OXJYeLdf9z3rY66onPm+DmZzNZC0rTd3qnOd7Q9b3618NrrKn/Qs9TDA5O77764Pi9r3MxWQxLaVu80X0yoF1PteN03QuuCz5YO1HcXfqQ+L9u2ma2GWmi7rypak2qg2vvTnw0Lp8soS7ePhS1Kv3DhXvW5OZqQ2SpIQuu7pxbtSQWqZ/zZX4RlqpFz3lkWoK4zP4fAMlsVtdC2Tm115itQLXvnueEY1ei+/8PoFyyuvG2rLTrH1+dnpyyzxWk07WmtzgIFqqe+4cxwoqpuoxrlDWdVBahrz7sNKEgOWXbK/o9iSFrLPsTm+NXTcXPeQ5Xx62xJaE1rKLS7vPjk8DJV3acKkZv/O7YmJkvvu+qK9tvrOrX+l/fc2re5bfyrtv8zg/jh2IebahR5mGX8UrxvvaZoJ/Ng+988JrykqnTlzCA61ehPeXXwEF173v1A75G6Z+bXY2saEQKo9939RePKiOyqGr2IQTWqiFFARMw9IuUnBoPBbc0149cDONd+lqocK8JOQKGKiNTnaf3MohakvjZK3RRCBERjVJlwRWtFOfOgLtr36br86lWmNzGh/yKWn37vZlq/cYBGNUZV7yfGVYDBgKoGMIiogGi6a4T0HEgaV1rXONVZ62+jI+MoqgYzboZImHO2zDp/TnuoRhExoBEFFRFDxGJQkECMghhVIqoIiBiQyFALCKKDKrTPgLVrALztvEdFn6qqpWDM8G7pSSJRvXFy4WAwfRn1IqRf1vkPl61FcA0Qve98EOybAUG1bnpJPSu1vCEo4QFjwv79fv8uZguvd7b1cTH+5em8WmJ19Anp7DQKmvI2lhYxlqq/QXu77Mzya7/Owh134PbpAde1HK2TTiZ+7iJoz4cQpCk/la2p4HGafVrffPgszTjSh6zHxhWrpX3sNsPidXjK7NvHiBiTnr958I3uJXVZcfQsY8c0DL5cxf7xgHY6nSdUpdyTBqPW9xtdk9pZUQ3HhtD/Fx4Fwd0aPGALBOc6rxXs2QBRw6dE9PIY41pqh8cYK7HSV2HtSsEsipW+Hvhd0jNEIDrX/oxgX1iX8XmR+HlCXBtn38+AVCDvFnH7qWhAx+03RYwlVH38/El3yBf/kckdd2DdoOTGTqGtNetg1TWCFEoM6QIItdhY1XC+iL1SJM7Q9KbUj5kUpYz60dYjFGlEeNyQDGlAlyK6Y4z6LjBL0BAVrhKNVxtrfygio/sMP63OkhNbK3ZVKyJVCOGpGvkjEIPE9zhnv0NQi0VAYijD81XsSaAViIEYxcZziEnaq74egTEK8VrV6n2qGEAsrlLD80BORfVHIfRX1TWY0wWPfZrpr+Nd987CT4bCdz/yS85f6l13XeEng7PtnwDzaFZo+fZHvZ9U7ybU2s77f8V9W8517vO+p77oBe976n0vet+LvphUX/SitV6Xf/Vf9UWq+tLBID6x0uiqoD3V2DrqWPUQfXte9L4XnZsove+pt+2PPjLNMruu3nauK3xPne38l7Wt5f/bAo1pneZcT73rPggsnHvcufbnU5tMzBS+p851vtTUBcDa1sXe9dS51ukbX9u5wPueWtu6oN71uMwiWgBrW0d6P6HeTwyKongaSdMUzPZQWwDetz9c+J56N6Het15ZX//+IgmfWml9oC7bsXFkoQU449snp/v1yqLoxUZwi6IXi/b8CMTf+Pgn9CTVeHI50MOCRhM0TgwGcUI1tt/9J+pAfWdBI7jRu4lQFMUe4/f5X2y+LqNtbefawk+q951VwIL62cz/sNwCsM51rvJ+Ur3vfo2kOHy9Wehu51x3Xd0mVeF7lffd/cf6bMLa9i+c65atVmvX+nmbvlqcFMKEetN+xVg/POJsaVNBAAzyfMGoEm4cDAa3k6bfwZxzFRBr+WAI8RTETKDmFc60JsS4twLEGD4YtP9W0nMFNuXqQDAqKxDROWUj1tGfXiN7veOd+uTTTtWqKonG8Z0I3oFGIwIqhz5TBQMxQvK8rGr4zzI5jAr0H8bzK6OpvqmTA/rWts41xh4aNdxdtcyLKFlDErCyvuZh240TTGzbR/cDEI1fq+/ZbMHa6mAR3yO1f6ExXFOG6Z8ATwJKY/xzROwi0fDtfr9/x9hzhMJ2D1aRbUCnbMGqcoa6fR5fNJ3VcrZze1FMqvedd9f7HmpAWQDv2+f5pHVL77ta+J5a2/mzsXM2lQho/p7nXOdntUYJRTEZvZ+Irc6CCMRdXvxSfZFqfF5ZxperxicNQqQM2o2qnRB0QjVO3H9/LBZvF7201BeTA+8m1Ln2H4zXcRM8rDCd936Zc51+0l5pZqGOLc95NluX/atiqi3AGNM+sW676Fz70LEyHIC17Y/WbTNIs0l3nXOdKec60851ppztzHg3Ea1tjfdVY659KJlc3X/bRD0fUbakxjVAcK59oGB2VY2qypfrYw/lXisgxugHYwivErFWEUIs/zyE/tmkDohQh2Q2cb+i6D5bVZaCBhCjqoj1DKbXsPSQQ3nG+R/XfghMOMMdVeSH3lAkxxxjDBoidvFiZN990Ku+qpi20xgVzCsL131hRE1TBwMRTIBYYOScwWDqK4wEOxRF54Uxmt8X0QFgiaCiIiIRZTsRU2gMt1ex/+m6/lX9GVuu8wZFXh1VWwy9em3CZTpS5IqqitRhB0UWpobUe6tq5rtj7RoBD3LEWHshYubEqFUVFZHwlTnXWlVZbgTRqFfVx2xd50ecLSm4qblVThAjRA23VtX0d+pjzRRoGAnxsIH6/f6d1hZ/a8W+NsbwpyH038ocoV0CvftgmjnTaYz6vBQT1ghqxDrCYIrujrtw4KWfg3YbFwIzAW4A3E9/LjzwAOyxO8SIxKhYgznsUOJVVzSxJxExT1JAxuJUw9GngpFw29hzSF2Xk4yYpw/DYGZMRUlzJReRTAPHcDpvHa7Gfpg6Kjw7ELwxs8Nhw1pdB0wxGkjRe7+3quw61mZzC40KBvTOqqq+O7Zfvfe7o7IHKCr6r2PP+qiwJVcyBcApPDf1tX6VUQcZSIkE54pzSA3QNHBj634kxPIDIUyPC60FonOdgx6wrXfW5xpG9mAH5Gia98HEoDFgvOWAiy+ivcP2lFVFx1q+MxOYcUbM6Wdg/v5TSRZDHAoqhxySitHY9G5Mg4GY7qURKAUiqv9W24ONTRuACUEOrc+r6mvqjXqLosK4ZkuBNTGnqBIV7Ssa0HS+qkZNAzKkRMiwvFh/j3UbIxL+pS53aFap2qPrvIMFtfU1FcQKjSUa+6BBVP+ZZMe75npVdwRifFS9u6pmrmfYJo8OW0rj1rFbt7+QRmmM2oRcGmGLwGFg3wH8NbCOMRNgMBjcDJzDSCgdUHn8vsAVYuzvhkBkTFM51z5QRHZqzAQxQjmzjmd86kJZ8syDtV+W9Lznrg0D7pwo8J+5BP3iF9D2S9KoEUFMkly7375UC7aBB9eBdQAyzMqNqJNP8cqx52605oGI2V5HAw6Ggq0KYjTqj6ow/Z9j7RKAroocDhhJA39c+Ugt3nNrMp5xcBBLEb16rI7NaUfXjuZ9MeqZzsXvkDJtcXRuy/T77ucwQ12fps5H15/XARuaPuZRYksJbm0m2N/CGNEY7g6h/436WBweF3kW2I61rbeE0P/9ur7VWBmGcaH1fj+N7goR03Yufrksh+XV9pocX2eoojhnBtNr2O0tv8fOLztZpwclrcIzKCuu9wXme7cirz0DNR699VYIAXFWU6ojiixditl3GfHqr6G+QGKUWemrhFEUFWnW6o4iCIbjUl0IJKer8eypn8kgXE0yd4YOn2u3D5BodlRNeeS5+baU2q7rMZaWaHLbiFjVeHNZDv6bkbYNExMT2/b7eoRquNq5eGpV9e8YzI3rAJsImEQmJxczHQ5JiUhpzIRHNSu7pUyFAFjFrCCljK5iNEohCdtSVZ4JRMGc2Wq1nkjToYlGAzmgcq7zG6r+ChG7DVFvmJ6evpfZU7NVZUWyM7wpp9ew3YoT2PUD76VfVeAsHSLX92G66uNOOUV07VowBfzwLvRnP6+TpTEJMWAOe1aq/niKdPQ1ChjV+KOqmmls99qMQETNMSkGh5l9tUBdoohePlZqGsxBjqq/DtN2m2KUhh1L3iVPDVW9ipH5FQAzGFRvEol/GcL04bVZ05gBZmyTWYXW/VX0q2eLyGIlThsTGsF9VMNgW0JwLaDed/cVkb1RFaN8sT7WNBTWFs8SMfNASxHbC8H8IbNjnjAU2vZzROQKEbO4drrGO8YA2vXdfUTMHmKsVjPrTW/Xp7HXBX9HiJEgho4x3PFgxY96Tvw5b0Ov/3elMw+MQdetVr31tiQLsfbQAQ6to0ljayCG6xFSxymwiqSmmjCdFkWxm4jsVStC0ywxaB5KwKnGqdLJ+HReT7tyVL1vtonAqAr1pzQVGqlyMfW+K0aXLp70vv2iGLmiLGfOGiu7YuQQN1tzr1njRVWPlrRg6YZ+v38nm47qPKJsCcGtPerwW2Csarx/EKZX1ccamwmDOSaFdTCgUZCXeO+XMZr6PVBZ2zoSzFfAzKcOF2ly9GBM0CvheDFWYiwr223ztEsugkULpQyRwhoenBpwfa/AXngJct5fQHeBoHXmwSBy4421FxIVk5rN7vd0ZMESdDBo3JvxHq1Vp3557G8DSIz2CBCnaIWOacP0kTpc9btMT/+YsRmmDTsBe9eDU1K7DJ3CJGRJp0Z0TOC0HkSKQXV1L7S/2bT3okUqrZb7VxH7Jms7t1nT/p61nf+ytnPTaGvfZE3nZmtb34beovraRri9qixPOl7HbflHlS0huAEwglmZnAi9BniA0cNWQAFyZB2XtICKGKdq30PqIA+URdF9rhH7TyKmm7xfvGr4WVXN3FCXNZyaQVZiBC2nzJM++Ula+z2dflmqeAdlxbelIHz3JnGv/x3UddCpB9GZdeiG9WiMxK/XMXWRtMWI2XapsM/eoDNgzHCiT3UUqxrXe2+uGXvupPxEjgZBkkkwnsJrNBxAIwTNFE1pW08TZCJpTjEgtt5G07mIEcSmSFlzfOjsguq/r2Xt6rpdzQMPPPBgv9/fRcScYIzdTYzd0ww3N/q0dg+DVVh//3idvPf7CLIbRKwOBfdRC4M1bG7nrF6+6JeB7JPMQ/0yI7vJAMH77p4oT2akMY1CEMxKa1vLQ+ivMqZ9oqpciIhLGicVEVW/Dqxn5MFrURS7i/P7VVNrdPE5bzfdk17EVFnS9h4fAzfNiKze8KC2XvlSdO0DKp352H33QVKoHabWIRs2YEIkWJf8nxDAGMwzDyFe8zUQ0TFfvokUfGtqauqnjOLRAZiH6qH1RD5XcYxsWRiPJkRAQnA3Gon/jOoeMSUVRiaCghKNqCFlH4ZRZVSDEXVLEBzEr47di3SSPTYZ71qBuuH0QRz5CIpTif8w1o/1fe0RImJU9e6Z2bb8o8oWEVxVu9KIcZGwvirNFYw6J62yVj289lkqEDfUSWIQ4u95316qai6qlVWsNU4UUazl8rSEYCgEVWxNrJB1q137uJVl8b4/cRvKkrb1OOCn6wM/8IX6N5yBfu8/VNsT0rvoAjUnHD9MJaiClgNUmjB/0roCag45JNWtyQFo/RegxMaWHAquta1DRMwSmuhJrXLHYwDpoczqsXarG2DDz8uKFaT07UN57eM2qAGic24Zaq9DJIjVKxvd22yqcpQYDDrUzvXx4cJdk2Y/GU8sNPc4Itm38Vo2QxisYXObCskTVo4HUYFvwvQ9jKayZqQeO2t1ctK7KaSFPRrsxaPl1Om9AxCnqoPS8LW6jNT/r3hFm3VrX22e+GT1n/pb0w+B0loVA+XUgJvbBfaP3y1y6Weh3aX7uYuxJxxPrCqiKkGVKKgWRdK+KUaqaayA3f8ZyORCGAxowqggFo0qEhrBHYb4DPLcWrZibVrMde1qbRnnsfF7W82s1CcFUje1TW+8zx+MWKcaby3L8ubx9ul0OjsYkQPrfZuSh6S6iT+sqlkx5TgxMbEU5CBAVKR51kc1DNawOQXXkKbtPYyYZygqmrzbZrld/UNxE0sROWSj+jXjO9mYMcnIcKqMdaTnJvr9H9VlOUSi/+zFHzKt1tO46KIw2GYbE6zFhCjtQcktrYLy/L/HveddqPW0L7gAu/K5VFPTKT1aVWgVoCyhrKCqoKyEskorwwYlst22yLJlaKzt3FpIFf1BWZa3MPvlTq/DqEAt+cPnGv2brN/4Akaaa3yJ5sNZ0ujT+XpMciz12vqOrfqYrSpdjphunX3blNClOmi8luR/NNe6cqY8TDALlThjTPj6qC8efTa34BKjOQ4xBRqmq0o+Q2qMGVIqMlgbDxFkMqUspTG25jappHejhnsVwBi9rC6vBPq+NXmSDGZew9/9fRUPOtCUP7mX8hPny3YP3M+9hWftP31VijedgW67nbavvBL7/16AgppuB7xHvE/Om/cpuuAd4l29z6GFR6zFHHUko5k1dZwol9XPVTVbURRPRmQ3mjlExxyzkTtjk3FpT3audcb49f+DrU7LykGgRPQSkiD26y2oyjEb1WA2ktS8vaR+tubaSo05on657r/6/f4P2AxhsIbNaePWHSonAKhyX1GwH3Sfng6rAak0curQ6mvSPzKcg4fMCiFpepVQVY0tuissGPVuPtMbPiKnnR7jU55k5Kw3S7zkczz1rz7M2m234+5rrpfilJM0lgF35FHofT9n8Mnzwfk0kcvozbDGQ1SRtFkLzoMxSKuAQakiFmKsp/Jk4hZFdyVoHS2RSpXnSoqlpvd2Zo+78S+SkmLy19aal0K80hi5AxiISMBaJQTqd3JmUa8EU1U1IhIg7hWjbJO0ouyE7a6wqAWJoD5GObK+dFyJjYWDcaqxwoQlBcVxWOtAAmgnRlYYQXQUNx/PbD6qbBZ7hNqGbbfbO4VgbkWlqPe7kQUwqyqhltn6H5U6wJ2cBSGtU5JRx9cOvaN5cVE1Cdb226r86G6ptK9P+cAHmXzL2Xz3O7dhV/6myL0/U9oT6MwG6rUndWlDxh2d4c1kThBesSK+o6jWr/VKnWUbq139sqQy5uPNioTNuXMiRSfmlJZe/Gz21Z7d+Mug9e6mkpqkOTQ/7z9yH2ofktr0UkTrFU/jvVGX62a/kClJn2i1trRxPzZT4qFhc2lcA8RYcaKIdMcc75ErPXayKrbuYpA0nzYvyTa2g8pIF9ZtPVsxCxUxGvnxvVJqX5e87JX03nI2N992F+bFz0fu/YlqexJCBUULbJfxcTEW2hrt1NmVHO6Ldfy/EZjmFe1aMGVo62ht3mxUmGwsxKPwIDJy7sZf4R26p6P2HN5E05fGJHFS9/XodG3aVFAdSxjMtsFmV3P8uAbg3x2cXfb7P2Q8VrwZ2FwaVwB1rnOg0bALECHU7fOQSZam/VMd7ejNWACtKkn7hufWHW3FmDg/Bvlzcb6I/Q20ly2Tnb95XbznF+tk6pijMDf9JzqxGEL9BswsIQxJHsbWV4mR5HiNO4jNu94xNjKQ6gWItWORpGangEY0NK9/DzVzqr+1TdRYRzdBCdVYQWmfGJPU9pgGrJMiQow6NoDS4RijomeqDn4G1thRu25qsDBnvzTmB6AhBLC2ahl351Q59R/1OZtVaMcr+rjCuc7pYt1HNYbKtb19wg3fZvW2T9C1Rx0l9lvXoZ0F6PQamK3IU2f53rgaS9oxlKDDVVGNxKlgBN+tf+ijjtyJQLl+GAPeSDpcL80Rw6hvEjgNU7OHRXO+7YgYMxJwRCmnUOKmOk8oJrW5WqBCxKuWf1WWM2/8n7foL2WzCy1sfsFtUpOJ5zwnfa5fn+qxf/0y6erVv7xeCxfO1hQf+9hIM8+bN+mnq1uxfonOrI1LP/8FmVm5kgeXH4n5xjVJaGc2MHHWmRTHr6R+G0LEOfSuu1hz6uloVSfijBEtp7XYa28m//QDaLebZEqVeN99TP3lhxlcdx24lkhURYxouYHWC3+bzqtfBa0WtaMkunatznzsE9K//J9VXCdpRyNKFTC9rkz+zUfU7LRTysgBDAb0v/ktpt77fuhXSZytFe2v1+6LX0LnjNOJUxvQmRlkchLjPeGWW2Tta9+g2ILhz9eo3jPo+WWsXj3Fsccadt45/trte8MNo329nnL11c1fTcx5i70IubkzZ+NJBsYaIjHeUA+ftFJsanCq+M6SML26mjzn7Xbwgufx4GHLMd+4RultI7r+fibf+S6673gba177OrQ/qBWjUVm3Di1LMK527iwaK2m95jUqy/aSta9/PeLaEAMLL70Y7fcZXHs1YropcjvYgD/0MBZeehHr3v+nVD/+sYoviOWMTr7lrUy8/730v/Il6p/QqcvfgDviuRQnncjqk1+e4sVa0l55PPPe8Tb6f3ehVP99m0prAjSmX9j5yU9Y/+kLsTvtTO8db2PdH5xLvO9+9O57UkvUpoyAGMeZrF69FoDLL3+otnvMscXeOfvtSy6xNx188HwWLSpKERvLshOj7caisKYoXKS0mkTIaBOYr4hBCQZi8ARUlRI23P2D23+xxx7rWbRoHhvKs+L0au0cu8L49/0Ja488GnPt1dBdCOUAjMEdeSTaatE98USwDh0MNNx4Ixve/vvpjrXTImWJ+Dbu+b8l4eZbcGWpVIjdeUcVoP+5S6kXr5F+jijQPfvNlN/6Nut/763DqSWCTL76NVRXX1MHACStLydFHFovPhG95x7Mg2uSR9Wfoth9d+lffz3VD76PFB1EYzK8bYty1dcJq66kd/Y56O23M/1HfziaOotJIcZSRHzU8Pn+zNQXAPu0W+7rVk+Zv1sKIWBtalfjktkjAVQqgnE+RKUy5YZYONc3MzN94+f3w7qfVeanuv7Gp2+/YXPLyqbYYoJ705572rIoFlj1XQWPjfPF+4Xi8OigsOBFxEcoFGOFaNWkd/7AqKSFsRokysSGDff+AtYVpb4m9qe290/etWyf/0n/4IqVylVfRTsLkXKApl8TYs2xK/EHHySy7VJ0ZkrbJxzPvHPewsynLpTy5ptUWl1EjGp/nRQHHYrbblvCmtX0zjtPFFVm+rLuzLO0f9k/iviualSVMMBOLsT/5uGsf+NZTfNKpKI4+DD8sr158OWnMMxQGxEd9NX0FlI8+1nEqSm6530It8uTMMD0J89nw7vORaTO+tZ2q6oi7Q5moHRe/ztMXfiZFPbrLUb7fYghCsaohtXO6RvLgQoisdrebxsjy8VQCZhkIseoxkQC6ixRhUp1UAl2JhpfVv1qujBmzcAN1hvXnYEfKOkFy4dKVmQeNnvu2fOmuKfozYsLvvTlqn3sCnUQi+6i6H0vFp35wYuN8087I2636uqw5LIvxiWX/WNccumlcYc774qLL7o4FmKjLybTTzG150cHcdFlX9Ttbrkl/XINPnps9BAdpPP8RHRFTx0utnfbU3dQ1aV33KFLVq3Spdf+my5dtSo+Ye3auM0/fEEdRptrfHu+Ooi9018Xn6CqxYLF0ULsPPPZcQfVOO+1r0v36CyI3k/E5hd3iva86DGxe9jhcUfV2N5jn+iwsWjPr+vT6xfFpPpW61V1yzwufwJpy0YVtIlrDtm4PqtWCcuXj/1d/7N8eRr1b3yj47zz+kW7+ybgL+zrXl/pt75lwzVfg84CJFQp2mWNajlD6/kvEL/PMmIMwyB69f3v07/kc2maNrVGRCAMaJ92KvH7tzP4+jXg2ilmK6aOsNZp/DoBgAb84c8Rf8ABivPSPGC49Vb6l30RVUTFpPCqGAh9iuOOwyxayMynLoSiA4MNtF72cuzChUz9zcdTooVh6EswRqlm1B1woBQH7M/URz8G4lSMxDrR4CFcPBhMncT4Si1VYdUqy/LlyqpVAsuBVTwHuBpG7bmJXgLgXOBcdM4vAG0xHuvhsFT/PZdM+FseuEV222M7nIt60384OvOFqhpmmZqXCONg3ez4cP3d+F4d+Kyj7JqSvlquBwQperXQbhzqHK1/BK02bQKKmxgFusYyewzWpT0pjJXuOViXIr++19xnGEhNMm809qdEqJRiUpj1gx/xC+W2i07mnnv6jLz/xx2PdcF1QFW44o1I8SGNMcVcW+1RWGluys3YRopTKFVIWi2mFxR0bjdbWydFw6zcrw7LnBOpNaZZJTYaGVqXvwkRapIVWo2l+F39Rn01WtY6+p3fVLKKpGurClVdbYQblfjxspz59Hg1f92GfKzxWBZcAeh2u9uWpd6RnGT9pop8idi/TkRGiw9KRr+61fzN2L7yIb6TVjT65txyPFGxcXmlR3w52uVHZWpzfenBl2PH0/3SMCg3ndGaW308lOlcvCe0Wq2frl+//r7xdplbRmbrwQAU3e5xRdF+c7vd3nlLV2gLIzxOHbFN8VjWuJui6bzH3U9b/goet7bs4xnh1/svpDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwmk8lkMplMJpPJZDKZTCaTyWQymUwm8zjm/wM2ec9J+AJIXQAAAABJRU5ErkJggg==" alt="Match Sport" style="height:100px; width:auto; display:block;">
      </a>
    </div>

    <!-- === Tarjeta de usuario admin con menú === -->
    <div class="user-card user-card-admin" id="admin-user-card">
      <button class="user-card-trigger" id="admin-user-trigger" aria-haspopup="true" aria-expanded="false">
        <span class="user-avatar user-avatar-admin">
          <i class="ti ti-shield-lock" style="font-size: 16px;"></i>
        </span>
        <span class="user-info">
          <span class="user-name">Super Admin</span>
          <span class="user-role">
            <i class="ti ti-key" style="font-size:10px;"></i>
            <span>Acceso total</span>
          </span>
        </span>
        <i class="ti ti-chevron-down user-chevron" style="font-size: 14px; opacity: 0.5;"></i>
      </button>

      <div class="user-menu" id="admin-user-menu" role="menu" aria-hidden="true">
        <div class="user-menu-header">
          <div class="user-menu-name">Super Admin</div>
          <div class="user-menu-email">Acceso global de plataforma</div>
        </div>
        <div class="user-menu-section">
          <button class="user-menu-item" data-route="/admin">
            <i class="ti ti-layout-dashboard"></i> Dashboard
          </button>
        </div>
        <div class="user-menu-divider"></div>
        <button class="user-menu-item user-menu-danger" id="admin-logout">
          <i class="ti ti-logout"></i> Cerrar sesión
        </button>
      </div>
    </div>

    <div class="sidebar-section">VISTA GLOBAL</div>
    <a class="sidebar-item" data-route="/admin"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
    <a class="sidebar-item" data-route="/admin/organizadores"><i class="ti ti-building-store"></i> Organizadores</a>
    <a class="sidebar-item" data-route="/admin/eventos"><i class="ti ti-calendar-event"></i> Eventos</a>
    <a class="sidebar-item" data-route="/admin/finanzas"><i class="ti ti-coin"></i> Finanzas</a>
  </aside>
  <div class="spa-content">

<section class="spa-page" data-route="/admin" data-shell="admin" id="page-admin-dashboard">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <div class="small muted" style="font-size: 12px; margin-bottom: 4px;">Buenos días, Cristian 👋</div>
        <h1>Resumen general de Match Sport</h1>
      </div>
      <div class="flex gap-2">
        <select class="select" style="max-width: 160px;">
          <option>Mayo 2027</option>
          <option>Abril 2027</option>
          <option>Q2 2027</option>
          <option>Año 2027</option>
        </select>
        <button class="btn btn-outline btn-sm" onclick="msExport('registrations', null, true)"><i class="ti ti-download" style="font-size: 14px;"></i> Exportar</button>
      </div>
    </div>

    <div class="income-banner">
      <div class="ib-inner">
        <div>
          <div class="ib-label"><i class="ti ti-coin"></i> TU INGRESO ESTE MES</div>
          <div class="ib-value-big">$920.000</div>
          <div class="ib-trend">
            <span class="pill">+42%</span> vs. abril ($647K)
          </div>
        </div>
        <div class="ib-stat-divider">
          <div class="ib-stat-label">GMV PROCESADO</div>
          <div class="ib-stat-value">$18.4M</div>
          <div class="ib-stat-sub">5% comisión Match</div>
        </div>
        <div class="ib-stat-divider">
          <div class="ib-stat-label">A TU CUENTA</div>
          <div class="ib-stat-value">$280K</div>
          <div class="ib-stat-sub">Margen neto</div>
        </div>
        <div class="ib-stat-divider">
          <div class="ib-stat-label">PROYECCIÓN</div>
          <div class="ib-stat-value" style="color: var(--amber-400);">$1.2M</div>
          <div class="ib-stat-sub">Cierre del mes</div>
        </div>
      </div>
    </div>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Organizadores</div>
          <div class="metric-icon purple"><i class="ti ti-users-group"></i></div>
        </div>
        <div class="metric-value">23</div>
        <div class="metric-trend up"><i class="ti ti-arrow-up-right" style="font-size: 11px;"></i> +5 este mes</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Eventos activos</div>
          <div class="metric-icon amber"><i class="ti ti-calendar-event"></i></div>
        </div>
        <div class="metric-value">47</div>
        <div class="metric-trend up"><i class="ti ti-arrow-up-right" style="font-size: 11px;"></i> +8 semanal</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Tickets vendidos</div>
          <div class="metric-icon blue"><i class="ti ti-ticket"></i></div>
        </div>
        <div class="metric-value">3.247</div>
        <div class="metric-trend up"><i class="ti ti-arrow-up-right" style="font-size: 11px;"></i> +18%</div>
      </div>
      <div class="metric-card">
        <div class="metric-head">
          <div class="metric-label">Deportistas únicos</div>
          <div class="metric-icon green"><i class="ti ti-run"></i></div>
        </div>
        <div class="metric-value">2.184</div>
        <div class="metric-trend up"><i class="ti ti-arrow-up-right" style="font-size: 11px;"></i> +267 nuevos</div>
      </div>
    </div>

    <div class="chart-grid mb-4">
      <div class="chart-card">
        <div class="flex-between" style="align-items: flex-end; margin-bottom: 14px;">
          <div>
            <h3>Tu comisión los últimos 12 meses</h3>
            <p class="sub">Crecimiento sostenido · barra clara = proyección</p>
          </div>
          <div class="flex gap-2" style="align-items: center;">
            <span style="display: flex; align-items: center; gap: 4px; font-size: 11px; color: var(--text-secondary);">
              <span style="width: 8px; height: 8px; background: var(--purple-700); border-radius: 2px;"></span> Real
            </span>
            <span style="display: flex; align-items: center; gap: 4px; font-size: 11px; color: var(--text-secondary);">
              <span style="width: 8px; height: 8px; background: var(--amber-500); border-radius: 2px;"></span> Proyec.
            </span>
          </div>
        </div>
        <div class="chart-canvas-wrap">
          <canvas id="comisionChart"></canvas>
        </div>
      </div>

      <div class="chart-card">
        <h3>Top organizadores</h3>
        <p class="sub">Por GMV este mes</p>

        <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 14px;">
          <div class="top-org-item">
            <div class="org-rank org-rank-1">1</div>
            <div class="org-info">
              <strong>Productora Aurora</strong>
              <div class="small">8 eventos · Música</div>
            </div>
            <div class="org-stat"><strong>$4.2M</strong></div>
          </div>
          <div class="top-org-item">
            <div class="org-rank org-rank-2">2</div>
            <div class="org-info">
              <strong>Club Cumbres</strong>
              <div class="small">4 eventos · Running</div>
            </div>
            <div class="org-stat"><strong>$3.7M</strong></div>
          </div>
          <div class="top-org-item">
            <div class="org-rank org-rank-3">3</div>
            <div class="org-info">
              <strong>Liga Osorno</strong>
              <div class="small">2 eventos · Fútbol</div>
            </div>
            <div class="org-stat"><strong>$2.1M</strong></div>
          </div>
          <div class="top-org-item">
            <div class="org-rank org-rank-other">4</div>
            <div class="org-info">
              <strong>RunningChile</strong>
              <div class="small">6 eventos</div>
            </div>
            <div class="org-stat"><strong>$1.8M</strong></div>
          </div>
          <div class="top-org-item">
            <div class="org-rank org-rank-other">5</div>
            <div class="org-info">
              <strong>BikeFest</strong>
              <div class="small">3 eventos</div>
            </div>
            <div class="org-stat"><strong>$1.2M</strong></div>
          </div>
        </div>

        <a href="#/admin/organizadores" style="display: block; margin-top: 12px; padding-top: 10px; border-top: 0.5px solid var(--border); font-size: 11px; color: var(--purple-700); font-weight: 600;">
          Ver los 23 organizadores <i class="ti ti-arrow-right" style="font-size: 12px;"></i>
        </a>
      </div>
    </div>

    <div class="chart-grid">
      <div class="chart-card">
        <h3>Distribución por deporte</h3>
        <p class="sub">% del GMV total este mes</p>
        <div class="chart-canvas-wrap" style="height: 200px;">
          <canvas id="categoryChart"></canvas>
        </div>
      </div>

      <div class="chart-card">
        <h3>🚨 Alertas activas</h3>
        <p class="sub">Requieren tu atención</p>
        <div class="alert-card warn">
          <i class="ti ti-alert-triangle" style="color: var(--amber-600); font-size: 18px; flex-shrink: 0;"></i>
          <div>
            <strong>3 eventos con baja venta</strong>
            <p>Menos del 20% vendido a 1 mes del evento</p>
          </div>
        </div>
        <div class="alert-card danger">
          <i class="ti ti-flag" style="color: var(--red-600); font-size: 18px; flex-shrink: 0;"></i>
          <div>
            <strong>Evento marcado para revisión</strong>
            <p>"Fiesta XL" reportado por usuario</p>
          </div>
        </div>
        <div class="alert-card info">
          <i class="ti ti-info-circle" style="color: var(--blue-700); font-size: 18px; flex-shrink: 0;"></i>
          <div>
            <strong>2 reembolsos pendientes</strong>
            <p>Esperando tu aprobación</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>




</section>

<section class="spa-page" data-route="/admin/organizadores" data-shell="admin" id="page-admin-organizadores">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Organizadores</h1>
        <p class="muted">23 organizadores activos en la plataforma</p>
      </div>
      <button class="btn btn-primary"><i class="ti ti-plus"></i> Invitar organizador</button>
    </div>

    <div class="flex gap-2 mb-6">
      <input class="input" placeholder="🔍 Buscar organizador..." style="max-width: 320px;">
      <select class="select" style="max-width: 160px;">
        <option>Todos los deportes</option>
        <option>Running</option>
        <option>Fútbol</option>
        <option>Música</option>
      </select>
      <select class="select" style="max-width: 160px;">
        <option>Ordenar por GMV</option>
        <option>Más eventos</option>
        <option>Más recientes</option>
      </select>
    </div>

    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th>Organizador</th>
            <th>Deporte</th>
            <th>Eventos</th>
            <th>GMV total</th>
            <th>Tu comisión</th>
            <th>Última act.</th>
            <th>Estado</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <span class="avatar" style="background: var(--amber-600); margin-right: 10px; vertical-align: middle;">PA</span>
              <div style="display: inline-block; vertical-align: middle;">
                <div style="font-weight: 600;">Productora Aurora</div>
                <div class="small muted">contacto@aurora.cl</div>
              </div>
            </td>
            <td>Música</td>
            <td>8</td>
            <td><strong>$4.2M</strong></td>
            <td style="color: var(--purple-700); font-weight: 700;">$210K</td>
            <td><span class="small muted">hace 2h</span></td>
            <td><span class="badge badge-green">Activo</span></td>
            <td><button class="btn btn-outline btn-sm">Ver →</button></td>
          </tr>
          <tr>
            <td>
              <span class="avatar" style="background: var(--purple-700); margin-right: 10px; vertical-align: middle;">CC</span>
              <div style="display: inline-block; vertical-align: middle;">
                <div style="font-weight: 600;">Club Cumbres Purranque</div>
                <div class="small muted">cumbrespurranque@gmail.com</div>
              </div>
            </td>
            <td>Running</td>
            <td>4</td>
            <td><strong>$3.7M</strong></td>
            <td style="color: var(--purple-700); font-weight: 700;">$185K</td>
            <td><span class="small muted">hace 12 min</span></td>
            <td><span class="badge badge-green">Activo</span></td>
            <td><button class="btn btn-outline btn-sm">Ver →</button></td>
          </tr>
          <tr>
            <td>
              <span class="avatar" style="background: var(--blue-700); margin-right: 10px; vertical-align: middle;">LO</span>
              <div style="display: inline-block; vertical-align: middle;">
                <div style="font-weight: 600;">Liga Barrial Osorno</div>
                <div class="small muted">contacto@ligaosorno.cl</div>
              </div>
            </td>
            <td>Fútbol</td>
            <td>2</td>
            <td><strong>$2.1M</strong></td>
            <td style="color: var(--purple-700); font-weight: 700;">$105K</td>
            <td><span class="small muted">ayer</span></td>
            <td><span class="badge badge-green">Activo</span></td>
            <td><button class="btn btn-outline btn-sm">Ver →</button></td>
          </tr>
          <tr>
            <td>
              <span class="avatar" style="background: var(--green-600); margin-right: 10px; vertical-align: middle;">RC</span>
              <div style="display: inline-block; vertical-align: middle;">
                <div style="font-weight: 600;">RunningChile</div>
                <div class="small muted">info@runningchile.com</div>
              </div>
            </td>
            <td>Running</td>
            <td>6</td>
            <td><strong>$1.8M</strong></td>
            <td style="color: var(--purple-700); font-weight: 700;">$90K</td>
            <td><span class="small muted">hace 3 días</span></td>
            <td><span class="badge badge-green">Activo</span></td>
            <td><button class="btn btn-outline btn-sm">Ver →</button></td>
          </tr>
          <tr>
            <td>
              <span class="avatar" style="background: var(--red-500); margin-right: 10px; vertical-align: middle;">BF</span>
              <div style="display: inline-block; vertical-align: middle;">
                <div style="font-weight: 600;">BikeFest</div>
                <div class="small muted">contacto@bikefest.cl</div>
              </div>
            </td>
            <td>Ciclismo</td>
            <td>3</td>
            <td><strong>$1.2M</strong></td>
            <td style="color: var(--purple-700); font-weight: 700;">$60K</td>
            <td><span class="small muted">hace 1 semana</span></td>
            <td><span class="badge badge-green">Activo</span></td>
            <td><button class="btn btn-outline btn-sm">Ver →</button></td>
          </tr>
          <tr>
            <td>
              <span class="avatar" style="background: var(--text-tertiary); margin-right: 10px; vertical-align: middle;">EX</span>
              <div style="display: inline-block; vertical-align: middle;">
                <div style="font-weight: 600;">Eventos XL Producciones</div>
                <div class="small muted">eventosxl@email.com</div>
              </div>
            </td>
            <td>Social</td>
            <td>2</td>
            <td><strong>$580K</strong></td>
            <td style="color: var(--purple-700); font-weight: 700;">$29K</td>
            <td><span class="small muted">hace 2 semanas</span></td>
            <td><span class="badge badge-amber">En revisión</span></td>
            <td><button class="btn btn-outline btn-sm">Ver →</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</div>



</section>

<section class="spa-page" data-route="/admin/eventos" data-shell="admin" id="page-admin-eventos">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Todos los eventos</h1>
        <p class="muted" id="admin-eventos-resumen">Eventos publicados en la plataforma</p>
      </div>
      <button class="btn btn-outline btn-sm" onclick="msExport('events', null, true)"><i class="ti ti-download"></i> Exportar</button>
    </div>

    <div class="flex gap-2 mb-6">
      <input class="input" placeholder="🔍 Buscar evento u organizador..." style="max-width: 320px;">
      <select class="select" style="max-width: 160px;">
        <option>Todos los estados</option>
        <option>Activos</option>
        <option>Finalizados</option>
        <option>En revisión</option>
      </select>
      <select class="select" style="max-width: 160px;">
        <option>Todos los deportes</option>
        <option>Running</option>
        <option>Fútbol</option>
        <option>Básquet</option>
      </select>
    </div>

    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th>Evento</th>
            <th>Organizador</th>
            <th>Fecha</th>
            <th>Vendidos</th>
            <th>GMV</th>
            <th>Tu comisión</th>
            <th>Estado</th>
            <th style="text-align: right;">Acciones</th>
          </tr>
        </thead>
        <tbody id="eventTbody"></tbody>
      </table>
    </div>
  </main>
</div>

<!-- Confirm delete modal -->
<div class="confirm-modal" id="confirmModalAdmin">
  <div class="confirm-card">
    <div class="confirm-icon"><i class="ti ti-trash"></i></div>
    <h3>¿Eliminar este evento de la plataforma?</h3>
    <p>Estás a punto de eliminar <span class="conf-name" id="confNameAdmin">—</span>. Esto afectará al organizador y a los deportistas inscritos.</p>
    <div class="confirm-warning">
      <i class="ti ti-alert-triangle"></i>
      <div><strong>Acción de Super Admin.</strong> El evento será removido de los listados públicos. Si tiene ventas, primero gestiona los reembolsos.</div>
    </div>
    <div class="confirm-actions">
      <button class="btn btn-outline" onclick="cancelDeleteAdmin()">Cancelar</button>
      <button class="btn" onclick="confirmDeleteAdmin()" style="background: var(--red-600); color: white;">
        <i class="ti ti-trash"></i> Eliminar evento
      </button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-notice" id="toastNotice">
  <i class="ti ti-circle-check"></i>
  <span id="toastMsg">Evento eliminado</span>
</div>




</section>

<section class="spa-page" data-route="/admin/finanzas" data-shell="admin" id="page-admin-finanzas">


<div class="dashboard">
  <main class="content">
    <div class="content-header">
      <div>
        <h1>Finanzas</h1>
        <p class="muted">Flujo de dinero · Mayo 2027</p>
      </div>
      <div class="flex gap-2">
        <select class="select" style="max-width: 160px;">
          <option>Mayo 2027</option>
          <option>Abril 2027</option>
          <option>Q2 2027</option>
        </select>
        <button class="btn btn-outline btn-sm" onclick="msExport('registrations', null, true)"><i class="ti ti-download"></i> Excel</button>
        <button class="btn btn-primary btn-sm"><i class="ti ti-file-text"></i> Reporte SII</button>
      </div>
    </div>

    <!-- ===== RESUMEN REAL DE COMISIONES E IVA (datos de la API) ===== -->
    <div class="card" style="margin-bottom:20px;">
      <h3 style="font-size:15px;margin-bottom:16px;font-weight:700;">Resumen real de comisiones</h3>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px;">
        <div><div class="muted small">GMV (subtotal)</div><div id="fin-subtotal" style="font-size:20px;font-weight:700;">—</div></div>
        <div><div class="muted small">Comisión Match Sport (7%)</div><div id="fin-comision" style="font-size:20px;font-weight:700;color:var(--purple-700);">—</div></div>
        <div><div class="muted small"><span data-ms="tax-label">IVA</span> de la comisión</div><div id="fin-iva" style="font-size:20px;font-weight:700;">—</div></div>
        <div><div class="muted small">Total cobrado</div><div id="fin-total" style="font-size:20px;font-weight:700;">—</div></div>
        <div><div class="muted small">Inscripciones</div><div id="fin-inscritos" style="font-size:20px;font-weight:700;">—</div></div>
        <div><div class="muted small">Transferido a organizadores</div><div id="fin-transferido" style="font-size:20px;font-weight:700;color:var(--green-600);">—</div></div>
      </div>
    </div>

    <!-- ===== PAGOS A ORGANIZADORES (subir comprobante + monto transferido) ===== -->
    <div class="card" style="margin-bottom:20px;">
      <h3 style="font-size:15px;margin-bottom:6px;font-weight:700;">Pagos a organizadores</h3>
      <p class="muted small" style="margin-bottom:16px;">Sube el comprobante de la transferencia e indica cuánto del total recaudado se transfirió. El organizador lo verá en su panel.</p>
      <form id="payout-form" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;align-items:end;">
        <div>
          <label class="label">Organizador</label>
          <select class="select" id="payout-org" required></select>
        </div>
        <div>
          <label class="label">Evento (opcional)</label>
          <select class="select" id="payout-event"><option value="">— General —</option></select>
        </div>
        <div>
          <label class="label">Monto transferido</label>
          <input class="input" type="number" step="0.01" id="payout-monto" placeholder="0" required>
        </div>
        <div>
          <label class="label">Total recaudado del evento</label>
          <input class="input" type="number" step="0.01" id="payout-total" placeholder="0">
        </div>
        <div>
          <label class="label">Moneda</label>
          <select class="select" id="payout-currency">
            <option value="CLP">CLP</option><option value="ARS">ARS</option><option value="BRL">BRL</option>
            <option value="COP">COP</option><option value="PEN">PEN</option><option value="USD">USD</option>
          </select>
        </div>
        <div>
          <label class="label">Comprobante (jpg/png/pdf)</label>
          <input class="input" type="file" id="payout-file" accept="image/*,application/pdf">
        </div>
        <div style="grid-column:1/-1;">
          <label class="label">Nota (opcional)</label>
          <input class="input" id="payout-nota" placeholder="Ej: Transferencia parcial, banco...">
        </div>
        <div style="grid-column:1/-1;">
          <button class="btn btn-primary" type="submit"><i class="ti ti-upload"></i> Registrar transferencia</button>
          <span id="payout-msg" class="small" style="margin-left:10px;"></span>
        </div>
      </form>
      <div style="overflow-x:auto;margin-top:18px;">
        <table class="table" style="width:100%;">
          <thead><tr>
            <th style="text-align:left;">Fecha</th><th style="text-align:left;">Organizador</th>
            <th style="text-align:left;">Evento</th><th style="text-align:right;">Monto</th>
            <th style="text-align:right;">Total</th><th style="text-align:left;">Comprobante</th>
          </tr></thead>
          <tbody id="payout-list"><tr><td colspan="6" class="muted small" style="padding:14px;">Sin transferencias registradas.</td></tr></tbody>
        </table>
      </div>
    </div>

    <div class="finance-flow">
      <h3 style="font-size: 15px; margin-bottom: 20px; font-weight: 700;">Flujo de dinero — este mes</h3>
      <div class="flow-grid">
        <div class="flow-box amber">
          <div class="label">GMV bruto</div>
          <div class="amount">$18.4M</div>
        </div>
        <div class="flow-arrow"><i class="ti ti-arrow-right"></i></div>
        <div class="flow-box danger">
          <div class="label">Comisión MercadoPago (3.5%)</div>
          <div class="amount">-$644K</div>
        </div>
        <div class="flow-arrow"><i class="ti ti-arrow-right"></i></div>
        <div class="flow-box primary">
          <div class="label">Comisión Match Sport (7%)</div>
          <div class="amount">$920K</div>
        </div>
      </div>
      <div class="margin-final">
        <p class="label">Margen neto Match Sport después de gastos operacionales</p>
        <div class="amount">$280K</div>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px; margin-bottom: 14px;">
      <div class="chart-card">
        <h3 style="font-size: 14px; margin-bottom: 4px; font-weight: 700;">Comisión Match Sport — últimos 12 meses</h3>
        <p class="small muted mb-3" style="font-size: 11px;">Ingreso bruto antes de gastos operacionales</p>
        <div style="position: relative; height: 260px;">
          <canvas id="comisionChart"></canvas>
        </div>
      </div>

      <div class="chart-card">
        <h3 style="font-size: 14px; margin-bottom: 14px; font-weight: 700;">Métodos de pago</h3>
        <div style="position: relative; height: 180px;">
          <canvas id="metodoChart"></canvas>
        </div>
        <ul style="list-style: none; padding: 0; font-size: 12px; margin-top: 16px;">
          <li class="flex-between" style="margin-bottom: 6px;"><span>💳 Tarjeta crédito</span><strong>54%</strong></li>
          <li class="flex-between" style="margin-bottom: 6px;"><span>💳 Débito (Redcompra)</span><strong>22%</strong></li>
          <li class="flex-between" style="margin-bottom: 6px;"><span>🏦 Transferencia</span><strong>14%</strong></li>
          <li class="flex-between"><span>💼 MP Wallet</span><strong>10%</strong></li>
        </ul>
      </div>
    </div>

    <div class="card">
      <h3 style="font-size: 15px; margin-bottom: 16px; font-weight: 700;">Movimientos recientes</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Evento</th>
            <th>Organizador</th>
            <th>Método</th>
            <th>Monto bruto</th>
            <th>Tu comisión</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>13 may 14:23</td>
            <td>Rally Costero Purranque</td>
            <td>Club Cumbres</td>
            <td>Tarjeta crédito</td>
            <td>$15.000</td>
            <td style="color: var(--purple-700); font-weight: 700;">$1.050</td>
            <td><span class="badge badge-green">Conciliado</span></td>
          </tr>
          <tr>
            <td>13 may 13:58</td>
            <td>Festival Jazz</td>
            <td>Productora Aurora</td>
            <td>Webpay</td>
            <td>$25.000</td>
            <td style="color: var(--purple-700); font-weight: 700;">$1.250</td>
            <td><span class="badge badge-green">Conciliado</span></td>
          </tr>
          <tr>
            <td>13 may 13:42</td>
            <td>Liga Barrial Osorno</td>
            <td>Liga Osorno</td>
            <td>MP Wallet</td>
            <td>$120.000</td>
            <td style="color: var(--purple-700); font-weight: 700;">$6.000</td>
            <td><span class="badge badge-green">Conciliado</span></td>
          </tr>
          <tr>
            <td>13 may 13:30</td>
            <td>Trail Llanquihue</td>
            <td>Club Cumbres</td>
            <td>Transferencia</td>
            <td>$18.000</td>
            <td style="color: var(--purple-700); font-weight: 700;">$900</td>
            <td><span class="badge badge-amber">Pendiente</span></td>
          </tr>
          <tr>
            <td>13 may 13:15</td>
            <td>Festival Jazz</td>
            <td>Productora Aurora</td>
            <td>Tarjeta crédito</td>
            <td>$50.000</td>
            <td style="color: var(--purple-700); font-weight: 700;">$2.500</td>
            <td><span class="badge badge-green">Conciliado</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</div>




</section>
  </div><!-- cierre de .spa-content (admin) -->
</div><!-- cierre de #shell-admin -->

<!-- ===== SHARED JS ===== -->
<script>
// ========== MATCH SPORT - Funciones globales ==========

function formatCLP(amount) {
  return new Intl.NumberFormat('es-CL', {
    style: 'currency',
    currency: 'CLP',
    maximumFractionDigits: 0
  }).format(amount);
}

function formatDate(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleDateString('es-CL', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
}

function toast(message, type = 'success') {
  const div = document.createElement('div');
  const bg = type === 'success' ? '#16A34A' : type === 'error' ? '#DC2626' : '#0B8B84';
  div.style.cssText = `
    position: fixed; top: 20px; right: 20px; z-index: 9999;
    background: ${bg};
    color: white; padding: 14px 22px; border-radius: 10px;
    font-size: 14px; font-weight: 500; box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    animation: slideIn 0.3s ease;
  `;
  div.textContent = message;
  document.body.appendChild(div);
  setTimeout(() => {
    div.style.opacity = '0';
    div.style.transition = 'opacity 0.3s';
    setTimeout(() => div.remove(), 300);
  }, 2500);
}

function navTo(url) {
  window.location.href = url;
}

// Inyectar animación CSS
const style = document.createElement('style');
style.textContent = `
  @keyframes slideIn {
    from { transform: translateX(20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
  }
`;
document.head.appendChild(style);


// ============================================================
// ============================================================
// Chart.js patch — destruir chart existente antes de crear uno nuevo
// Evita el warning "Canvas is already in use" al navegar entre páginas
// ============================================================
(function patchChart(){
  if (typeof Chart === 'undefined' || Chart.__patched) return;
  const _OriginalChart = Chart;
  function PatchedChart(ctx, config) {
    // Resolver el canvas real
    let canvas = ctx;
    if (typeof ctx === 'string') canvas = document.getElementById(ctx);
    else if (ctx && ctx.canvas) canvas = ctx.canvas;
    // Si ya hay un chart en este canvas, destruirlo
    if (canvas && typeof _OriginalChart.getChart === 'function') {
      const existing = _OriginalChart.getChart(canvas);
      if (existing) {
        try { existing.destroy(); } catch(_) {}
      }
    }
    return new _OriginalChart(ctx, config);
  }
  // Copiar propiedades estáticas
  Object.setPrototypeOf(PatchedChart, _OriginalChart);
  PatchedChart.prototype = _OriginalChart.prototype;
  for (const key of Object.keys(_OriginalChart)) {
    try { PatchedChart[key] = _OriginalChart[key]; } catch(_) {}
  }
  PatchedChart.__patched = true;
  window.Chart = PatchedChart;
})();

// SPA ROUTER + AUTH
// ============================================================
const MatchSPA = (function(){
  const ROUTES = {};
  document.querySelectorAll('.spa-page').forEach(s => {
    ROUTES[s.dataset.route] = { el: s, shell: s.dataset.shell };
  });

  function getSession() {
    try {
      return {
        org: JSON.parse(localStorage.getItem('orgSession') || 'null'),
        admin: JSON.parse(localStorage.getItem('adminSession') || 'null'),
      };
    } catch (_) { return { org: null, admin: null }; }
  }

  function setOrgSession(data) {
    if (data) localStorage.setItem('orgSession', JSON.stringify(data));
    else localStorage.removeItem('orgSession');
    updatePublicNavActions();
  }
  function setAdminSession(data) {
    if (data) localStorage.setItem('adminSession', JSON.stringify(data));
    else localStorage.removeItem('adminSession');
  }

  function updatePublicNavActions() {
    const cont = document.getElementById('public-nav-actions');
    if (!cont) return;
    const s = getSession();
    if (s.org) {
      cont.innerHTML = `
        <a class="btn btn-ghost" data-route="/organizador">Mi panel</a>
        <a class="btn btn-primary" data-route="/organizador/crear-evento">Crear evento</a>
      `;
    } else {
      cont.innerHTML = `
        <a class="btn btn-ghost" data-route="/login">Ingresar</a>
        <a class="btn btn-primary" data-route="/login">Crear evento</a>
      `;
    }
    // Re-bind data-route clicks (delegation handles it but content swap is fine)
  }

  function getRoute() {
    const h = (location.hash || '#/').slice(1);
    return h === '' ? '/' : h;
  }

  // Separa "/eventos?filter=running" en {path:'/eventos', params:{filter:'running'}}
  function parseRoute(fullRoute) {
    const qIdx = fullRoute.indexOf('?');
    if (qIdx === -1) return { path: fullRoute, params: {} };
    const path = fullRoute.slice(0, qIdx);
    const queryStr = fullRoute.slice(qIdx + 1);
    const params = {};
    queryStr.split('&').forEach(p => {
      if (!p) return;
      const [k, v] = p.split('=');
      params[decodeURIComponent(k)] = v !== undefined ? decodeURIComponent(v) : '';
    });
    return { path, params };
  }

  function navigate(route) {
    if (location.hash !== '#' + route) location.hash = '#' + route;
    else render();
  }

  function render() {
    const fullRoute = getRoute();
    const { path: route, params } = parseRoute(fullRoute);
    const s = getSession();

    // Guard org routes
    if (route.startsWith('/organizador') && !s.org) {
      navigate('/login');
      return;
    }
    // Guard admin routes (except admin/login)
    if (route.startsWith('/admin') && route !== '/admin/login' && !s.admin) {
      navigate('/admin/login');
      return;
    }

    // Find page
    let page = ROUTES[route];
    if (!page) {
      // 404 fallback
      page = ROUTES['/'];
    }

    // Hide all pages and shells
    document.querySelectorAll('.spa-page').forEach(p => p.classList.remove('active'));
    document.getElementById('shell-public').classList.remove('active');
    document.getElementById('shell-org').classList.remove('active');
    document.getElementById('shell-admin').classList.remove('active');
    document.getElementById('shell-public').style.display = 'none';
    document.getElementById('shell-org').classList.remove('active');
    document.getElementById('shell-admin').classList.remove('active');

    // Show the right shell
    if (page.shell === 'public') {
      document.getElementById('shell-public').style.display = 'block';
    } else if (page.shell === 'org') {
      document.getElementById('shell-org').classList.add('active');
    } else if (page.shell === 'admin') {
      document.getElementById('shell-admin').classList.add('active');
    } else if (page.shell === 'admin-login') {
      // standalone, no shell wrapper
    }

    // Show the page
    page.el.classList.add('active');

    // Guardar query params actuales en window para que páginas los lean
    window.__routeParams = params;

    // Update active state on sidebar/nav
    document.querySelectorAll('[data-route]').forEach(a => {
      if (a.dataset.route === route) a.classList.add('active');
      else a.classList.remove('active');
    });

    // Update public nav actions
    updatePublicNavActions();

    // Scroll to top
    window.scrollTo(0, 0);

    // Re-run any page init hooks that pages may have registered
    if (window.__pageInits && window.__pageInits[page.el.id]) {
      const hooks = window.__pageInits[page.el.id];
      if (Array.isArray(hooks)) {
        hooks.forEach(fn => {
          try { fn(); } catch(e) { console.warn('Page init error:', e); }
        });
      } else if (typeof hooks === 'function') {
        try { hooks(); } catch(e) { console.warn('Page init error:', e); }
      }
    }
  }

  function init() {
    // Hide everything initially
    document.getElementById('shell-public').style.display = 'none';

    // Intercept data-route clicks: solo aplica a enlaces/botones con data-route,
    // NO a las <section> contenedoras que también tienen data-route.
    document.addEventListener('click', e => {
      // Buscar el enlace/botón clickeable más cercano que tenga data-route
      let el = e.target;
      while (el && el !== document.body) {
        // Si llegamos a una sección, dejar de buscar (no es un click sobre nav)
        if (el.tagName === 'SECTION' && el.classList.contains('spa-page')) {
          return;
        }
        // Card de deporte → navegar a /eventos con filtro
        if (el.hasAttribute && el.hasAttribute('data-sport-filter')) {
          e.preventDefault();
          const sport = el.dataset.sportFilter;
          navigate('/eventos?filter=' + encodeURIComponent(sport));
          return;
        }
        if (el.hasAttribute && el.hasAttribute('data-route') &&
            (el.tagName === 'A' || el.tagName === 'BUTTON' || el.classList.contains('sidebar-item') || el.classList.contains('logo'))) {
          e.preventDefault();
          navigate(el.dataset.route);
          return;
        }
        el = el.parentElement;
      }
    });

    // Org logout
    const orgLogout = document.getElementById('org-logout');
    if (orgLogout) orgLogout.addEventListener('click', e => {
      e.preventDefault();
      setOrgSession(null);
      navigate('/');
      if (typeof toast === 'function') toast('Sesión cerrada');
    });

    // Admin logout
    const adminLogout = document.getElementById('admin-logout');
    if (adminLogout) adminLogout.addEventListener('click', e => {
      e.preventDefault();
      setAdminSession(null);
      navigate('/');
      if (typeof toast === 'function') toast('Sesión admin cerrada');
    });

    window.addEventListener('hashchange', render);
    render();
  }

  // Expose globally for page scripts
  return {
    init,
    navigate,
    getSession,
    setOrgSession,
    setAdminSession,
    onPageInit: function(slug, fn) {
      window.__pageInits = window.__pageInits || {};
      // Acumular múltiples callbacks por slug (no sobrescribir)
      if (!window.__pageInits[slug]) {
        window.__pageInits[slug] = [];
      } else if (typeof window.__pageInits[slug] === 'function') {
        // Migración: si antes era función, convertirla a array
        window.__pageInits[slug] = [window.__pageInits[slug]];
      }
      window.__pageInits[slug].push(fn);
    }
  };
})();

// Asegurar acceso desde window — necesario porque const/let no se exponen a window automáticamente
window.MatchSPA = MatchSPA;

// ============================================================
// USER CARD: llenar avatar/nombre y manejar dropdown
// ============================================================
(function userCardSetup(){
  function getInitials(name) {
    if (!name) return '··';
    const parts = name.trim().split(/\s+/);
    if (parts.length === 1) return parts[0].slice(0, 2).toUpperCase();
    return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
  }

  function refreshOrgUserCard() {
    const session = MatchSPA.getSession().org;
    if (!session) return;

    const name = session.name || 'Organizador';
    const email = session.email || '';
    const type = session.accountType || 'persona';

    // Avatar
    const avatar = document.getElementById('org-user-avatar');
    if (avatar) {
      avatar.classList.toggle('user-avatar-club', type === 'club');
      if (type === 'club') {
        avatar.innerHTML = '<i class="ti ti-building" style="font-size: 18px;"></i>';
      } else {
        avatar.innerHTML = `<span class="user-avatar-text">${getInitials(name)}</span>`;
      }
    }

    // Nombre principal en el sidebar
    const nameEl = document.getElementById('org-user-name');
    if (nameEl) nameEl.textContent = name;

    // Badge de rol
    const roleEl = document.getElementById('org-user-role');
    if (roleEl) {
      if (type === 'club') {
        roleEl.innerHTML = '<i class="ti ti-building" style="font-size:10px;"></i><span>Club / Organización</span>';
      } else {
        roleEl.innerHTML = '<i class="ti ti-user" style="font-size:10px;"></i><span>Organizador</span>';
      }
    }

    // Menú desplegable
    const menuName = document.getElementById('org-menu-name');
    const menuEmail = document.getElementById('org-menu-email');
    if (menuName) menuName.textContent = name;
    if (menuEmail) {
      // Si es Apple con relay, mostrar email real si lo tenemos
      menuEmail.textContent = session.realEmail || email || '—';
    }

    // Texto del toggle ("Cambiar a club" o "Cambiar a persona")
    const otherType = document.getElementById('org-other-type');
    if (otherType) otherType.textContent = type === 'club' ? 'persona' : 'club / organización';
  }

  function toggleAccountType() {
    const session = MatchSPA.getSession().org;
    if (!session) return;
    const newType = (session.accountType === 'club') ? 'persona' : 'club';
    MatchSPA.setOrgSession({ ...session, accountType: newType });
    refreshOrgUserCard();
    if (typeof toast === 'function') {
      toast(newType === 'club' ? 'Ahora apareces como Club / Organización' : 'Ahora apareces como Persona');
    }
    // Cerrar el menú
    document.getElementById('org-user-card')?.classList.remove('open');
  }

  function setupDropdown(cardId, triggerId, menuId) {
    const card = document.getElementById(cardId);
    const trigger = document.getElementById(triggerId);
    const menu = document.getElementById(menuId);
    if (!card || !trigger || !menu) return;

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const isOpen = card.classList.contains('open');
      // Cerrar otros menús
      document.querySelectorAll('.user-card.open').forEach(c => c.classList.remove('open'));
      if (!isOpen) {
        card.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
        menu.setAttribute('aria-hidden', 'false');
      } else {
        trigger.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');
      }
    });
  }

  // Cerrar menús al hacer clic afuera
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.user-card')) {
      document.querySelectorAll('.user-card.open').forEach(c => c.classList.remove('open'));
    }
  });

  // Cerrar con ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.user-card.open').forEach(c => c.classList.remove('open'));
    }
  });

  // Setup cuando DOM esté listo
  function init() {
    setupDropdown('org-user-card', 'org-user-trigger', 'org-user-menu');
    setupDropdown('admin-user-card', 'admin-user-trigger', 'admin-user-menu');

    // Listener para el botón de cambiar tipo de cuenta
    const toggleBtn = document.getElementById('org-toggle-account-type');
    if (toggleBtn) toggleBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      toggleAccountType();
    });

    refreshOrgUserCard();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Refrescar al cambiar de ruta (por si entras al panel desde otro lado)
  window.addEventListener('hashchange', refreshOrgUserCard);

  // Exponer por si lo necesitamos desde otros lados
  window.refreshOrgUserCard = refreshOrgUserCard;
})();

// Replace global navTo with route-aware version (override the one in script.js)
window.navTo = function(target) {
  // Map legacy .html nav calls to routes if possible
  const map = {
    'index.html': '/',
    'eventos.html': '/eventos',
    'evento.html': '/evento',
    'checkout.html': '/checkout',
    'ticket.html': '/ticket',
    'resultados.html': '/resultados',
    'login.html': '/login',
    'como-funciona.html': '/como-funciona',
    '#/organizador': '/organizador',
    '#/organizador/mis-eventos': '/organizador/mis-eventos',
    '#/organizador/crear-evento': '/organizador/crear-evento',
  };
  if (map[target]) {
    MatchSPA.navigate(map[target]);
  } else if (target.startsWith('#/')) {
    MatchSPA.navigate(target.slice(1));
  } else if (target.startsWith('/')) {
    MatchSPA.navigate(target);
  } else {
    location.href = target;
  }
};

// Bootstrap when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', MatchSPA.init);
} else {
  MatchSPA.init();
}
</script>

<!-- ===== JS de evento.html ===== -->
<script>
(function(){ try {
function showTab(id, evt) {
  document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  // Activar el tab correcto: por el evento de click, o buscando el que apunta a este id
  const ev = evt || (typeof event !== 'undefined' ? event : null);
  if (ev && ev.currentTarget) {
    ev.currentTarget.classList.add('active');
  } else {
    // Llamada programática: encontrar el tab-item que abre este panel
    document.querySelectorAll('.tab-item').forEach(t => {
      const oc = t.getAttribute('onclick') || '';
      if (oc.includes("'" + id + "'")) t.classList.add('active');
    });
  }
  const panel = document.getElementById('panel-' + id);
  if (panel) panel.classList.add('active');
}
window.showTab = showTab;

function selectTicket(el) {
  document.querySelectorAll('.ticket-option').forEach(t => t.classList.remove('selected'));
  el.classList.add('selected');
}
window.selectTicket = selectTicket;

// "Comprar entrada" → abrir la pestaña de Entradas (donde se eligen tickets)
window.irAEntradas = function() {
  showTab('tickets');
  // hacer scroll a las pestañas
  const tabs = document.querySelector('section.spa-page[data-route="/evento"] .tab-panel.active');
  if (tabs && tabs.scrollIntoView) tabs.scrollIntoView({ behavior: 'smooth', block: 'start' });
};
} catch(_e) { console.warn('[evento.html]', _e.message); } })();
</script>

<!-- ===== JS de checkout.html ===== -->
<script>
(function(){ try {
function selectPay(el) {
  document.querySelectorAll('.pay-method').forEach(p => p.classList.remove('selected'));
  el.classList.add('selected');
}

function completarCompra() {
  // Validar email coincide antes de pagar
  var emailErr = document.getElementById('ck-email-error');
  if (emailErr && emailErr.style.display === 'block') {
    if (window.toast) toast('Los correos no coinciden, corrígelos antes de pagar', 'error');
    return;
  }

  // Validar campos médicos OBLIGATORIOS
  function val(id) { var e = document.getElementById(id); return e ? (e.value || '').trim() : ''; }
  function focar(id, msg) {
    if (window.toast) toast(msg, 'error');
    var e = document.getElementById(id);
    if (e) { try { e.scrollIntoView({ behavior:'smooth', block:'center' }); e.focus(); } catch(_){} e.style.borderColor = '#DC2626'; }
  }
  var obligatorios = [
    ['ck-fnac', 'Falta la fecha de nacimiento'],
    ['ck-sexo', 'Falta seleccionar el sexo'],
    ['ck-nacionalidad', 'Falta la nacionalidad'],
    ['ck-sangre', 'Falta el grupo sanguíneo'],
    ['ck-seguro', 'Falta el seguro o sociedad médica'],
    ['ck-cronica-sel', 'Indica si tienes enfermedad crónica'],
    ['ck-celiaco', 'Indica si eres celíaco/a'],
    ['ck-medicamentos-sel', 'Indica si consumes medicamentos de forma permanente'],
    ['ck-emer-nombre', 'Falta el nombre del contacto de emergencia'],
    ['ck-emer-telefono', 'Falta el teléfono de emergencia'],
    ['ck-ciudad', 'Falta tu ciudad o comuna'],
  ];
  // La talla es obligatoria sólo si el campo está visible (evento incluye polera)
  var tallaInput = document.getElementById('ck-talla');
  var tallaGroup = document.getElementById('ck-talla-group');
  if (tallaInput && tallaGroup && tallaGroup.style.display !== 'none') {
    obligatorios.push(['ck-talla', 'Falta la talla de polera']);
  }
  for (var i = 0; i < obligatorios.length; i++) {
    if (!val(obligatorios[i][0])) { focar(obligatorios[i][0], obligatorios[i][1]); return; }
  }
  // Si tiene enfermedad crónica, el detalle es obligatorio
  if (val('ck-cronica-sel') === 'si' && !val('ck-cronica-detalle')) {
    focar('ck-cronica-detalle', 'Describe tu enfermedad crónica'); return;
  }
  // Si consume medicamentos, el detalle es obligatorio
  if (val('ck-medicamentos-sel') === 'si' && !val('ck-medicamentos-detalle')) {
    focar('ck-medicamentos-detalle', 'Indica qué medicamento consumes'); return;
  }

  // Recopilar datos de la inscripción
  var sel = null;
  try { sel = JSON.parse(localStorage.getItem('ms_checkout_selection') || 'null'); } catch(_) {}

  var nombre = (document.getElementById('ck-email') ? '' : '');
  // Tomar nombre del comprador (primer input de la sección comprador)
  var compradorInputs = document.querySelectorAll('#page-checkout .section-block input');
  var nombreComprador = 'Participante';
  try {
    var nombreEl = document.querySelector('#page-checkout input[placeholder="Nombre"]');
    var apellidoEl = document.querySelector('#page-checkout input[placeholder="Apellido"]');
    if (nombreEl) nombreComprador = (nombreEl.value + ' ' + (apellidoEl ? apellidoEl.value : '')).trim() || 'Participante';
  } catch(_) {}

  var emailEl = document.getElementById('ck-email');
  var email = emailEl ? emailEl.value : 'tu@correo.com';
  var catEl = document.getElementById('ck-categoria-text');
  var categoria = catEl ? catEl.textContent.replace(/\s*\(\d+ años\)/, '').trim() : 'Open · Mixto';
  if (/Ingresa tu fecha/.test(categoria)) categoria = 'Por definir';

  // Número de orden único
  var orden = 'MS-' + Date.now().toString(36).toUpperCase().slice(-6);

  // Construir registro de inscripción
  var primerItem = (sel && sel.items && sel.items[0]) ? sel.items[0] : { nombre: 'General', precio: 15000, cantidad: 1 };
  var totalPagado = 0;
  if (sel && sel.items) {
    sel.items.forEach(function(it){ totalPagado += (it.precio + (it.fee||0)) * it.cantidad; });
    if (sel.promo && sel.promo.descuento) totalPagado = Math.max(0, totalPagado - sel.promo.descuento);
  }

  var inscripcion = {
    orden: orden,
    eventId: sel ? sel.eventId : null,
    evento: (sel && sel.eventName) ? sel.eventName : 'Rally Costero Purranque RCP 2027',
    asistente: nombreComprador,
    email: email,
    ticket: primerItem.nombre,
    distancia: primerItem.nombre,
    categoria: categoria,
    ciudad: val('ck-ciudad'),
    club: val('ck-equipo') || '—',
    total: totalPagado,
    items: sel ? sel.items : [],
    fecha: Date.now(),
    estado: 'confirmado'
  };

  // Mostrar modal de procesando
  mostrarProcesandoPago(function() {
    // Guardar inscripción
    try {
      var insc = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]');
      insc.unshift(inscripcion);
      localStorage.setItem('ms_inscripciones', JSON.stringify(insc));
      localStorage.setItem('ms_last_inscripcion', JSON.stringify(inscripcion));
      try {
        if (window.MSApi) {
          MSApi.pushRegistration(inscripcion).then(function(r){
            if (r && r.ok && r.ticket_code) {
              try { inscripcion.ticket_code = r.ticket_code; localStorage.setItem('ms_last_inscripcion', JSON.stringify(inscripcion)); } catch(_) {}
            }
          });
        }
      } catch(_) {}
    } catch(_) {}
    // Ir al ticket
    if (window.MatchSPA) MatchSPA.navigate('/ticket');
    else window.location.hash = '#/ticket';
  });
}

// Modal de "procesando pago" con spinner
function mostrarProcesandoPago(onDone) {
  var overlay = document.getElementById('pago-procesando');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'pago-procesando';
    overlay.innerHTML =
      '<div class="pago-card">' +
        '<div class="pago-spinner"></div>' +
        '<h3 id="pago-titulo">Procesando tu pago...</h3>' +
        '<p id="pago-sub" class="small muted">Conectando con la pasarela de pago</p>' +
      '</div>';
    document.body.appendChild(overlay);
  }
  overlay.classList.add('show');
  var titulo = document.getElementById('pago-titulo');
  var sub = document.getElementById('pago-sub');

  // Secuencia simulada
  setTimeout(function(){ if(sub) sub.textContent = 'Verificando los datos de la tarjeta...'; }, 800);
  setTimeout(function(){ if(sub) sub.textContent = 'Confirmando la transacción...'; }, 1700);
  setTimeout(function(){
    if (titulo) titulo.textContent = '¡Pago aprobado!';
    if (sub) sub.textContent = 'Generando tu ticket...';
    var card = overlay.querySelector('.pago-card');
    var spinner = document.querySelector('#pago-procesando .pago-spinner');
    if (spinner) spinner.outerHTML = '<div class="pago-check"><i class="ti ti-check"></i></div>';
  }, 2600);
  setTimeout(function(){
    overlay.classList.remove('show');
    if (onDone) onDone();
  }, 3400);
}

// Exponer a window para que los onclick funcionen (están dentro de un IIFE)
window.completarCompra = completarCompra;
window.mostrarProcesandoPago = mostrarProcesandoPago;
window.selectPay = selectPay;

document.querySelectorAll('.check-card input[type="checkbox"]').forEach(cb => {
  cb.addEventListener('change', function() {
    this.closest('.check-card').classList.toggle('checked', this.checked);
  });
});
} catch(_e) { console.warn('[checkout.html]', _e.message); } })();
</script>

<!-- ===== JS de como-funciona.html ===== -->
<script>
(function(){ try {
document.write(Array.from({length:64},()=>`<div style="background:${Math.random()>.5?'white':'transparent'};"></div>`).join(''))
// ===== ROLE TABS =====
  document.querySelectorAll('.role-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      const role = tab.dataset.role;
      document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.role-panel').forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      document.querySelector(`.role-panel[data-panel="${role}"]`).classList.add('active');
    });
  });
} catch(_e) { console.warn('[como-funciona.html]', _e.message); } })();
</script>

<!-- ===== JS de login.html ===== -->
<script>
(function(){ try {
function ingresarOrg() {
  const email = document.getElementById('orgEmail').value;
  try { localStorage.setItem('ms_role', 'organizador'); localStorage.setItem('ms_email', email); } catch(e) {}
  if (window.toast) toast('Ingresando a tu cuenta...', 'success');
  setTimeout(() => location.href = '#/organizador', 800);
}

function loginSocial(provider) {
  // Demo: simula el flujo OAuth y redirige al dashboard del organizador
  try { localStorage.setItem('ms_role', 'organizador'); localStorage.setItem('ms_provider', provider); } catch(e) {}
  const label = { google: 'Google', facebook: 'Facebook', instagram: 'Instagram', apple: 'Apple' }[provider];
  if (window.toast) toast('Conectando con ' + label + '...', 'info');
  setTimeout(() => location.href = '#/organizador', 900);
}
} catch(_e) { console.warn('[login.html]', _e.message); } })();
</script>

<!-- ===== JS de organizador/dashboard.html ===== -->
<script>
(function(){ try {
const ctxV = document.getElementById('ventasChart');

// ============ Datos del evento actual (Rally 2027) ============
const dias = [];
const ventas = [];
const hoy = new Date();
for (let i = 29; i >= 0; i--) {
  const f = new Date(hoy);
  f.setDate(f.getDate() - i);
  dias.push(f.toLocaleDateString('es-CL', { day: 'numeric', month: 'short' }));
  let base = Math.floor(Math.random() * 8) + 2;
  if (i < 7) base += Math.floor(Math.random() * 15);
  ventas.push(base);
}

// ============ Datos simulados de eventos anteriores comparables ============
// Generamos curvas con misma forma pero menor magnitud, para que la comparación
// muestre claramente que el evento actual va mejor (o peor según el caso).
function makePrevSeries(scale, noise) {
  return ventas.map(v => Math.max(0, Math.round(v * scale + (Math.random() * noise - noise/2))));
}
const COMPARE_DATA = {
  'rally-2026': {
    nombre: 'Rally Costero Purranque 2026',
    ventasPorDia: makePrevSeries(0.80, 3),
    ticketsTot: 198,
    monto: '$2.9M', montoNum: 2900000,
    conversion: 61,
    pctVendido: 52
  },
  'rally-2025': {
    nombre: 'Rally Costero Purranque 2025',
    ventasPorDia: makePrevSeries(0.65, 3),
    ticketsTot: 156,
    monto: '$2.1M', montoNum: 2100000,
    conversion: 58,
    pctVendido: 44
  }
};

// Totales del evento actual (en línea con lo que muestra el banner del dashboard)
const NOW_STATS = { tickets: 247, monto: '$3.7M', montoNum: 3700000, conversion: 68, pctVendido: 62 };

// ============ Inicializar el chart con sus opciones base ============
const baseOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: {
    y: { beginAtZero: true, ticks: { stepSize: 5, font: { size: 10 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
    x: { grid: { display: false }, ticks: { maxTicksLimit: 8, font: { size: 10 } } }
  }
};

// ============ Lógica del toggle de comparación ============
// Se bindea ANTES de crear el chart para que funcione aunque Chart.js falle a cargar
const toggleEl = document.getElementById('toggleCompare');
const selectorEl = document.getElementById('compareSelector');
const eventSelectEl = document.getElementById('compareEvent');
const metricsEl = document.getElementById('compareMetrics');

let ventasChart = null; // se setea después si Chart está disponible

// ============ Inicializar el chart si Chart.js cargó ============
try {
  if (typeof Chart !== 'undefined') {
    ventasChart = new Chart(ctxV, {
      type: 'line',
      data: {
        labels: dias,
        datasets: [{
          label: 'Rally 2027',
          data: ventas,
          borderColor: '#0B8B84',
          backgroundColor: 'rgba(11, 139, 132, 0.1)',
          fill: true,
          tension: 0.35,
          borderWidth: 2.5,
          pointRadius: 2,
          pointBackgroundColor: '#0B8B84'
        }]
      },
      options: baseOptions
    });
  }
} catch (e) { console.warn('Chart init falló:', e.message); }

function formatDelta(now, prev, suffix) {
  if (prev === 0) return { text: '—', cls: 'cmp-flat' };
  const diff = now - prev;
  const sign = diff > 0 ? '+' : '';
  if (suffix === 'pp') {
    // diferencia en puntos porcentuales
    return {
      text: sign + diff.toFixed(0) + 'pp',
      cls: diff > 0.5 ? 'cmp-up' : (diff < -0.5 ? 'cmp-down' : 'cmp-flat')
    };
  }
  const pct = ((diff / prev) * 100);
  return {
    text: sign + pct.toFixed(1) + '%',
    cls: pct > 1 ? 'cmp-up' : (pct < -1 ? 'cmp-down' : 'cmp-flat')
  };
}

function setDelta(elId, deltaInfo) {
  const el = document.getElementById(elId);
  if (!el) return;
  el.textContent = deltaInfo.text;
  el.classList.remove('cmp-up', 'cmp-down', 'cmp-flat');
  el.classList.add(deltaInfo.cls);
}

function applyComparison(eventKey) {
  const prev = COMPARE_DATA[eventKey];
  if (!prev) return;

  // 1) Actualizar chart (si Chart.js cargó): agregar segundo dataset
  if (ventasChart) {
    ventasChart.data.datasets = [
      {
        label: 'Evento actual',
        data: ventas,
        borderColor: '#0B8B84',
        backgroundColor: 'rgba(11, 139, 132, 0.1)',
        fill: true,
        tension: 0.35,
        borderWidth: 2.5,
        pointRadius: 2,
        pointBackgroundColor: '#0B8B84'
      },
      {
        label: prev.nombre,
        data: prev.ventasPorDia,
        borderColor: '#F59E0B',
        backgroundColor: 'transparent',
        fill: false,
        tension: 0.35,
        borderWidth: 2,
        borderDash: [6, 4],
        pointRadius: 1.5,
        pointBackgroundColor: '#F59E0B'
      }
    ];
    ventasChart.options.plugins.legend = {
      display: true, position: 'top', align: 'end',
      labels: { boxWidth: 16, font: { size: 11 }, padding: 12 }
    };
    ventasChart.update();
  }

  // 2) Actualizar tarjeta de métricas con Δ
  document.getElementById('cmpTicketsNow').textContent = NOW_STATS.tickets;
  document.getElementById('cmpTicketsPrev').textContent = prev.ticketsTot;
  setDelta('cmpTicketsDelta', formatDelta(NOW_STATS.tickets, prev.ticketsTot));

  document.getElementById('cmpMontoNow').textContent = NOW_STATS.monto;
  document.getElementById('cmpMontoPrev').textContent = prev.monto;
  setDelta('cmpMontoDelta', formatDelta(NOW_STATS.montoNum, prev.montoNum));

  document.getElementById('cmpConvNow').textContent = NOW_STATS.conversion + '%';
  document.getElementById('cmpConvPrev').textContent = prev.conversion + '%';
  setDelta('cmpConvDelta', formatDelta(NOW_STATS.conversion, prev.conversion, 'pp'));

  document.getElementById('cmpPctNow').textContent = NOW_STATS.pctVendido + '%';
  document.getElementById('cmpPctPrev').textContent = prev.pctVendido + '%';
  setDelta('cmpPctDelta', formatDelta(NOW_STATS.pctVendido, prev.pctVendido, 'pp'));

  // 3) Subtítulo del chart
  const sub = document.getElementById('ventasChartSub');
  if (sub) sub.textContent = 'Comparando: Rally Costero Purranque 2027 vs ' + prev.nombre;
}

function clearComparison() {
  if (ventasChart) {
    ventasChart.data.datasets = [{
      label: 'Tickets',
      data: ventas,
      borderColor: '#0B8B84',
      backgroundColor: 'rgba(11, 139, 132, 0.1)',
      fill: true,
      tension: 0.35,
      borderWidth: 2.5,
      pointRadius: 2,
      pointBackgroundColor: '#0B8B84'
    }];
    ventasChart.options.plugins.legend = { display: false };
    ventasChart.update();
  }
  const sub = document.getElementById('ventasChartSub');
  if (sub) sub.textContent = 'Tickets vendidos por día · Rally Costero Purranque 2027';
}

if (toggleEl) {
  toggleEl.addEventListener('change', () => {
    // Re-query elements en caso de que el DOM haya cambiado
    const sel = document.getElementById('compareSelector');
    const mts = document.getElementById('compareMetrics');
    const evSel = document.getElementById('compareEvent');
    const tg = document.getElementById('toggleCompare');
    if (!sel || !mts || !evSel || !tg) return;

    if (tg.checked) {
      sel.style.display = 'flex';
      mts.style.display = 'grid';
      applyComparison(evSel.value);
    } else {
      sel.style.display = 'none';
      mts.style.display = 'none';
      clearComparison();
    }
  });
}
if (eventSelectEl) {
  eventSelectEl.addEventListener('change', () => {
    const tg = document.getElementById('toggleCompare');
    const evSel = document.getElementById('compareEvent');
    if (tg && tg.checked && evSel) applyComparison(evSel.value);
  });
}

new Chart(document.getElementById('ticketsChart'), {
  type: 'doughnut',
  data: {
    labels: ['General 8km', 'Premium 16km', 'VIP'],
    datasets: [{
      data: [123, 87, 37],
      backgroundColor: ['#0B8B84', '#F59E0B', '#17BDB5'],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 10, padding: 10 } }
    }
  }
});
} catch(_e) { console.warn('[organizador/dashboard.html]', _e.message); } })();
</script>

<!-- ===== JS de organizador/mis-eventos.html ===== -->
<script>
(function(){ try {
// ===== EVENT STATE (persisted to localStorage) =====
  // Sin eventos de ejemplo: la plataforma muestra solo eventos reales
  // creados por organizadores y sincronizados desde la API.
  const DEFAULT_EVENTS = [];
  const DEFAULT_EVENTS_UNUSED = [
    {
      id: 'rally-purranque',
      icon: 'ti-run', color: 'purple',
      nombre: 'Rally Costero Purranque 2027',
      fecha: '16 mayo · Purranque, Los Lagos',
      estado: 'activo', estadoLabel: 'Activo', estadoColor: 'green',
      vendidos: 247, total: 400,
      stats: [
        { v: '$3.7M', l: 'Recaudado', class: 'purple' },
        { v: '193', l: 'Fichas listas' },
        { v: '54', l: 'Pendientes' }
      ]
    },
    {
      id: 'trail-llanquihue',
      icon: 'ti-mountain', color: 'purple',
      nombre: 'Trail Lago Llanquihue',
      fecha: '22 junio · Frutillar',
      estado: 'activo', estadoLabel: 'Activo', estadoColor: 'green',
      vendidos: 89, total: 300,
      stats: [
        { v: '$1.3M', l: 'Recaudado', class: 'purple' },
        { v: '67', l: 'Fichas listas' },
        { v: '22', l: 'Pendientes' }
      ]
    },
    {
      id: 'liga-osorno',
      icon: 'ti-ball-football', color: 'amber',
      nombre: 'Liga Barrial Osorno 2027',
      fecha: '24 mayo · Cancha El Cero',
      estado: 'activo', estadoLabel: 'Activo', estadoColor: 'green',
      vendidos: 8, total: 18, unidad: 'equipos',
      stats: [
        { v: '$960K', l: 'Recaudado', class: 'purple' },
        { v: '8', l: 'Equipos' },
        { v: '10', l: 'Cupos' }
      ]
    },
    {
      id: 'maraton-osorno-2026',
      icon: 'ti-run', color: 'purple',
      nombre: 'Maratón Osorno 2026',
      fecha: '12 octubre 2026 · Osorno',
      estado: 'finalizado', estadoLabel: 'Finalizado', estadoColor: 'blue',
      vendidos: 456, total: 500,
      stats: [
        { v: '$6.8M', l: 'Recaudado', class: 'purple' },
        { v: '456', l: 'Diplomas' },
        { v: '4.8 ★', l: 'Rating' }
      ]
    },
    {
      id: 'mtb-puyehue',
      icon: 'ti-bike', color: 'amber',
      nombre: 'Circuito MTB Puyehue',
      fecha: 'Sin fecha definida',
      estado: 'borrador', estadoLabel: 'Borrador', estadoColor: 'gray',
      vendidos: 0, total: 0,
      isDraft: true
    }
  ];

  const STORAGE_KEY = 'ms_org_events';
  let events = [];
  let currentFilter = 'todos';
  let toDelete = null;

  // Lista de IDs eliminados (para que los eventos default no reaparezcan)
  const DELETED_KEY = 'ms_deleted_events';
  function getDeletedIds() {
    try { return new Set(JSON.parse(localStorage.getItem(DELETED_KEY) || '[]')); }
    catch(_) { return new Set(); }
  }
  function markDeleted(id) {
    try {
      const set = getDeletedIds();
      set.add(id);
      localStorage.setItem(DELETED_KEY, JSON.stringify([...set]));
    } catch(_) {}
  }

  function loadEvents() {
    try {
      const deleted = getDeletedIds();
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) {
        // Primera carga: usar defaults (menos los que se hayan eliminado)
        events = JSON.parse(JSON.stringify(DEFAULT_EVENTS)).filter(e => !deleted.has(e.id));
      } else {
        const saved = JSON.parse(raw);
        const savedIds = new Set(saved.map(e => e.id));
        // Defaults que faltan Y que no fueron eliminados a propósito
        const missingDefaults = DEFAULT_EVENTS.filter(d => !savedIds.has(d.id) && !deleted.has(d.id));
        events = [...saved, ...missingDefaults].filter(e => !deleted.has(e.id));
        // Persistir el merge limpio
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(events)); } catch(_) {}
      }
    } catch(e) {
      events = JSON.parse(JSON.stringify(DEFAULT_EVENTS));
    }
  }
  function saveEvents() {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(events)); } catch(e) {}
  }

  function counts() {
    return {
      todos: events.length,
      activo: events.filter(e => e.estado === 'activo').length,
      borrador: events.filter(e => e.estado === 'borrador').length,
      finalizado: events.filter(e => e.estado === 'finalizado').length,
    };
  }

  function renderFilters() {
    const c = counts();
    const filters = [
      { id: 'todos', label: 'Todos', n: c.todos },
      { id: 'activo', label: 'Activos', n: c.activo },
      { id: 'borrador', label: 'Borradores', n: c.borrador },
      { id: 'finalizado', label: 'Finalizados', n: c.finalizado },
    ];
    document.getElementById('filterRow').innerHTML = filters.map(f => `
      <span class="filter-pill ${currentFilter === f.id ? 'active' : ''}"
            onclick="setFilter('${f.id}')">${f.label} (${f.n})</span>
    `).join('');
  }

  function setFilter(id) {
    currentFilter = id;
    renderFilters();
    renderGrid();
  }

  // Cuenta inscritos/ventas reales de un evento desde ms_inscripciones
  function statsRealesEvento(eventId) {
    let inscripciones = [];
    try { inscripciones = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
    const delEvento = inscripciones.filter(i => i && i.eventId === eventId);
    const vendidos = delEvento.length;
    const recaudado = delEvento.reduce((acc, i) => acc + (Number(i.total) || 0), 0);
    // "Fichas listas" = inscripciones con datos médicos completos (todas las reales lo están, por la validación)
    const fichasListas = delEvento.length;
    return { vendidos, recaudado, fichasListas, pendientes: 0 };
  }

  function fmtMoneyShort(n) {
    if (!n) return '$0';
    if (n >= 1000000) return '$' + (n/1000000).toFixed(1).replace('.0','') + 'M';
    if (n >= 1000) return '$' + Math.round(n/1000) + 'K';
    return '$' + n.toLocaleString('es-CL');
  }

  function renderGrid() {
    const filtered = currentFilter === 'todos'
      ? events
      : events.filter(e => e.estado === currentFilter);
    const grid = document.getElementById('eventGrid');

    if (filtered.length === 0) {
      grid.innerHTML = `
        <div class="empty-state">
          <i class="ti ti-calendar-off"></i>
          <h3>No hay eventos en "${currentFilter}"</h3>
          <p>${events.length === 0 ? 'Crea tu primer evento para empezar.' : 'Cambia el filtro o crea uno nuevo.'}</p>
          <a href="#/organizador/crear-evento" class="btn btn-primary"><i class="ti ti-plus"></i> Crear evento</a>
        </div>
      `;
      return;
    }

    grid.innerHTML = filtered.map(e => {
      if (e.isDraft) {
        return `
          <div class="event-tile" style="background: var(--bg-secondary); border-style: dashed;">
            <div class="et-actions">
              <button class="et-action delete" onclick="askDelete('${e.id}')" title="Eliminar borrador">
                <i class="ti ti-trash"></i>
              </button>
            </div>
            <a href="#/organizador/crear-evento" class="et-link" onclick="event.preventDefault(); editEvent('${e.id}');">
              <div class="et-top">
                <div class="et-icon" style="background: var(--bg-tertiary); color: var(--text-tertiary);"><i class="ti ${e.icon}"></i></div>
                <span class="badge" style="background: var(--bg-tertiary); color: var(--text-secondary);">${e.estadoLabel}</span>
              </div>
              <h3>${e.nombre}</h3>
              <p class="meta">${e.fecha}</p>
              <p class="small muted mt-4" style="font-style: italic;">Continúa configurando este evento para publicarlo</p>
              <button class="btn btn-outline btn-block mt-4 btn-sm" onclick="event.preventDefault(); event.stopPropagation(); editEvent('${e.id}');"><i class="ti ti-edit"></i> Continuar editando</button>
            </a>
          </div>
        `;
      }

      // ¿Es un evento real creado por el usuario? (no demo) → usar stats reales
      const DEMO_IDS = ['rally-purranque','liga-osorno','torneo-3x3','trail-llanquihue','mtb-puyehue','crossfit-bicentenario'];
      const esReal = !DEMO_IDS.includes(e.id);
      let vendidos = e.vendidos, total = e.total, statsArr = e.stats;
      if (esReal) {
        const sr = statsRealesEvento(e.id);
        vendidos = sr.vendidos;
        // total = suma de stock de los tickets, o el total guardado
        let stockTotal = 0;
        if (e._meta && Array.isArray(e._meta.tickets)) {
          stockTotal = e._meta.tickets.reduce((a, t) => a + (Number(t.stock) || 0), 0);
        }
        total = stockTotal || e.total || 100;
        statsArr = [
          { v: fmtMoneyShort(sr.recaudado), l: 'Recaudado', class: 'purple' },
          { v: String(sr.fichasListas), l: 'Fichas listas' },
          { v: String(sr.pendientes), l: 'Pendientes' },
        ];
      }
      const pct = total ? Math.round((vendidos / total) * 100) : 0;
      const unidad = e.unidad || 'vendidos';
      const badgeClass = `badge-${e.estadoColor}`;
      const progressColor = e.estado === 'finalizado' ? 'var(--blue-500)' : '';
      const pctColor = e.estado === 'finalizado' ? 'var(--blue-700)' : 'var(--purple-700)';

      // Imagen de portada (si la cargó el organizador al crear/editar)
      const cover = e._meta && e._meta.imagen ? e._meta.imagen : null;
      const iconBlock = cover
        ? `<div class="et-icon et-icon-img" style="background-image: url('${cover}'); background-size: cover; background-position: center;"></div>`
        : `<div class="et-icon ${e.color}"><i class="ti ${e.icon}"></i></div>`;

      return `
        <div class="event-tile">
          <div class="et-actions">
            <button class="et-action" onclick="event.stopPropagation(); editEvent('${e.id}')" title="Editar"><i class="ti ti-edit"></i></button>
            <button class="et-action delete" onclick="event.stopPropagation(); askDelete('${e.id}')" title="Eliminar"><i class="ti ti-trash"></i></button>
          </div>
          <a href="#/organizador/evento?id=${e.id}" class="et-link" onclick="event.preventDefault(); verGestionEvento('${e.id}');">
            <div class="et-top">
              ${iconBlock}
              <span class="badge ${badgeClass}">${e.estadoLabel}</span>
            </div>
            <h3>${e.nombre}</h3>
            <p class="meta"><i class="ti ti-calendar" style="font-size: 13px;"></i> ${e.fecha}</p>
            <div class="et-progress">
              <div class="flex-between small muted">
                <span>${vendidos} / ${total} ${unidad}</span>
                <span style="color: ${pctColor}; font-weight: 600;">${pct}%</span>
              </div>
              <div class="et-progress-bar"><div class="et-progress-fill" style="width: ${pct}%; ${progressColor ? 'background:' + progressColor : ''}"></div></div>
            </div>
            <div class="et-stats">
              ${statsArr.map(s => `<div class="et-stat"><strong${s.class ? ' class="' + s.class + '"' : ''}>${s.v}</strong><small>${s.l}</small></div>`).join('')}
            </div>
          </a>
        </div>
      `;
    }).join('');
  }

  function askDelete(id) {
    toDelete = id;
    const ev = events.find(x => x.id === id);
    document.getElementById('confName').textContent = ev ? ev.nombre : '';
    document.getElementById('confirmModal').classList.add('open');
  }

  function cancelDelete() {
    toDelete = null;
    document.getElementById('confirmModal').classList.remove('open');
  }

  function confirmDelete() {
    if (!toDelete) return;
    const ev = events.find(x => x.id === toDelete);
    events = events.filter(x => x.id !== toDelete);
    markDeleted(toDelete); // recordar que se eliminó para que no reaparezca
    saveEvents();
    cancelDelete();
    renderFilters();
    renderGrid();
    showToast(`"${ev?.nombre || 'Evento'}" eliminado`);
  }

  function showToast(msg) {
    const t = document.getElementById('toastNotice');
    document.getElementById('toastMsg').textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2400);
  }

  // close modal on bg click
  document.getElementById('confirmModal').addEventListener('click', e => {
    if (e.target.id === 'confirmModal') cancelDelete();
  });

  loadEvents();
  renderFilters();
  renderGrid();

  // ============ EXPONER FUNCIONES A WINDOW ============
  // Los botones de las tarjetas usan onclick="askDelete(...)" / "setFilter(...)"
  // que requieren funciones globales (están atrapadas en este IIFE).
  window.askDelete = askDelete;
  window.cancelDelete = cancelDelete;
  window.confirmDelete = confirmDelete;
  window.setFilter = setFilter;

  // ============ EDITAR EVENTO ============
  // Carga el evento en localStorage como "borrador de edición" y abre el wizard.
  window.editEvent = function(eventId) {
    try {
      const list = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
      const ev = list.find(e => e.id === eventId);
      if (!ev) {
        if (window.toast) toast('No se encontró el evento', 'error');
        return;
      }
      // Guardar el evento a editar para que el wizard lo precargue
      localStorage.setItem('ms_editing_event', JSON.stringify(ev));
      if (window.toast) toast('Editando: ' + (ev.nombre || 'evento'));
      if (window.MatchSPA) MatchSPA.navigate('/organizador/crear-evento');
      else location.hash = '#/organizador/crear-evento';
    } catch(e) {
      console.warn('Error al editar:', e);
    }
  };

  // Recargar eventos cuando se navega a esta página (sin recargar el documento).
  // Útil para que aparezca el evento recién creado por el wizard.
  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-mis-eventos', function() {
      loadEvents();
      renderFilters();
      renderGrid();
    });
  }
} catch(_e) { console.warn('[organizador/mis-eventos.html]', _e.message); } })();
</script>

<!-- ===== JS de organizador/crear-evento.html ===== -->
<script>
(function(){ try {
// ============ STATE ============
  const state = {
    step: 1,
    deporte: null,
    subtipo: null,
    nombre: 'Rally Costero Purranque RCP 2027',
    fecha: '2027-05-16',
    hora: '08:00',
    lugar: 'Plaza de Armas, Purranque, Los Lagos',
    desc: 'La cuarta edición del Rally Costero Purranque recorre los paisajes más espectaculares del sur de Chile.',
    autoprogramar: false,
    pubFecha: '',
    pubHora: '09:00',
    cierre: '',
    distancias: [
      { nombre: 'General 8 km', km: 8, hora: '08:00' },
      { nombre: 'Trail 16 km', km: 16, hora: '08:00' },
    ],
    generos: ['M', 'F'],
    categorias: [
      { nombre: 'Open', edadMin: 18, edadMax: 39 },
      { nombre: 'Senior 40+', edadMin: 40, edadMax: 49 },
      { nombre: 'Master 50+', edadMin: 50, edadMax: 99 },
      { nombre: 'Junior', edadMin: 14, edadMax: 17 },
    ],
    tickets: [
      { nombre: 'General 8 km', precio: 15000, stock: 200, distancias: [0] },
      { nombre: 'Premium 16 km', precio: 22000, stock: 150, distancias: [1] },
      { nombre: 'VIP 16 km + kit', precio: 35000, stock: 50, distancias: [1] },
    ],
    comisionPaga: 'corredor',
    mapaTipo: 'preset',
    mapaPreset: 'costero',
    incluyePolera: true,
    reglamento: null,
    videoArchivo: null,
    precioTipo: 'pago',
    modalidad: 'presencial',
    cronograma: [
      { dia: '', horaIni: '', horaFin: '', actividad: '', detalle: '' },
    ],
    cronogramaTexto: '',
    gpxList: [],
    altimetrias: [],
    features: { ficha: true, diplomas: true, listaEspera: true, transferencia: false },
  };

  // ============ STEPPER ============
  const STEPS = [
    { n: 1, label: 'Tipo' },
    { n: 2, label: 'Datos' },
    { n: 3, label: 'Categorías' },
    { n: 4, label: 'Entradas' },
    { n: 5, label: 'Mapa' },
    { n: 6, label: 'Publicar' },
  ];

  function renderStepper() {
    const el = document.getElementById('stepper');
    el.innerHTML = STEPS.map((s, i) => {
      const status = s.n < state.step ? 'done' : s.n === state.step ? 'active' : '';
      const inner = s.n < state.step
        ? `<i class="ti ti-check" style="font-size: 12px;"></i>`
        : s.n;
      return `
        ${i > 0 ? `<div class="step-line ${s.n <= state.step ? 'done' : ''}"></div>` : ''}
        <div class="step ${status}" onclick="go(${s.n})">
          <div class="step-num">${inner}</div>
          <span>${s.label}</span>
        </div>
      `;
    }).join('');
  }

  function go(n) {
    // Allow navigating freely (since data is hardcoded for demo)
    if (n < 1 || n > 6) return;
    state.step = n;
    document.querySelectorAll('.step-pane').forEach(p => {
      p.classList.toggle('active', parseInt(p.dataset.pane) === n);
    });
    renderStepper();
    if (n === 1) { try { renderFormatoState(); } catch(_) {} }
    // Al entrar al paso 3, renderizar categorías y marcar chips de género
    if (n === 2) { try { renderReglamentoState(); renderVideoState(); } catch(_) {} }
    if (n === 3) {
      try {
        renderCat();
        document.querySelectorAll('#generoChips .genero-chip').forEach(ch => {
          ch.classList.toggle('active', (state.generos||[]).indexOf(ch.dataset.genero) >= 0);
        });
      } catch(_) {}
    }
    // Al entrar al paso 5, asegurar que el cronograma esté renderizado
    if (n === 5) { try { renderCrono(); renderGpxList(); renderAltimetriaList(); } catch(_) {} }
    showSaved();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function showSaved() {
    const el = document.getElementById('autoSaveTop');
    el.style.display = 'inline-flex';
    el.style.alignItems = 'center';
    el.style.gap = '4px';
    clearTimeout(window.__savedTo);
    window.__savedTo = setTimeout(() => { el.style.display = 'none'; }, 2200);
  }

  // ============ STEP 1: SPORT GRID ============
  const SPORTS = [
    { id: 'running', name: 'Running', icon: 'ti-run', desc: 'Carreras urbanas, calle, 5K-42K',
      subs: ['Calle / Asfalto', 'Cross country', 'Pista', 'Carrera kids'] },
    { id: 'trail', name: 'Trail / Montaña', icon: 'ti-mountain', desc: 'Cerro, sendero, ultra distancias',
      subs: ['Trail corto', 'Ultra trail', 'Skyrunning', 'Vertical kilometer'] },
    { id: 'ciclismo', name: 'Ciclismo', icon: 'ti-bike', desc: 'MTB, ruta, gravel, urbano',
      subs: ['MTB XCO', 'MTB enduro', 'Ruta', 'Gravel', 'Granfondo'] },
    { id: 'futbol', name: 'Fútbol', icon: 'ti-ball-football', desc: 'Ligas, torneos, babyfútbol',
      subs: ['Liga regular', 'Torneo eliminatoria', 'Babyfútbol', 'Senior', 'Femenino'] },
    { id: 'basquet', name: 'Básquet', icon: 'ti-ball-basketball', desc: 'Torneos 3x3, 5x5, clínicas',
      subs: ['Torneo 5x5', 'Torneo 3x3', 'Liga', 'Clínica deportiva'] },
    { id: 'natacion', name: 'Natación / Triatlón', icon: 'ti-swimming', desc: 'Aguas abiertas, piscina, tri',
      subs: ['Aguas abiertas', 'Piscina', 'Triatlón sprint', 'Triatlón olímpico'] },
    { id: 'fitness', name: 'Fitness / Crossfit', icon: 'ti-yoga', desc: 'Funcional, crossfit, yoga',
      subs: ['Crossfit competencia', 'Funcional', 'Yoga / mindful', 'HIIT'] },
    { id: 'outdoor', name: 'Outdoor', icon: 'ti-tent', desc: 'Trekking, escalada, kayak',
      subs: ['Trekking', 'Escalada', 'Kayak', 'Stand-up paddle', 'Aventura combinada'] },
    { id: 'otro', name: 'Otra disciplina', icon: 'ti-plus', desc: 'Crea categorías a medida',
      subs: [] },
  ];

  function renderSports() {
    const el = document.getElementById('sportGrid');
    el.innerHTML = SPORTS.map(s => `
      <div class="sport-card ${state.deporte === s.id ? 'sel' : ''}" onclick="selectSport('${s.id}')">
        <div class="sport-icon"><i class="ti ${s.icon}"></i></div>
        <div class="sport-name">${s.name}</div>
        <div class="sport-desc">${s.desc}</div>
      </div>
    `).join('');
  }

  function selectSport(id) {
    state.deporte = id;
    state.subtipo = null;
    renderSports();
    renderSubtipos();
    document.getElementById('next1').disabled = false;
    document.getElementById('next1').style.opacity = '1';
  }

  function renderSubtipos() {
    const sport = SPORTS.find(s => s.id === state.deporte);
    const block = document.getElementById('subtipoBlock');
    const row = document.getElementById('subtipoRow');
    if (!sport || !sport.subs.length) {
      block.style.display = 'none';
      return;
    }
    block.style.display = 'block';
    row.innerHTML = sport.subs.map(s => `
      <div class="subtipo-chip ${state.subtipo === s ? 'sel' : ''}" onclick="selectSubtipo('${s.replace(/'/g, "\\'")}')">${s}</div>
    `).join('');
  }

  function selectSubtipo(s) {
    state.subtipo = state.subtipo === s ? null : s;
    renderSubtipos();
  }

  document.getElementById('next1').addEventListener('click', () => go(2));

  // ============ STEP 2: FORM + TOGGLES ============
  function bindFormFields() {
    document.getElementById('f-nombre').value = state.nombre;
    document.getElementById('f-fecha').value = state.fecha;
    document.getElementById('f-hora').value = state.hora;
    document.getElementById('f-lugar').value = state.lugar;
    document.getElementById('f-desc').value = state.desc;
    const ytEl = document.getElementById('f-youtube');
    if (ytEl) ytEl.value = state.youtube || '';

    document.getElementById('f-nombre').oninput = e => { state.nombre = e.target.value; showSaved(); };
    document.getElementById('f-fecha').oninput = e => { state.fecha = e.target.value; showSaved(); };
    document.getElementById('f-hora').oninput = e => { state.hora = e.target.value; showSaved(); };
    document.getElementById('f-lugar').oninput = e => { state.lugar = e.target.value; showSaved(); };
    document.getElementById('f-desc').oninput = e => { state.desc = e.target.value; showSaved(); };
    if (ytEl) ytEl.oninput = e => { state.youtube = e.target.value; showSaved(); };
  }

  document.querySelectorAll('[data-toggle]').forEach(t => {
    t.addEventListener('click', () => {
      const k = t.dataset.toggle;
      if (k === 'autoprogramar') {
        state.autoprogramar = !state.autoprogramar;
        t.classList.toggle('on', state.autoprogramar);
        document.getElementById('autoprogReveal').classList.toggle('open', state.autoprogramar);
      } else if (state.features.hasOwnProperty(k)) {
        state.features[k] = !state.features[k];
        t.classList.toggle('on', state.features[k]);
      }
      showSaved();
    });
  });

  // ============ STEP 3: DISTANCIAS ============
  function renderDist() {
    const el = document.getElementById('distList');
    if (!state.distancias.length) {
      el.innerHTML = `<div class="empty"><i class="ti ti-route"></i>Aún no agregas distancias.<br>Usa una plantilla o haz click en + Agregar.</div>`;
      return;
    }
    el.innerHTML = state.distancias.map((d, i) => `
      <div class="item-row dist">
        <div class="item-handle">${i + 1}</div>
        <div>
          <label class="label">Nombre</label>
          <input class="input" value="${d.nombre}" oninput="updateDist(${i}, 'nombre', this.value)">
        </div>
        <div>
          <label class="label">Distancia (km)</label>
          <input type="number" class="input" value="${d.km}" oninput="updateDist(${i}, 'km', parseFloat(this.value))">
        </div>
        <div>
          <label class="label">Hora largada</label>
          <input type="time" class="input" value="${d.hora}" oninput="updateDist(${i}, 'hora', this.value)">
        </div>
        <button class="item-del" onclick="removeDist(${i})" title="Eliminar"><i class="ti ti-trash"></i></button>
      </div>
    `).join('');
  }

  function updateDist(i, k, v) { state.distancias[i][k] = v; showSaved(); }
  function removeDist(i) { state.distancias.splice(i, 1); renderDist(); renderTickets(); showSaved(); }
  function addDist() {
    state.distancias.push({ nombre: 'Nueva distancia', km: 5, hora: state.hora });
    renderDist(); showSaved();
  }

  const DIST_PRESETS = {
    running: [
      { nombre: '5 km', km: 5, hora: '08:00' },
      { nombre: '10 km', km: 10, hora: '08:00' },
      { nombre: 'Media maratón 21K', km: 21.097, hora: '07:30' },
    ],
    trail: [
      { nombre: 'Trail corto 8 km', km: 8, hora: '08:00' },
      { nombre: 'Trail medio 16 km', km: 16, hora: '08:00' },
      { nombre: 'Ultra 30 km', km: 30, hora: '07:00' },
    ],
    mtb: [
      { nombre: 'XCO corto', km: 25, hora: '09:00' },
      { nombre: 'XCO largo', km: 50, hora: '09:00' },
    ],
    triatlon: [
      { nombre: 'Sprint (750/20/5)', km: 25.75, hora: '08:00' },
      { nombre: 'Olímpico (1.5/40/10)', km: 51.5, hora: '07:30' },
    ],
  };
  function applyDistPreset(p) {
    state.distancias = JSON.parse(JSON.stringify(DIST_PRESETS[p]));
    renderDist();
    renderTickets();
    document.querySelectorAll('#distList ~ * + .preset-row .preset-chip').forEach(c => c.classList.remove('applied'));
    showSaved();
  }

  // ============ STEP 3: CATEGORIAS ============
  const GENERO_LABEL = { M: 'Masculino', F: 'Femenino', mixto: 'Mixto' };
  const GENERO_SUFIJO = { M: 'M', F: 'F', mixto: 'Mixto' };

  function renderCat() {
    const el = document.getElementById('catList');
    if (!state.categorias.length) {
      el.innerHTML = `<div class="empty"><i class="ti ti-users-group"></i>Aún no agregas categorías.</div>`;
      updateGeneroPreview();
      return;
    }
    el.innerHTML = state.categorias.map((c, i) => `
      <div class="item-row cat" style="grid-template-columns: 40px 1.6fr 1fr auto;">
        <div class="item-handle" style="background: var(--amber-500);">${String.fromCharCode(65 + i)}</div>
        <div>
          <label class="label">Nombre</label>
          <input class="input" value="${(c.nombre||'').replace(/"/g,'&quot;')}" oninput="updateCat(${i}, 'nombre', this.value)">
        </div>
        <div>
          <label class="label">Edad rango</label>
          <div style="display: flex; gap: 4px; align-items: center;">
            <input type="number" class="input" style="padding: 8px 8px;" value="${c.edadMin}" oninput="updateCat(${i}, 'edadMin', parseInt(this.value))">
            <span style="color: var(--text-tertiary);">–</span>
            <input type="number" class="input" style="padding: 8px 8px;" value="${c.edadMax}" oninput="updateCat(${i}, 'edadMax', parseInt(this.value))">
          </div>
        </div>
        <button class="item-del" onclick="removeCat(${i})"><i class="ti ti-trash"></i></button>
      </div>
    `).join('');
    updateGeneroPreview();
  }

  // Géneros seleccionados (chips)
  function toggleGenero(g) {
    if (!Array.isArray(state.generos)) state.generos = [];
    const idx = state.generos.indexOf(g);
    if (idx >= 0) {
      // No permitir quedar sin ningún género
      if (state.generos.length === 1) { if (window.toast) toast('Debe quedar al menos un género', 'error'); return; }
      state.generos.splice(idx, 1);
    } else {
      state.generos.push(g);
    }
    // Actualizar chips visualmente
    document.querySelectorAll('#generoChips .genero-chip').forEach(ch => {
      ch.classList.toggle('active', state.generos.indexOf(ch.dataset.genero) >= 0);
    });
    updateGeneroPreview();
    showSaved();
  }

  // Generar la lista final de categorías (edad × género)
  function buildCategoriasFinal() {
    const generos = (Array.isArray(state.generos) && state.generos.length) ? state.generos : ['mixto'];
    const out = [];
    state.categorias.forEach(c => {
      generos.forEach(g => {
        out.push({
          nombre: c.nombre + ' ' + GENERO_SUFIJO[g],
          base: c.nombre,
          edadMin: c.edadMin,
          edadMax: c.edadMax,
          genero: g
        });
      });
    });
    return out;
  }

  function updateGeneroPreview() {
    const el = document.getElementById('genero-preview');
    if (!el) return;
    const final = buildCategoriasFinal();
    if (!final.length) { el.textContent = ''; return; }
    const generos = (Array.isArray(state.generos) && state.generos.length) ? state.generos : ['mixto'];
    const nombresGen = generos.map(g => GENERO_LABEL[g]).join(' + ');
    el.innerHTML = `<i class="ti ti-arrow-right" style="font-size:11px;"></i> Se generarán <strong>${final.length} categorías</strong> (${state.categorias.length} edades × ${generos.length} género${generos.length>1?'s':''}: ${nombresGen}): ${final.slice(0,6).map(c=>c.nombre).join(', ')}${final.length>6?'…':''}`;
  }

  function updateCat(i, k, v) { state.categorias[i][k] = v; updateGeneroPreview(); showSaved(); }
  function removeCat(i) { state.categorias.splice(i, 1); renderCat(); showSaved(); }
  function addCat() {
    state.categorias.push({ nombre: 'Nueva categoría', edadMin: 18, edadMax: 39 });
    renderCat(); showSaved();
  }

  // ============ POLERA ============
  // ============ FORMATO (precio / modalidad) ============
  function setFormato(grupo, valor) {
    if (grupo === 'precio') state.precioTipo = valor;
    if (grupo === 'modalidad') state.modalidad = valor;
    // Marcar visualmente las tarjetas del grupo
    document.querySelectorAll(`.formato-card[data-formato="${grupo}"]`).forEach(card => {
      card.classList.toggle('active', card.dataset.value === valor);
    });
    showSaved();
  }

  function renderFormatoState() {
    document.querySelectorAll('.formato-card[data-formato="precio"]').forEach(card => {
      card.classList.toggle('active', card.dataset.value === (state.precioTipo || 'pago'));
    });
    document.querySelectorAll('.formato-card[data-formato="modalidad"]').forEach(card => {
      card.classList.toggle('active', card.dataset.value === (state.modalidad || 'presencial'));
    });
  }

  function setPolera(incluye) {
    state.incluyePolera = incluye;
    const si = document.getElementById('polera-si');
    const no = document.getElementById('polera-no');
    if (si) si.classList.toggle('active', incluye);
    if (no) no.classList.toggle('active', !incluye);
    showSaved();
  }

  // ============ REGLAMENTO (PDF/Word) ============
  function onReglamentoUpload(input) {
    const file = input.files && input.files[0];
    if (!file) return;
    // Validar tipo
    const okExt = /\.(pdf|docx?|doc)$/i.test(file.name);
    if (!okExt) {
      if (window.toast) toast('El reglamento debe ser PDF o Word', 'error');
      input.value = '';
      return;
    }
    // Límite razonable (8 MB) para no reventar localStorage
    if (file.size > 8 * 1024 * 1024) {
      if (window.toast) toast('El archivo es muy grande (máx 8 MB)', 'error');
      input.value = '';
      return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
      state.reglamento = { nombre: file.name, tipo: file.type, dataUrl: e.target.result };
      renderReglamentoState();
      showSaved();
    };
    reader.readAsDataURL(file);
  }

  function removeReglamento() {
    state.reglamento = null;
    const input = document.getElementById('f-reglamento');
    if (input) input.value = '';
    renderReglamentoState();
    showSaved();
  }

  function renderReglamentoState() {
    const empty = document.getElementById('reglamento-empty');
    const loaded = document.getElementById('reglamento-loaded');
    const nombre = document.getElementById('reglamento-nombre');
    if (!empty || !loaded) return;
    if (state.reglamento && state.reglamento.nombre) {
      empty.style.display = 'none';
      loaded.style.display = 'flex';
      if (nombre) nombre.textContent = state.reglamento.nombre;
    } else {
      empty.style.display = 'block';
      loaded.style.display = 'none';
    }
  }

  // ============ VIDEO (archivo subido) ============
  function onVideoUpload(input) {
    const file = input.files && input.files[0];
    if (!file) return;
    const okExt = /\.(mp4|webm|mov)$/i.test(file.name) || /^video\//.test(file.type);
    if (!okExt) {
      if (window.toast) toast('El archivo debe ser un video (MP4, WebM o MOV)', 'error');
      input.value = '';
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      if (window.toast) toast('El video es muy grande (máx 50 MB)', 'error');
      input.value = '';
      return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
      state.videoArchivo = { nombre: file.name, tipo: file.type, dataUrl: e.target.result };
      renderVideoState();
      showSaved();
    };
    reader.readAsDataURL(file);
  }

  function removeVideo() {
    state.videoArchivo = null;
    const input = document.getElementById('f-video');
    if (input) input.value = '';
    renderVideoState();
    showSaved();
  }

  function renderVideoState() {
    const empty = document.getElementById('video-empty');
    const loaded = document.getElementById('video-loaded');
    const nombre = document.getElementById('video-nombre');
    if (!empty || !loaded) return;
    if (state.videoArchivo && state.videoArchivo.nombre) {
      empty.style.display = 'none';
      loaded.style.display = 'flex';
      if (nombre) nombre.textContent = state.videoArchivo.nombre;
    } else {
      empty.style.display = 'block';
      loaded.style.display = 'none';
    }
  }

  // ============ CRONOGRAMA (texto libre, mismo formato que la descripción) ============
  function renderCrono() {
    const el = document.getElementById('f-cronograma');
    if (!el) return;
    // Cargar el texto guardado en el textarea
    el.value = state.cronogramaTexto || '';
  }
  function updateCronogramaTexto(v) {
    state.cronogramaTexto = v;
    showSaved();
  }
  // Compatibilidad: funciones antiguas mantenidas como no-op (ya no hay campos por fila)
  function addCrono() {}
  function updateCrono() {}
  function removeCrono() {}

  // ============ RECORRIDO: GPX/KML múltiples ============
  function renderGpxList() {
    const el = document.getElementById('gpxList');
    if (!el) return;
    if (!state.gpxList.length) {
      el.innerHTML = '<p class="small muted" style="padding:6px 0 10px;">Aún no has subido archivos de recorrido.</p>';
      return;
    }
    el.innerHTML = state.gpxList.map((g, i) => `
      <div class="recorrido-item">
        <i class="ti ti-file-check" style="font-size:22px; color: var(--green-600);"></i>
        <div style="flex:1; min-width:0;">
          <input class="input" style="font-weight:600; font-size:13px; margin-bottom:4px;" value="${(g.titulo||'').replace(/"/g,'&quot;')}" placeholder="Nombre del circuito (ej: 21K)" oninput="updateGpxTitulo(${i}, this.value)">
          <div class="small muted" style="font-size:11px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${(g.nombre||'').replace(/</g,'&lt;')}</div>
        </div>
        <button type="button" class="item-del" onclick="removeGpx(${i})"><i class="ti ti-trash"></i></button>
      </div>
    `).join('');
  }

  function addGpx() {
    // Crear input temporal para seleccionar archivo
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.gpx,.kml,application/gpx+xml,application/vnd.google-earth.kml+xml';
    input.onchange = function() {
      const file = input.files && input.files[0];
      if (!file) return;
      if (!/\.(gpx|kml)$/i.test(file.name)) {
        if (window.toast) toast('El archivo debe ser GPX o KML', 'error');
        return;
      }
      if (file.size > 8 * 1024 * 1024) {
        if (window.toast) toast('El archivo es muy grande (máx 8 MB)', 'error');
        return;
      }
      const reader = new FileReader();
      reader.onload = function(e) {
        state.gpxList.push({ nombre: file.name, titulo: file.name.replace(/\.(gpx|kml)$/i,''), dataUrl: e.target.result });
        renderGpxList();
        showSaved();
      };
      reader.readAsDataURL(file);
    };
    input.click();
  }

  function updateGpxTitulo(i, v) { if (state.gpxList[i]) { state.gpxList[i].titulo = v; showSaved(); } }
  function removeGpx(i) { state.gpxList.splice(i, 1); renderGpxList(); showSaved(); }

  // ============ ALTIMETRÍA: fotos múltiples ============
  function renderAltimetriaList() {
    const el = document.getElementById('altimetriaList');
    if (!el) return;
    if (!state.altimetrias.length) {
      el.innerHTML = '<p class="small muted" style="padding:6px 0 10px;">Aún no has subido fotos de altimetría.</p>';
      return;
    }
    el.innerHTML = state.altimetrias.map((a, i) => `
      <div class="altimetria-item">
        <img src="${a.dataUrl}" alt="Altimetría" class="altimetria-thumb">
        <div style="flex:1; min-width:0;">
          <input class="input" style="font-weight:600; font-size:13px;" value="${(a.titulo||'').replace(/"/g,'&quot;')}" placeholder="Nombre del circuito (ej: 21K)" oninput="updateAltimetriaTitulo(${i}, this.value)">
        </div>
        <button type="button" class="item-del" onclick="removeAltimetria(${i})"><i class="ti ti-trash"></i></button>
      </div>
    `).join('');
  }

  function addAltimetria() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp';
    input.onchange = function() {
      const file = input.files && input.files[0];
      if (!file) return;
      if (!/^image\//.test(file.type) && !/\.(jpe?g|png|webp)$/i.test(file.name)) {
        if (window.toast) toast('Debe ser una imagen (JPG, PNG o WebP)', 'error');
        return;
      }
      if (file.size > 5 * 1024 * 1024) {
        if (window.toast) toast('La imagen es muy grande (máx 5 MB)', 'error');
        return;
      }
      const reader = new FileReader();
      reader.onload = function(e) {
        state.altimetrias.push({ nombre: file.name, titulo: file.name.replace(/\.(jpe?g|png|webp)$/i,''), dataUrl: e.target.result });
        renderAltimetriaList();
        showSaved();
      };
      reader.readAsDataURL(file);
    };
    input.click();
  }

  function updateAltimetriaTitulo(i, v) { if (state.altimetrias[i]) { state.altimetrias[i].titulo = v; showSaved(); } }
  function removeAltimetria(i) { state.altimetrias.splice(i, 1); renderAltimetriaList(); showSaved(); }

  const CAT_PRESETS = {
    basico: [
      { nombre: 'Junior', edadMin: 14, edadMax: 17 },
      { nombre: 'Open', edadMin: 18, edadMax: 39 },
      { nombre: 'Senior', edadMin: 40, edadMax: 99 },
    ],
    completo: [
      { nombre: 'Sub-18', edadMin: 14, edadMax: 17 },
      { nombre: 'Sub-23', edadMin: 18, edadMax: 22 },
      { nombre: 'Elite', edadMin: 23, edadMax: 39 },
      { nombre: 'Master 40+', edadMin: 40, edadMax: 49 },
      { nombre: 'Master 50+', edadMin: 50, edadMax: 59 },
      { nombre: 'Master 60+', edadMin: 60, edadMax: 99 },
    ],
  };
  function applyCatPreset(p) {
    state.categorias = JSON.parse(JSON.stringify(CAT_PRESETS[p]));
    renderCat();
    showSaved();
  }

  // ============ STEP 4: TICKETS + COMISIÓN ============
  // Calcula la vigencia de un ticket según sus fechas de inscripción
  function ticketVigencia(t) {
    const hoy = new Date(); hoy.setHours(0,0,0,0);
    const desde = t.inscDesde ? new Date(t.inscDesde + 'T00:00:00') : null;
    const hasta = t.inscHasta ? new Date(t.inscHasta + 'T23:59:59') : null;
    if (desde && hoy < desde) return { estado: 'proximo', clase: 'badge-proximo', label: '○ Próximamente' };
    if (hasta && hoy > hasta) return { estado: 'cerrado', clase: 'badge-cerrado', label: '✕ Cerrado' };
    return { estado: 'vigente', clase: 'badge-vigente', label: '● Vigente' };
  }

  function renderTickets() {
    const el = document.getElementById('ticketList');
    if (!state.tickets.length) {
      el.innerHTML = `<div class="empty"><i class="ti ti-ticket"></i>Aún no agregas tipos de entrada.</div>`;
      return;
    }
    el.innerHTML = state.tickets.map((t, i) => {
      const distChips = state.distancias.map((d, di) => `
        <div class="dist-tag ${t.distancias.includes(di) ? 'on' : ''}" onclick="toggleTicketDist(${i}, ${di})">${d.nombre}</div>
      `).join('');
      return `
        <div class="ticket-card">
          <div class="ticket-head">
            <strong>Ticket ${i + 1}</strong>
            <button class="item-del" onclick="removeTicket(${i})"><i class="ti ti-trash"></i></button>
          </div>
          <div class="ticket-fields">
            <div>
              <label class="label">Nombre del ticket</label>
              <input class="input" value="${(t.nombre||'').replace(/"/g,'&quot;')}" oninput="updateTicket(${i}, 'nombre', this.value)">
            </div>
            <div>
              <label class="label">Precio (${(state.moneda||'CLP')})</label>
              <input type="number" class="input" value="${t.precio}" oninput="updateTicket(${i}, 'precio', parseInt(this.value))">
            </div>
            <div>
              <label class="label">Stock</label>
              <input type="number" class="input" value="${t.stock}" oninput="updateTicket(${i}, 'stock', parseInt(this.value))">
            </div>
            <div></div>
          </div>
          <div class="ticket-period-row">
            <div>
              <label class="label">Inscripción abre</label>
              <input type="date" class="input" value="${t.inscDesde || ''}" oninput="updateTicket(${i}, 'inscDesde', this.value)">
            </div>
            <div>
              <label class="label">Inscripción cierra</label>
              <input type="date" class="input" value="${t.inscHasta || ''}" oninput="updateTicket(${i}, 'inscHasta', this.value)">
            </div>
            <div style="align-self:end;">
              <span class="ticket-period-badge ${ticketVigencia(t).clase}">${ticketVigencia(t).label}</span>
            </div>
          </div>
          ${state.distancias.length ? `
            <div class="ticket-dist-row">
              <label class="label">Distancias incluidas en este ticket</label>
              <div class="dist-tag-list">${distChips || '<span class="small muted">No hay distancias creadas en el paso anterior.</span>'}</div>
            </div>
          ` : ''}
        </div>
      `;
    }).join('');
  }

  function updateTicket(i, k, v) {
    state.tickets[i][k] = v;
    // Si cambió una fecha de inscripción, re-renderizar para actualizar el badge de vigencia
    if (k === 'inscDesde' || k === 'inscHasta') renderTickets();
    showSaved();
  }
  function removeTicket(i) { state.tickets.splice(i, 1); renderTickets(); showSaved(); }
  function addTicket() {
    state.tickets.push({ nombre: 'Nuevo ticket', precio: 10000, stock: 100, distancias: [] });
    renderTickets(); showSaved();
  }
  function toggleTicketDist(ti, di) {
    const arr = state.tickets[ti].distancias;
    const idx = arr.indexOf(di);
    if (idx >= 0) arr.splice(idx, 1); else arr.push(di);
    renderTickets(); showSaved();
  }

  // Comisión
  document.querySelectorAll('.comision-opt').forEach(o => {
    o.addEventListener('click', () => {
      document.querySelectorAll('.comision-opt').forEach(x => x.classList.remove('sel'));
      o.classList.add('sel');
      state.comisionPaga = o.dataset.val;
      showSaved();
    });
  });

  // ============ STEP 5: MAPA ============
  function setMapType(t) {
    state.mapaTipo = t;
    document.querySelectorAll('.map-type-card').forEach(c => {
      c.classList.toggle('sel', c.dataset.maptype === t);
    });
    document.getElementById('mapPanePreset').style.display = t === 'preset' ? 'block' : 'none';
    document.getElementById('mapPaneUpload').style.display = t === 'upload' ? 'block' : 'none';
    document.getElementById('mapPaneDraw').style.display = t === 'draw' ? 'block' : 'none';
    showSaved();
  }
  function selectMapPreset(el) {
    state.mapaPreset = el.dataset.preset;
    document.querySelectorAll('.preset-map-card').forEach(c => c.classList.remove('sel'));
    el.classList.add('sel');
    showSaved();
  }

  // ============ STEP 6: SUMMARY ============
  function getSportName() {
    const s = SPORTS.find(x => x.id === state.deporte);
    return s ? s.name + (state.subtipo ? ' · ' + state.subtipo : '') : 'Sin seleccionar';
  }
  function formatPrecio(n) {
    return '$' + n.toLocaleString('es-CL');
  }
  function formatFecha(f) {
    if (!f) return 'Sin fecha';
    const [y, m, d] = f.split('-');
    const meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
    return `${d} ${meses[parseInt(m)-1]} ${y}`;
  }

  function renderSummary() {
    const el = document.getElementById('summary');
    if (!el) return;
    try {
      const tickets = Array.isArray(state.tickets) ? state.tickets : [];
      const distancias = Array.isArray(state.distancias) ? state.distancias : [];
      const categorias = Array.isArray(state.categorias) ? state.categorias : [];
      const cronograma = Array.isArray(state.cronograma) ? state.cronograma : [];
      const totalIngreso = tickets.reduce((acc, t) => acc + ((t.precio||0) * (t.stock||0)), 0);
      const lugarCorto = (state.lugar || '').split(',')[0] || '—';
      const generos = (Array.isArray(state.generos) && state.generos.length) ? state.generos : ['mixto'];
      const catFinal = (typeof buildCategoriasFinal === 'function') ? buildCategoriasFinal() : categorias;

      el.innerHTML = `
      <div class="summary-card">
        <h3>${state.nombre || 'Tu evento'}</h3>
        <div class="summary-sub">${getSportName()} · ${state.fecha ? formatFecha(state.fecha) : 'sin fecha'} · ${state.hora || '—'} hrs</div>
        <div class="summary-meta-row">
          <div>
            <strong>${lugarCorto}</strong>
            <span>Ubicación</span>
          </div>
          <div>
            <strong>${distancias.length} distancia${distancias.length !== 1 ? 's' : ''}</strong>
            <span>${distancias.map(d => d.km + 'K').join(' · ')}</span>
          </div>
          <div>
            <strong>${tickets.length} ticket${tickets.length !== 1 ? 's' : ''}</strong>
            <span>Comisión paga: ${state.comisionPaga === 'corredor' ? 'corredor' : 'organizador'}</span>
          </div>
        </div>
      </div>

      <div class="summary-block">
        <h4>Distancias <button onclick="go(3)">Editar</button></h4>
        ${distancias.map(d => `
          <div class="summary-list-item">
            <span class="si-name">${d.nombre}</span>
            <span class="si-meta">${d.km} km · largada ${d.hora || '—'}</span>
          </div>
        `).join('')}
      </div>

      <div class="summary-block">
        <h4>Categorías (${catFinal.length}) <button onclick="go(3)">Editar</button></h4>
        <div class="summary-list-item">
          <span class="si-meta">${categorias.length} edades × ${generos.length} género${generos.length>1?'s':''} (${generos.map(g=>g==='M'?'Masculino':g==='F'?'Femenino':'Mixto').join(' + ')})</span>
        </div>
        ${catFinal.slice(0, 10).map(c => `
          <div class="summary-list-item">
            <span class="si-name">${c.nombre}</span>
            <span class="si-meta">${c.edadMin}–${c.edadMax} años</span>
          </div>
        `).join('')}
        ${catFinal.length > 10 ? `<div class="summary-list-item"><span class="si-meta">…y ${catFinal.length-10} más</span></div>` : ''}
      </div>

      <div class="summary-block">
        <h4>Entradas y precios <button onclick="go(4)">Editar</button></h4>
        ${tickets.map(t => `
          <div class="summary-list-item">
            <span class="si-name">${t.nombre}</span>
            <span class="si-meta">${formatPrecio(t.precio)} · ${t.stock} cupos</span>
          </div>
        `).join('')}
      </div>

      <div class="summary-block">
        <h4>Cronograma <button onclick="go(5)">Editar</button></h4>
        ${(state.cronogramaTexto||'').trim()
          ? `<div class="summary-list-item"><span class="si-meta" style="white-space:pre-wrap;">${(state.cronogramaTexto||'').replace(/[<>&]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;'}[c]))}</span></div>`
          : '<div class="summary-list-item"><span class="si-meta" style="color:var(--red-600);">⚠ Falta escribir el cronograma</span></div>'}
      </div>

      <div class="summary-block">
        <h4>Recorrido <button onclick="go(5)">Editar</button></h4>
        <div class="summary-list-item">
          <span class="si-name">Archivos GPX/KML</span>
          <span class="si-meta">${(state.gpxList||[]).length} archivo${(state.gpxList||[]).length!==1?'s':''}</span>
        </div>
        <div class="summary-list-item">
          <span class="si-name">Fotos de altimetría</span>
          <span class="si-meta">${(state.altimetrias||[]).length} foto${(state.altimetrias||[]).length!==1?'s':''}</span>
        </div>
      </div>

      <div class="summary-block">
        <h4>Reglamento <button onclick="go(2)">Editar</button></h4>
        <div class="summary-list-item">
          <span class="si-name">${state.reglamento && state.reglamento.nombre ? state.reglamento.nombre : 'Sin reglamento'}</span>
          <span class="si-meta">${state.reglamento ? '✓ Cargado' : 'Opcional'}</span>
        </div>
      </div>

      <div class="summary-block">
        <h4>Mapa &amp; funciones <button onclick="go(5)">Editar</button></h4>
        <div class="summary-list-item">
          <span class="si-name">Polera oficial</span>
          <span class="si-meta">${state.incluyePolera !== false ? '✓ Incluida' : 'No incluida'}</span>
        </div>
        <div class="summary-list-item">
          <span class="si-name">Ficha médica</span>
          <span class="si-meta">${state.features && state.features.ficha ? '✓ Activada' : 'Desactivada'}</span>
        </div>
        <div class="summary-list-item">
          <span class="si-name">Diplomas automáticos</span>
          <span class="si-meta">${state.features && state.features.diplomas ? '✓ Activada' : 'Desactivada'}</span>
        </div>
      </div>
    `;
    } catch(err) {
      console.warn('renderSummary error:', err);
      // Fallback: mostrar al menos lo esencial para no dejar la pantalla en blanco
      el.innerHTML = `
        <div class="summary-card">
          <h3>${state.nombre || 'Tu evento'}</h3>
          <div class="summary-sub">Revisa los datos y publica cuando estés listo.</div>
        </div>
        <div class="summary-block">
          <p class="small muted">Resumen no disponible, pero puedes publicar igualmente.</p>
        </div>`;
    }
  }

  function saveDraft() {
    const draft = collectEventData('borrador');
    saveEventToStorage(draft);
    // Limpiar cache de uploads para que el próximo evento empiece limpio
    try { window.__uploadCache = {}; } catch(_) {}
    if (window.toast) toast('💾 Borrador guardado. Lo encuentras en Mis eventos.', 'success');
    else alert('💾 Borrador guardado.');
    setTimeout(() => {
      if (window.MatchSPA) MatchSPA.navigate('/organizador/mis-eventos');
      else location.hash = '#/organizador/mis-eventos';
    }, 800);
  }

  function publish() {
    // Validar mínimos antes de publicar
    if (!state.nombre || state.nombre.trim().length < 3) {
      if (window.toast) toast('Falta el nombre del evento', 'error');
      go(1);
      return;
    }
    if (!state.fecha) {
      if (window.toast) toast('Falta la fecha del evento', 'error');
      go(2);
      return;
    }
    // Cronograma OBLIGATORIO: el texto no puede estar vacío
    const cronoValido = (state.cronogramaTexto || '').trim().length > 0;
    if (!cronoValido) {
      if (window.toast) toast('Debes escribir el cronograma del evento', 'error');
      go(5);
      setTimeout(() => {
        try { renderCrono(); } catch(_) {}
        const err = document.getElementById('crono-error');
        if (err) { err.style.display = 'block'; err.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
        const ta = document.getElementById('f-cronograma');
        if (ta) ta.focus();
      }, 200);
      return;
    }

    if (confirm('¿Publicar el evento ahora?\n\nSerá visible para todos los deportistas en match-sport.com')) {
      const event = collectEventData('publicado');
      saveEventToStorage(event);
      // Limpiar cache de uploads para que el próximo evento empiece limpio
      try { window.__uploadCache = {}; } catch(_) {}
      if (window.toast) toast('🎉 ¡Evento publicado! Ya aparece en la página de inicio', 'success');
      // Ir al inicio para que el organizador VEA su evento publicado en destacados
      setTimeout(() => {
        if (window.MatchSPA) MatchSPA.navigate('/');
        else location.hash = '#/';
      }, 1200);
    }
  }

  // Helper: construir objeto evento desde el state actual
  // El formato debe coincidir con el que espera "Mis eventos" (ms_org_events)
  function collectEventData(status) {
    // Construir label de fecha humano (ej: "16 mayo · Purranque, Los Lagos")
    function formatFechaLabel(iso, lugar) {
      if (!iso) return lugar || 'Sin fecha definida';
      try {
        const d = new Date(iso + 'T00:00:00');
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        const txt = `${d.getDate()} ${meses[d.getMonth()]} ${d.getFullYear()}`;
        return lugar ? `${txt} · ${lugar.split(',')[0]}` : txt;
      } catch(_) { return iso + (lugar ? ' · ' + lugar : ''); }
    }

    // Detectar ícono según deporte
    const sportIcons = {
      running: 'ti-run', trail: 'ti-mountain', mtb: 'ti-bike',
      ciclismo: 'ti-bike', natacion: 'ti-swimming', triatlon: 'ti-triangle',
      futbol: 'ti-ball-football', basquet: 'ti-ball-basketball', tenis: 'ti-ball-tennis'
    };
    const icon = sportIcons[state.deporte] || 'ti-run';

    // Mapear status
    const estadoMap = {
      borrador: { estado: 'borrador', estadoLabel: 'Borrador', estadoColor: 'gray', isDraft: true },
      publicado: { estado: 'activo', estadoLabel: 'Activo', estadoColor: 'green', isDraft: false }
    };
    const estadoInfo = estadoMap[status] || estadoMap.publicado;

    // Calcular cupo total desde tickets
    let totalCupos = 0;
    (state.tickets || []).forEach(t => {
      totalCupos += parseInt(t.cupo || t.stock || 0) || 0;
    });

    return {
      id: 'evt-' + Date.now() + '-' + Math.random().toString(36).slice(2, 6),
      icon: icon,
      color: 'purple',
      nombre: state.nombre || 'Evento sin nombre',
      fecha: formatFechaLabel(state.fecha, state.lugar),
      ...estadoInfo,
      vendidos: 0,
      total: totalCupos || 100,
      stats: status === 'borrador' ? [] : [
        { v: '$0', l: 'Recaudado', class: 'purple' },
        { v: '0', l: 'Fichas listas' },
        { v: '0', l: 'Pendientes' }
      ],
      // Datos completos por si los necesitamos al editar
      _meta: {
        deporte: state.deporte || null,
        subtipo: state.subtipo || null,
        fechaISO: state.fecha || null,
        hora: state.hora || null,
        lugar: state.lugar || null,
        desc: state.desc || null,
        distancias: Array.isArray(state.distancias) ? state.distancias : [],
        // Categorías base (edad) + géneros seleccionados + categorías finales generadas
        categoriasBase: Array.isArray(state.categorias) ? state.categorias.slice() : [],
        generos: Array.isArray(state.generos) ? state.generos.slice() : ['mixto'],
        categorias: (typeof buildCategoriasFinal === 'function') ? buildCategoriasFinal() : (state.categorias || []),
        tickets: state.tickets || [],
        // Imagen de portada (data URL si el usuario subió una)
        imagen: (function(){
          try {
            const cache = (window.__getUploadCache && window.__getUploadCache()) || {};
            return cache.cover || null;
          } catch(_) { return null; }
        })(),
        // Archivo de recorrido (solo metadata para el prototipo)
        recorrido: (function(){
          try {
            const cache = (window.__getUploadCache && window.__getUploadCache()) || {};
            return cache.recorrido || null;
          } catch(_) { return null; }
        })(),
        // Galería de fotos adicionales (data URLs)
        galeria: (function(){
          try {
            const cache = (window.__getUploadCache && window.__getUploadCache()) || {};
            return Array.isArray(cache.gallery) ? cache.gallery.slice() : [];
          } catch(_) { return []; }
        })(),
        // Enlace de video de YouTube
        youtube: state.youtube || null,
        videoArchivo: state.videoArchivo || null,
        // ¿Incluye polera oficial? (define si se pide talla en el checkout)
        incluyePolera: state.incluyePolera !== false,
        // Formato del evento
        precioTipo: state.precioTipo || 'pago',
        modalidad: state.modalidad || 'presencial',
        // Reglamento del evento (PDF/Word como data URL)
        reglamento: state.reglamento || null,
        // Cronograma del evento (obligatorio)
        cronograma: Array.isArray(state.cronograma) ? state.cronograma.slice() : [],
        cronogramaTexto: state.cronogramaTexto || '',
        gpxList: Array.isArray(state.gpxList) ? state.gpxList.slice() : [],
        altimetrias: Array.isArray(state.altimetrias) ? state.altimetrias.slice() : [],
        createdAt: Date.now(),
        createdBy: (function(){
          try {
            const s = JSON.parse(localStorage.getItem('orgSession') || 'null');
            return s ? s.email : 'demo@match-sport.com';
          } catch(_) { return 'demo@match-sport.com'; }
        })()
      }
    };
  }

  // Helper: persistir evento en localStorage en la clave que usa "Mis eventos"
  function saveEventToStorage(event) {
    try {
      const KEY = 'ms_org_events';
      const list = JSON.parse(localStorage.getItem(KEY) || '[]');

      // Si estamos editando un evento existente, actualizarlo en su lugar
      if (state._editingId) {
        const idx = list.findIndex(e => e.id === state._editingId);
        if (idx !== -1) {
          // Conservar el id original y mezclar los nuevos datos
          event.id = state._editingId;
          list[idx] = event;
          localStorage.setItem(KEY, JSON.stringify(list));
          try { if (window.MSApi) MSApi.pushEvent(event); } catch(_) {}
          state._editingId = null;
          return;
        }
      }

      // Evento nuevo: agregar al principio
      list.unshift(event);
      localStorage.setItem(KEY, JSON.stringify(list));
      try { if (window.MSApi) MSApi.pushEvent(event); } catch(_) {}
    } catch(e) {
      console.warn('No se pudo guardar el evento:', e);
    }
  }

  // ============ EXPONER FUNCIONES A WINDOW ============
  // Los botones del wizard usan onclick="funcName(...)" que requiere funciones globales.
  // Como este código está envuelto en un IIFE por el SPA, hay que exponerlas explícitamente.
  const wizardExports = {
    go, publish, saveDraft, renderSummary, collectEventData,
    selectSport: typeof selectSport !== 'undefined' ? selectSport : undefined,
    selectSubtipo: typeof selectSubtipo !== 'undefined' ? selectSubtipo : undefined,
    addDist: typeof addDist !== 'undefined' ? addDist : undefined,
    updateDist: typeof updateDist !== 'undefined' ? updateDist : undefined,
    removeDist: typeof removeDist !== 'undefined' ? removeDist : undefined,
    applyDistPreset: typeof applyDistPreset !== 'undefined' ? applyDistPreset : undefined,
    addCat: typeof addCat !== 'undefined' ? addCat : undefined,
    updateCat: typeof updateCat !== 'undefined' ? updateCat : undefined,
    removeCat: typeof removeCat !== 'undefined' ? removeCat : undefined,
    setPolera: typeof setPolera !== 'undefined' ? setPolera : undefined,
    setFormato: typeof setFormato !== 'undefined' ? setFormato : undefined,
    onReglamentoUpload: typeof onReglamentoUpload !== 'undefined' ? onReglamentoUpload : undefined,
    removeReglamento: typeof removeReglamento !== 'undefined' ? removeReglamento : undefined,
    onVideoUpload: typeof onVideoUpload !== 'undefined' ? onVideoUpload : undefined,
    removeVideo: typeof removeVideo !== 'undefined' ? removeVideo : undefined,
    addCrono: typeof addCrono !== 'undefined' ? addCrono : undefined,
    updateCrono: typeof updateCrono !== 'undefined' ? updateCrono : undefined,
    updateCronogramaTexto: typeof updateCronogramaTexto !== 'undefined' ? updateCronogramaTexto : undefined,
    addGpx: typeof addGpx !== 'undefined' ? addGpx : undefined,
    updateGpxTitulo: typeof updateGpxTitulo !== 'undefined' ? updateGpxTitulo : undefined,
    removeGpx: typeof removeGpx !== 'undefined' ? removeGpx : undefined,
    addAltimetria: typeof addAltimetria !== 'undefined' ? addAltimetria : undefined,
    updateAltimetriaTitulo: typeof updateAltimetriaTitulo !== 'undefined' ? updateAltimetriaTitulo : undefined,
    removeAltimetria: typeof removeAltimetria !== 'undefined' ? removeAltimetria : undefined,
    removeCrono: typeof removeCrono !== 'undefined' ? removeCrono : undefined,
    applyCatPreset: typeof applyCatPreset !== 'undefined' ? applyCatPreset : undefined,
    toggleGenero: typeof toggleGenero !== 'undefined' ? toggleGenero : undefined,
    addTicket: typeof addTicket !== 'undefined' ? addTicket : undefined,
    updateTicket: typeof updateTicket !== 'undefined' ? updateTicket : undefined,
    removeTicket: typeof removeTicket !== 'undefined' ? removeTicket : undefined,
    toggleTicketDist: typeof toggleTicketDist !== 'undefined' ? toggleTicketDist : undefined,
    selectMapPreset: typeof selectMapPreset !== 'undefined' ? selectMapPreset : undefined,
    setMapType: typeof setMapType !== 'undefined' ? setMapType : undefined,
    setFilter: typeof setFilter !== 'undefined' ? setFilter : undefined,
    askDelete: typeof askDelete !== 'undefined' ? askDelete : undefined,
  };
  Object.keys(wizardExports).forEach(k => {
    if (wizardExports[k]) window[k] = wizardExports[k];
  });

  // ============ INIT ============
  // Si venimos de "Editar evento", precargar los datos guardados
  (function loadEditingEvent(){
    try {
      const raw = localStorage.getItem('ms_editing_event');
      if (!raw) return;
      const ev = JSON.parse(raw);
      const meta = ev._meta || {};

      // Precargar campos del state desde el evento guardado
      if (ev.nombre) state.nombre = ev.nombre;
      if (meta.deporte) state.deporte = meta.deporte;
      if (meta.subtipo) state.subtipo = meta.subtipo;
      if (meta.fechaISO) state.fecha = meta.fechaISO;
      if (meta.hora) state.hora = meta.hora;
      if (meta.lugar) state.lugar = meta.lugar;
      if (meta.desc) state.desc = meta.desc;
      if (Array.isArray(meta.distancias) && meta.distancias.length) state.distancias = meta.distancias;
      if (Array.isArray(meta.categorias) && meta.categorias.length) state.categorias = meta.categorias;
      if (Array.isArray(meta.tickets) && meta.tickets.length) state.tickets = meta.tickets;
      if (Array.isArray(meta.cronograma) && meta.cronograma.length) state.cronograma = meta.cronograma;
      if (Array.isArray(meta.generos) && meta.generos.length) state.generos = meta.generos;
      if (Array.isArray(meta.categoriasBase) && meta.categoriasBase.length) state.categorias = meta.categoriasBase;
      if (typeof meta.incluyePolera !== 'undefined') state.incluyePolera = meta.incluyePolera !== false;
      if (meta.reglamento) state.reglamento = meta.reglamento;
      if (meta.videoArchivo) state.videoArchivo = meta.videoArchivo;
      if (meta.precioTipo) state.precioTipo = meta.precioTipo;
      if (meta.modalidad) state.modalidad = meta.modalidad;
      if (meta.cronogramaTexto) state.cronogramaTexto = meta.cronogramaTexto;
      if (Array.isArray(meta.gpxList)) state.gpxList = meta.gpxList;
      if (Array.isArray(meta.altimetrias)) state.altimetrias = meta.altimetrias;

      // Guardar el id que estamos editando para actualizar (no duplicar) al publicar
      state._editingId = ev.id;

      // Precargar imagen y recorrido en cache de uploads (para que se conserven al republicar)
      window.__uploadCache = window.__uploadCache || {};
      if (meta.imagen) window.__uploadCache.cover = meta.imagen;
      if (meta.recorrido) window.__uploadCache.recorrido = meta.recorrido;
      if (Array.isArray(meta.galeria)) window.__uploadCache.gallery = meta.galeria.slice();
      if (meta.youtube) state.youtube = meta.youtube;

      // Limpiar la marca de edición (ya la consumimos)
      localStorage.removeItem('ms_editing_event');

      // Actualizar inputs del formulario si existen
      setTimeout(() => {
        const setVal = (id, val) => { const el = document.getElementById(id); if (el && val != null) el.value = val; };
        setVal('evNombre', state.nombre);
        setVal('evFecha', state.fecha);
        setVal('evHora', state.hora);
        setVal('evLugar', state.lugar);
        setVal('evDesc', state.desc);

        // Si el evento tiene imagen guardada, mostrarla en la zona de upload
        if (meta.imagen) {
          const zone = document.getElementById('evCoverUploadZone');
          if (zone) {
            const empty = zone.querySelector('.upload-empty');
            const prev = zone.querySelector('.upload-preview');
            const img = zone.querySelector('.upload-preview-img');
            if (empty) empty.style.display = 'none';
            if (prev) prev.style.display = 'flex';
            if (img) img.src = meta.imagen;
            zone.classList.add('has-file');
          }
        }
      }, 100);
    } catch(e) { console.warn('No se pudo precargar el evento en edición:', e); }
  })();

  renderStepper();
  renderSports();
  bindFormFields();
  renderDist();
  renderCat();
  renderTickets();

  // Cada vez que se navega al wizard (sin recargar la página), revisar si
  // hay un evento para editar y precargarlo. Necesario porque el IIFE solo
  // corre una vez al cargar el documento.
  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-crear-evento', function() {
      try {
        const raw = localStorage.getItem('ms_editing_event');
        if (!raw) return;
        const ev = JSON.parse(raw);
        const meta = ev._meta || {};
        if (ev.nombre) state.nombre = ev.nombre;
        if (meta.deporte) state.deporte = meta.deporte;
        if (meta.subtipo) state.subtipo = meta.subtipo;
        if (meta.fechaISO) state.fecha = meta.fechaISO;
        if (meta.hora) state.hora = meta.hora;
        if (meta.lugar) state.lugar = meta.lugar;
        if (meta.desc) state.desc = meta.desc;
        if (Array.isArray(meta.distancias) && meta.distancias.length) state.distancias = meta.distancias;
        if (Array.isArray(meta.categorias) && meta.categorias.length) state.categorias = meta.categorias;
        if (Array.isArray(meta.tickets) && meta.tickets.length) state.tickets = meta.tickets;
        if (Array.isArray(meta.cronograma) && meta.cronograma.length) state.cronograma = meta.cronograma;
        if (Array.isArray(meta.generos) && meta.generos.length) state.generos = meta.generos;
        if (Array.isArray(meta.categoriasBase) && meta.categoriasBase.length) state.categorias = meta.categoriasBase;
        if (typeof meta.incluyePolera !== 'undefined') state.incluyePolera = meta.incluyePolera !== false;
        if (meta.reglamento) state.reglamento = meta.reglamento;
        if (meta.videoArchivo) state.videoArchivo = meta.videoArchivo;
        if (meta.precioTipo) state.precioTipo = meta.precioTipo;
        if (meta.modalidad) state.modalidad = meta.modalidad;
        if (meta.cronogramaTexto) state.cronogramaTexto = meta.cronogramaTexto;
        if (Array.isArray(meta.gpxList)) state.gpxList = meta.gpxList;
        if (Array.isArray(meta.altimetrias)) state.altimetrias = meta.altimetrias;
        state._editingId = ev.id;
        state.step = 1;

        // Restaurar imagen y recorrido en el cache de uploads
        window.__uploadCache = window.__uploadCache || {};
        if (meta.imagen) window.__uploadCache.cover = meta.imagen;
        if (meta.recorrido) window.__uploadCache.recorrido = meta.recorrido;
        if (Array.isArray(meta.galeria)) window.__uploadCache.gallery = meta.galeria.slice();
        if (meta.youtube) state.youtube = meta.youtube;

        localStorage.removeItem('ms_editing_event');

        // Re-renderizar todo el wizard con los datos cargados
        renderStepper();
        renderSports();
        bindFormFields();
        renderDist();
        renderCat();
        renderTickets();
        go(1);

        // Actualizar inputs visibles y mostrar preview de imagen si existe
        setTimeout(() => {
          const setVal = (id, val) => { const el = document.getElementById(id); if (el && val != null) el.value = val; };
          setVal('evNombre', state.nombre);
          setVal('evFecha', state.fecha);
          setVal('evHora', state.hora);
          setVal('evLugar', state.lugar);
          setVal('evDesc', state.desc);

          // Si el evento tenía imagen, mostrarla en la zona de upload
          if (meta.imagen) {
            const zone = document.getElementById('evCoverUploadZone');
            if (zone) {
              const empty = zone.querySelector('.upload-empty');
              const prev = zone.querySelector('.upload-preview');
              const img = zone.querySelector('.upload-preview-img');
              if (empty) empty.style.display = 'none';
              if (prev) prev.style.display = 'flex';
              if (img) img.src = meta.imagen;
              zone.classList.add('has-file');
            }
          }
        }, 80);
      } catch(e) { console.warn('Error precargando edición:', e); }
    });
  }
} catch(_e) { console.warn('[organizador/crear-evento.html]', _e.message); } })();
</script>

<!-- ===== JS de admin/login.html ===== -->
<script>
(function(){ try {
const ADMIN_PASS = 'match2027';
  function ingresar() {
    const pass = document.getElementById('pass').value;
    const err = document.getElementById('err');
    if (pass !== ADMIN_PASS) {
      err.classList.add('show');
      setTimeout(() => err.classList.remove('show'), 3000);
      return;
    }
    try { localStorage.setItem('ms_role', 'admin'); } catch(e) {}
    // Obtener token real de administrador desde la API.
    try { if (window.MSApi) MSApi.adminLogin(pass); } catch(_) {}
    location.href = '#/admin';
  }
} catch(_e) { console.warn('[admin/login.html]', _e.message); } })();
</script>

<!-- ===== JS de admin/dashboard.html ===== -->
<script>
(function(){ try {
const meses = ['jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic', 'ene', 'feb', 'mar', 'abr', 'may'];
const comisiones = [120, 165, 195, 235, 285, 330, 380, 450, 540, 680, 820, 1200];
const colores = ['#17BDB5', '#17BDB5', '#17BDB5', '#17BDB5', '#0DA69E', '#0DA69E', '#0DA69E', '#0B8B84', '#0B8B84', '#0B8B84', '#0B8B84', '#F59E0B'];

new Chart(document.getElementById('comisionChart'), {
  type: 'bar',
  data: {
    labels: meses,
    datasets: [{
      data: comisiones,
      backgroundColor: colores,
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: { callbacks: { label: ctx => '$' + ctx.parsed.y + 'K' } }
    },
    scales: {
      y: { beginAtZero: true, ticks: { callback: v => '$' + v + 'K', font: { size: 10 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
      x: { grid: { display: false }, ticks: { font: { size: 10 } } }
    }
  }
});

new Chart(document.getElementById('categoryChart'), {
  type: 'doughnut',
  data: {
    labels: ['Running', 'Fútbol', 'Básquet', 'Ciclismo', 'Otros'],
    datasets: [{
      data: [38, 28, 14, 12, 8],
      backgroundColor: ['#0B8B84', '#F59E0B', '#17BDB5', '#3B82F6', '#94A3B8'],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'right', labels: { font: { size: 11 }, boxWidth: 10, padding: 8 } }
    }
  }
});
} catch(_e) { console.warn('[admin/dashboard.html]', _e.message); } })();
</script>

<!-- ===== JS de admin/eventos.html ===== -->
<script>
(function(){ try {
const DEFAULT_EVENTS = [
    { id: 'rally-purranque', icon: 'ti-run', color: 'purple', nombre: 'Rally Costero Purranque 2027', tipo: 'Running · Trail',
      org: 'Club Cumbres', fecha: '16 may 2027', vendidos: '247 / 400', gmv: '$3.7M', comision: '$185K',
      estado: 'activo', estadoLabel: 'Activo', badge: 'green' },
    { id: 'liga-osorno', icon: 'ti-ball-football', color: 'amber', nombre: 'Liga Barrial Osorno 2027', tipo: 'Fútbol · Por equipos',
      org: 'Liga Osorno', fecha: '24 may 2027', vendidos: '8 / 18 equipos', gmv: '$2.1M', comision: '$105K',
      estado: 'activo', estadoLabel: 'Activo', badge: 'green' },
    { id: 'festival-jazz', icon: 'ti-music', color: 'purple', nombre: 'Festival Jazz Bicentenario', tipo: 'Música',
      org: 'Productora Aurora', fecha: '24 may 2027', vendidos: '1.240 / 2.000', gmv: '$31M', comision: '$1.55M',
      estado: 'activo', estadoLabel: 'Activo', badge: 'green' },
    { id: 'trail-llanquihue', icon: 'ti-mountain', color: 'purple', nombre: 'Trail Lago Llanquihue', tipo: 'Running · Trail',
      org: 'Club Cumbres', fecha: '22 jun 2027', vendidos: '89 / 300', gmv: '$1.3M', comision: '$65K',
      estado: 'activo', estadoLabel: 'Activo', badge: 'green' },
    { id: 'fiesta-xl', icon: 'ti-confetti', color: 'amber', nombre: 'Fiesta XL Open Air', tipo: '⚠ Reportado por usuario', tipoColor: 'amber',
      org: 'Eventos XL', fecha: '15 jun 2027', vendidos: '120 / 500', gmv: '$2.4M', comision: '$120K',
      estado: 'revision', estadoLabel: 'Revisión', badge: 'amber', highlight: true },
    { id: 'maraton-osorno', icon: 'ti-run', color: 'purple', nombre: 'Maratón Osorno 2026', tipo: 'Running',
      org: 'Club Cumbres', fecha: '12 oct 2026', vendidos: '456 / 500', gmv: '$6.8M', comision: '$340K',
      estado: 'finalizado', estadoLabel: 'Finalizado', badge: 'blue' }
  ];

  const KEY = 'ms_admin_events';
  let events = [];
  let toDelete = null;

  function load() {
    try {
      const raw = localStorage.getItem(KEY);
      events = raw ? JSON.parse(raw) : JSON.parse(JSON.stringify(DEFAULT_EVENTS));
    } catch(e) { events = JSON.parse(JSON.stringify(DEFAULT_EVENTS)); }
  }
  function save() { try { localStorage.setItem(KEY, JSON.stringify(events)); } catch(e) {} }

  function render() {
    const tbody = document.getElementById('eventTbody');
    if (events.length === 0) {
      tbody.innerHTML = `
        <tr class="empty-row"><td colspan="8">
          <i class="ti ti-calendar-off"></i>
          <h3>No quedan eventos</h3>
          <p>Has eliminado todos los eventos de la plataforma.</p>
        </td></tr>`;
      return;
    }
    tbody.innerHTML = events.map(e => `
      <tr ${e.highlight ? 'style="background: var(--amber-50);"' : ''}>
        <td>
          <span class="cat-icon-mini" style="background: var(--${e.color}-${e.color === 'amber' ? '50' : '100'}); color: var(--${e.color}-700);"><i class="ti ${e.icon}" style="font-size: 18px;"></i></span>
          <div style="display: inline-block; vertical-align: middle;">
            <div style="font-weight: 600;">${e.nombre}</div>
            <div class="small ${e.tipoColor ? '' : 'muted'}" ${e.tipoColor ? 'style="color: var(--amber-700);"' : ''}>${e.tipo}</div>
          </div>
        </td>
        <td>${e.org}</td>
        <td>${e.fecha}</td>
        <td>${e.vendidos}</td>
        <td><strong>${e.gmv}</strong></td>
        <td style="color: var(--purple-700); font-weight: 700;">${e.comision}</td>
        <td><span class="badge badge-${e.badge}">${e.estadoLabel}</span></td>
        <td>
          <div class="row-actions">
            <button class="row-action" title="Ver detalle"><i class="ti ti-eye"></i></button>
            <button class="row-action delete" onclick="askDeleteAdmin('${e.id}')" title="Eliminar"><i class="ti ti-trash"></i></button>
          </div>
        </td>
      </tr>
    `).join('');
  }

  function askDeleteAdmin(id) {
    toDelete = id;
    const ev = events.find(x => x.id === id);
    const nameEl = document.getElementById('confNameAdmin');
    if (nameEl) nameEl.textContent = ev ? ev.nombre : '';
    const modal = document.getElementById('confirmModalAdmin');
    if (modal) modal.classList.add('open');
  }
  function cancelDeleteAdmin() {
    toDelete = null;
    const modal = document.getElementById('confirmModalAdmin');
    if (modal) modal.classList.remove('open');
  }
  function confirmDeleteAdmin() {
    if (!toDelete) return;
    const ev = events.find(x => x.id === toDelete);
    events = events.filter(x => x.id !== toDelete);
    save();
    cancelDeleteAdmin();
    render();
    showToast(`"${ev?.nombre || 'Evento'}" eliminado`);
  }
  function showToast(msg) {
    const t = document.getElementById('toastNotice');
    if (!t) { if (window.toast) toast(msg); return; }
    const m = document.getElementById('toastMsg');
    if (m) m.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2400);
  }

  const adminModal = document.getElementById('confirmModalAdmin');
  if (adminModal) {
    adminModal.addEventListener('click', e => {
      if (e.target.id === 'confirmModalAdmin') cancelDeleteAdmin();
    });
  }

  // Exponer funciones del admin con nombres únicos (no chocan con las del organizador)
  window.askDeleteAdmin = askDeleteAdmin;
  window.cancelDeleteAdmin = cancelDeleteAdmin;
  window.confirmDeleteAdmin = confirmDeleteAdmin;

  load();
  render();

  // Recargar al navegar a esta página
  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-admin-eventos', function(){ load(); render(); });
  }
} catch(_e) { console.warn('[admin/eventos.html]', _e.message); } })();
</script>

<!-- ===== JS de admin/finanzas.html ===== -->
<script>
(function(){ try {
const meses = ['Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May'];
const comisiones = [120, 165, 195, 235, 285, 330, 380, 450, 540, 680, 820, 920];

new Chart(document.getElementById('comisionChart'), {
  type: 'bar',
  data: {
    labels: meses,
    datasets: [{
      label: 'Comisión',
      data: comisiones,
      backgroundColor: '#0B8B84',
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => '$' + ctx.parsed.y + 'K' } } },
    scales: {
      y: { beginAtZero: true, ticks: { callback: v => '$' + v + 'K', font: { size: 10 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
      x: { grid: { display: false }, ticks: { font: { size: 11 } } }
    }
  }
});

new Chart(document.getElementById('metodoChart'), {
  type: 'doughnut',
  data: {
    labels: ['Crédito', 'Débito', 'Transferencia', 'MP Wallet'],
    datasets: [{
      data: [54, 22, 14, 10],
      backgroundColor: ['#0B8B84', '#17BDB5', '#F59E0B', '#3B82F6'],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } }
  }
});
} catch(_e) { console.warn('[admin/finanzas.html]', _e.message); } })();
</script>

<script>
// ============================================================
// LOGIN HOOKS — wire up forms inside login pages to call session setters
// ============================================================
(function(){
  // Helper to find a page section by data-route — busca específicamente <section.spa-page>
  function $page(route) { return document.querySelector(`section.spa-page[data-route="${route}"]`); }

  function bindOrgLogin() {
    const page = $page('/login');
    if (!page) return;
    if (page.dataset.loginBound) return;
    page.dataset.loginBound = '1';

    // === Botones sociales (Google, Facebook, Instagram, Apple) ===
    // Cada botón abre un modal que simula la pantalla de OAuth real
    const allButtons = page.querySelectorAll('button, a:not([data-route])');
    allButtons.forEach(b => {
      const txt = (b.textContent || '').toLowerCase().trim();
      const isGoogle    = /continuar con google|con google/i.test(txt);
      const isFacebook  = /continuar con facebook|con facebook/i.test(txt);
      const isInstagram = /continuar con instagram|con instagram/i.test(txt);
      const isApple     = /continuar con apple|con apple/i.test(txt);
      if (!(isGoogle || isFacebook || isInstagram || isApple)) return;

      b.addEventListener('click', function(e) {
        e.preventDefault();
        let provider = 'google';
        if (isFacebook) provider = 'facebook';
        else if (isInstagram) provider = 'instagram';
        else if (isApple) provider = 'apple';
        openOAuthModal(provider);
      });
    });

    // ============ DETECTAR TIPO DE CUENTA (persona vs club) ============
    // Heurística: si el nombre contiene palabras típicas de organización, sugerir "club"
    function detectAccountType(name) {
      if (!name) return 'persona';
      const orgKeywords = /\b(club|liga|asociaci[óo]n|federaci[óo]n|escuela|gimnasio|gym|maratón|maraton|centro deportivo|complejo|academia|equipo|team|organizaci[óo]n|fundaci[óo]n|corporaci[óo]n|empresa|sociedad)\b/i;
      return orgKeywords.test(name) ? 'club' : 'persona';
    }

    // === Modal OAuth (simulación realista) ===
    function openOAuthModal(provider) {
      // Si ya hay un modal abierto, no abrir otro
      if (document.getElementById('oauth-modal')) return;

      const config = {
        google: {
          label: 'Google',
          logo: '<svg width="24" height="24" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>',
          bg: '#fff',
          textColor: '#3c4043',
          accent: '#4285F4',
          title: 'Iniciar sesión',
          subtitle: 'para continuar a Match Sport',
          domainSuggestion: 'gmail.com'
        },
        facebook: {
          label: 'Facebook',
          logo: '<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>',
          bg: '#1877F2',
          textColor: '#fff',
          accent: '#fff',
          title: 'Match Sport',
          subtitle: 'quiere acceder a tu información pública',
          domainSuggestion: ''
        },
        instagram: {
          label: 'Instagram',
          logo: '<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
          bg: 'linear-gradient(45deg, #F58529, #DD2A7B, #8134AF, #515BD4)',
          textColor: '#fff',
          accent: '#fff',
          title: 'Match Sport',
          subtitle: 'quiere usar tu cuenta de Instagram',
          domainSuggestion: '',
          note: 'Instagram usa el inicio de sesión de Facebook'
        },
        apple: {
          label: 'Apple',
          logo: '<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>',
          bg: '#000',
          textColor: '#fff',
          accent: '#fff',
          title: 'Iniciar sesión con Apple ID',
          subtitle: 'para usar Match Sport',
          domainSuggestion: 'icloud.com',
          note: 'Apple oculta tu correo real con un alias privado'
        }
      };
      const cfg = config[provider];

      const overlay = document.createElement('div');
      overlay.id = 'oauth-modal';
      overlay.style.cssText = `
        position: fixed; inset: 0; background: rgba(0,0,0,0.6);
        z-index: 100000; display: flex; align-items: center; justify-content: center;
        animation: oauthFadeIn 0.2s ease-out;
        padding: 16px;
      `;
      overlay.innerHTML = `
        <style>
          @keyframes oauthFadeIn { from { opacity: 0; } to { opacity: 1; } }
          @keyframes oauthSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        </style>
        <div style="background: ${cfg.bg}; color: ${cfg.textColor}; border-radius: 14px; max-width: 420px; width: 100%; overflow: hidden; box-shadow: 0 24px 60px rgba(0,0,0,0.3); animation: oauthSlideUp 0.25s ease-out; font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;">
          <!-- Header con logo del provider -->
          <div style="padding: 28px 32px 20px; ${provider === 'google' ? 'border-bottom: 1px solid #dadce0;' : ''} display: flex; flex-direction: column; align-items: center; gap: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              ${cfg.logo}
              ${provider === 'google' ? '<span style="font-size: 20px; font-weight: 500; color: #3c4043;">Google</span>' : ''}
            </div>
            <div style="text-align: center;">
              <div style="font-size: 22px; font-weight: ${provider === 'google' ? '400' : '600'}; margin-bottom: 4px;">${cfg.title}</div>
              <div style="font-size: 14px; opacity: 0.85;">${cfg.subtitle}</div>
            </div>
          </div>

          <!-- Form -->
          <div style="padding: 24px 32px 20px;">
            <!-- Toggle Persona / Club -->
            <div style="margin-bottom: 18px;">
              <label style="display: block; font-size: 13px; margin-bottom: 8px; opacity: 0.85;">Cuenta de</label>
              <div id="oauth-type-toggle" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; padding: 4px; background: ${provider === 'google' ? '#f1f3f4' : 'rgba(255,255,255,0.10)'}; border-radius: 10px;">
                <button type="button" data-type="persona" class="oauth-type-btn active" style="
                  padding: 9px 8px; border: 0; border-radius: 7px;
                  background: ${provider === 'google' ? '#fff' : 'rgba(255,255,255,0.18)'};
                  color: inherit; font-weight: 600; font-size: 13px;
                  cursor: pointer; font-family: inherit;
                  display: flex; align-items: center; justify-content: center; gap: 6px;
                  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
                ">
                  <i class="ti ti-user" style="font-size: 15px;"></i> Persona
                </button>
                <button type="button" data-type="club" class="oauth-type-btn" style="
                  padding: 9px 8px; border: 0; border-radius: 7px;
                  background: transparent;
                  color: inherit; font-weight: 500; font-size: 13px; opacity: 0.7;
                  cursor: pointer; font-family: inherit;
                  display: flex; align-items: center; justify-content: center; gap: 6px;
                ">
                  <i class="ti ti-building" style="font-size: 15px;"></i> Club / Organización
                </button>
              </div>
              <div id="oauth-type-hint" style="font-size: 11px; opacity: 0.65; margin-top: 6px; min-height: 14px;"></div>
            </div>

            <label id="oauth-name-label" style="display: block; font-size: 13px; margin-bottom: 6px; opacity: 0.85;">Tu nombre</label>
            <input id="oauth-name" type="text" placeholder="Ej: Cristian Muñoz" value="" autocomplete="name" style="
              width: 100%; padding: 11px 14px; margin-bottom: 16px;
              background: ${provider === 'google' ? '#fff' : 'rgba(255,255,255,0.12)'};
              color: ${provider === 'google' ? '#000' : cfg.textColor};
              border: 1px solid ${provider === 'google' ? '#dadce0' : 'rgba(255,255,255,0.25)'};
              border-radius: 8px; font-size: 15px; box-sizing: border-box;
              font-family: inherit;
            ">

            <label id="oauth-email-label" style="display: block; font-size: 13px; margin-bottom: 6px; opacity: 0.85;">Tu correo</label>
            <input id="oauth-email" type="email" placeholder="${cfg.domainSuggestion ? 'tu@' + cfg.domainSuggestion : 'tu@correo.com'}" value="" autocomplete="email" style="
              width: 100%; padding: 11px 14px; margin-bottom: 8px;
              background: ${provider === 'google' ? '#fff' : 'rgba(255,255,255,0.12)'};
              color: ${provider === 'google' ? '#000' : cfg.textColor};
              border: 1px solid ${provider === 'google' ? '#dadce0' : 'rgba(255,255,255,0.25)'};
              border-radius: 8px; font-size: 15px; box-sizing: border-box;
              font-family: inherit;
            ">
            ${cfg.note ? `<div style="font-size: 12px; opacity: 0.75; margin-bottom: 14px; padding: 8px 10px; background: rgba(255,255,255,0.08); border-radius: 6px;"><i class="ti ti-info-circle" style="font-size: 13px; vertical-align: -2px;"></i> ${cfg.note}</div>` : '<div style="margin-bottom: 14px;"></div>'}

            <div id="oauth-error" style="display: none; color: #DC2626; font-size: 13px; margin-bottom: 10px; padding: 8px 10px; background: rgba(220,38,38,0.1); border-radius: 6px;"></div>

            <button id="oauth-continue" style="
              width: 100%; padding: 12px; margin-bottom: 10px;
              background: ${provider === 'google' ? '#4285F4' : (provider === 'apple' ? '#fff' : 'rgba(255,255,255,0.95)')};
              color: ${provider === 'google' ? '#fff' : (provider === 'apple' ? '#000' : '#1F1F1F')};
              border: 0; border-radius: 8px; font-size: 15px; font-weight: 600;
              cursor: pointer; font-family: inherit;
            ">
              Continuar con ${cfg.label}
            </button>

            <button id="oauth-cancel" style="
              width: 100%; padding: 10px;
              background: transparent;
              color: ${cfg.textColor}; opacity: 0.75;
              border: 0; border-radius: 8px; font-size: 14px;
              cursor: pointer; font-family: inherit;
            ">
              Cancelar
            </button>
          </div>

          <!-- Footer simulación notice -->
          <div style="padding: 12px 32px; background: rgba(0,0,0,${provider === 'google' ? '0.04' : '0.2'}); font-size: 11px; text-align: center; opacity: 0.6;">
            🔒 Demo · En producción esto será ${cfg.label} OAuth real
          </div>
        </div>
      `;

      document.body.appendChild(overlay);
      const nameInput = overlay.querySelector('#oauth-name');
      const emailInput = overlay.querySelector('#oauth-email');
      const continueBtn = overlay.querySelector('#oauth-continue');
      const cancelBtn = overlay.querySelector('#oauth-cancel');
      const errorBox = overlay.querySelector('#oauth-error');
      const typeBtns = overlay.querySelectorAll('.oauth-type-btn');
      const typeHint = overlay.querySelector('#oauth-type-hint');
      const nameLabel = overlay.querySelector('#oauth-name-label');

      // Tipo de cuenta: 'persona' o 'club'
      let accountType = 'persona';
      let userOverrodeType = false; // si usuario tocó el toggle manualmente, no auto-cambiar

      function updateTypeUI() {
        typeBtns.forEach(b => {
          const isActive = b.dataset.type === accountType;
          b.classList.toggle('active', isActive);
          if (isActive) {
            b.style.background = (provider === 'google' ? '#fff' : 'rgba(255,255,255,0.18)');
            b.style.fontWeight = '600';
            b.style.opacity = '1';
            b.style.boxShadow = '0 1px 3px rgba(0,0,0,0.08)';
          } else {
            b.style.background = 'transparent';
            b.style.fontWeight = '500';
            b.style.opacity = '0.7';
            b.style.boxShadow = 'none';
          }
        });
        nameLabel.textContent = accountType === 'club' ? 'Nombre del club / organización' : 'Tu nombre';
        nameInput.placeholder = accountType === 'club' ? 'Ej: Club Deportivo Osorno' : 'Ej: Cristian Muñoz';
      }

      // Click manual sobre toggle
      typeBtns.forEach(b => {
        b.addEventListener('click', () => {
          accountType = b.dataset.type;
          userOverrodeType = true;
          updateTypeUI();
          typeHint.textContent = '';
        });
      });

      // Auto-detectar tipo cuando el usuario escribe el nombre
      nameInput.addEventListener('input', () => {
        if (userOverrodeType) return; // respetar elección manual
        const detected = detectAccountType(nameInput.value);
        if (detected !== accountType) {
          accountType = detected;
          updateTypeUI();
          if (detected === 'club') {
            typeHint.innerHTML = '<span style="color:#10B981;">✓</span> Detectamos que es una organización. Puedes cambiar arriba si no.';
          } else {
            typeHint.textContent = '';
          }
        }
      });

      // Foco automático en el nombre
      setTimeout(() => nameInput.focus(), 100);

      // Función para cerrar modal
      function closeModal() {
        overlay.style.animation = 'oauthFadeIn 0.15s ease-out reverse';
        setTimeout(() => overlay.remove(), 150);
      }

      // Cancelar
      cancelBtn.addEventListener('click', closeModal);
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
      });
      // ESC para cerrar
      function escHandler(e) {
        if (e.key === 'Escape') {
          closeModal();
          document.removeEventListener('keydown', escHandler);
        }
      }
      document.addEventListener('keydown', escHandler);

      // Continuar
      function attemptLogin() {
        const name = nameInput.value.trim();
        const email = emailInput.value.trim();

        if (!name) {
          errorBox.textContent = 'Ingresa tu nombre';
          errorBox.style.display = 'block';
          nameInput.focus();
          return;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
          errorBox.textContent = 'Ingresa un correo válido';
          errorBox.style.display = 'block';
          emailInput.focus();
          return;
        }
        errorBox.style.display = 'none';

        // Estado "conectando..."
        continueBtn.disabled = true;
        continueBtn.style.opacity = '0.6';
        continueBtn.innerHTML = `
          <span style="display: inline-flex; align-items: center; gap: 8px;">
            <span style="display: inline-block; width: 14px; height: 14px; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: spin 0.7s linear infinite;"></span>
            Autorizando...
          </span>
        `;

        setTimeout(() => {
          // Si es Apple, simular email privado (relay)
          let storedEmail = email;
          if (provider === 'apple') {
            const hash = Math.random().toString(36).slice(2, 12);
            storedEmail = `${hash}@privaterelay.appleid.com`;
          }
          MatchSPA.setOrgSession({
            provider: provider,
            name: name,
            email: storedEmail,
            realEmail: provider === 'apple' ? email : undefined,
            accountType: accountType, // 'persona' o 'club'
            loginAt: Date.now()
          });
          closeModal();
          const displayName = accountType === 'club' ? name : name.split(' ')[0];
          if (typeof toast === 'function') toast(`Bienvenido, ${displayName} 👋`);
          MatchSPA.navigate('/organizador');
        }, 1100);
      }

      continueBtn.addEventListener('click', attemptLogin);
      // Enter en cualquier input dispara el login
      nameInput.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); emailInput.focus(); } });
      emailInput.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); attemptLogin(); } });
    }

    // === Login por correo (magic link) ===
    const emailInput = page.querySelector('input[type="email"]');
    if (emailInput) {
      // Buscar el botón "Ingresar" — está justo después del input de correo
      let magicBtn = null;
      // 1) Buscar botón con texto que contenga "ingresar", "enviar", "continuar"
      const allActionButtons = page.querySelectorAll('button:not([type="button"]), button[type="submit"], a.btn, button');
      allActionButtons.forEach(b => {
        const t = (b.textContent || '').toLowerCase();
        if (/ingresar|link mágico|magic link|enviar link|continuar →/i.test(t) &&
            !/google|facebook|instagram|apple/i.test(t)) {
          magicBtn = b;
        }
      });
      // 2) Fallback: buscar el siguiente botón después del input
      if (!magicBtn) {
        const sib = emailInput.parentElement?.querySelector('button') ||
                    emailInput.nextElementSibling?.tagName === 'BUTTON' ? emailInput.nextElementSibling : null;
        magicBtn = sib;
      }

      function isValidEmail(s) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((s || '').trim());
      }

      function doMagicLogin() {
        const email = emailInput.value.trim();
        if (!isValidEmail(email)) {
          emailInput.style.borderColor = '#DC2626';
          emailInput.style.boxShadow = '0 0 0 3px rgba(220,38,38,0.15)';
          emailInput.focus();
          if (typeof toast === 'function') toast('Ingresa un correo válido (ej: tu@email.com)', 'error');
          return;
        }
        // Reset estilo de error
        emailInput.style.borderColor = '';
        emailInput.style.boxShadow = '';

        if (typeof toast === 'function') toast('Ingresando a tu cuenta...', 'success');

        // Deshabilitar botón y mostrar estado de carga
        if (magicBtn) {
          magicBtn.disabled = true;
          magicBtn.style.opacity = '0.6';
          magicBtn.style.pointerEvents = 'none';
          const original = magicBtn.innerHTML;
          magicBtn.innerHTML = '<i class="ti ti-loader-2" style="font-size:16px; animation: spin 0.8s linear infinite;"></i> Validando...';
        }

        // Simular validación y entrar al panel
        setTimeout(() => {
          const guessedName = email.split('@')[0];
          MatchSPA.setOrgSession({
            provider: 'email',
            name: guessedName,
            email: email,
            accountType: detectAccountType(guessedName), // auto-detectado por el nombre del usuario
            loginAt: Date.now()
          });
          MatchSPA.navigate('/organizador');
        }, 2000);
      }

      if (magicBtn) {
        magicBtn.addEventListener('click', function(e) {
          e.preventDefault();
          doMagicLogin();
        });
        // Si está dentro de un <form>, capturar también el submit
        let parentForm = magicBtn.closest('form');
        if (parentForm) {
          parentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            doMagicLogin();
          });
        }
      }

      emailInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          doMagicLogin();
        }
      });

      // Limpiar estilo de error mientras escribe
      emailInput.addEventListener('input', function() {
        if (emailInput.style.borderColor === 'rgb(220, 38, 38)') {
          emailInput.style.borderColor = '';
          emailInput.style.boxShadow = '';
        }
      });
    }
  }

  function bindAdminLogin() {
    const page = $page('/admin/login');
    if (!page) return;
    const submitBtn = page.querySelector('button[type="submit"], .btn-primary, button');
    const passInput = page.querySelector('input[type="password"]');
    if (submitBtn) {
      submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const val = passInput ? passInput.value : '';
        if (val === 'match2027') {
          MatchSPA.setAdminSession({ loginAt: Date.now() });
          if (typeof toast === 'function') toast('Bienvenido, Super Admin');
          setTimeout(() => MatchSPA.navigate('/admin'), 400);
        } else {
          if (typeof toast === 'function') toast('Clave incorrecta. Pista: match2027', 'error');
          if (passInput) { passInput.style.borderColor = '#DC2626'; passInput.focus(); }
        }
      });
    }
    if (passInput) {
      passInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') submitBtn && submitBtn.click();
      });
    }
  }

  function bindHiddenAdminEntrance() {
    // Triple-clic en el copyright del footer original abre el login admin (entrada oculta)
    const copy = document.querySelector('.footer .footer-bottom') ||
                 document.querySelector('.footer-bottom') ||
                 document.querySelector('.footer p');
    if (copy) {
      let clicks = 0, timer;
      copy.addEventListener('click', () => {
        clicks++;
        clearTimeout(timer);
        timer = setTimeout(() => clicks = 0, 800);
        if (clicks >= 3) {
          clicks = 0;
          MatchSPA.navigate('/admin/login');
        }
      });
    }
  }

  // Bind after DOM ready and SPA init
  function bindAll() {
    bindOrgLogin();
    bindAdminLogin();
    bindHiddenAdminEntrance();
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindAll);
  } else {
    setTimeout(bindAll, 50);
  }
})();
</script>

<!-- ============================================================
     FILTRO DE DEPORTES en /eventos
     - Lee el query param ?filter=running (etc.) de la URL hash
     - Filtra las event cards mostrando solo las del deporte
     - Activa el chip correspondiente arriba
     - Muestra un banner "Filtrando por: Running [Ver todos]"
     - Permite cambiar el filtro clickeando otro chip
     ============================================================ -->
<script>
(function(){
  const SPORT_LABELS = {
    all: 'Todos los deportes',
    running: 'Running',
    futbol: 'Fútbol',
    basquet: 'Básquet',
    ciclismo: 'Ciclismo',
    natacion: 'Natación',
    outdoor: 'Outdoor',
    fitness: 'Fitness',
    trail: 'Trail'
  };

  // Mapea texto del ev-tag (ej. "RUNNING", "TRAIL", "BÁSQUET") al filtro normalizado
  function tagToFilter(tagText) {
    if (!tagText) return null;
    const t = tagText.trim().toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, ''); // quitar acentos
    if (t === 'running' || t === 'trail') return ['running', 'trail'].includes(t) ? t : 'running';
    if (t === 'futbol') return 'futbol';
    if (t === 'basquet' || t === 'basket' || t === 'basquetbol') return 'basquet';
    if (t === 'ciclismo' || t === 'mtb' || t === 'bike') return 'ciclismo';
    if (t === 'natacion' || t === 'natación' || t === 'swim') return 'natacion';
    if (t === 'outdoor' || t === 'trekking' || t === 'escalada') return 'outdoor';
    if (t === 'fitness' || t === 'crossfit' || t === 'yoga') return 'fitness';
    return t;
  }

  // ¿Una card corresponde al filtro activo?
  function cardMatchesFilter(card, filter) {
    if (!filter || filter === 'all') return true;
    const tagEl = card.querySelector('.ev-tag');
    const cardFilter = tagToFilter(tagEl ? tagEl.textContent : '');
    // Running engloba "trail" también
    if (filter === 'running') return cardFilter === 'running' || cardFilter === 'trail';
    return cardFilter === filter;
  }

  function applyFilter(filter) {
    const page = document.querySelector('section.spa-page[data-route="/eventos"]');
    if (!page) return;

    filter = (filter || 'all').toLowerCase();
    if (!SPORT_LABELS[filter]) filter = 'all';

    // 1) Filtrar tarjetas
    const cards = page.querySelectorAll('.ev-card');
    let visibleCount = 0;
    cards.forEach(c => {
      const matches = cardMatchesFilter(c, filter);
      c.style.display = matches ? '' : 'none';
      if (matches) visibleCount++;
    });

    // 2) Activar chip correspondiente
    page.querySelectorAll('.filter-chips .chip').forEach(chip => {
      const isActive = chip.dataset.filter === filter;
      chip.classList.toggle('active', isActive);
    });

    // 3) Actualizar contador de resultados
    const info = page.querySelector('.results-info .muted');
    if (info) {
      if (filter === 'all') {
        info.textContent = visibleCount + ' eventos encontrados';
      } else {
        info.textContent = visibleCount + ' eventos de ' + SPORT_LABELS[filter];
      }
    }

    // 4) Mostrar/ocultar banner de filtro activo
    let banner = page.querySelector('#sport-filter-banner');
    if (filter === 'all') {
      if (banner) banner.remove();
    } else {
      if (!banner) {
        banner = document.createElement('div');
        banner.id = 'sport-filter-banner';
        banner.style.cssText = `
          display: flex; align-items: center; justify-content: space-between;
          gap: 12px; flex-wrap: wrap;
          max-width: 1200px; margin: 16px auto 0; padding: 12px 18px;
          background: linear-gradient(90deg, #ECFEFD 0%, #F2FEFD 100%);
          border: 1px solid #A5F3EF; border-radius: 12px;
          font-size: 14px; color: #063734;
        `;
        const chips = page.querySelector('.filter-chips');
        if (chips && chips.parentElement) {
          chips.parentElement.insertBefore(banner, chips.nextSibling);
        }
      }
      banner.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
          <i class="ti ti-filter" style="font-size: 18px; color: #0B8B84;"></i>
          <span>Mostrando solo eventos de <strong style="color: #0B8B84;">${SPORT_LABELS[filter]}</strong></span>
        </div>
        <button id="clear-sport-filter" type="button" style="
          background: white; border: 1px solid #0B8B84; color: #0B8B84;
          padding: 7px 14px; border-radius: 999px;
          font-size: 13px; font-weight: 600; cursor: pointer;
          display: inline-flex; align-items: center; gap: 6px;
          font-family: inherit;
        ">
          <i class="ti ti-x" style="font-size: 14px;"></i> Ver todos los eventos
        </button>
      `;
    }
  }

  // Bind a los chips de filtro (cambiar el filtro sin recargar)
  function bindChips() {
    const page = document.querySelector('section.spa-page[data-route="/eventos"]');
    if (!page || page.dataset.chipsBound) return;
    page.dataset.chipsBound = '1';
    page.querySelectorAll('.filter-chips .chip').forEach(chip => {
      chip.style.cursor = 'pointer';
      chip.addEventListener('click', () => {
        const f = chip.dataset.filter || 'all';
        // Actualizar URL sin disparar render completo
        if (f === 'all') {
          if (window.MatchSPA) MatchSPA.navigate('/eventos');
        } else {
          if (window.MatchSPA) MatchSPA.navigate('/eventos?filter=' + f);
        }
      });
    });
  }

  // Bind al botón "Ver todos los eventos" (delegación porque se crea dinámicamente)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest && e.target.closest('#clear-sport-filter');
    if (btn) {
      e.preventDefault();
      if (window.MatchSPA) MatchSPA.navigate('/eventos');
    }
  });

  function init() {
    bindChips();
    const filter = (window.__routeParams && window.__routeParams.filter) || 'all';
    applyFilter(filter);
  }

  // Ejecutar al cargar la página eventos
  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-eventos', init);
  }

  // Si el usuario aterriza directo en /eventos?filter=X al cargar el documento
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(init, 100));
  } else {
    setTimeout(init, 100);
  }
})();
</script>

<!-- ============================================================
     CATÁLOGO DE EVENTOS + DETALLE DINÁMICO + INTERCEPCIÓN DE CLICKS
     ============================================================ -->
<script>
(function(){
  // Catálogo de eventos disponibles (datos simulados pero diferenciados)
  const EVENT_CATALOG = {
    'rally-purranque': {
      sport: 'Running · Trail', icon: 'ti-run', breadcrumb: 'Running',
      title: 'Rally Costero Purranque RCP 2027',
      date: 'Domingo 16 mayo 2027', time: '08:00 hrs', place: 'Purranque, Los Lagos',
      sectionTitle: 'Sobre la carrera',
      desc: 'La cuarta edición del Rally Costero Purranque recorre los paisajes más espectaculares del sur de Chile. Dos distancias, cronometraje oficial, hidratación cada 4 km y ambulancia en ruta.'
    },
    'liga-osorno': {
      sport: 'Fútbol · Liga', icon: 'ti-ball-football', breadcrumb: 'Fútbol',
      title: 'Liga Barrial Osorno 2027',
      date: 'Comienza viernes 24 mayo 2027', time: '19:00 hrs', place: 'Cancha El Cero, Osorno',
      sectionTitle: 'Sobre la liga',
      desc: 'La liga barrial más grande de Osorno vuelve con 18 equipos divididos en dos zonas. Partidos los viernes y sábados, fase regular de 9 fechas, playoffs a definir campeón. Inscripción por equipo de hasta 12 jugadores.'
    },
    'torneo-3x3': {
      sport: 'Básquet · 3x3', icon: 'ti-ball-basketball', breadcrumb: 'Básquet',
      title: 'Torneo 3x3 Plaza de Armas',
      date: 'Sábado 7 junio 2027', time: '10:00 hrs', place: 'Plaza de Armas, Osorno',
      sectionTitle: 'Sobre el torneo',
      desc: 'Torneo abierto de básquet 3x3 en cancha exterior. Modalidad eliminación directa, partidos a 15 puntos o 10 minutos. Categorías Sub-16, Sub-18 y Adulto Open. Premios en efectivo para los tres primeros.'
    },
    'trail-llanquihue': {
      sport: 'Running · Trail', icon: 'ti-mountain', breadcrumb: 'Trail',
      title: 'Trail Lago Llanquihue 2027',
      date: 'Martes 22 junio 2027', time: '07:30 hrs', place: 'Frutillar, Los Lagos',
      sectionTitle: 'Sobre el trail',
      desc: 'Trail de montaña con vista al volcán Osorno y al lago Llanquihue. Tres distancias: 12K, 25K y 50K ultra. Senderos técnicos con desnivel positivo de hasta 1.800 metros. Cronometraje con chip.'
    },
    'mtb-puyehue': {
      sport: 'Ciclismo · MTB', icon: 'ti-bike', breadcrumb: 'Ciclismo',
      title: 'Circuito MTB Puyehue',
      date: 'Lunes 5 julio 2027', time: '09:00 hrs', place: 'Parque Nacional Puyehue',
      sectionTitle: 'Sobre el circuito',
      desc: 'Circuito de MTB cross-country en los senderos del Parque Nacional Puyehue. Tres categorías: Promocional 20K, Sport 40K y Elite 60K. Hidratación cada 8 km, asistencia mecánica en ruta.'
    },
    'crossfit-bicentenario': {
      sport: 'Fitness · Crossfit', icon: 'ti-barbell', breadcrumb: 'Fitness',
      title: 'Encuentro Crossfit Parque Bicentenario',
      date: 'Lunes 14 junio 2027', time: '10:00 hrs', place: 'Parque Bicentenario, Vitacura',
      sectionTitle: 'Sobre el encuentro',
      desc: 'Encuentro gratuito de Crossfit al aire libre. Tres WODs en formato AMRAP, EMOM y para tiempo. Abierto a todos los niveles, con escalas de modificación. Coaches certificados, calentamiento dirigido y stretching al final.'
    }
  };

  // Muestra un aviso cuando el evento solicitado no existe (sin datos falsos).
  function renderEventoNoExiste() {
    const page = document.querySelector('section.spa-page[data-route="/evento"]');
    if (!page) return;
    page.innerHTML =
      '<div style="max-width:560px;margin:80px auto;text-align:center;padding:0 20px;">' +
        '<div style="font-size:56px;color:var(--purple-400);"><i class="ti ti-calendar-off"></i></div>' +
        '<h1 style="margin:16px 0 8px;font-size:26px;color:var(--text);">Este evento no existe</h1>' +
        '<p style="color:var(--text-secondary);margin-bottom:24px;">El evento que buscas no está disponible o fue retirado. Explora los eventos activos de Match Sport.</p>' +
        '<a class="btn btn-primary btn-lg" data-route="/eventos">Ver eventos disponibles</a>' +
      '</div>';
  }

  // Aplicar los datos de un evento a la página /evento
  function loadEventDetail(eventId) {
    // Buscar primero en eventos creados por el usuario (localStorage)
    let userEvent = null;
    try {
      const userEvents = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
      userEvent = userEvents.find(e => e.id === eventId);
    } catch(_) {}

    // Construir data desde el evento real (creado por organizador o del servidor).
    let data;
    if (userEvent) {
      const m = userEvent._meta || {};
      data = {
        sport: m.deporte || userEvent.deporte || 'Evento deportivo',
        icon: userEvent.icon || 'ti-trophy',
        breadcrumb: m.deporte || userEvent.deporte || 'Eventos',
        title: userEvent.nombre || 'Evento',
        date: userEvent.fecha || 'Por confirmar',
        time: m.hora || '—',
        place: m.lugar || userEvent.ubicacion || '—',
        sectionTitle: 'Sobre el evento',
        desc: m.desc || userEvent.desc || userEvent.descripcion || 'Inscripciones abiertas. Más información próximamente.',
        cover: m.imagen || null,
        galeria: Array.isArray(m.galeria) ? m.galeria : [],
        youtube: m.youtube || null,
        videoArchivo: m.videoArchivo || null,
        tickets: Array.isArray(m.tickets) ? m.tickets : [],
        cronograma: Array.isArray(m.cronograma) ? m.cronograma : [],
        cronogramaTexto: m.cronogramaTexto || '',
        gpxList: Array.isArray(m.gpxList) ? m.gpxList : [],
        altimetrias: Array.isArray(m.altimetrias) ? m.altimetrias : [],
        incluyePolera: m.incluyePolera !== false,
        reglamento: m.reglamento || null
      };
    } else {
      // El evento no está en el navegador: preguntar a la API.
      // Si no existe, mostrar "el evento no existe" (sin datos inventados).
      if (window.MSApi) {
        MSApi.getEvent(eventId).then(function(r){
          if (r && r.ok && r.event) {
            var e = r.event;
            var ui = (e.data && typeof e.data === 'object') ? e.data : {};
            ui.id = ui.id || e.slug || String(e.id);
            ui.nombre = ui.nombre || e.nombre;
            ui.deporte = ui.deporte || e.deporte;
            ui.fecha = ui.fecha || e.fecha;
            ui.ubicacion = ui.ubicacion || e.ubicacion;
            ui._server = true;
            try {
              var l = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
              if (!l.some(function(x){ return x.id === ui.id; })) { l.unshift(ui); localStorage.setItem('ms_org_events', JSON.stringify(l)); }
            } catch(_) {}
            loadEventDetail(ui.id);
          } else {
            renderEventoNoExiste();
          }
        }).catch(renderEventoNoExiste);
      } else {
        renderEventoNoExiste();
      }
      return;
    }

    const page = document.querySelector('section.spa-page[data-route="/evento"]');
    if (!page) return;

    const set = (id, value) => { const el = page.querySelector('#' + id); if (el && value != null) el.textContent = value; };
    const setIcon = (id, iconClass) => {
      const el = page.querySelector('#' + id);
      if (el) {
        el.className = el.className.replace(/\bti-[a-z-]+/g, '').trim() + ' ' + iconClass;
        if (!/\bti\b/.test(el.className)) el.classList.add('ti');
      }
    };

    set('ev-breadcrumb-sport', data.breadcrumb);
    set('ev-breadcrumb-name', data.title.replace(/\s+\d{4}$/, ''));
    set('ev-pill-label', data.sport);
    setIcon('ev-pill-icon', data.icon);
    set('ev-detail-title', data.title);
    set('ev-detail-section-title', data.sectionTitle);
    set('ev-detail-desc', data.desc);

    const dateSpan = page.querySelector('#ev-detail-date span');
    if (dateSpan) dateSpan.textContent = data.date;
    const timeSpan = page.querySelector('#ev-detail-time span');
    if (timeSpan) timeSpan.textContent = data.time;
    const placeSpan = page.querySelector('#ev-detail-place span');
    if (placeSpan) placeSpan.textContent = data.place;

    // Aplicar imagen de portada al hero si existe (con overlay más legible)
    const hero = page.querySelector('#ev-hero-photo') || page.querySelector('.event-hero');
    if (hero) {
      if (data.cover) {
        // Foto limpia, sin overlay (el texto ahora va debajo de la imagen)
        hero.style.backgroundImage = `url('${data.cover}')`;
        hero.style.backgroundSize = 'cover';
        hero.style.backgroundPosition = 'center';
      } else {
        // Sin foto: degradado morado de marca
        hero.style.backgroundImage = 'linear-gradient(135deg, var(--purple-700) 0%, var(--purple-900) 100%)';
        hero.style.backgroundSize = '';
        hero.style.backgroundPosition = '';
      }
    }

    // === CRONOGRAMA ===
    const cronoWrap = page.querySelector('#ev-cronograma-wrap');
    const cronoCont = page.querySelector('#ev-cronograma');
    if (cronoWrap && cronoCont) {
      const escapeHtml = (s) => (s==null?'':String(s)).replace(/[<>&]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;'}[c]));
      const textoLibre = (data.cronogramaTexto || '').trim();
      if (textoLibre) {
        // Cronograma de texto libre: mostrar respetando saltos de línea
        cronoCont.innerHTML = `<div class="evento-crono-texto">${escapeHtml(textoLibre).replace(/\n/g,'<br>')}</div>`;
        cronoWrap.style.display = 'block';
      } else {
        // Compatibilidad con eventos antiguos (cronograma por campos)
        const crono = (data.cronograma || []).filter(c => c && (c.actividad || '').trim());
        if (crono.length) {
          const porDia = {};
          const orden = [];
          crono.forEach(c => {
            const dia = c.dia || 'Sin fecha';
            if (!porDia[dia]) { porDia[dia] = []; orden.push(dia); }
            porDia[dia].push(c);
          });
          function fmtDia(iso) {
            if (!iso || iso === 'Sin fecha') return 'Programa';
            try {
              const d = new Date(iso + 'T00:00:00');
              const dias = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
              const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
              return `${dias[d.getDay()]} ${d.getDate()} de ${meses[d.getMonth()]} ${d.getFullYear()}`;
            } catch(_) { return iso; }
          }
          function fmtHora(c) {
            if (c.horaIni && c.horaFin) return `${c.horaIni} — ${c.horaFin}`;
            return c.horaIni || c.horaFin || '';
          }
          cronoCont.innerHTML = orden.map(dia => `
            <div class="evento-crono-day">${fmtDia(dia)}</div>
            ${porDia[dia].map(c => `
              <div class="evento-crono-item">
                <div class="evento-crono-time">${fmtHora(c)}</div>
                <div class="evento-crono-act">
                  <div class="act-name">${c.actividad || ''}</div>
                  ${c.detalle ? `<div class="act-detail">${c.detalle}</div>` : ''}
                </div>
              </div>
            `).join('')}
          `).join('');
          cronoWrap.style.display = 'block';
        } else {
          cronoWrap.style.display = 'none';
        }
      }
    }

    // === POLERA: ocultar pill si el evento no incluye polera ===
    const pillPolera = page.querySelector('#ev-pill-polera');
    if (pillPolera) {
      pillPolera.style.display = (data.incluyePolera === false) ? 'none' : '';
    }

    // === RECORRIDO: altimetría (fotos) y GPX ===
    const recWrap = page.querySelector('#ev-recorrido-wrap');
    const altGrid = page.querySelector('#ev-altimetria-grid');
    const gpxLinks = page.querySelector('#ev-gpx-links');
    if (recWrap && altGrid && gpxLinks) {
      const alts = Array.isArray(data.altimetrias) ? data.altimetrias : [];
      const gpxs = Array.isArray(data.gpxList) ? data.gpxList : [];
      if (alts.length || gpxs.length) {
        altGrid.innerHTML = alts.map(a => `
          <div class="ev-altimetria-card">
            <img src="${a.dataUrl}" alt="Altimetría ${(a.titulo||'').replace(/"/g,'&quot;')}">
            ${a.titulo ? `<div class="cap">${a.titulo.replace(/</g,'&lt;')}</div>` : ''}
          </div>
        `).join('');
        gpxLinks.innerHTML = gpxs.map(g => `
          <a class="ev-gpx-link" href="${g.dataUrl}" download="${(g.nombre||'recorrido.gpx').replace(/"/g,'&quot;')}">
            <i class="ti ti-route"></i> ${(g.titulo || g.nombre || 'Recorrido').replace(/</g,'&lt;')}
          </a>
        `).join('');
        recWrap.style.display = 'block';
      } else {
        recWrap.style.display = 'none';
      }
    }

    // === LISTADO DE INSCRITOS ===
    renderInscritos(eventId);

    // === REGLAMENTO ===
    const regWrap = page.querySelector('#ev-reglamento-wrap');
    const regLink = page.querySelector('#ev-reglamento-link');
    const regNombre = page.querySelector('#ev-reglamento-nombre');
    if (regWrap && regLink) {
      if (data.reglamento && data.reglamento.dataUrl) {
        regLink.href = data.reglamento.dataUrl;
        regLink.setAttribute('download', data.reglamento.nombre || 'reglamento');
        if (regNombre) regNombre.textContent = data.reglamento.nombre || 'Descargar';
        regWrap.style.display = 'block';
      } else {
        regWrap.style.display = 'none';
      }
    }

    // === GALERÍA ===
    const galWrap = page.querySelector('#ev-detail-gallery-wrap');
    const galCont = page.querySelector('#ev-detail-gallery');
    if (galWrap && galCont) {
      if (data.galeria && data.galeria.length) {
        galCont.innerHTML = data.galeria.map((url, i) =>
          `<img src="${url}" alt="Foto ${i+1}" onclick="openLightbox('${url}')">`
        ).join('');
        galWrap.style.display = 'block';
      } else {
        galWrap.style.display = 'none';
        galCont.innerHTML = '';
      }
    }

    // === VIDEO (YouTube o archivo subido) ===
    const vidWrap = page.querySelector('#ev-detail-video-wrap');
    const vidCont = page.querySelector('#ev-detail-video');
    if (vidWrap && vidCont) {
      const ytId = data.youtube ? extractYouTubeId(data.youtube) : null;
      if (ytId) {
        vidCont.innerHTML = `<iframe src="https://www.youtube.com/embed/${ytId}" title="Video del evento" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        vidWrap.style.display = 'block';
      } else if (data.videoArchivo && data.videoArchivo.dataUrl) {
        vidCont.innerHTML = `<video src="${data.videoArchivo.dataUrl}" controls style="width:100%; height:100%; border-radius:12px; background:#000;"></video>`;
        vidWrap.style.display = 'block';
      } else {
        vidWrap.style.display = 'none';
        vidCont.innerHTML = '';
      }
    }

    // === TICKETS DE COMPRA ===
    renderBuyTickets(data.tickets, { id: eventId, title: data.title });
  }

  // Extraer el ID de un enlace de YouTube (varios formatos)
  function extractYouTubeId(url) {
    if (!url) return null;
    const patterns = [
      /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([A-Za-z0-9_-]{11})/
    ];
    for (const p of patterns) {
      const m = url.match(p);
      if (m) return m[1];
    }
    return null;
  }

  // Renderizar tickets de compra con selector de cantidad
  // Estado de la selección de compra (accesible para continuarInscripcion)
  let currentEventForBuy = null;
  const FEE_RATE = 0.07; // 7% de comisión, sumada al total (la paga el corredor)

  function fmtCLP(n) { return '$' + Math.round(n).toLocaleString('es-CL') + ' CLP'; }
  function fmtFechaCorta(iso) {
    if (!iso) return '';
    try {
      const d = new Date(iso + 'T00:00:00');
      const meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
      return `${d.getDate()} ${meses[d.getMonth()]}`;
    } catch(_) { return iso; }
  }

  // Renderiza la tabla de corredores inscritos en el detalle del evento
  function renderInscritos(eventId) {
    const body = document.getElementById('ev-inscritos-body');
    const empty = document.getElementById('ev-inscritos-empty');
    const countEl = document.getElementById('ev-inscritos-count');
    const table = document.getElementById('ev-inscritos-table');
    if (!body) return;

    let inscripciones = [];
    try { inscripciones = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}

    // Filtrar las inscripciones de ESTE evento
    const delEvento = inscripciones.filter(i => {
      if (!i) return false;
      if (eventId && i.eventId) return i.eventId === eventId;
      return false;
    });

    if (countEl) countEl.textContent = delEvento.length;

    if (!delEvento.length) {
      body.innerHTML = '';
      if (table) table.style.display = 'none';
      if (empty) empty.style.display = 'block';
      return;
    }

    if (table) table.style.display = '';
    if (empty) empty.style.display = 'none';

    function esc(s) { return (s == null ? '' : String(s)).replace(/[<>&"]/g, c => ({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])); }

    body.innerHTML = delEvento.map(i => `
      <tr>
        <td>${esc(i.asistente || '—')}</td>
        <td>${esc(i.distancia || i.ticket || '—')}</td>
        <td>${esc(i.categoria || '—')}</td>
        <td>${esc(i.ciudad || '—')}</td>
        <td>${esc(i.club || '—')}</td>
      </tr>
    `).join('');
  }

  function renderBuyTickets(tickets, eventData) {
    const cont = document.getElementById('ev-buy-tickets');
    if (!cont) return;
    currentEventForBuy = eventData || null;

    // Si el evento no trae tickets propios, usar 3 de ejemplo para la demo
    if (!tickets || !tickets.length) {
      tickets = [
        { nombre: 'General 8 km', precio: 15000, descripcion: 'Recorrido costero · medalla finisher · hidratación' },
        { nombre: 'Premium 16 km', precio: 22000, descripcion: 'Incluye polera oficial + kit de corredor' },
        { nombre: 'VIP 16 km + Kit', precio: 35000, descripcion: 'Polera + medalla + foto profesional + kit premium' }
      ];
    }

    let promoDescuento = 0; // monto de descuento aplicado por código promocional

    // Helper de vigencia por fechas de inscripción
    function vigenciaTicket(t) {
      const hoy = new Date(); hoy.setHours(0,0,0,0);
      const desde = t.inscDesde ? new Date(t.inscDesde + 'T00:00:00') : null;
      const hasta = t.inscHasta ? new Date(t.inscHasta + 'T23:59:59') : null;
      if (desde && hoy < desde) return { estado:'proximo', comprable:false, badge:'<span class="buy-badge buy-proximo">Próximamente</span>' };
      if (hasta && hoy > hasta) return { estado:'cerrado', comprable:false, badge:'<span class="buy-badge buy-cerrado">Inscripción cerrada</span>' };
      return { estado:'vigente', comprable:true, badge:'' };
    }

    cont.innerHTML = tickets.map((t, i) => {
      const precio = (t.precio != null && !isNaN(t.precio)) ? Number(t.precio) : 0;
      const fee = Math.round(precio * FEE_RATE);
      const nombre = t.nombre || t.name || ('Entrada ' + (i+1));
      const desc = t.descripcion || t.desc || (t.distancia ? t.distancia : '');
      const vig = vigenciaTicket(t);
      const cerrado = !vig.comprable;
      let periodoTxt = '';
      if (t.inscHasta && vig.estado === 'vigente') periodoTxt = `<div class="wt-periodo">Cierra el ${fmtFechaCorta(t.inscHasta)}</div>`;
      else if (t.inscDesde && vig.estado === 'proximo') periodoTxt = `<div class="wt-periodo">Abre el ${fmtFechaCorta(t.inscDesde)}</div>`;
      return `
        <div class="welcu-ticket-row ${cerrado ? 'wt-disabled' : ''}" data-i="${i}" data-precio="${precio}" data-fee="${fee}" data-comprable="${vig.comprable ? '1' : '0'}">
          <div class="wt-info">
            <div class="wt-name">${nombre} ${vig.badge}</div>
            ${periodoTxt}
            ${desc ? `<button type="button" class="wt-moreinfo" data-more="${i}">Más info ›</button>
            <div class="wt-desc" id="wt-desc-${i}">${desc}</div>` : ''}
          </div>
          <div class="wt-precio">${precio === 0 ? 'Gratis' : fmtCLP(precio)}</div>
          <div class="wt-fee">${precio === 0 ? '—' : '+ ' + fmtCLP(fee)}</div>
          <div class="wt-total" id="wt-total-${i}">$0 CLP</div>
          <div class="wt-cant">
            ${cerrado
              ? '<span class="small muted" style="font-size:11px;">No disponible</span>'
              : `<button type="button" class="welcu-qty-btn wt-minus" data-i="${i}" disabled>−</button>
                 <span class="welcu-qty-val" id="wt-qty-${i}">0</span>
                 <button type="button" class="welcu-qty-btn wt-plus" data-i="${i}">+</button>`}
          </div>
        </div>`;
    }).join('');

    // Estado de cantidades
    const qty = {};
    tickets.forEach((_, i) => qty[i] = 0);
    window.__buySelection = { event: eventData, tickets: tickets, qty: qty, feeRate: FEE_RATE, promo: null };

    function recalc() {
      let granTotal = 0;
      tickets.forEach((t, i) => {
        const precio = (t.precio != null && !isNaN(t.precio)) ? Number(t.precio) : 0;
        const fee = Math.round(precio * FEE_RATE);
        const totalFila = (precio + fee) * qty[i];
        const totalEl = document.getElementById('wt-total-' + i);
        if (totalEl) totalEl.textContent = fmtCLP(totalFila);
        granTotal += totalFila;
      });
      // Aplicar descuento promocional si existe
      const sel = window.__buySelection;
      if (sel && sel.promo && sel.promo.descuento) {
        granTotal = Math.max(0, granTotal - sel.promo.descuento);
      }
      const grandEl = document.getElementById('ev-grand-total');
      if (grandEl) grandEl.textContent = fmtCLP(granTotal);
    }
    window.__recalcBuy = recalc;

    cont.querySelectorAll('.wt-plus').forEach(btn => {
      btn.addEventListener('click', () => {
        const i = parseInt(btn.dataset.i, 10);
        qty[i]++;
        document.getElementById('wt-qty-' + i).textContent = qty[i];
        cont.querySelector(`.wt-minus[data-i="${i}"]`).disabled = false;
        recalc();
      });
    });
    cont.querySelectorAll('.wt-minus').forEach(btn => {
      btn.addEventListener('click', () => {
        const i = parseInt(btn.dataset.i, 10);
        if (qty[i] > 0) qty[i]--;
        document.getElementById('wt-qty-' + i).textContent = qty[i];
        if (qty[i] === 0) btn.disabled = true;
        recalc();
      });
    });
    // "Más info" colapsable
    cont.querySelectorAll('.wt-moreinfo').forEach(btn => {
      btn.addEventListener('click', () => {
        const i = btn.dataset.more;
        const d = document.getElementById('wt-desc-' + i);
        if (d) {
          d.classList.toggle('open');
          btn.textContent = d.classList.contains('open') ? 'Menos info ‹' : 'Más info ›';
        }
      });
    });

    recalc();
    bindPromo();
  }

  // Código promocional (lee los cupones guardados en ms_coupons)
  function bindPromo() {
    const toggle = document.getElementById('ev-promo-toggle');
    const box = document.getElementById('ev-promo-box');
    const apply = document.getElementById('ev-promo-apply');
    const codeInput = document.getElementById('ev-promo-code');
    const msg = document.getElementById('ev-promo-msg');
    if (!toggle || toggle.dataset.bound) return;
    toggle.dataset.bound = '1';

    toggle.addEventListener('click', () => {
      box.style.display = box.style.display === 'none' ? 'flex' : 'none';
    });

    apply.addEventListener('click', () => {
      const code = (codeInput.value || '').trim().toUpperCase();
      if (!code) return;
      let cupones = [];
      try { cupones = JSON.parse(localStorage.getItem('ms_coupons') || '[]'); } catch(_) {}
      const cup = cupones.find(c => c.code === code);
      const sel = window.__buySelection;
      if (!cup) {
        msg.style.display = 'block'; msg.style.color = 'var(--red-600)';
        msg.textContent = 'Código no válido o no existe';
        if (sel) sel.promo = null;
      } else {
        // Calcular descuento sobre el subtotal de tickets (sin fee)
        let subtotal = 0;
        sel.tickets.forEach((t, i) => {
          const precio = (t.precio != null && !isNaN(t.precio)) ? Number(t.precio) : 0;
          subtotal += precio * sel.qty[i];
        });
        let descuento = 0;
        if (cup.type === 'pct') descuento = Math.round(subtotal * (cup.value / 100));
        else descuento = Math.min(cup.value, subtotal);
        sel.promo = { code: cup.code, descuento: descuento };
        msg.style.display = 'block'; msg.style.color = 'var(--green-600)';
        msg.textContent = `✓ Código ${code} aplicado: −${fmtCLP(descuento)}`;
      }
      // Recalcular total
      const ev = new Event('recalc-promo');
      document.getElementById('ev-buy-tickets').dispatchEvent(ev);
      // Forzar recálculo manual
      if (window.__recalcBuy) window.__recalcBuy();
    });
  }

  // Continuar al checkout con la selección actual
  window.continuarInscripcion = function() {
    const sel = window.__buySelection || {};
    const qty = sel.qty || {};
    const tickets = sel.tickets || [];
    // Validar que haya al menos un ticket seleccionado (si el evento tiene tickets propios)
    if (tickets.length) {
      const totalUnidades = Object.values(qty).reduce((a,b) => a + b, 0);
      if (totalUnidades === 0) {
        if (window.toast) toast('Selecciona al menos una entrada', 'error');
        else alert('Selecciona al menos una entrada');
        return;
      }
    }
    // Guardar la selección para que el checkout la lea
    try {
      const feeRate = sel.feeRate || 0.07;
      const items = tickets.map((t, i) => {
        const precio = (t.precio != null && !isNaN(t.precio)) ? Number(t.precio) : 0;
        const fee = Math.round(precio * feeRate);
        return {
          nombre: t.nombre || t.name || ('Entrada ' + (i+1)),
          precio: precio,
          fee: fee,
          cantidad: qty[i] || 0
        };
      }).filter(it => it.cantidad > 0);
      localStorage.setItem('ms_checkout_selection', JSON.stringify({
        eventId: sel.event ? sel.event.id : null,
        eventName: sel.event ? sel.event.title : null,
        items: items,
        promo: sel.promo || null,
        ts: Date.now()
      }));
    } catch(_) {}
    if (window.MatchSPA) MatchSPA.navigate('/checkout');
    else location.hash = '#/checkout';
  };

  // Lightbox de galería
  window.openLightbox = function(url) {
    let lb = document.getElementById('ev-lightbox');
    if (!lb) {
      lb = document.createElement('div');
      lb.id = 'ev-lightbox';
      lb.innerHTML = '<button class="lb-close" aria-label="Cerrar">×</button><img alt="Foto ampliada">';
      document.body.appendChild(lb);
      lb.addEventListener('click', () => lb.classList.remove('open'));
    }
    lb.querySelector('img').src = url;
    lb.classList.add('open');
  };

  // Interceptar clicks en cards de evento (en home y /eventos)
  document.addEventListener('click', (e) => {
    const card = e.target.closest && e.target.closest('[data-event-id]');
    if (!card) return;
    e.preventDefault();
    const id = card.dataset.eventId;
    if (window.MatchSPA) MatchSPA.navigate('/evento?id=' + encodeURIComponent(id));
    else location.hash = '#/evento?id=' + encodeURIComponent(id);
  });

  // Cuando se navega a /evento, leer el id del query param y cargar datos
  function init() {
    const id = (window.__routeParams && window.__routeParams.id) || 'rally-purranque';
    loadEventDetail(id);
  }
  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-evento', init);
  }
  // Al cargar inicialmente, si ya estamos en /evento
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(init, 150));
  } else {
    setTimeout(init, 150);
  }
})();
</script>

<!-- ============================================================
     FILTROS DE SIDEBAR — ubicación, precio, fecha
     Trabajan en combinación con el filtro de deporte ya existente.
     ============================================================ -->
<script>
(function(){
  // Normaliza texto (quita acentos y pasa a minúsculas)
  function norm(s) {
    return (s || '').toString().toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();
  }

  // Mapea texto del label del checkbox al valor a comparar
  function valueFromLabel(label) {
    return norm(label.replace(/\s*\d+\s*$/, '')); // quitar contador final como "18"
  }

  // ¿Una card pasa los filtros del sidebar?
  function cardPasses(card, locations, prices, when) {
    // Ubicación: comparamos contra la metadata del ev-tag y del ev-meta de lugar
    if (locations.length > 0) {
      const metaText = norm(card.textContent);
      const ok = locations.some(loc => {
        // Mapeo: ubicación → palabras clave en el texto de la card
        const map = {
          'santiago': ['santiago', 'vitacura', 'bicentenario'],
          'los lagos': ['osorno', 'purranque', 'frutillar', 'llanquihue', 'puyehue', 'los lagos'],
          'valparaiso': ['valparaiso', 'viña'],
          'biobio': ['biobio', 'biobío', 'concepcion'],
          'online': ['online', 'virtual']
        };
        const keys = map[loc] || [loc];
        return keys.some(k => metaText.includes(k));
      });
      if (!ok) return false;
    }

    // Precio
    if (prices.length > 0) {
      const priceEl = card.querySelector('.ev-price, .event-price');
      if (!priceEl) return false;
      const priceText = norm(priceEl.textContent);
      // Extraer número (en miles si tiene punto chileno: $15.000)
      let num = 0;
      if (/gratuito|gratis|free/.test(priceText)) {
        num = 0;
      } else {
        const m = priceText.match(/[\d.,]+/);
        if (m) {
          // formato chileno: $15.000 → 15000; quitar puntos como separadores de miles
          num = parseInt(m[0].replace(/\./g, '').replace(/,/g, ''), 10) || 0;
        }
      }
      const ok = prices.some(p => {
        if (p === 'gratuito') return num === 0;
        if (p === '$1 - $20.000') return num >= 1 && num <= 20000;
        if (p === '$20.000 - $50.000') return num > 20000 && num <= 50000;
        if (p === '$50.000+') return num > 50000;
        return true;
      });
      if (!ok) return false;
    }

    // "Cuándo" — todos los eventos son 2027, así que aceptamos "Cualquier fecha"
    // y los demás filtros son indicativos. (Implementación simbólica.)
    return true;
  }

  let bound = false;
  function bindSidebar() {
    const page = document.querySelector('section.spa-page[data-route="/eventos"]');
    if (!page || bound) return;
    bound = true;

    function getActiveFilters() {
      const locations = [];
      const prices = [];
      let when = 'any';

      page.querySelectorAll('.filter-block').forEach(block => {
        const head = block.querySelector('h4');
        if (!head) return;
        const headText = norm(head.textContent);
        block.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
          const label = cb.closest('label');
          if (!label) return;
          const val = valueFromLabel(label.textContent);
          if (/ubicacion/.test(headText)) locations.push(val);
          else if (/precio/.test(headText)) prices.push(label.textContent.trim().replace(/\s*\d+\s*$/, '').trim());
        });
        if (/cuando/.test(headText)) {
          const radio = block.querySelector('input[type="radio"]:checked');
          if (radio) {
            const lblTxt = norm(radio.closest('label')?.textContent || '');
            if (/cualquier/.test(lblTxt)) when = 'any';
            else if (/este mes/.test(lblTxt)) when = 'month';
            else if (/3 meses/.test(lblTxt)) when = 'quarter';
            else if (/este ano|este año/.test(lblTxt)) when = 'year';
          }
        }
      });

      return { locations, prices, when };
    }

    function applySidebarFilters() {
      const { locations, prices, when } = getActiveFilters();
      const cards = page.querySelectorAll('.ev-card');
      let visible = 0;
      cards.forEach(c => {
        // Conservar el filtro de deporte: si ya estaba escondida por deporte, no la mostremos
        if (c.dataset.hiddenBySport === '1') {
          c.style.display = 'none';
          return;
        }
        const passes = cardPasses(c, locations, prices, when);
        c.style.display = passes ? '' : 'none';
        if (passes) visible++;
      });
      // Actualizar contador
      const info = page.querySelector('.results-info .muted');
      if (info && !info.textContent.includes(' de ')) {
        info.textContent = visible + ' eventos encontrados';
      } else if (info) {
        // si ya hay filtro de deporte aplicado, conservar el "de X"
        info.textContent = info.textContent.replace(/^\d+/, visible);
      }
    }

    // Bind a cada checkbox/radio
    page.querySelectorAll('aside.filters input[type="checkbox"], aside.filters input[type="radio"]').forEach(input => {
      input.addEventListener('change', applySidebarFilters);
    });

    // Botón "Limpiar filtros"
    const clearBtn = page.querySelector('aside.filters .btn-outline');
    if (clearBtn) {
      clearBtn.addEventListener('click', (e) => {
        e.preventDefault();
        page.querySelectorAll('aside.filters input[type="checkbox"]').forEach(cb => cb.checked = false);
        // Resetear radio a "Cualquier fecha"
        const cualquier = Array.from(page.querySelectorAll('aside.filters input[type="radio"]'))
          .find(r => /cualquier/i.test(r.closest('label')?.textContent || ''));
        if (cualquier) cualquier.checked = true;
        applySidebarFilters();
      });
    }
  }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-eventos', () => setTimeout(bindSidebar, 50));
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(bindSidebar, 200));
  } else {
    setTimeout(bindSidebar, 200);
  }
})();
</script>

<!-- ============================================================
     UPLOAD HANDLER — Carga de archivos (imágenes, GPX, Excel)
     - Click abre selector del sistema (cámara/galería en móvil)
     - Drag & drop funciona en desktop
     - Validación de tipo y tamaño
     - Imagen: preview + compresión a max 1600px / JPEG 0.85
     - GPX/Excel: pill con nombre y tamaño
     - Persistencia de la imagen del evento vía wizard
     ============================================================ -->
<script>
(function(){
  const MAX_IMAGE_BYTES  = 5 * 1024 * 1024;
  const MAX_FILE_BYTES   = 10 * 1024 * 1024;
  const MAX_IMG_WIDTH    = 1600;
  const COMPRESSED_TYPE  = 'image/jpeg';
  const COMPRESSED_QUAL  = 0.85;

  function fmtBytes(b) {
    if (b < 1024) return b + ' B';
    if (b < 1024 * 1024) return (b / 1024).toFixed(1) + ' KB';
    return (b / (1024 * 1024)).toFixed(2) + ' MB';
  }

  function validateFile(file, uploadType) {
    if (!file) return { ok: false, msg: 'No se seleccionó archivo' };
    if (uploadType === 'image' || uploadType === 'gallery') {
      if (!/^image\/(jpeg|jpg|png|webp)$/i.test(file.type)) {
        return { ok: false, msg: 'Solo imágenes JPG, PNG o WebP' };
      }
      if (file.size > MAX_IMAGE_BYTES) {
        return { ok: false, msg: 'La imagen supera los 5MB. Usa una más liviana.' };
      }
    } else if (uploadType === 'gpx') {
      if (!/\.(gpx|kml)$/i.test(file.name)) {
        return { ok: false, msg: 'Solo archivos .gpx o .kml' };
      }
      if (file.size > MAX_FILE_BYTES) {
        return { ok: false, msg: 'El archivo supera los 10MB' };
      }
    } else if (uploadType === 'excel') {
      if (!/\.(xlsx|xls|csv)$/i.test(file.name)) {
        return { ok: false, msg: 'Solo archivos Excel (.xlsx, .xls) o CSV' };
      }
      if (file.size > MAX_FILE_BYTES) {
        return { ok: false, msg: 'El archivo supera los 10MB' };
      }
    }
    return { ok: true };
  }

  function compressImage(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = (e) => {
        const img = new Image();
        img.onload = () => {
          let { width, height } = img;
          if (width > MAX_IMG_WIDTH) {
            height = Math.round(height * (MAX_IMG_WIDTH / width));
            width = MAX_IMG_WIDTH;
          }
          const canvas = document.createElement('canvas');
          canvas.width = width;
          canvas.height = height;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, width, height);
          try {
            const dataUrl = canvas.toDataURL(COMPRESSED_TYPE, COMPRESSED_QUAL);
            resolve({ dataUrl, width, height });
          } catch (err) { reject(err); }
        };
        img.onerror = () => reject(new Error('No se pudo cargar la imagen'));
        img.src = e.target.result;
      };
      reader.onerror = () => reject(new Error('No se pudo leer el archivo'));
      reader.readAsDataURL(file);
    });
  }

  function showPreview(zone, payload) {
    const empty = zone.querySelector('.upload-empty');
    const prev = zone.querySelector('.upload-preview');
    if (empty) empty.style.display = 'none';
    if (prev) prev.style.display = 'flex';
    zone.classList.add('has-file');

    const type = zone.dataset.uploadType;
    if (type === 'image' && payload.dataUrl) {
      const img = prev.querySelector('.upload-preview-img');
      if (img) img.src = payload.dataUrl;
      const meta = prev.querySelector('.upload-preview-meta');
      if (meta && payload.width) {
        meta.textContent = `${payload.width}×${payload.height}px · ${fmtBytes(payload.dataUrl.length * 0.75)}`;
      }
    } else {
      const nameEl = prev.querySelector('.upload-file-name');
      const sizeEl = prev.querySelector('.upload-file-size');
      if (nameEl) nameEl.textContent = payload.fileName || 'archivo';
      if (sizeEl) sizeEl.textContent = fmtBytes(payload.fileSize || 0);
    }
  }

  function showEmpty(zone) {
    const empty = zone.querySelector('.upload-empty');
    const prev = zone.querySelector('.upload-preview');
    if (empty) empty.style.display = 'flex';
    if (prev) prev.style.display = 'none';
    zone.classList.remove('has-file');
  }

  // Renderizar miniaturas de la galería + permitir quitar cada una
  function renderGalleryThumbs() {
    const cont = document.getElementById('evGalleryThumbs');
    if (!cont) return;
    const cache = (window.__uploadCache && window.__uploadCache.gallery) || [];
    if (!cache.length) { cont.style.display = 'none'; cont.innerHTML = ''; return; }
    cont.style.display = 'grid';
    cont.innerHTML = cache.map((url, i) => `
      <div class="gallery-thumb">
        <img src="${url}" alt="Foto ${i+1}">
        <button type="button" class="gallery-thumb-remove" data-gallery-index="${i}">×</button>
      </div>`).join('');
    cont.querySelectorAll('.gallery-thumb-remove').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const idx = parseInt(btn.dataset.galleryIndex, 10);
        window.__uploadCache.gallery.splice(idx, 1);
        renderGalleryThumbs();
        if (window.toast) toast('Foto quitada');
      });
    });
  }

  async function processFile(zone, file) {
    const type = zone.dataset.uploadType;
    const field = zone.dataset.uploadField;
    const validation = validateFile(file, type);
    if (!validation.ok) {
      if (window.toast) toast(validation.msg, 'error');
      else alert(validation.msg);
      return;
    }

    try {
      if (type === 'image') {
        if (window.toast) toast('Procesando imagen...');
        const result = await compressImage(file);
        showPreview(zone, result);
        window.__uploadCache = window.__uploadCache || {};
        window.__uploadCache[field] = result.dataUrl;
        if (window.toast) toast('Imagen lista', 'success');
      } else if (type === 'gallery') {
        // Galería: acumular en un array, máx 6 fotos
        window.__uploadCache = window.__uploadCache || {};
        window.__uploadCache.gallery = window.__uploadCache.gallery || [];
        if (window.__uploadCache.gallery.length >= 6) {
          if (window.toast) toast('Máximo 6 fotos en la galería', 'error');
          return;
        }
        const result = await compressImage(file);
        window.__uploadCache.gallery.push(result.dataUrl);
        renderGalleryThumbs();
        if (window.toast) toast('Foto agregada a la galería', 'success');
      } else {
        const payload = { fileName: file.name, fileSize: file.size };
        showPreview(zone, payload);
        window.__uploadCache = window.__uploadCache || {};
        window.__uploadCache[field] = payload;
        if (window.toast) toast('Archivo cargado: ' + file.name, 'success');
      }
    } catch (err) {
      const msg = 'Error al procesar el archivo: ' + (err.message || err);
      if (window.toast) toast(msg, 'error');
      else alert(msg);
    }
  }

  // Procesar múltiples archivos (para galería)
  async function processFiles(zone, files) {
    for (let i = 0; i < files.length; i++) {
      await processFile(zone, files[i]);
    }
  }

  function bindUploadZone(zone) {
    if (zone.dataset.uploadBound === '1') return;
    zone.dataset.uploadBound = '1';

    const inputId = zone.dataset.uploadTarget;
    const input = inputId ? document.getElementById(inputId) : zone.querySelector('input[type="file"]');
    if (!input) return;

    zone.addEventListener('click', (e) => {
      if (e.target.closest('.upload-btn-remove')) return;
      input.click();
    });

    input.addEventListener('change', (e) => {
      const files = e.target.files;
      if (!files || !files.length) return;
      if (zone.dataset.uploadType === 'gallery') {
        processFiles(zone, files);
        input.value = ''; // permitir re-seleccionar las mismas
      } else {
        processFile(zone, files[0]);
      }
    });

    const removeBtn = zone.querySelector('.upload-btn-remove');
    if (removeBtn) {
      removeBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        input.value = '';
        showEmpty(zone);
        const field = zone.dataset.uploadField;
        if (window.__uploadCache) delete window.__uploadCache[field];
        if (window.toast) toast('Archivo eliminado');
      });
    }

    zone.addEventListener('dragover', (e) => {
      e.preventDefault();
      e.stopPropagation();
      zone.classList.add('dragging');
    });
    zone.addEventListener('dragleave', (e) => {
      if (e.target === zone || !zone.contains(e.relatedTarget)) {
        zone.classList.remove('dragging');
      }
    });
    zone.addEventListener('drop', (e) => {
      e.preventDefault();
      e.stopPropagation();
      zone.classList.remove('dragging');
      const files = e.dataTransfer.files;
      if (!files || !files.length) return;
      if (zone.dataset.uploadType === 'gallery') processFiles(zone, files);
      else processFile(zone, files[0]);
    });
  }

  function bindAll() {
    document.querySelectorAll('.upload-zone[data-upload-type]').forEach(bindUploadZone);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindAll);
  } else {
    setTimeout(bindAll, 100);
  }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-crear-evento', () => setTimeout(bindAll, 50));
    MatchSPA.onPageInit('page-organizador-diplomas', () => setTimeout(bindAll, 50));
  }

  // Helper público
  window.__getUploadCache = function() { return window.__uploadCache || {}; };
})();
</script>

<!-- ============================================================
     CHATBOT DE SOPORTE (Etapa 1 — FAQ sin IA real)
     Botón flotante en todas las páginas. Pregunta el tipo de usuario
     y muestra preguntas frecuentes. Detecta palabras clave si el
     usuario escribe libre. Fallback a WhatsApp.
     ============================================================ -->
<style>
  #ms-chat-fab {
    position: fixed;
    bottom: 22px; right: 22px;
    width: 58px; height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, #17BDB5 0%, #0B8B84 100%);
    border: none;
    box-shadow: 0 8px 28px rgba(11, 139, 132,0.4);
    cursor: pointer;
    z-index: 99990;
    display: flex; align-items: center; justify-content: center;
    color: white;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  #ms-chat-fab:hover { transform: scale(1.08); box-shadow: 0 10px 34px rgba(11, 139, 132,0.5); }
  #ms-chat-fab i { font-size: 26px; }
  #ms-chat-fab .ms-chat-badge {
    position: absolute; top: -3px; right: -3px;
    width: 18px; height: 18px;
    background: #F59E0B;
    border-radius: 50%;
    border: 2px solid white;
    font-size: 10px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    color: white;
  }

  #ms-chat-panel {
    position: fixed;
    bottom: 92px; right: 22px;
    width: 380px; max-width: calc(100vw - 32px);
    height: 560px; max-height: calc(100vh - 130px);
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    z-index: 99991;
    display: none;
    flex-direction: column;
    overflow: hidden;
    font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
  }
  #ms-chat-panel.open { display: flex; animation: msChatIn 0.22s ease-out; }
  @keyframes msChatIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }

  .ms-chat-header {
    background: linear-gradient(135deg, #0B8B84 0%, #08514D 100%);
    color: white;
    padding: 16px 18px;
    display: flex; align-items: center; gap: 12px;
  }
  .ms-chat-header .ms-chat-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
  }
  .ms-chat-header h4 { margin: 0; font-size: 15px; font-weight: 700; }
  .ms-chat-header p { margin: 2px 0 0; font-size: 12px; opacity: 0.85; display: flex; align-items: center; gap: 5px; }
  .ms-chat-header .ms-online-dot { width: 7px; height: 7px; border-radius: 50%; background: #4ADE80; display: inline-block; }
  .ms-chat-close {
    margin-left: auto; background: rgba(255,255,255,0.15); border: none;
    width: 30px; height: 30px; border-radius: 8px; color: white; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
  }
  .ms-chat-close:hover { background: rgba(255,255,255,0.28); }

  .ms-chat-body {
    flex: 1; overflow-y: auto; padding: 16px;
    background: #FAFAF9;
    display: flex; flex-direction: column; gap: 12px;
  }
  .ms-msg { max-width: 85%; padding: 10px 14px; border-radius: 14px; font-size: 14px; line-height: 1.5; }
  .ms-msg-bot { background: #fff; border: 1px solid rgba(0,0,0,0.07); align-self: flex-start; border-bottom-left-radius: 4px; color: #1F1F1F; }
  .ms-msg-user { background: linear-gradient(135deg, #17BDB5, #0B8B84); color: white; align-self: flex-end; border-bottom-right-radius: 4px; }
  .ms-chat-options { display: flex; flex-direction: column; gap: 8px; align-self: flex-start; width: 100%; }
  .ms-chat-option {
    text-align: left; background: #fff; border: 1px solid #A5F3EF;
    color: #0A6E69; padding: 10px 14px; border-radius: 10px;
    font-size: 13.5px; font-weight: 500; cursor: pointer; font-family: inherit;
    transition: all 0.15s;
  }
  .ms-chat-option:hover { background: #ECFEFD; border-color: #17BDB5; }
  .ms-chat-whatsapp {
    background: #25D366 !important; color: white !important; border: none !important;
    display: flex; align-items: center; gap: 8px; justify-content: center; font-weight: 600;
  }
  .ms-chat-whatsapp:hover { background: #1EBE57 !important; }
  .ms-chat-back {
    background: transparent !important; border: none !important; color: #0B8B84 !important;
    font-size: 13px !important; padding: 4px !important; text-align: left;
  }

  .ms-chat-footer { padding: 12px; border-top: 1px solid rgba(0,0,0,0.07); background: #fff; display: flex; gap: 8px; }
  .ms-chat-input {
    flex: 1; padding: 10px 14px; border: 1px solid #E5E5E0; border-radius: 999px;
    font-size: 16px; outline: none; font-family: inherit;
  }
  .ms-chat-input:focus { border-color: #17BDB5; }
  .ms-chat-send {
    width: 42px; height: 42px; border-radius: 50%; border: none;
    background: #0B8B84; color: white; cursor: pointer; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
  }
  .ms-chat-send:hover { background: #0A6E69; }
  .ms-chat-disclaimer { font-size: 10px; color: #9CA3AF; text-align: center; padding: 0 12px 8px; background: #fff; }

  @media (max-width: 480px) {
    #ms-chat-panel { bottom: 0; right: 0; width: 100vw; max-width: 100vw; height: 100vh; max-height: 100vh; border-radius: 0; }
    #ms-chat-fab { bottom: 16px; right: 16px; }
  }
</style>

<button id="ms-chat-fab" aria-label="Abrir chat de ayuda">
  <i class="ti ti-message-chatbot"></i>
  <span class="ms-chat-badge">1</span>
</button>

<div id="ms-chat-panel" role="dialog" aria-label="Chat de ayuda Match Sport">
  <div class="ms-chat-header">
    <div class="ms-chat-avatar">🤖</div>
    <div>
      <h4>Asistente Match Sport</h4>
      <p><span class="ms-online-dot"></span> Responde al instante</p>
    </div>
    <button class="ms-chat-close" id="ms-chat-close" aria-label="Cerrar"><i class="ti ti-x" style="font-size:16px;"></i></button>
  </div>
  <div class="ms-chat-body" id="ms-chat-body"></div>
  <div class="ms-chat-footer">
    <input type="text" class="ms-chat-input" id="ms-chat-input" placeholder="Escribe tu pregunta...">
    <button class="ms-chat-send" id="ms-chat-send" aria-label="Enviar"><i class="ti ti-send" style="font-size:16px;"></i></button>
  </div>
  <div class="ms-chat-disclaimer">Asistente automático · Para casos complejos te derivamos a una persona</div>
</div>

<script>
(function(){
  // === CONFIGURACIÓN ===
  // Reemplaza este número por el WhatsApp real de soporte (formato internacional sin +, espacios ni guiones)
  const WHATSAPP_NUMBER = '56981896741'; // WhatsApp de soporte Match Sport
  const WHATSAPP_MSG = 'Hola, necesito ayuda con Match Sport';

  // === BASE DE CONOCIMIENTO (FAQ) ===
  const FAQ = {
    deportista: [
      { q: '¿Cómo me inscribo a un evento?', a: 'Es muy fácil: 1) Busca el evento en "Explorar eventos", 2) Haz click en "Inscribirse", 3) Elige tu categoría/distancia, 4) Completa tus datos y la ficha médica, 5) Paga con Webpay, tarjeta o Mercado Pago. ¡Listo! Recibirás tu ticket con código QR por correo.', kw: ['inscrib', 'registr', 'anotar', 'participar', 'apuntar'] },
      { q: '¿Puedo pedir reembolso?', a: 'La política de reembolso la define cada organizador. Generalmente puedes solicitar reembolso hasta cierta fecha antes del evento. Revisa las condiciones en la página del evento o escríbele al organizador desde tu ticket.', kw: ['reembols', 'devoluc', 'devolver', 'cancelar inscrip', 'plata', 'dinero'] },
      { q: '¿Qué es la ficha médica y por qué la piden?', a: 'La ficha médica es una declaración de salud que confirma que estás en condiciones de participar. Protege tu seguridad y la del evento. Algunos eventos la exigen obligatoriamente, otros la dejan opcional. Se firma digitalmente al inscribirte.', kw: ['ficha', 'medic', 'salud', 'declaracion', 'certificado'] },
      { q: '¿Cómo descargo mi diploma?', a: 'Después de que el organizador suba los resultados, recibirás un correo con el enlace a tu diploma digital. También puedes verlo en la sección "Resultados" buscando tu nombre o RUT. Cada diploma tiene un QR verificable.', kw: ['diploma', 'certificado finish', 'medalla', 'resultado mio'] },
      { q: '¿Cómo veo los resultados de un evento?', a: 'Ve a la sección "Resultados" en el menú principal. Ahí puedes buscar por nombre del evento, tu nombre o RUT. Los resultados aparecen una vez que el organizador los publica, generalmente entre 24 y 48 horas después del evento.', kw: ['resultado', 'tiempo', 'posicion', 'ranking', 'clasificac'] },
      { q: '¿Es seguro pagar en Match Sport?', a: 'Sí. Los pagos se procesan a través de Webpay (Transbank) y Mercado Pago, pasarelas de pago seguras de la región. Match Sport no almacena los datos de tu tarjeta. La conexión está cifrada.', kw: ['seguro', 'pago', 'pagar', 'tarjeta', 'webpay', 'transbank', 'mercado pago', 'estafa'] }
    ],
    organizador: [
      { q: '¿Cómo creo mi primer evento?', a: 'Ingresa o crea tu cuenta de organizador, luego ve a "Crear evento". Un asistente te guía en 6 pasos: información básica, fecha y lugar, distancias/categorías, tickets y precios, configuración de pagos, y publicación. Puedes guardar como borrador y publicar cuando quieras.', kw: ['crear evento', 'primer evento', 'nuevo evento', 'organizar', 'publicar evento'] },
      { q: '¿Cuál es la comisión de Match Sport?', a: 'El plan Estándar cobra 7% por ticket vendido, sin costo fijo. El plan Gratuito permite 1 evento con hasta 30 inscritos sin comisión. Para grandes organizaciones, el plan Corporativo tiene tarifas a convenir. Sin sorpresas ni letra chica.', kw: ['comision', 'cobran', 'cuanto cuesta', 'precio', 'tarifa', 'fee', 'porcentaje', 'cobro'] },
      { q: '¿Cuándo recibo el pago de los inscritos?', a: 'Los pagos se liquidan según el plan contratado, típicamente entre 24 y 48 horas hábiles después de cada venta, o de forma agendada. El dinero llega directo a tu cuenta bancaria registrada. Puedes ver el detalle en tu dashboard.', kw: ['cuando recibo', 'pago', 'plata', 'transferencia', 'liquidacion', 'cobro', 'deposito', 'cuando me pagan'] },
      { q: '¿Cómo descargo la lista de inscritos?', a: 'En tu panel, ve a "Asistentes". Ahí ves la lista completa de inscritos con sus datos, estado de pago y ficha médica. Puedes exportarla a Excel con el botón "Exportar" para usarla el día del evento.', kw: ['lista inscritos', 'asistentes', 'participantes', 'exportar', 'descargar lista', 'excel inscritos'] },
      { q: '¿Cómo funciona el check-in el día del evento?', a: 'Usa la sección "Check-in QR" desde tu celular o tablet. Escaneas el código QR del ticket de cada participante y queda registrada su asistencia al instante. Funciona sin internet una vez cargada la lista.', kw: ['check-in', 'checkin', 'acreditacion', 'qr', 'dia del evento', 'registro entrada', 'escanear'] },
      { q: '¿Puedo crear códigos de descuento?', a: 'Sí. En la sección "Descuentos" puedes crear cupones (ej: EARLY20 con 20% de descuento, o GRUPO5 para compras grupales). Defines el monto, la cantidad de usos y la fecha de vencimiento. Ideal para promociones de lanzamiento.', kw: ['descuento', 'cupon', 'codigo', 'promocion', 'early bird', 'oferta', 'rebaja'] },
      { q: '¿Cómo genero los diplomas?', a: 'En "Diplomas", subes un Excel con los resultados (RUT, nombre, tiempo, categoría, posición) y la plataforma genera automáticamente un diploma único para cada participante, con QR verificable. Se envían por correo a los inscritos.', kw: ['diploma', 'certificado', 'generar diploma', 'resultados excel'] }
    ]
  };

  // === ESTADO ===
  let userType = null; // 'deportista' | 'organizador'

  const fab = document.getElementById('ms-chat-fab');
  const panel = document.getElementById('ms-chat-panel');
  const closeBtn = document.getElementById('ms-chat-close');
  const body = document.getElementById('ms-chat-body');
  const input = document.getElementById('ms-chat-input');
  const sendBtn = document.getElementById('ms-chat-send');
  const badge = fab.querySelector('.ms-chat-badge');

  function scrollDown() { setTimeout(() => { body.scrollTop = body.scrollHeight; }, 50); }

  function addBot(html) {
    const d = document.createElement('div');
    d.className = 'ms-msg ms-msg-bot';
    d.innerHTML = html;
    body.appendChild(d);
    scrollDown();
  }
  function addUser(text) {
    const d = document.createElement('div');
    d.className = 'ms-msg ms-msg-user';
    d.textContent = text;
    body.appendChild(d);
    scrollDown();
  }
  function addOptions(options) {
    const wrap = document.createElement('div');
    wrap.className = 'ms-chat-options';
    options.forEach(opt => {
      const btn = document.createElement('button');
      btn.className = 'ms-chat-option' + (opt.cls ? ' ' + opt.cls : '');
      btn.innerHTML = opt.label;
      btn.addEventListener('click', opt.action);
      wrap.appendChild(btn);
    });
    body.appendChild(wrap);
    scrollDown();
    return wrap;
  }

  function whatsappOption() {
    return {
      label: '<i class="ti ti-brand-whatsapp" style="font-size:16px;"></i> Hablar por WhatsApp',
      cls: 'ms-chat-whatsapp',
      action: () => {
        const url = 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' + encodeURIComponent(WHATSAPP_MSG);
        window.open(url, '_blank');
      }
    };
  }

  function showTypeQuestion() {
    addBot('¡Hola! 👋 Soy el asistente de Match Sport. ¿Con qué perfil necesitas ayuda?');
    addOptions([
      { label: '🏃 Soy deportista (busco inscribirme)', action: () => selectType('deportista') },
      { label: '📋 Soy organizador (creo eventos)', action: () => selectType('organizador') }
    ]);
  }

  function selectType(type) {
    userType = type;
    addUser(type === 'deportista' ? 'Soy deportista' : 'Soy organizador');
    addBot('Perfecto. Estas son las preguntas más frecuentes. Toca una, o escríbeme tu duda directamente:');
    showFaqList();
  }

  function showFaqList() {
    const list = FAQ[userType] || [];
    const options = list.map(item => ({
      label: item.q,
      action: () => answerFaq(item)
    }));
    options.push(whatsappOption());
    options.push({ label: '↩ Cambiar de perfil', cls: 'ms-chat-back', action: () => { userType = null; addBot('Sin problema. ¿Qué perfil eres?'); addOptions([
      { label: '🏃 Soy deportista', action: () => selectType('deportista') },
      { label: '📋 Soy organizador', action: () => selectType('organizador') }
    ]); } });
    addOptions(options);
  }

  function answerFaq(item) {
    addUser(item.q);
    setTimeout(() => {
      addBot(item.a);
      setTimeout(() => {
        addBot('¿Te ayudo con algo más?');
        addOptions([
          { label: 'Ver otras preguntas', action: () => showFaqList() },
          whatsappOption()
        ]);
      }, 400);
    }, 350);
  }

  // Búsqueda por palabras clave cuando el usuario escribe libre
  function handleFreeText(text) {
    addUser(text);
    const norm = text.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    // Buscar en ambas categorías (o en la del tipo actual primero)
    const pools = userType ? [FAQ[userType], FAQ[userType === 'deportista' ? 'organizador' : 'deportista']] : [FAQ.deportista, FAQ.organizador];
    let best = null, bestScore = 0;
    pools.forEach(pool => {
      pool.forEach(item => {
        let score = 0;
        (item.kw || []).forEach(k => { if (norm.includes(k)) score++; });
        if (score > bestScore) { bestScore = score; best = item; }
      });
    });

    setTimeout(() => {
      if (best && bestScore > 0) {
        addBot(best.a);
        setTimeout(() => {
          addBot('¿Resolví tu duda?');
          addOptions([
            { label: 'Sí, gracias 👍', action: () => addBot('¡Genial! Estoy aquí si necesitas algo más. 🙌') },
            { label: 'Ver más preguntas', action: () => { if (!userType) showTypeQuestion(); else showFaqList(); } },
            whatsappOption()
          ]);
        }, 400);
      } else {
        addBot('Mmm, no estoy seguro de cómo ayudarte con eso. 😅 Puedo derivarte a una persona de nuestro equipo:');
        addOptions([
          whatsappOption(),
          { label: 'Ver preguntas frecuentes', action: () => { if (!userType) showTypeQuestion(); else showFaqList(); } }
        ]);
      }
    }, 400);
  }

  function sendMessage() {
    const text = input.value.trim();
    if (!text) return;
    input.value = '';
    handleFreeText(text);
  }

  // === EVENTOS ===
  let initialized = false;
  function openPanel() {
    panel.classList.add('open');
    badge.style.display = 'none';
    if (!initialized) {
      initialized = true;
      showTypeQuestion();
    }
    setTimeout(() => input.focus(), 200);
  }
  function closePanel() { panel.classList.remove('open'); }

  fab.addEventListener('click', () => {
    if (panel.classList.contains('open')) closePanel();
    else openPanel();
  });
  closeBtn.addEventListener('click', closePanel);
  sendBtn.addEventListener('click', sendMessage);
  input.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); sendMessage(); } });
})();
</script>

<!-- ============================================================
     GESTIÓN DE CUPONES DE DESCUENTO
     - Render dinámico desde array (persistido en localStorage)
     - Crear y editar cupones (código, descuento, vencimiento, usos máx)
     - Barra de progreso de usos (X de Y) + estado agotado/vencido
     ============================================================ -->
<script>
(function(){
  const KEY = 'ms_coupons';

  // Sin cupones de ejemplo: el organizador crea los suyos
  const DEFAULT_COUPONS = [];

  let coupons = [];

  function load() {
    try {
      const raw = localStorage.getItem(KEY);
      coupons = raw ? JSON.parse(raw) : [];
    } catch(_) { coupons = []; }
  }
  function save() {
    try { localStorage.setItem(KEY, JSON.stringify(coupons)); } catch(_) {}
  }

  function isExpired(c) {
    if (!c.expiry) return false;
    return new Date(c.expiry) < new Date();
  }
  function isFull(c) {
    return c.max != null && c.used >= c.max;
  }

  function fmtMoney(n) {
    if (n >= 1000) return '$' + Math.round(n/1000) + 'K';
    return '$' + n;
  }
  function fmtDiscountLabel(c) {
    return c.type === 'pct' ? c.value + '% de descuento' : '$' + c.value.toLocaleString('es-CL') + ' fijo';
  }
  function fmtExpiryLabel(c) {
    if (!c.expiry) return 'Sin vencimiento';
    const d = new Date(c.expiry + 'T00:00:00');
    const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    const txt = d.getDate() + ' ' + meses[d.getMonth()];
    return isExpired(c) ? 'Venció ' + txt : 'Hasta ' + txt;
  }

  function updateCouponKPIs() {
    const activos = coupons.filter(c => !isExpired(c) && !isFull(c)).length;
    const usos = coupons.reduce((a,c) => a + (Number(c.used)||0), 0);
    const descuento = coupons.reduce((a,c) => a + (Number(c.discount)||0), 0);
    const set = (id,v) => { const el = document.getElementById(id); if(el) el.textContent = v; };
    set('cup-activos', activos);
    set('cup-usos', usos);
    set('cup-descuento', descuento >= 1000 ? '$' + Math.round(descuento/1000) + 'K' : '$' + descuento);
    set('cup-total', coupons.length);
  }

  function render() {
    const list = document.getElementById('couponsList');
    if (!list) return;
    updateCouponKPIs();

    if (coupons.length === 0) {
      list.innerHTML = `<div style="text-align:center; padding:40px 20px; color:#9CA3AF;">
        <i class="ti ti-discount-off" style="font-size:36px;"></i>
        <p style="margin-top:10px;">Aún no tienes cupones. Crea el primero para tus promociones.</p>
      </div>`;
      return;
    }

    list.innerHTML = coupons.map(c => {
      const expired = isExpired(c);
      const full = isFull(c);
      const inactive = expired || full;
      let badge, badgeText;
      if (expired) { badge = 'badge-red'; badgeText = 'Vencido'; }
      else if (full) { badge = 'badge-red'; badgeText = 'Agotado'; }
      else { badge = 'badge-green'; badgeText = 'Activo'; }

      let usageHtml = '';
      if (c.max != null) {
        const pct = Math.min(100, Math.round((c.used / c.max) * 100));
        const fillCls = pct >= 100 ? 'full' : (pct >= 80 ? 'high' : '');
        usageHtml = `
          <div class="coupon-usage">
            <div class="coupon-usage-bar"><div class="coupon-usage-fill ${fillCls}" style="width:${pct}%;"></div></div>
            <div class="coupon-usage-text">
              <span>${c.used} de ${c.max} usos</span>
              <span class="${full ? 'agotado' : ''}">${full ? '¡Agotado!' : (c.max - c.used) + ' disponibles'}</span>
            </div>
          </div>`;
      } else {
        usageHtml = `
          <div class="coupon-usage">
            <div class="coupon-usage-text"><span>${c.used} usos · sin límite</span><span>∞ disponibles</span></div>
          </div>`;
      }

      return `
        <div class="coupon-card" ${inactive ? 'style="opacity:0.6;"' : ''}>
          <div class="coupon-info">
            <div class="flex" style="align-items: center; gap: 12px; margin-bottom: 4px;">
              <span class="coupon-code">${c.code}</span>
              <span class="badge ${badge}">${badgeText}</span>
            </div>
            <p>${c.desc} · ${fmtDiscountLabel(c)} · ${fmtExpiryLabel(c)}</p>
            ${usageHtml}
          </div>
          <div class="coupon-stat"><strong>${c.used}</strong>Usos</div>
          <div class="coupon-stat"><strong>${fmtMoney(c.discount || 0)}</strong>Descuento</div>
          <div class="coupon-stat"><strong>${c.max != null ? c.max : '∞'}</strong>Máximo</div>
          <div class="flex gap-1">
            <button class="btn btn-outline btn-sm" onclick="editCoupon('${c.id}')" title="Editar"><i class="ti ti-edit"></i></button>
            <button class="btn btn-outline btn-sm" onclick="copyCoupon('${c.id}')" title="Copiar código"><i class="ti ti-copy"></i></button>
          </div>
        </div>`;
    }).join('');
  }

  window.openCouponModal = function() {
    document.getElementById('couponEditId').value = '';
    document.getElementById('couponModalTitle').textContent = 'Crear nuevo cupón';
    document.getElementById('couponSaveBtn').textContent = 'Crear cupón';
    document.getElementById('couponCode').value = '';
    document.getElementById('couponType').value = 'pct';
    document.getElementById('couponValue').value = '';
    document.getElementById('couponMax').value = '';
    document.getElementById('couponExpiry').value = '';
    document.getElementById('couponDesc').value = '';
    document.getElementById('modal').classList.add('show');
  };

  window.editCoupon = function(id) {
    const c = coupons.find(x => x.id === id);
    if (!c) return;
    document.getElementById('couponEditId').value = c.id;
    document.getElementById('couponModalTitle').textContent = 'Editar cupón';
    document.getElementById('couponSaveBtn').textContent = 'Guardar cambios';
    document.getElementById('couponCode').value = c.code;
    document.getElementById('couponType').value = c.type;
    document.getElementById('couponValue').value = c.value;
    document.getElementById('couponMax').value = c.max != null ? c.max : '';
    document.getElementById('couponExpiry').value = c.expiry || '';
    document.getElementById('couponDesc').value = c.desc || '';
    document.getElementById('modal').classList.add('show');
  };

  window.closeCouponModal = function() {
    document.getElementById('modal').classList.remove('show');
  };

  window.saveCoupon = function() {
    const editId = document.getElementById('couponEditId').value;
    const code = document.getElementById('couponCode').value.trim().toUpperCase();
    const type = document.getElementById('couponType').value;
    const value = parseInt(document.getElementById('couponValue').value, 10);
    const maxRaw = document.getElementById('couponMax').value.trim();
    const max = maxRaw === '' ? null : parseInt(maxRaw, 10);
    const expiry = document.getElementById('couponExpiry').value || null;
    const desc = document.getElementById('couponDesc').value.trim() || 'Cupón de descuento';

    if (!code || code.length < 3) { if (window.toast) toast('El código debe tener al menos 3 caracteres', 'error'); return; }
    if (!value || value <= 0) { if (window.toast) toast('Ingresa un valor de descuento válido', 'error'); return; }

    if (editId) {
      const c = coupons.find(x => x.id === editId);
      if (c) {
        c.code = code; c.type = type; c.value = value; c.max = max; c.expiry = expiry; c.desc = desc;
      }
      if (window.toast) toast('Cupón actualizado', 'success');
    } else {
      if (coupons.some(x => x.code === code)) {
        if (window.toast) toast('Ya existe un cupón con ese código', 'error');
        return;
      }
      coupons.unshift({
        id: 'c' + Date.now(),
        code, type, value, max, used: 0, discount: 0, expiry, desc
      });
      if (window.toast) toast('🎉 Cupón creado', 'success');
    }
    save();
    render();
    closeCouponModal();
  };

  window.copyCoupon = function(id) {
    const c = coupons.find(x => x.id === id);
    if (!c) return;
    try {
      if (navigator.clipboard) navigator.clipboard.writeText(c.code);
    } catch(_) {}
    if (window.toast) toast('Código ' + c.code + ' copiado');
  };

  function init() { load(); render(); }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-descuentos', init);
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(init, 150));
  } else {
    setTimeout(init, 150);
  }
})();
</script>

<!-- ============================================================
     EVENTOS PÚBLICOS — Inyectar eventos creados por organizadores
     en "Explorar eventos" y "Eventos destacados", + carrusel rotativo.
     Los eventos creados (ms_org_events, estado publicado) se muestran
     junto a los de ejemplo, para que los corredores los vean.
     ============================================================ -->
<script>
(function(){
  // Mapea deporte → etiqueta y color del tag
  const SPORT_META = {
    running:  { label: 'RUNNING',  color: 'var(--purple-700)', cat: 'Running' },
    trail:    { label: 'TRAIL',    color: 'var(--purple-700)', cat: 'Trail' },
    futbol:   { label: 'FÚTBOL',   color: 'var(--amber-700)',  cat: 'Fútbol' },
    basquet:  { label: 'BÁSQUET',  color: 'var(--amber-700)',  cat: 'Básquet' },
    ciclismo: { label: 'CICLISMO', color: 'var(--purple-700)', cat: 'Ciclismo' },
    mtb:      { label: 'CICLISMO', color: 'var(--purple-700)', cat: 'MTB' },
    natacion: { label: 'NATACIÓN', color: 'var(--purple-700)', cat: 'Natación' },
    outdoor:  { label: 'OUTDOOR',  color: 'var(--amber-700)',  cat: 'Outdoor' },
    fitness:  { label: 'FITNESS',  color: 'var(--purple-700)', cat: 'Fitness' }
  };

  // IDs de eventos de ejemplo/demo que NO deben contar como "creados por el usuario"
  const DEMO_EVENT_IDS = new Set(['rally-purranque','liga-osorno','torneo-3x3','trail-llanquihue','mtb-puyehue','crossfit-bicentenario']);

  function getCreatedEvents() {
    try {
      const list = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
      const deleted = new Set(JSON.parse(localStorage.getItem('ms_deleted_events') || '[]'));
      // Mostrar publicados/activos, no borradores, no eliminados, no eventos demo
      return list.filter(e => {
        if (deleted.has(e.id)) return false;
        if (DEMO_EVENT_IDS.has(e.id)) return false; // excluir los de ejemplo
        const estado = (e.estado || '').toLowerCase();
        const label = (e.estadoLabel || '').toLowerCase();
        if (estado === 'borrador' || label === 'borrador') return false;
        return estado === 'publicado' || estado === 'activo' || label === 'activo' || label === 'publicado' || (!estado && !label);
      });
    } catch(_) { return []; }
  }

  function priceLabel(ev) {
    const m = ev._meta || {};
    if (Array.isArray(m.tickets) && m.tickets.length) {
      const precios = m.tickets.map(t => t.precio).filter(p => p != null && !isNaN(p));
      if (precios.length) {
        const min = Math.min(...precios);
        if (min === 0) return 'Gratis';
        return 'Desde $' + min.toLocaleString('es-CL');
      }
    }
    return 'Por confirmar';
  }

  function metaFor(ev) {
    const m = ev._meta || {};
    const sport = (m.deporte || '').toLowerCase();
    return SPORT_META[sport] || { label: (m.deporte || 'EVENTO').toUpperCase(), color: 'var(--purple-700)', cat: m.deporte || 'Evento' };
  }

  function lugarCorto(ev) {
    const m = ev._meta || {};
    return (m.lugar || '').split(',')[0] || 'Por confirmar';
  }

  function fechaCorta(ev) {
    return ev.fecha || (ev._meta && ev._meta.fechaISO) || 'Por confirmar';
  }

  // Card para la lista "Explorar eventos" (.ev-card)
  function cardExplore(ev) {
    const meta = metaFor(ev);
    const cover = ev._meta && ev._meta.imagen;
    const imgHtml = cover
      ? `<div class="ev-img" style="background-image:url('${cover}'); background-size:cover; background-position:center;"><div class="ev-img-overlay"></div><span class="ev-tag" style="color:${meta.color};">${meta.label}</span><span class="ev-badge">Nuevo</span></div>`
      : `<div class="ev-img" style="background:linear-gradient(135deg,#17BDB5,#0B8B84);"><div class="ev-img-overlay"></div><span class="ev-tag" style="color:${meta.color};">${meta.label}</span><span class="ev-badge">Nuevo</span></div>`;
    return `
      <a href="#/evento" class="ev-card" data-event-id="${ev.id}" data-created="1">
        ${imgHtml}
        <div class="ev-body">
          <div class="ev-cat-line">${meta.cat} · ${lugarCorto(ev)}</div>
          <div class="ev-title">${ev.nombre}</div>
          <div class="ev-meta"><i class="ti ti-calendar" style="font-size:12px;"></i> ${fechaCorta(ev)}</div>
          <div class="ev-meta"><i class="ti ti-map-pin" style="font-size:12px;"></i> ${lugarCorto(ev)}</div>
          <div class="ev-price-row">
            <div class="ev-price">${priceLabel(ev)}</div>
            <i class="ti ti-arrow-right" style="color: var(--purple-700);"></i>
          </div>
        </div>
      </a>`;
  }

  // Card para "Eventos destacados" del inicio (.event-card)
  function cardFeatured(ev) {
    const meta = metaFor(ev);
    const cover = ev._meta && ev._meta.imagen;
    const imgHtml = cover
      ? `<div class="event-img" style="background-image:url('${cover}'); background-size:cover; background-position:center;"><div class="event-img-overlay"></div><span class="event-tag" style="color:${meta.color};">${meta.label}</span><span class="event-progress">Nuevo</span></div>`
      : `<div class="event-img" style="background:linear-gradient(135deg,#17BDB5,#0B8B84);"><div class="event-img-overlay"></div><span class="event-tag" style="color:${meta.color};">${meta.label}</span><span class="event-progress">Nuevo</span></div>`;
    const precio = priceLabel(ev).replace('Desde ', '');
    return `
      <a href="#/evento" class="event-card" data-event-id="${ev.id}" data-created="1">
        ${imgHtml}
        <div class="event-body">
          <div class="event-title">${ev.nombre}</div>
          <div class="event-meta"><i class="ti ti-calendar" style="font-size:12px;"></i> ${fechaCorta(ev)}</div>
          <div class="event-meta"><i class="ti ti-map-pin" style="font-size:12px;"></i> ${ev._meta && ev._meta.lugar || lugarCorto(ev)}</div>
          <div class="event-footer">
            <div>
              <div class="event-price-label">Desde</div>
              <div class="event-price">${precio}</div>
            </div>
            <span class="btn btn-primary btn-sm">Inscribirse</span>
          </div>
        </div>
      </a>`;
  }

  // Inyectar en la lista de "Explorar eventos"
  function injectExplore() {
    const explorePage = document.querySelector('section.spa-page[data-route="/eventos"]');
    if (!explorePage) return;
    const list = explorePage.querySelector('#explore-events-grid') || explorePage.querySelector('.events-list');
    if (!list) return;
    // Quitar inyecciones previas para no duplicar
    list.querySelectorAll('[data-created="1"]').forEach(el => el.remove());
    const created = getCreatedEvents();

    const emptyState = explorePage.querySelector('#explore-empty');
    const counter = explorePage.querySelector('#explore-count');
    const cargarMas = explorePage.querySelector('.text-center.mt-6');

    if (created.length > 0) {
      const html = created.map(cardExplore).join('');
      list.insertAdjacentHTML('afterbegin', html);
      list.style.display = '';
      if (emptyState) emptyState.style.display = 'none';
    } else {
      list.style.display = 'none';
      if (emptyState) emptyState.style.display = 'block';
    }
    // Contador real
    if (counter) counter.textContent = created.length + (created.length === 1 ? ' evento encontrado' : ' eventos encontrados');
    // Ocultar "Cargar más" (no hay paginación real en el prototipo)
    if (cargarMas) cargarMas.style.display = 'none';
  }

  // Inyectar en "Eventos destacados" del inicio
  function injectFeatured() {
    const homePage = document.querySelector('section.spa-page[data-route="/"]');
    if (!homePage) return;
    const grid = homePage.querySelector('#featured-grid') || homePage.querySelector('.events-grid');
    if (!grid) return;
    const emptyState = homePage.querySelector('#featured-empty');

    // Quitar inyecciones previas
    grid.querySelectorAll('[data-created="1"]').forEach(el => el.remove());

    const created = getCreatedEvents();

    if (created.length > 0) {
      // Hay eventos reales: mostrarlos, ocultar el mensaje vacío
      const html = created.map(cardFeatured).join('');
      grid.insertAdjacentHTML('afterbegin', html);
      grid.style.display = '';
      if (emptyState) emptyState.style.display = 'none';
    } else {
      // No hay eventos publicados. ¿Hay borradores?
      grid.style.display = 'none';
      if (emptyState) {
        emptyState.style.display = 'block';
        // Detectar si tiene borradores para dar un mensaje más útil
        let hayBorradores = false;
        try {
          const all = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
          const deleted = new Set(JSON.parse(localStorage.getItem('ms_deleted_events') || '[]'));
          hayBorradores = all.some(e => {
            if (deleted.has(e.id) || DEMO_EVENT_IDS.has(e.id)) return false;
            const est = (e.estado || '').toLowerCase();
            const lbl = (e.estadoLabel || '').toLowerCase();
            return est === 'borrador' || lbl === 'borrador';
          });
        } catch(_) {}
        const titleEl = emptyState.querySelector('h3');
        const pEl = emptyState.querySelector('p');
        const btnEl = emptyState.querySelector('a.btn');
        if (hayBorradores) {
          if (titleEl) titleEl.textContent = 'Tienes un evento sin publicar';
          if (pEl) pEl.textContent = 'Tu evento está guardado como borrador. Publícalo para que aparezca aquí y la gente se pueda inscribir.';
          if (btnEl) { btnEl.textContent = 'Ir a Mis eventos'; btnEl.setAttribute('href', '#/organizador/mis-eventos'); }
        } else {
          if (titleEl) titleEl.textContent = 'Aún no hay eventos publicados';
          if (pEl) pEl.textContent = 'Sé el primero en crear un evento deportivo. Aparecerá aquí para que la gente se inscriba.';
          if (btnEl) { btnEl.textContent = 'Crear mi evento'; btnEl.setAttribute('href', '#/organizador/crear-evento'); }
        }
      }
    }
  }

  // ====== CARRUSEL de eventos destacados ======
  let carouselTimer = null;
  function startCarousel() {
    const homePage = document.querySelector('section.spa-page[data-route="/"]');
    if (!homePage) return;
    const grid = homePage.querySelector('.events-grid');
    if (!grid) return;
    // Solo las cards de eventos reales (creadas), que son las visibles
    const cards = Array.from(grid.querySelectorAll('.event-card[data-created="1"]'));
    if (cards.length <= 3) return; // no rotar si hay 3 o menos

    stopCarousel();
    let offset = 0;
    // Mostrar de a 3, rotando cada 4 segundos
    function showWindow() {
      cards.forEach((c, i) => {
        const visible = i >= offset && i < offset + 3;
        c.style.display = visible ? '' : 'none';
      });
    }
    showWindow();
    carouselTimer = setInterval(() => {
      offset = (offset + 3) % cards.length;
      if (offset + 3 > cards.length) offset = 0; // volver al inicio si no completa 3
      showWindow();
    }, 4000);
  }
  function stopCarousel() {
    if (carouselTimer) { clearInterval(carouselTimer); carouselTimer = null; }
  }

  // Inicializar en cada página
  // Actualizar contadores de eventos por deporte con datos reales
  function updateSportCounts() {
    const created = getCreatedEvents();
    // Contar por deporte
    const counts = {};
    created.forEach(e => {
      const sp = ((e._meta && e._meta.deporte) || '').toLowerCase();
      // mapear mtb/trail a su categoría madre
      let key = sp;
      if (sp === 'mtb') key = 'ciclismo';
      if (sp === 'trail') key = 'running';
      if (key) counts[key] = (counts[key] || 0) + 1;
    });
    // Actualizar cada tarjeta de deporte
    document.querySelectorAll('[data-sport-count]').forEach(el => {
      const sport = el.getAttribute('data-sport-count');
      const n = counts[sport] || 0;
      el.textContent = n + (n === 1 ? ' evento →' : ' eventos →');
    });
    // Total de eventos activos (hero + explorar)
    const total = created.length;
    const heroCount = document.getElementById('hero-eventos-count');
    if (heroCount) heroCount.textContent = total;
    const exploreCount = document.getElementById('explore-eventos-count');
    if (exploreCount) exploreCount.textContent = total;
    // Tickets vendidos reales (inscripciones de eventos reales)
    const heroTickets = document.getElementById('hero-tickets-count');
    if (heroTickets) {
      let ins = [];
      try { ins = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
      const ids = new Set(created.map(e => e.id));
      const vendidos = ins.filter(i => i && ids.has(i.eventId)).length;
      heroTickets.textContent = vendidos.toLocaleString('es-CL');
    }
  }

  function initHome() { try { injectFeatured(); startCarousel(); updateSportCounts(); } catch(e){ console.warn('initHome', e); } }
  function initExplore() { try { injectExplore(); updateSportCounts(); } catch(e){ console.warn('initExplore', e); } }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-index', initHome);
    MatchSPA.onPageInit('page-eventos', initExplore);
  }

  // Fallback robusto: re-inyectar según la ruta en cada cambio de hash.
  // (No depende solo de onPageInit, por si el orden de carga varía.)
  function routeInject() {
    const h = (location.hash || '#/').split('?')[0];
    if (h === '#/' || h === '#' || h === '') {
      setTimeout(initHome, 60);
    } else if (h === '#/eventos') {
      setTimeout(initExplore, 60);
      stopCarousel();
    } else {
      stopCarousel();
    }
  }
  window.addEventListener('hashchange', routeInject);

  // Re-render cuando llegan los datos reales sincronizados desde la API.
  document.addEventListener('ms:events-synced', function(){ setTimeout(routeInject, 30); });
  document.addEventListener('ms:registrations-synced', function(){ setTimeout(routeInject, 30); });

  // Primer render
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(routeInject, 200));
  } else {
    setTimeout(routeInject, 200);
  }
})();
</script>

<!-- ============================================================
     CHECKOUT — Cálculo automático de categoría por edad + sexo
     y mostrar/ocultar el campo de enfermedad crónica.
     ============================================================ -->
<script>
(function(){
  const RANGOS = [
    { min: 0,  max: 17, nombre: 'Sub-18' },
    { min: 18, max: 22, nombre: 'Sub-23' },
    { min: 23, max: 39, nombre: 'Open' },
    { min: 40, max: 49, nombre: 'Master 40+' },
    { min: 50, max: 59, nombre: 'Master 50+' },
    { min: 60, max: 120, nombre: 'Master 60+' }
  ];

  function calcEdad(fechaNac, fechaEvento) {
    const nac = new Date(fechaNac);
    const ev = fechaEvento ? new Date(fechaEvento) : new Date();
    if (isNaN(nac.getTime())) return null;
    let edad = ev.getFullYear() - nac.getFullYear();
    const m = ev.getMonth() - nac.getMonth();
    if (m < 0 || (m === 0 && ev.getDate() < nac.getDate())) edad--;
    return edad;
  }

  function categoriaPara(edad, sexo) {
    if (edad == null || edad < 0) return null;
    const rango = RANGOS.find(r => edad >= r.min && edad <= r.max);
    if (!rango) return null;
    const sufijoSexo = sexo === 'masculino' ? 'Masculino' : (sexo === 'femenino' ? 'Femenino' : 'Mixto');
    return rango.nombre + ' · ' + sufijoSexo;
  }

  function updateCategoria() {
    const fnacEl = document.getElementById('ck-fnac');
    const sexoEl = document.getElementById('ck-sexo');
    const box = document.getElementById('ck-categoria-box');
    const txt = document.getElementById('ck-categoria-text');
    if (!fnacEl || !sexoEl || !box || !txt) return;

    const fnac = fnacEl.value;
    const sexo = sexoEl.value;
    if (!fnac || !sexo) {
      box.classList.remove('resolved');
      txt.textContent = 'Ingresa tu fecha de nacimiento y sexo para ver tu categoría';
      return;
    }
    const edad = calcEdad(fnac);
    const cat = categoriaPara(edad, sexo);
    if (cat) {
      box.classList.add('resolved');
      txt.textContent = cat + '  (' + edad + ' años)';
    } else {
      box.classList.remove('resolved');
      txt.textContent = 'No pudimos calcular tu categoría, revisa la fecha';
    }
  }
  window.__updateCategoria = updateCategoria; // exponer para tests

  function loadCheckoutSelection() {
    let sel = null;
    try { sel = JSON.parse(localStorage.getItem('ms_checkout_selection') || 'null'); } catch(_) {}
    if (!sel) return;

    // Nombre del evento
    const evEl = document.getElementById('ck-resumen-evento');
    if (evEl && sel.eventName) evEl.textContent = sel.eventName;

    // Items
    const itemsEl = document.getElementById('ck-resumen-items');
    const totalEl = document.getElementById('ck-resumen-total');
    if (itemsEl && Array.isArray(sel.items) && sel.items.length) {
      let subtotal = 0, totalFees = 0;
      let rows = sel.items.map(it => {
        const sub = it.precio * it.cantidad;
        const feeSub = (it.fee || 0) * it.cantidad;
        subtotal += sub; totalFees += feeSub;
        const precioLabel = it.precio === 0 ? 'Gratis' : '$' + sub.toLocaleString('es-CL');
        return `<div class="summary-row"><span>${it.nombre} × ${it.cantidad}</span><span>${precioLabel}</span></div>`;
      }).join('');
      // Fila de comisión (sumada, como Welcu)
      if (totalFees > 0) {
        rows += `<div class="summary-row"><span class="muted">Comisión Match Sport (7%)</span><span class="muted">$${totalFees.toLocaleString('es-CL')}</span></div>`;
      }
      // Descuento promocional
      let descuento = 0;
      if (sel.promo && sel.promo.descuento) {
        descuento = sel.promo.descuento;
        rows += `<div class="summary-row" style="color:var(--green-600);"><span>Descuento (${sel.promo.code})</span><span>−$${descuento.toLocaleString('es-CL')}</span></div>`;
      }
      itemsEl.innerHTML = rows;
      const total = Math.max(0, subtotal + totalFees - descuento);
      const totalLabel = total === 0 ? 'Gratis' : '$' + total.toLocaleString('es-CL');
      if (totalEl) totalEl.textContent = totalLabel;
      const btn = document.querySelector('#page-checkout button[onclick*="completarCompra"]');
      if (btn) {
        btn.innerHTML = total === 0
          ? '<i class="ti ti-check" style="font-size: 17px;"></i> Confirmar inscripción gratuita'
          : '<i class="ti ti-lock" style="font-size: 17px;"></i> Pagar ' + totalLabel + ' de forma segura';
      }
    }
  }

  function bindCheckout() {
    loadCheckoutSelection();

    // Validación: confirmar email coincide
    const emailEl = document.getElementById('ck-email');
    const emailConfEl = document.getElementById('ck-email-confirm');
    const emailErr = document.getElementById('ck-email-error');
    function checkEmails() {
      if (!emailConfEl || !emailErr) return;
      const a = (emailEl && emailEl.value || '').trim().toLowerCase();
      const b = (emailConfEl.value || '').trim().toLowerCase();
      if (b && a !== b) emailErr.style.display = 'block';
      else emailErr.style.display = 'none';
    }
    if (emailConfEl && !emailConfEl.dataset.bound) {
      emailConfEl.dataset.bound = '1';
      emailConfEl.addEventListener('input', checkEmails);
      if (emailEl) emailEl.addEventListener('input', checkEmails);
    }

    const fnacEl = document.getElementById('ck-fnac');
    const sexoEl = document.getElementById('ck-sexo');
    if (fnacEl && !fnacEl.dataset.bound) {
      fnacEl.dataset.bound = '1';
      fnacEl.addEventListener('change', updateCategoria);
      fnacEl.addEventListener('input', updateCategoria);
    }
    if (sexoEl && !sexoEl.dataset.bound) {
      sexoEl.dataset.bound = '1';
      sexoEl.addEventListener('change', updateCategoria);
    }
    const cronicaSel = document.getElementById('ck-cronica-sel');
    const cronicaWrap = document.getElementById('ck-cronica-detalle-wrap');
    if (cronicaSel && cronicaWrap && !cronicaSel.dataset.bound) {
      cronicaSel.dataset.bound = '1';
      cronicaSel.addEventListener('change', () => {
        cronicaWrap.style.display = cronicaSel.value === 'si' ? 'block' : 'none';
      });
    }

    // Toggle del detalle de medicamentos
    const medSel = document.getElementById('ck-medicamentos-sel');
    const medWrap = document.getElementById('ck-medicamentos-detalle-wrap');
    if (medSel && medWrap && !medSel.dataset.bound) {
      medSel.dataset.bound = '1';
      medSel.addEventListener('change', () => {
        medWrap.style.display = medSel.value === 'si' ? 'block' : 'none';
      });
    }

    // Ocultar el campo "Talla de polera" si el evento NO incluye polera
    try {
      const sel = JSON.parse(localStorage.getItem('ms_checkout_selection') || 'null');
      const tallaGroup = document.getElementById('ck-talla-group');
      let incluyePolera = true;
      if (sel && sel.eventId) {
        const evs = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
        const ev = evs.find(e => e.id === sel.eventId);
        if (ev && ev._meta && ev._meta.incluyePolera === false) incluyePolera = false;
      }
      if (tallaGroup) {
        tallaGroup.style.display = incluyePolera ? '' : 'none';
        const tallaInput = document.getElementById('ck-talla');
        if (tallaInput) tallaInput.dataset.requerido = incluyePolera ? '1' : '0';
      }
    } catch(_) {}
  }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-checkout', () => setTimeout(bindCheckout, 50));
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(bindCheckout, 200));
  } else {
    setTimeout(bindCheckout, 200);
  }
})();
</script>

<!-- ============================================================
     TICKET — llenar con datos reales de la inscripción +
     vista previa del correo de confirmación
     ============================================================ -->
<script>
(function(){
  function fmtMoney(n) {
    if (!n || n === 0) return 'Gratis';
    return '$' + Number(n).toLocaleString('es-CL');
  }

  function fillTicket() {
    let insc = null;
    try { insc = JSON.parse(localStorage.getItem('ms_last_inscripcion') || 'null'); } catch(_) {}
    if (!insc) return; // dejar los datos de ejemplo

    const set = (id, val) => { const el = document.getElementById(id); if (el && val) el.textContent = val; };
    set('tk-email', insc.email);
    set('tk-evento', insc.evento);
    set('tk-asistente', insc.asistente);
    set('tk-ticket', insc.ticket);
    set('tk-categoria', insc.categoria);
    set('tk-orden', insc.orden);
  }

  // Vista previa del correo de confirmación
  window.verCorreoConfirmacion = function() {
    let insc = null;
    try { insc = JSON.parse(localStorage.getItem('ms_last_inscripcion') || 'null'); } catch(_) {}
    insc = insc || { evento:'Rally Costero Purranque RCP 2027', asistente:'Cristian Almuna', email:'calmuna1979@gmail.com', ticket:'General 8 km', categoria:'Open · Mixto', orden:'MS-RCP2027', total:15000 };

    let modal = document.getElementById('correo-preview');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'correo-preview';
      document.body.appendChild(modal);
      modal.addEventListener('click', (e) => { if (e.target.id === 'correo-preview') modal.classList.remove('show'); });
    }
    let itemsRows = '';
    if (Array.isArray(insc.items) && insc.items.length) {
      itemsRows = insc.items.map(it =>
        `<div class="row"><span class="k">${it.nombre} × ${it.cantidad}</span><span class="v">${fmtMoney((it.precio + (it.fee||0)) * it.cantidad)}</span></div>`
      ).join('');
    } else {
      itemsRows = `<div class="row"><span class="k">${insc.ticket}</span><span class="v">${fmtMoney(insc.total)}</span></div>`;
    }

    modal.innerHTML = `
      <div class="correo-card">
        <div class="correo-toolbar">
          <span><i class="ti ti-mail"></i> Vista previa del correo</span>
          <button onclick="document.getElementById('correo-preview').classList.remove('show')">×</button>
        </div>
        <div class="correo-header">
          <div class="logo">MATCH SPORT</div>
          <h2>¡Inscripción confirmada! 🎉</h2>
        </div>
        <div class="correo-body">
          <p class="saludo">Hola ${insc.asistente},</p>
          <p>Tu inscripción al evento <strong>${insc.evento}</strong> fue confirmada con éxito. Aquí está el resumen:</p>
          <div class="correo-detalle">
            <div class="row"><span class="k">N° de orden</span><span class="v">${insc.orden}</span></div>
            <div class="row"><span class="k">Categoría</span><span class="v">${insc.categoria}</span></div>
            ${itemsRows}
            <div class="row" style="border-top:1px solid #D0FAF7; margin-top:6px; padding-top:10px;"><span class="k"><strong>Total pagado</strong></span><span class="v" style="color:#0B8B84;">${fmtMoney(insc.total)}</span></div>
          </div>
          <p>Presenta el código QR de tu ticket el día del evento. Lo encuentras en este enlace o adjunto a este correo.</p>
          <p style="margin-top:16px;">¡Nos vemos en la partida! 🏃</p>
        </div>
        <div class="correo-footer">
          Este correo fue enviado por Match Sport · match-sport.com<br>
          Si tienes dudas, responde a este correo o escríbenos por WhatsApp.
        </div>
      </div>`;
    modal.classList.add('show');
  };

  // "Descargar PDF" — en el prototipo, simula la descarga
  window.descargarTicketPDF = function() {
    if (window.toast) toast('Generando PDF del ticket...', 'success');
    setTimeout(() => { if (window.toast) toast('En producción, aquí se descarga el PDF del ticket', 'success'); }, 1200);
  };

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-ticket', () => setTimeout(fillTicket, 60));
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(fillTicket, 200));
  } else {
    setTimeout(fillTicket, 200);
  }
})();
</script>

<!-- ============================================================
     ASISTENTES — listado real de inscritos del evento gestionado
     + navegación desde Mis eventos a la gestión del evento
     ============================================================ -->
<script>
(function(){
  function fmtMoneyShort(n) {
    if (!n) return '$0';
    if (n >= 1000000) return '$' + (n/1000000).toFixed(1).replace('.0','') + 'M';
    if (n >= 1000) return '$' + Math.round(n/1000) + 'K';
    return '$' + n.toLocaleString('es-CL');
  }
  function esc(s){ return (s==null?'':String(s)).replace(/[<>&"]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])); }
  function iniciales(nombre){
    const parts = (nombre||'').trim().split(/\s+/);
    return ((parts[0]||'')[0]||'' ) + ((parts[1]||'')[0]||'');
  }

  // Navegar a la gestión del evento (Asistentes filtrado por ese evento)
  window.verGestionEvento = function(eventId) {
    try { localStorage.setItem('ms_evento_gestion', eventId); } catch(_) {}
    if (window.MatchSPA) MatchSPA.navigate('/organizador/asistentes');
    else location.hash = '#/organizador/asistentes';
  };

  function getEventoGestion() {
    let id = null;
    try { id = localStorage.getItem('ms_evento_gestion'); } catch(_) {}
    let evs = [];
    try { evs = JSON.parse(localStorage.getItem('ms_org_events') || '[]'); } catch(_) {}
    // Si no hay uno marcado, usar el primer evento real publicado
    let ev = id ? evs.find(e => e.id === id) : null;
    if (!ev) ev = evs.find(e => (e.estado||'').toLowerCase() === 'activo') || evs[0];
    return ev || null;
  }

  function renderAsistentes() {
    const ev = getEventoGestion();
    const subtitle = document.getElementById('asist-subtitle');
    const tbody = document.getElementById('asist-tbody');
    const empty = document.getElementById('asist-empty');
    if (!tbody) return;

    let inscripciones = [];
    try { inscripciones = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
    const delEvento = ev ? inscripciones.filter(i => i && i.eventId === ev.id) : [];

    // Métricas
    const total = delEvento.length;
    const recaudado = delEvento.reduce((a,i)=>a+(Number(i.total)||0),0);
    const checkins = delEvento.filter(i => i.checkin).length;
    const setT = (id,v) => { const e=document.getElementById(id); if(e) e.textContent = v; };
    setT('asist-total', total);
    setT('asist-fichas', total); // todas las inscripciones reales tienen ficha completa (validación obligatoria)
    const pctEl = document.getElementById('asist-fichas-pct');
    if (pctEl) pctEl.textContent = total ? '100% del total' : '—';
    setT('asist-recaudado', fmtMoneyShort(recaudado));
    setT('asist-checkin', checkins);
    if (subtitle) subtitle.textContent = (ev ? ev.nombre : 'Sin evento seleccionado') + ' — ' + total + ' inscrito' + (total===1?'':'s');

    // Tabla
    if (!total) {
      tbody.innerHTML = '';
      if (empty) empty.style.display = 'block';
      return;
    }
    if (empty) empty.style.display = 'none';
    const colores = ['var(--purple-700)','var(--amber-600)','var(--blue-700)','var(--green-600)','var(--purple-500)'];
    tbody.innerHTML = delEvento.map((i, idx) => `
      <tr>
        <td>
          <span class="avatar avatar-sm" style="background: ${colores[idx % colores.length]}; margin-right: 8px; vertical-align: middle;">${esc(iniciales(i.asistente).toUpperCase())}</span>
          <span style="font-weight: 500;">${esc(i.asistente || '—')}</span>
          <div class="small muted" style="margin-left: 36px;">${esc(i.email || '')}</div>
        </td>
        <td>${esc(i.distancia || i.ticket || '—')}</td>
        <td>${esc(i.categoria || '—')}</td>
        <td>${esc(i.ciudad || '—')}</td>
        <td>${esc(i.club || '—')}</td>
        <td><span class="status-pill s-ok"><i class="ti ti-check" style="font-size: 10px;"></i> Pagado</span></td>
      </tr>
    `).join('');

    // Búsqueda
    const search = document.getElementById('asist-search');
    if (search && !search.dataset.bound) {
      search.dataset.bound = '1';
      search.addEventListener('input', () => {
        const q = search.value.toLowerCase();
        tbody.querySelectorAll('tr').forEach(tr => {
          tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
      });
    }
  }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-asistentes', renderAsistentes);
  }
})();
</script>

<!-- ============================================================
     DASHBOARD ORGANIZADOR — datos reales (sin eventos de ejemplo)
     ============================================================ -->
<script>
(function(){
  const DEMO_IDS = ['rally-purranque','liga-osorno','torneo-3x3','trail-llanquihue','mtb-puyehue','crossfit-bicentenario','maraton-osorno','maraton-osorno-2026'];
  function fmtMoneyShort(n) {
    if (!n) return '$0';
    if (n >= 1000000) return '$' + (n/1000000).toFixed(1).replace('.0','') + 'M';
    if (n >= 1000) return '$' + Math.round(n/1000) + 'K';
    return '$' + n.toLocaleString('es-CL');
  }
  function esc(s){ return (s==null?'':String(s)).replace(/[<>&"]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])); }

  function eventosReales() {
    let evs = [];
    try { evs = JSON.parse(localStorage.getItem('ms_org_events') || '[]'); } catch(_) {}
    let deleted = new Set();
    try { deleted = new Set(JSON.parse(localStorage.getItem('ms_deleted_events') || '[]')); } catch(_) {}
    return evs.filter(e => {
      if (!e || deleted.has(e.id)) return false;
      if (DEMO_IDS.includes(e.id)) return false;
      // Un evento real fue creado por el wizard (tiene createdAt en _meta)
      // Los eventos demo no tienen ese marcador
      if (e._meta && e._meta.createdAt) return true;
      // Si no tiene el marcador pero tampoco es un demo conocido, incluirlo (compatibilidad)
      return !DEMO_IDS.includes(e.id) && !/^(rally-|liga-|torneo-|trail-|mtb-|crossfit-|maraton-)/.test(e.id || '');
    });
  }

  function inscripcionesDe(eventId) {
    let ins = [];
    try { ins = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
    return ins.filter(i => i && i.eventId === eventId);
  }

  function tiempoRelativo(ts) {
    if (!ts) return '';
    const diff = Date.now() - ts;
    const min = Math.floor(diff/60000);
    if (min < 1) return 'recién';
    if (min < 60) return 'hace ' + min + ' min';
    const h = Math.floor(min/60);
    if (h < 24) return 'hace ' + h + ' hora' + (h>1?'s':'');
    const d = Math.floor(h/24);
    return 'hace ' + d + ' día' + (d>1?'s':'');
  }

  function renderDashboard() {
    const eventos = eventosReales();

    // === Tabla "Todos mis eventos" ===
    const body = document.getElementById('dash-eventos-body');
    const emptyT = document.getElementById('dash-eventos-empty');
    if (body) {
      if (!eventos.length) {
        body.innerHTML = '';
        if (emptyT) emptyT.style.display = 'block';
      } else {
        if (emptyT) emptyT.style.display = 'none';
        body.innerHTML = eventos.map(e => {
          const ins = inscripcionesDe(e.id);
          const vendidos = ins.length;
          let stockTotal = 0;
          if (e._meta && Array.isArray(e._meta.tickets)) stockTotal = e._meta.tickets.reduce((a,t)=>a+(Number(t.stock)||0),0);
          const total = stockTotal || e.total || 100;
          const pct = total ? Math.round((vendidos/total)*100) : 0;
          const estado = (e.estado||'activo').toLowerCase();
          const pillClass = estado === 'borrador' ? 'pill-draft' : estado === 'finalizado' ? 'pill-done' : 'pill-active';
          const estadoLabel = e.estadoLabel || (estado==='borrador'?'Borrador':estado==='finalizado'?'Finalizado':'Activo');
          const sportName = (e._meta && e._meta.deporte) ? e._meta.deporte : (e.tipo || '');
          const accion = estado === 'borrador'
            ? `<a href="#/organizador/crear-evento" class="small" style="color: var(--purple-700); font-weight: 600;" onclick="event.preventDefault(); if(window.editEvent)editEvent('${e.id}');">Editar →</a>`
            : `<a href="#" class="small" style="color: var(--purple-700); font-weight: 600;" onclick="event.preventDefault(); if(window.verGestionEvento)verGestionEvento('${e.id}');">Ver →</a>`;
          return `
            <tr>
              <td>
                <div style="font-weight: 600; font-size: 13px;">${esc(e.nombre)}</div>
                <div class="small muted">${esc(sportName)}</div>
              </td>
              <td>${esc(e.fecha || '—')}</td>
              <td>
                <div style="font-size: 13px; font-weight: 600;">${vendidos} / ${total}</div>
                <div class="progress-bar-mini mt-1"><div class="progress-fill-mini" style="width: ${pct}%"></div></div>
              </td>
              <td><span class="pill-status ${pillClass}">${esc(estadoLabel)}</span></td>
              <td>${accion}</td>
            </tr>`;
        }).join('');
      }
    }

    // === Banner principal (primer evento activo real) ===
    const activo = eventos.find(e => (e.estado||'').toLowerCase() === 'activo') || eventos[0];
    if (activo) {
      const ins = inscripcionesDe(activo.id);
      const vendidos = ins.length;
      const recaudado = ins.reduce((a,i)=>a+(Number(i.total)||0),0);
      let stockTotal = 0;
      if (activo._meta && Array.isArray(activo._meta.tickets)) stockTotal = activo._meta.tickets.reduce((a,t)=>a+(Number(t.stock)||0),0);
      const total = stockTotal || activo.total || 100;
      const cupoRest = Math.max(0, total - vendidos);
      const set = (id,v)=>{ const el=document.getElementById(id); if(el) el.textContent=v; };
      set('dash-banner-title', activo.nombre);
      const meta = activo._meta || {};
      set('dash-banner-meta', (activo.fecha||'') + (meta.hora?' · '+meta.hora:'') + (meta.lugar?' · '+meta.lugar.split(',')[0]:''));
      set('dash-banner-vendidos', vendidos);
      set('dash-banner-recaudado', fmtMoneyShort(recaudado));
      set('dash-banner-cupo', cupoRest);
      set('dash-banner-cupo-sub', cupoRest + ' de ' + total + ' cupos');
    } else {
      const banner = document.getElementById('dash-banner');
      if (banner) banner.style.display = 'none';
    }

    // === Métricas globales ===
    let totalInscritos = 0, totalRecaudado = 0;
    eventos.forEach(e => {
      const ins = inscripcionesDe(e.id);
      totalInscritos += ins.length;
      totalRecaudado += ins.reduce((a,i)=>a+(Number(i.total)||0),0);
    });
    const setM = (id,v)=>{ const el=document.getElementById(id); if(el) el.textContent=v; };
    setM('dash-fichas', totalInscritos);
    setM('dash-fichas-total', totalInscritos);
    setM('dash-total-inscritos', totalInscritos);
    setM('dash-recaudado-total', fmtMoneyShort(totalRecaudado));

    // === Actividad reciente (inscripciones reales) ===
    const actCont = document.getElementById('dash-actividad');
    const actEmpty = document.getElementById('dash-actividad-empty');
    if (actCont) {
      let todas = [];
      try { todas = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
      // Solo de eventos reales del organizador
      const idsReales = new Set(eventos.map(e=>e.id));
      const recientes = todas.filter(i => idsReales.has(i.eventId)).slice(0, 6);
      if (!recientes.length) {
        actCont.innerHTML = '';
        if (actEmpty) actEmpty.style.display = 'block';
      } else {
        if (actEmpty) actEmpty.style.display = 'none';
        actCont.innerHTML = recientes.map(i => `
          <div class="activity-item">
            <div class="activity-icon"><i class="ti ti-ticket"></i></div>
            <div class="activity-text">
              <strong>Nueva inscripción</strong>
              ${esc(i.asistente || '')} · ${esc(i.evento || '')}
              <div class="time">${tiempoRelativo(i.fecha)}</div>
            </div>
          </div>
        `).join('');
      }
    }
  }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-dashboard', renderDashboard);
  }
})();
</script>

<!-- ============================================================
     CHECK-IN — acreditación por código de ticket (sin cámara)
     ============================================================ -->
<script>
(function(){
  function esc(s){ return (s==null?'':String(s)).replace(/[<>&"]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])); }

  function eventoCheckin() {
    let id = null;
    try { id = localStorage.getItem('ms_evento_gestion'); } catch(_) {}
    let evs = [];
    try { evs = JSON.parse(localStorage.getItem('ms_org_events') || '[]'); } catch(_) {}
    let ev = id ? evs.find(e => e.id === id) : null;
    if (!ev) ev = evs.find(e => (e.estado||'').toLowerCase() === 'activo') || evs[0];
    return ev || null;
  }

  function inscripcionesCheckin() {
    const ev = eventoCheckin();
    let ins = [];
    try { ins = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
    return ev ? ins.filter(i => i && i.eventId === ev.id) : [];
  }

  function guardarInscripciones(todas) {
    try { localStorage.setItem('ms_inscripciones', JSON.stringify(todas)); } catch(_) {}
  }

  // Marca a un corredor como acreditado por código de orden (MS-XXX)
  window.verificarCheckin = function() {
    const input = document.getElementById('ci-codigo');
    const resultado = document.getElementById('ci-resultado');
    if (!input || !resultado) return;
    const codigo = (input.value || '').trim().toUpperCase();
    if (!codigo) {
      resultado.innerHTML = '<div class="ci-msg ci-msg-warn">Ingresa un código de ticket</div>';
      return;
    }
    let todas = [];
    try { todas = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
    const ev = eventoCheckin();
    // Buscar por orden (acepta con o sin "MS-")
    const idx = todas.findIndex(i => {
      if (!i || (ev && i.eventId !== ev.id)) return false;
      const orden = (i.orden || '').toUpperCase();
      return orden === codigo || orden === 'MS-' + codigo || orden.replace('MS-','') === codigo.replace('MS-','');
    });
    if (idx === -1) {
      resultado.innerHTML = `<div class="ci-msg ci-msg-err"><i class="ti ti-x"></i> Código no encontrado en este evento</div>`;
      return;
    }
    if (todas[idx].checkin) {
      resultado.innerHTML = `<div class="ci-msg ci-msg-warn"><i class="ti ti-alert-triangle"></i> <strong>${esc(todas[idx].asistente)}</strong> ya estaba acreditado</div>`;
      input.value = '';
      return;
    }
    // Acreditar
    todas[idx].checkin = true;
    todas[idx].checkinAt = Date.now();
    guardarInscripciones(todas);
    resultado.innerHTML = `<div class="ci-msg ci-msg-ok"><i class="ti ti-check"></i> <strong>${esc(todas[idx].asistente)}</strong> acreditado correctamente</div>`;
    input.value = '';
    renderCheckin();
  };

  window.filtrarInscritosCheckin = function(q) {
    renderListaInscritos((q||'').toLowerCase());
  };

  function renderListaInscritos(filtro) {
    const cont = document.getElementById('ci-lista-inscritos');
    if (!cont) return;
    let ins = inscripcionesCheckin();
    if (filtro) ins = ins.filter(i => (i.asistente||'').toLowerCase().includes(filtro));
    if (!ins.length) {
      cont.innerHTML = '<p class="small muted" style="padding:8px 0;">Sin inscritos para mostrar.</p>';
      return;
    }
    cont.innerHTML = ins.slice(0, 30).map(i => `
      <div class="ci-inscrito-row">
        <div>
          <div style="font-weight:600; font-size:13px;">${esc(i.asistente||'—')}</div>
          <div class="small muted" style="font-size:11px;">${esc(i.orden||'')} · ${esc(i.distancia||i.ticket||'')}</div>
        </div>
        ${i.checkin
          ? '<span class="ci-pill ci-pill-ok"><i class="ti ti-check"></i> Acreditado</span>'
          : `<button class="btn btn-outline btn-sm" onclick="acreditarManual('${esc(i.orden||'')}')">Acreditar</button>`}
      </div>
    `).join('');
  }

  // Acreditar desde la lista (por orden)
  window.acreditarManual = function(orden) {
    const input = document.getElementById('ci-codigo');
    if (input) input.value = orden;
    verificarCheckin();
  };

  window.renderCheckin = function() {
    const ev = eventoCheckin();
    const ins = inscripcionesCheckin();
    const acreditados = ins.filter(i => i.checkin);

    // Subtitle
    const sub = document.querySelector('#page-organizador-checkin .content-header .muted');
    if (sub) sub.textContent = (ev ? ev.nombre : 'Sin evento') + ' — En vivo';

    // Stats
    const set = (id,v) => { const e = document.getElementById(id); if(e) e.textContent = v; };
    set('ci-acreditados', acreditados.length);
    set('ci-total', ins.length);
    set('ci-porllegar', ins.length - acreditados.length);

    // Lista de últimos acreditados (orden por checkinAt desc)
    const cont = document.getElementById('ci-recientes');
    const empty = document.getElementById('ci-recientes-empty');
    if (cont) {
      const recientes = acreditados.slice().sort((a,b)=>(b.checkinAt||0)-(a.checkinAt||0)).slice(0, 10);
      if (!recientes.length) {
        cont.innerHTML = '';
        if (empty) empty.style.display = 'block';
      } else {
        if (empty) empty.style.display = 'none';
        cont.innerHTML = recientes.map(i => {
          const hora = i.checkinAt ? new Date(i.checkinAt).toLocaleTimeString('es-CL',{hour:'2-digit',minute:'2-digit'}) : '';
          return `
            <div class="recent-item">
              <div class="check-icon"><i class="ti ti-check"></i></div>
              <div class="check-info">
                <div class="check-name">${esc(i.asistente||'—')}</div>
                <div class="check-meta">${esc(i.distancia||i.ticket||'')}${i.categoria?' · '+esc(i.categoria):''} · ${esc(i.orden||'')}</div>
              </div>
              <div class="check-time">${hora}</div>
            </div>`;
        }).join('');
      }
    }

    // Lista de inscritos para acreditar
    renderListaInscritos('');
  };

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-organizador-checkin', renderCheckin);
  }
})();
</script>

<!-- ============================================================
     RESULTADOS — estadísticas reales (sin datos inventados)
     ============================================================ -->
<script>
(function(){
  const DEMO_IDS = ['rally-purranque','liga-osorno','torneo-3x3','trail-llanquihue','mtb-puyehue','crossfit-bicentenario','maraton-osorno','maraton-osorno-2026'];

  function eventosReales() {
    let evs = [];
    try { evs = JSON.parse(localStorage.getItem('ms_org_events') || '[]'); } catch(_) {}
    let deleted = new Set();
    try { deleted = new Set(JSON.parse(localStorage.getItem('ms_deleted_events') || '[]')); } catch(_) {}
    return evs.filter(e => {
      if (!e || deleted.has(e.id) || DEMO_IDS.includes(e.id)) return false;
      if (e._meta && e._meta.createdAt) return true;
      return !/^(rally-|liga-|torneo-|trail-|mtb-|crossfit-|maraton-)/.test(e.id || '');
    });
  }

  function esc(s){ return (s==null?'':String(s)).replace(/[<>&"]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])); }

  function cardResultado(e, insReales) {
    const finishers = insReales.filter(i => i.eventId === e.id).length;
    const dep = (e._meta && e._meta.deporte) || e.deporte || 'Evento';
    const icon = e.icon || 'ti-trophy';
    return `
      <a class="result-card" href="#/evento" data-event-id="${esc(e.id)}" style="cursor:pointer;">
        <div class="result-head">
          <div class="result-icon" style="background: var(--purple-100); color: var(--purple-700);">
            <i class="ti ${esc(icon)}" style="font-size: 22px;"></i>
          </div>
          <span class="badge badge-purple">${esc(dep)}</span>
        </div>
        <div class="result-title">${esc(e.nombre || 'Evento')}</div>
        <div class="result-meta">${esc(e.fecha || 'Fecha por confirmar')}</div>
        <div class="result-stats">
          <div class="rstat"><strong class="purple">${finishers}</strong><small>Inscritos</small></div>
          <div class="rstat"><strong>—</strong><small>Mejor tiempo</small></div>
          <div class="rstat"><strong>QR</strong><small>Verificable</small></div>
        </div>
      </a>`;
  }

  function renderResultados() {
    const page = document.getElementById('page-resultados');
    const eventos = eventosReales();
    let inscripciones = [];
    try { inscripciones = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]'); } catch(_) {}
    const idsReales = new Set(eventos.map(e => e.id));
    const insReales = inscripciones.filter(i => i && idsReales.has(i.eventId));
    const emails = new Set(insReales.map(i => (i.email || '').toLowerCase()).filter(Boolean));

    const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };
    const fmt = n => n.toLocaleString(window.MS_LOCALE || 'es-CL');
    // Solo eventos finalizados cuentan como "resultados"
    const finalizados = eventos.filter(e => (e.estado || '').toLowerCase() === 'finalizado');
    set('res-resultados', fmt(insReales.length));
    set('res-eventos', fmt(finalizados.length));
    set('res-deportistas', fmt(emails.size));
    set('res-qr', insReales.length ? '100%' : '—');

    // Reemplazar tarjetas de ejemplo por datos reales (o estado vacío).
    if (page) {
      const grid = page.querySelector('.results-grid');
      const topRunners = page.querySelector('.top-runners');
      if (topRunners) topRunners.style.display = 'none'; // datos de ejemplo: ocultos
      if (grid) {
        if (!finalizados.length) {
          grid.innerHTML = '<div class="card" style="grid-column:1/-1; text-align:center; padding:48px 24px;">' +
            '<div style="font-size:44px; color:var(--purple-300);"><i class="ti ti-clipboard-off"></i></div>' +
            '<h3 style="margin:12px 0 6px;">Aún no hay resultados publicados</h3>' +
            '<p class="muted">Cuando un organizador finalice un evento y publique sus resultados, aparecerán aquí.</p></div>';
        } else {
          grid.innerHTML = finalizados.map(e => cardResultado(e, insReales)).join('');
        }
      }
    }
  }

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-resultados', renderResultados);
  }
})();
</script>

<!-- ============================================================
     PAGOS A ORGANIZADORES + FINANZAS REALES + SELECTOR DE PAÍS
     ============================================================ -->
<script>
(function(){
  function money(n, cur){
    n = Number(n||0);
    try { return new Intl.NumberFormat('es-CL', { style:'currency', currency: cur||'CLP', maximumFractionDigits:0 }).format(n); }
    catch(_) { return (cur||'') + ' ' + n.toLocaleString('es-CL'); }
  }
  function esc(s){ return (s==null?'':String(s)).replace(/[<>&"]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])); }
  function fileUrl(rel){ return (window.MSApi && MSApi.fileUrl) ? MSApi.fileUrl(rel) : rel; }

  // ---------- ADMIN: Finanzas reales ----------
  function loadFinance(){
    if (!window.MSApi) return;
    MSApi.adminFinance().then(function(r){
      if (!r || !r.ok) return;
      var t = r.totales || {};
      var set = function(id, v){ var el = document.getElementById(id); if (el) el.textContent = v; };
      set('fin-subtotal', money(t.subtotal));
      set('fin-comision', money(t.comision));
      set('fin-iva', money(t.iva_comision));
      set('fin-total', money(t.total_cobrado));
      set('fin-inscritos', (t.inscripciones||0).toLocaleString('es-CL'));
      set('fin-transferido', money(t.transferido_a_organizadores));
    }).catch(function(){});
  }

  // ---------- ADMIN: Pagos a organizadores ----------
  function loadOrgSelect(){
    if (!window.MSApi) return;
    MSApi.adminOrganizers().then(function(r){
      var sel = document.getElementById('payout-org');
      if (!sel || !r || !r.ok) return;
      sel.innerHTML = (r.organizers||[]).map(function(o){
        return '<option value="'+o.id+'">'+esc(o.name||o.email)+' ('+esc(o.email)+')</option>';
      }).join('') || '<option value="">No hay organizadores aún</option>';
    }).catch(function(){});
    // Eventos para el select opcional.
    MSApi.listEvents().then(function(r){
      var sel = document.getElementById('payout-event');
      if (!sel || !r || !r.ok) return;
      sel.innerHTML = '<option value="">— General —</option>' + (r.events||[]).map(function(e){
        return '<option value="'+esc(e.slug)+'">'+esc(e.nombre)+'</option>';
      }).join('');
    }).catch(function(){});
  }

  function loadAdminPayouts(){
    if (!window.MSApi) return;
    MSApi.listPayouts(true).then(function(r){
      var tb = document.getElementById('payout-list');
      if (!tb) return;
      var rows = (r && r.ok && r.payouts) ? r.payouts : [];
      if (!rows.length){ tb.innerHTML = '<tr><td colspan="6" class="muted small" style="padding:14px;">Sin transferencias registradas.</td></tr>'; return; }
      tb.innerHTML = rows.map(function(p){
        var comp = p.comprobante_file ? '<a href="'+esc(fileUrl(p.comprobante_file))+'" target="_blank" class="link">Ver</a>' : '—';
        return '<tr>'+
          '<td>'+esc((p.created_at||'').slice(0,10))+'</td>'+
          '<td>'+esc(p.organizer_name||p.organizer_email||('#'+(p.organizer_id||'')))+'</td>'+
          '<td>'+esc(p.event_name||'—')+'</td>'+
          '<td style="text-align:right;">'+money(p.monto, p.currency)+'</td>'+
          '<td style="text-align:right;">'+money(p.total_evento, p.currency)+'</td>'+
          '<td>'+comp+'</td></tr>';
      }).join('');
    }).catch(function(){});
  }

  function bindPayoutForm(){
    var form = document.getElementById('payout-form');
    if (!form || form._bound) return;
    form._bound = true;
    form.addEventListener('submit', function(ev){
      ev.preventDefault();
      var msg = document.getElementById('payout-msg');
      var fd = new FormData();
      fd.append('organizer_id', document.getElementById('payout-org').value || '');
      fd.append('event_id', document.getElementById('payout-event').value || '');
      fd.append('monto', document.getElementById('payout-monto').value || '0');
      fd.append('total_evento', document.getElementById('payout-total').value || '0');
      fd.append('currency', document.getElementById('payout-currency').value || 'CLP');
      fd.append('nota', document.getElementById('payout-nota').value || '');
      var file = document.getElementById('payout-file').files[0];
      if (file) fd.append('comprobante', file);
      if (msg) msg.textContent = 'Guardando...';
      MSApi.createPayout(fd).then(function(r){
        if (r && r.ok){
          if (msg){ msg.style.color = 'var(--green-600)'; msg.textContent = 'Transferencia registrada ✓'; }
          form.reset();
          loadAdminPayouts(); loadFinance();
        } else {
          if (msg){ msg.style.color = 'var(--red-600)'; msg.textContent = (r && r.error) ? r.error : 'No se pudo guardar.'; }
        }
      }).catch(function(){ if (msg){ msg.style.color='var(--red-600)'; msg.textContent='Error de conexión.'; } });
    });
  }

  // ---------- ORGANIZADOR: Transferencias recibidas ----------
  function loadOrgPayouts(){
    if (!window.MSApi) return;
    MSApi.ensureOrgToken().then(function(){
      MSApi.listPayouts(false).then(function(r){
        var card = document.getElementById('org-payouts-card');
        var tb = document.getElementById('org-payouts-list');
        if (!card || !tb) return;
        var rows = (r && r.ok && r.payouts) ? r.payouts : [];
        if (!rows.length){ card.style.display = 'none'; return; }
        card.style.display = 'block';
        tb.innerHTML = rows.map(function(p){
          var comp = p.comprobante_file ? '<a href="'+esc(fileUrl(p.comprobante_file))+'" target="_blank" class="link">Ver comprobante</a>' : '—';
          return '<tr>'+
            '<td>'+esc((p.created_at||'').slice(0,10))+'</td>'+
            '<td>'+esc(p.event_name||'General')+'</td>'+
            '<td style="text-align:right;">'+money(p.monto, p.currency)+'</td>'+
            '<td style="text-align:right;">'+money(p.total_evento, p.currency)+'</td>'+
            '<td><span class="badge" style="background:var(--green-50);color:var(--green-700);">'+esc(p.estado||'transferido')+'</span></td>'+
            '<td>'+comp+'</td></tr>';
        }).join('');
      }).catch(function(){});
    });
  }

  // ---------- Selector de país (configuración por países) ----------
  // El módulo assets/country.js es ahora el responsable del selector de país
  // y de aplicar la configuración regional completa. Este init queda como
  // respaldo por si country.js no cargara.
  function initCountrySelector(){
    if (window.MSCountry) return; // country.js gestiona todo
    document.querySelectorAll('.ms-country-select').forEach(function(sel){
      if (sel._filled) return;
      var current = '';
      try { current = localStorage.getItem('ms_country') || 'CL'; } catch(_) { current = 'CL'; }
      var list = window.MS_COUNTRIES || [
        {code:'CL',name:'Chile',flag:'🇨🇱'},{code:'AR',name:'Argentina',flag:'🇦🇷'},
        {code:'BR',name:'Brasil',flag:'🇧🇷'},{code:'CO',name:'Colombia',flag:'🇨🇴'},
        {code:'EC',name:'Ecuador',flag:'🇪🇨'},{code:'PE',name:'Perú',flag:'🇵🇪'}
      ];
      sel.innerHTML = list.map(function(c){
        return '<option value="'+c.code+'"'+(c.code===current?' selected':'')+'>'+(c.flag?c.flag+' ':'')+esc(c.name)+'</option>';
      }).join('');
      sel._filled = true;
      sel.addEventListener('change', function(){
        try { localStorage.setItem('ms_country', sel.value); } catch(_) {}
        document.dispatchEvent(new CustomEvent('ms:country-changed', { detail: sel.value }));
      });
    });
  }
  document.addEventListener('ms:countries-loaded', initCountrySelector);
  document.addEventListener('DOMContentLoaded', initCountrySelector);

  if (window.MatchSPA && typeof MatchSPA.onPageInit === 'function') {
    MatchSPA.onPageInit('page-admin-finanzas', function(){ loadFinance(); loadOrgSelect(); loadAdminPayouts(); bindPayoutForm(); });
    MatchSPA.onPageInit('page-organizador-dashboard', loadOrgPayouts);
  }
})();
</script>

</body>
</html>
