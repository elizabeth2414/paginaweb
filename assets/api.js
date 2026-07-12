/* ============================================================
 * Match Sport — Cliente de API (conecta el frontend con el backend PHP)
 * ------------------------------------------------------------
 * Este módulo reemplaza la simulación: guarda y lee datos REALES
 * desde /api (base de datos MySQL en Hostinger).
 *
 * Estrategia de integración:
 *  - Mantiene las mismas claves de localStorage que ya usa la interfaz
 *    (ms_org_events, ms_inscripciones, ...) para no romper el render.
 *  - Sincroniza esas claves con el servidor: al abrir la app baja los
 *    datos reales; al crear un evento / inscribirse, los sube.
 *  - Nunca lanza errores que rompan la UI: si el backend no responde,
 *    la app sigue funcionando con lo que haya en el navegador (modo offline).
 * ============================================================ */
(function () {
  'use strict';

  var CFG = window.MS_CONFIG || {};
  var API_BASE = (CFG.apiBase || 'api').replace(/\/$/, '');

  function tokenKeyFor(admin) { return admin ? 'ms_admin_token' : 'ms_token'; }
  function getToken(admin) { try { return localStorage.getItem(tokenKeyFor(admin)) || ''; } catch (_) { return ''; } }
  function setToken(t, admin) { try { t ? localStorage.setItem(tokenKeyFor(admin), t) : localStorage.removeItem(tokenKeyFor(admin)); } catch (_) {} }

  // --- Petición genérica ---------------------------------------------------
  function request(method, path, body, opts) {
    opts = opts || {};
    var headers = {};
    var token = getToken(opts.admin);
    if (token) headers['Authorization'] = 'Bearer ' + token;
    var init = { method: method, headers: headers };
    if (body instanceof FormData) {
      init.body = body;
    } else if (body != null) {
      headers['Content-Type'] = 'application/json';
      init.body = JSON.stringify(body);
    }
    return fetch(API_BASE + path, init).then(function (res) {
      var ct = res.headers.get('content-type') || '';
      if (ct.indexOf('application/json') === -1) {
        return res.text().then(function (t) { return { ok: res.ok, _raw: t }; });
      }
      return res.json().then(function (data) {
        if (!res.ok) { data = data || {}; data.ok = false; data._status = res.status; }
        return data;
      });
    });
  }

  // --- Cuenta de organizador para este dispositivo -------------------------
  // Garantiza que exista un token de organizador para poder guardar eventos
  // en el servidor aunque el usuario no haya hecho un login formal.
  function ensureOrgToken() {
    var token = getToken(false);
    if (token) return Promise.resolve(token);

    var email = '';
    try {
      var s = JSON.parse(localStorage.getItem('orgSession') || 'null');
      if (s && s.email) email = s.email;
      if (!email) email = localStorage.getItem('ms_email') || '';
    } catch (_) {}
    if (!email) {
      email = 'org-' + Math.random().toString(36).slice(2, 10) + '@match-sport.local';
      try { localStorage.setItem('ms_device_email', email); } catch (_) {}
    }
    var pass = localStorage.getItem('ms_device_pass') || 'ms-' + Math.random().toString(36).slice(2, 12);
    try { localStorage.setItem('ms_device_pass', pass); } catch (_) {}
    var country = (function () { try { return localStorage.getItem('ms_country') || 'CL'; } catch (_) { return 'CL'; } })();

    return request('POST', '/auth/login', { email: email, password: pass }).then(function (r) {
      if (r && r.ok && r.token) { setToken(r.token, false); return r.token; }
      return request('POST', '/auth/register', {
        email: email, password: pass, name: 'Organizador', role: 'organizador', country_code: country
      }).then(function (rr) {
        if (rr && rr.ok && rr.token) { setToken(rr.token, false); return rr.token; }
        return '';
      });
    }).catch(function () { return ''; });
  }

  // --- API pública ---------------------------------------------------------
  var MSApi = {
    base: API_BASE,
    getToken: getToken,
    setToken: setToken,
    request: request,
    ensureOrgToken: ensureOrgToken,

    countries: function () { return request('GET', '/countries'); },

    register: function (data) {
      return request('POST', '/auth/register', data).then(function (r) {
        if (r && r.ok && r.token) setToken(r.token, false);
        return r;
      });
    },
    login: function (email, password) {
      return request('POST', '/auth/login', { email: email, password: password }).then(function (r) {
        if (r && r.ok && r.token) setToken(r.token, false);
        return r;
      });
    },
    adminLogin: function (key) {
      return request('POST', '/auth/admin', { key: key }).then(function (r) {
        if (r && r.ok && r.token) setToken(r.token, true);
        return r;
      });
    },
    oauth: function (provider, payload) {
      var body = Object.assign({ provider: provider, country_code: (function(){ try { return localStorage.getItem('ms_country') || 'CL'; } catch(_) { return 'CL'; } })() }, payload || {});
      return request('POST', '/auth/oauth', body).then(function (r) {
        if (r && r.ok && r.token) setToken(r.token, false);
        return r;
      });
    },
    logout: function () {
      return request('POST', '/auth/logout', {}).then(function (r) { setToken('', false); return r; });
    },

    listEvents: function () { return request('GET', '/events'); },
    listMyEvents: function () { return request('GET', '/events?mine=1'); },
    getEvent: function (id) { return request('GET', '/events/' + encodeURIComponent(id)); },

    // Guarda un evento (con la forma de la UI dentro de `data`).
    pushEvent: function (ev) {
      if (!ev) return Promise.resolve(null);
      return ensureOrgToken().then(function () {
        var payload = {
          slug: String(ev.id || '').trim() || undefined,
          nombre: ev.nombre || ev.name || 'Evento',
          deporte: ev.deporte || '',
          descripcion: ev.desc || ev.descripcion || '',
          fecha: ev.fecha || '',
          ubicacion: ev.ubicacion || ev.lugar || '',
          country_code: ev.country_code || ev.pais || localStorage.getItem('ms_country') || 'CL',
          currency: ev.currency || ev.moneda || 'CLP',
          estado: ev.estado || 'activo',
          icon: ev.icon || 'ti-run',
          color: ev.color || 'purple',
          precio: Number(ev.precio || 0),
          cupos: Number(ev.total || ev.cupos || 0),
          lat: ev.lat, lng: ev.lng,
          data: ev
        };
        return request('POST', '/events', payload);
      });
    },

    listRegistrations: function (eventId) {
      var q = eventId ? '?event=' + encodeURIComponent(eventId) : '?mine=1';
      return request('GET', '/registrations' + q);
    },
    pushRegistration: function (insc) {
      if (!insc) return Promise.resolve(null);
      var subtotal = Number(insc.subtotal != null ? insc.subtotal : insc.total || 0);
      return request('POST', '/registrations', {
        event_id: insc.eventId || insc.event_id,
        nombre: insc.asistente || insc.nombre || '',
        email: insc.email || '',
        documento: insc.documento || '',
        categoria: insc.categoria || insc.distancia || '',
        currency: insc.currency || 'CLP',
        subtotal: subtotal,
        total: Number(insc.total || 0),
        payment_method: insc.payment_method || '',
        data: insc
      });
    },

    listPayouts: function (admin) { return request('GET', '/payouts', null, { admin: !!admin }); },
    createPayout: function (formData) { return request('POST', '/payouts', formData, { admin: true }); },
    adminFinance: function () { return request('GET', '/admin/finance', null, { admin: true }); },
    adminOrganizers: function () { return request('GET', '/admin/organizers', null, { admin: true }); },

    exportUrl: function (type, eventId, admin) {
      var url = API_BASE + '/export?type=' + encodeURIComponent(type || 'registrations');
      if (eventId) url += '&event=' + encodeURIComponent(eventId);
      var token = getToken(!!admin) || getToken(true) || getToken(false);
      if (token) url += '&token=' + encodeURIComponent(token);
      return url;
    },

    // Descarga real de un CSV (garantiza token de organizador si hace falta).
    download: function (type, eventId, admin) {
      var self = this;
      var run = function () { window.location.href = self.exportUrl(type, eventId, admin); };
      if (admin || getToken(true)) { run(); return; }
      this.ensureOrgToken().then(run);
    },

    fileUrl: function (rel) {
      if (!rel) return '';
      if (/^https?:/i.test(rel)) return rel;
      return (CFG.baseUrl || '.').replace(/\/$/, '') + '/' + rel.replace(/^\//, '');
    },

    // --- Sincronización: baja datos reales del servidor a localStorage -----
    syncEvents: function () {
      return this.listEvents().then(function (r) {
        if (!r || !r.ok || !Array.isArray(r.events)) return;
        var uiEvents = r.events.map(function (e) {
          var ui = (e.data && typeof e.data === 'object') ? e.data : {};
          ui.id = ui.id || e.slug || String(e.id);
          ui.nombre = ui.nombre || e.nombre;
          ui.estado = ui.estado || e.estado;
          ui.currency = ui.currency || e.currency;
          ui.country_code = ui.country_code || e.country_code;
          ui.vendidos = e.vendidos;
          ui.recaudado = e.recaudado;
          ui._server = true;
          return ui;
        });
        try {
          var localList = JSON.parse(localStorage.getItem('ms_org_events') || '[]');
          // Conserva eventos locales aún no sincronizados (sin _server).
          var localOnly = localList.filter(function (l) {
            return !uiEvents.some(function (s) { return s.id === l.id; });
          });
          var merged = uiEvents.concat(localOnly);
          localStorage.setItem('ms_org_events', JSON.stringify(merged));
        } catch (_) {}
        document.dispatchEvent(new CustomEvent('ms:events-synced'));
      }).catch(function () {});
    },

    syncRegistrations: function () {
      var token = getToken(false);
      if (!token) return Promise.resolve();
      return this.listRegistrations().then(function (r) {
        if (!r || !r.ok || !Array.isArray(r.registrations)) return;
        var uiInsc = r.registrations.map(function (reg) {
          var ui = (reg.data && typeof reg.data === 'object') ? reg.data : {};
          ui.eventId = ui.eventId || null;
          ui.total = ui.total != null ? ui.total : Number(reg.total);
          ui.ticket_code = reg.ticket_code;
          ui._server = true;
          return ui;
        });
        try {
          var local = JSON.parse(localStorage.getItem('ms_inscripciones') || '[]');
          var localOnly = local.filter(function (l) { return !l._server; });
          localStorage.setItem('ms_inscripciones', JSON.stringify(uiInsc.concat(localOnly)));
        } catch (_) {}
        document.dispatchEvent(new CustomEvent('ms:registrations-synced'));
      }).catch(function () {});
    },

    boot: function () {
      var self = this;
      // Países y monedas para los selectores.
      this.countries().then(function (r) {
        if (r && r.ok) { window.MS_COUNTRIES = r.countries; document.dispatchEvent(new CustomEvent('ms:countries-loaded')); }
      }).catch(function () {});
      // Sincroniza eventos reales; luego inscripciones si hay sesión org.
      this.syncEvents().then(function () { return self.syncRegistrations(); });
    }
  };

  window.MSApi = MSApi;

  // Helper global para los botones "Exportar" de la interfaz.
  window.msExport = function (type, eventId, admin) {
    try { MSApi.download(type || 'registrations', eventId || null, !!admin); }
    catch (e) { console.warn('Export error', e); }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () { MSApi.boot(); });
  } else {
    MSApi.boot();
  }
})();
