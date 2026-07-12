/* ============================================================
 * Match Sport — Configuración por país
 * ------------------------------------------------------------
 * Al seleccionar un país (Chile, Argentina, Brasil, Colombia,
 * Ecuador o Perú) toda la aplicación se adapta: moneda, formato
 * de números y fechas (locale), impuesto (IVA/IGV), ejemplos de
 * correo y teléfono, documento de identidad y nacionalidad.
 * ============================================================ */
(function () {
  'use strict';

  var CONFIG = {
    CL: {
      code: 'CL', name: 'Chile', flag: '🇨🇱',
      currency: 'CLP', currencySymbol: '$', currencyDecimals: 0, currencyLabel: 'Peso chileno (CLP)',
      locale: 'es-CL',
      phoneCode: '+56', phoneExample: '+56 9 1234 5678', phonePlaceholder: '+56 9 XXXX XXXX',
      emailExample: 'tu@correo.cl',
      taxLabel: 'IVA', taxRate: 0.19,
      docType: 'rut', docLabel: 'RUT', docPlaceholder: '12.345.678-9',
      nationality: 'Chilena', cityExample: 'Ej: Santiago', langNote: null
    },
    AR: {
      code: 'AR', name: 'Argentina', flag: '🇦🇷',
      currency: 'ARS', currencySymbol: '$', currencyDecimals: 0, currencyLabel: 'Peso argentino (ARS)',
      locale: 'es-AR',
      phoneCode: '+54', phoneExample: '+54 9 11 1234 5678', phonePlaceholder: '+54 9 XX XXXX XXXX',
      emailExample: 'tu@correo.com.ar',
      taxLabel: 'IVA', taxRate: 0.21,
      docType: 'dni', docLabel: 'DNI', docPlaceholder: '12.345.678',
      nationality: 'Argentina', cityExample: 'Ej: Buenos Aires', langNote: null
    },
    BR: {
      code: 'BR', name: 'Brasil', flag: '🇧🇷',
      currency: 'BRL', currencySymbol: 'R$', currencyDecimals: 2, currencyLabel: 'Real brasileño (BRL)',
      locale: 'pt-BR',
      phoneCode: '+55', phoneExample: '+55 11 91234 5678', phonePlaceholder: '+55 XX XXXXX XXXX',
      emailExample: 'seu@correio.com.br',
      taxLabel: 'Impuesto', taxRate: 0.17,
      docType: 'cpf', docLabel: 'CPF', docPlaceholder: '123.456.789-00',
      nationality: 'Brasileña', cityExample: 'Ej: São Paulo', langNote: null
    },
    CO: {
      code: 'CO', name: 'Colombia', flag: '🇨🇴',
      currency: 'COP', currencySymbol: '$', currencyDecimals: 0, currencyLabel: 'Peso colombiano (COP)',
      locale: 'es-CO',
      phoneCode: '+57', phoneExample: '+57 300 123 4567', phonePlaceholder: '+57 3XX XXX XXXX',
      emailExample: 'tu@correo.com.co',
      taxLabel: 'IVA', taxRate: 0.19,
      docType: 'cedula', docLabel: 'Cédula', docPlaceholder: '1.234.567.890',
      nationality: 'Colombiana', cityExample: 'Ej: Bogotá', langNote: null
    },
    EC: {
      code: 'EC', name: 'Ecuador', flag: '🇪🇨',
      currency: 'USD', currencySymbol: '$', currencyDecimals: 2, currencyLabel: 'Dólar (USD)',
      locale: 'es-EC',
      phoneCode: '+593', phoneExample: '+593 99 123 4567', phonePlaceholder: '+593 9X XXX XXXX',
      emailExample: 'tu@correo.com.ec',
      taxLabel: 'IVA', taxRate: 0.12,
      docType: 'cedula', docLabel: 'Cédula', docPlaceholder: '1234567890',
      nationality: 'Ecuatoriana', cityExample: 'Ej: Quito', langNote: null
    },
    PE: {
      code: 'PE', name: 'Perú', flag: '🇵🇪',
      currency: 'PEN', currencySymbol: 'S/', currencyDecimals: 2, currencyLabel: 'Sol peruano (PEN)',
      locale: 'es-PE',
      phoneCode: '+51', phoneExample: '+51 987 654 321', phonePlaceholder: '+51 9XX XXX XXX',
      emailExample: 'tu@correo.com.pe',
      taxLabel: 'IGV', taxRate: 0.18,
      docType: 'dni', docLabel: 'DNI', docPlaceholder: '12345678',
      nationality: 'Peruana', cityExample: 'Ej: Lima', langNote: null
    }
  };

  function getCode() {
    try { return localStorage.getItem('ms_country') || 'CL'; } catch (_) { return 'CL'; }
  }
  function cfg(code) { return CONFIG[code || getCode()] || CONFIG.CL; }

  function money(n, currencyOverride) {
    var c = cfg();
    var cur = currencyOverride || c.currency;
    n = Number(n || 0);
    try {
      return new Intl.NumberFormat(c.locale, {
        style: 'currency', currency: cur,
        maximumFractionDigits: c.currencyDecimals, minimumFractionDigits: 0
      }).format(n);
    } catch (_) {
      return c.currencySymbol + ' ' + n.toLocaleString(c.locale);
    }
  }

  function dateFmt(dstr) {
    var c = cfg();
    var d = (dstr instanceof Date) ? dstr : new Date(dstr);
    if (isNaN(d.getTime())) return dstr;
    try { return d.toLocaleDateString(c.locale, { day: 'numeric', month: 'long', year: 'numeric' }); }
    catch (_) { return d.toLocaleDateString('es', { day: 'numeric', month: 'long', year: 'numeric' }); }
  }

  function setVal(id, prop, value) {
    var el = document.getElementById(id);
    if (el && value != null) el[prop] = value;
  }
  function setPlaceholderAll(selector, value) {
    document.querySelectorAll(selector).forEach(function (el) { if (value != null) el.placeholder = value; });
  }

  // Aplica la configuración del país a toda la interfaz visible.
  function apply(code) {
    var c = cfg(code);
    window.MS_CURRENCY = c.currency;
    window.MS_LOCALE = c.locale;
    window.MS_COUNTRY_CFG = c;

    // Selectores de país (barra superior u otros).
    document.querySelectorAll('.ms-country-select').forEach(function (sel) {
      if (sel.value !== c.code) sel.value = c.code;
    });

    // Moneda por defecto en los selects de moneda.
    document.querySelectorAll('#ev-currency, #payout-currency').forEach(function (sel) {
      if (sel && sel.querySelector('option[value="' + c.currency + '"]')) sel.value = c.currency;
    });

    // Checkout / formularios: placeholders y valores de ejemplo.
    setVal('ck-email', 'placeholder', c.emailExample);
    var nac = document.getElementById('ck-nacionalidad');
    if (nac && (!nac.value || nac.dataset.msAuto !== 'off')) { nac.value = c.nationality; nac.dataset.msAuto = 'on'; }
    if (nac) nac.placeholder = c.nationality;
    setPlaceholderAll('#ck-emer-telefono, [data-ms="phone"]', c.phonePlaceholder);
    setVal('ck-ciudad', 'placeholder', c.cityExample);
    setVal('ck-doc-numero', 'placeholder', c.docLabel + ' ej: ' + c.docPlaceholder);
    var docPais = document.getElementById('ck-doc-pais');
    if (docPais && docPais.querySelector('option[value="' + c.code + '"]')) docPais.value = c.code;
    var docTipo = document.getElementById('ck-doc-tipo');
    if (docTipo && docTipo.querySelector('option[value="' + c.docType + '"]')) docTipo.value = c.docType;

    // Etiquetas dinámicas (impuesto, moneda, ejemplos, país).
    document.querySelectorAll('[data-ms="tax-label"]').forEach(function (e) { e.textContent = c.taxLabel; });
    document.querySelectorAll('[data-ms="tax-rate"]').forEach(function (e) { e.textContent = Math.round(c.taxRate * 100) + '%'; });
    document.querySelectorAll('[data-ms="currency"]').forEach(function (e) { e.textContent = c.currency; });
    document.querySelectorAll('[data-ms="currency-label"]').forEach(function (e) { e.textContent = c.currencyLabel; });
    document.querySelectorAll('[data-ms="country-name"]').forEach(function (e) { e.textContent = c.name; });
    document.querySelectorAll('[data-ms="phone-example"]').forEach(function (e) { e.textContent = c.phoneExample; });
    document.querySelectorAll('[data-ms="email-example"]').forEach(function (e) { e.textContent = c.emailExample; });

    document.dispatchEvent(new CustomEvent('ms:country-changed', { detail: c }));
  }

  function set(code) {
    if (!CONFIG[code]) return;
    try { localStorage.setItem('ms_country', code); } catch (_) {}
    apply(code);
    // Re-render de la ruta actual para que los montos se reformateen.
    if (window.MatchSPA && typeof MatchSPA.render === 'function') {
      try { MatchSPA.render(); } catch (_) {}
    } else {
      try { window.dispatchEvent(new HashChangeEvent('hashchange')); } catch (_) {
        var ev = document.createEvent('Event'); ev.initEvent('hashchange', true, true); window.dispatchEvent(ev);
      }
    }
    if (window.toast) toast('País: ' + cfg(code).name + ' · Moneda ' + cfg(code).currency);
  }

  window.MSCountry = {
    all: CONFIG,
    current: function () { return cfg(); },
    cfg: cfg,
    money: money,
    date: dateFmt,
    apply: apply,
    set: set
  };

  // Sobrescribe los formateadores globales para que respeten el país.
  window.formatCLP = function (amount) { return money(amount); };
  window.formatDate = function (dstr) { return dateFmt(dstr); };

  // Rellena los selectores de país (con banderas) y engancha el cambio.
  function initSelectors() {
    document.querySelectorAll('.ms-country-select').forEach(function (sel) {
      if (!sel._msFilled) {
        var current = getCode();
        sel.innerHTML = Object.keys(CONFIG).map(function (k) {
          var c = CONFIG[k];
          return '<option value="' + c.code + '"' + (c.code === current ? ' selected' : '') + '>' + c.flag + ' ' + c.name + '</option>';
        }).join('');
        sel._msFilled = true;
        sel.addEventListener('change', function () { set(sel.value); });
      }
    });
  }

  function boot() {
    initSelectors();
    apply(getCode());
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
  // Reaplica al navegar (nuevas pantallas necesitan placeholders/labels).
  window.addEventListener('hashchange', function () { setTimeout(function () { apply(getCode()); }, 60); });
})();
