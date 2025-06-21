# CiviCRM Starter-Suite Dashboard

## Überblick

Das modernisierte Vorstandsdashboard für die CiviCRM Starter-Suite bietet eine umfassende Übersicht über alle Aspekte der Vereinsverwaltung für "Menschlichkeit Österreich".

## Features

### 🎯 Dashboard-Übersicht
- **KPI-Karten**: Aktive Mitglieder, monatliche Spenden, laufende Kampagnen, n8n Workflow-Status
- **Real-time Status**: Live-Aktualisierung aller Systemkomponenten
- **Responsive Design**: Optimiert für Desktop, Tablet und Mobile

### 🔄 n8n Workflow-Monitoring
- **Spenden-Pipeline**: Live-Status der Workflows F-01 bis F-10
- **Mitglieder-Onboarding**: Überwachung der Workflows F-11 bis F-18
- **Automation Health**: Uptime, Fehlerrate, Queue-Status, Monitoring

### 🏛️ CiviCRM Integration
- **Extension Status**: Übersicht aller installierten CiviCRM-Erweiterungen
- **Datenbank-Metriken**: Mitgliederanzahl, Spendensummen, aktive Kampagnen
- **Schnellaktionen**: Direkter Zugriff auf häufige CiviCRM-Funktionen

### 🛡️ DSGVO-Compliance
- **Datenschutz-Checks**: Status aller Compliance-Anforderungen
- **Audit Trail**: Dokumentation aller datenschutzrelevanten Aktivitäten
- **Sicherheitsmonitoring**: Verschlüsselung, Zugriffskontrolle, Backup-Status

### 📊 Projekt-Übersicht
- **Implementierungsstatus**: Vollständige Übersicht aller 18 implementierten Workflows
- **Go-Live Status**: Produktionsstatus seit Juni 2025
- **Dokumentations-Links**: Direkter Zugriff auf alle relevanten Dokumentationen

## Technische Details

### Architektur
- **Frontend**: HTML5 + Tailwind CSS (CDN)
- **JavaScript**: Vanilla JS für Interaktivität
- **Responsive**: Mobile-first Design
- **Accessibility**: WCAG 2.1 konform

### Integration
- **CiviCRM API**: REST-API für Live-Daten
- **n8n Webhooks**: Status-Updates der Workflows
- **Prometheus**: Metriken für Monitoring
- **MinIO**: Backup-Status

### Sicherheit
- **CSP Headers**: Content Security Policy
- **HTTPS Only**: Sichere Datenübertragung
- **Session Management**: Sichere Authentifizierung
- **Audit Logging**: Vollständige Nachverfolgbarkeit

## Verwendung

### Lokale Entwicklung
```bash
# Dashboard öffnen
open html/vorstandsdasboard.html

# Mit lokalem Server (empfohlen)
python -m http.server 8080
# Dann http://localhost:8080/html/vorstandsdasboard.html
```

### Produktions-Setup
```bash
# In Apache/Nginx DocumentRoot kopieren
cp html/vorstandsdasboard.html /var/www/html/dashboard.html

# Oder über Docker
docker run -p 8080:80 -v $(pwd)/html:/usr/share/nginx/html nginx
```

## Konfiguration

### API-Endpunkte
Das Dashboard erwartet folgende API-Endpunkte:

```javascript
// CiviCRM API
/civicrm/ajax/api4/Contact/get
/civicrm/ajax/api4/Contribution/get
/civicrm/ajax/api4/Membership/get

// n8n Webhook
/webhook/dashboard-status
/webhook/workflow-metrics

// Prometheus Metrics
/metrics/prometheus
```

### Umgebungsvariablen
```bash
CIVICRM_API_URL=https://your-site.org/civicrm
N8N_WEBHOOK_URL=https://your-n8n.org/webhook
PROMETHEUS_URL=https://your-monitoring.org
```

## Anpassungen

### Design
- CSS-Variablen in `:root` für Farbschema
- Tailwind-Klassen für Layout-Anpassungen
- Responsive Breakpoints konfigurierbar

### Funktionalität
- JavaScript-Event-Handler für Custom Actions
- API-Integration über Fetch API
- Modular aufgebaute Komponenten

## Monitoring

### Metriken
- Dashboard-Aufrufe: Google Analytics / Matomo
- API-Response-Zeiten: Prometheus
- Fehlerrate: Application Logging
- User-Interaktionen: Custom Events

### Alerts
- CiviCRM API nicht erreichbar
- n8n Workflows fehlerhaft
- DSGVO-Compliance-Verletzungen
- System-Ausfall

## Wartung

### Updates
- Tailwind CSS: CDN automatisch aktuell
- JavaScript: Kompatibilität mit ES6+
- CiviCRM: API-Version 4 verwenden
- n8n: Webhook-Kompatibilität prüfen

### Backup
- HTML-Dateien: Git-Repository
- Konfiguration: Environment Files
- API-Keys: Secure Vault (HashiCorp Vault)

## Support

### Dokumentation
- [Go-Live Checkliste](../docs/GO-LIVE-CHECKLIST.md)
- [Quick Start Guide](../QUICK_START.md)
- [Architecture Decisions](../docs/architecture/ADR.md)
- [DSGVO Assessment](../docs/architecture/DPIA.md)

### Kontakt
- **Entwickler**: CiviCRM Starter-Suite Team
- **Repository**: [GitHub](https://github.com/your-org/civicrm-starter-suite)
- **Issues**: GitHub Issues für Bug Reports
- **Diskussionen**: GitHub Discussions für Feature Requests

## Lizenz

Open Source unter MIT-Lizenz. Entwickelt speziell für Non-Profit-Organisationen.

---

**Version**: 1.0.0  
**Build**: Juni 2025  
**Status**: ✅ Production Ready
