# CiviCRM n8n Integration - Architektur Entscheidungen

## ADR-001: Workflow-Orchestrierung mit n8n

**Status:** Angenommen  
**Datum:** 2025-06-21  
**Autoren:** DevOps Team

### Kontext
Für die Automatisierung der Spendenprozesse benötigen wir eine robuste Workflow-Engine, die CiviCRM-Webhooks verarbeitet und verschiedene Dienste orchestriert.

### Entscheidung
Wir verwenden n8n als Workflow-Orchestrierung-Tool mit folgender Architektur:

- **n8n 1.41+** in Queue-Mode mit Redis
- **Horizontale Skalierung** mit separaten Worker-Pods
- **PostgreSQL** als primäre Datenbank
- **MinIO S3** für Binary-Daten-Storage

### Begründung
- **Open Source** und selbst-hostbar
- **Visuelle Workflow-Erstellung** für nicht-technische Nutzer
- **Umfangreiche Integration** mit CiviCRM, Social Media APIs
- **Queue-basierte Architektur** für Skalierbarkeit
- **Robustes Error-Handling** mit Retry-Mechanismen

### Konsequenzen
- **Positiv:**
  - Skalierbare Architektur
  - Einfache Wartung und Erweiterung
  - Gute Performance bei hohem Durchsatz
  - Versionskontrolle über JSON-Export

- **Negativ:**
  - Komplexere Infrastruktur (Redis, PostgreSQL)
  - Vendor-Lock-in bei spezifischen n8n-Features
  - Lernkurve für komplexere Workflows

---

## ADR-002: PDF-Generierung mit CraftMyPDF

**Status:** Angenommen  
**Datum:** 2025-06-21

### Kontext
Für die automatische Generierung von Spendenbestätigungen benötigen wir einen Service, der HTML-Templates in PDF-UA-konforme Dokumente konvertiert.

### Entscheidung
Verwendung von CraftMyPDF als externe PDF-Generierungslösung.

### Begründung
- **DSGVO-konform** (EU-basiert)
- **PDF-UA-Unterstützung** für Barrierefreiheit
- **Template-basiert** mit dynamischen Daten
- **n8n-Integration** über Community-Node
- **Kosteneffizient** für unser Volumen

### Konsequenzen
- **Positiv:**
  - Professionelle PDF-Qualität
  - Automatische Barrierefreiheit
  - Keine lokale PDF-Infrastruktur nötig

- **Negativ:**
  - Abhängigkeit von externem Service
  - Monatliche Kosten
  - Potentielle Latenz bei hohem Volumen

---

## ADR-003: Social Media API-Versionen

**Status:** Angenommen  
**Datum:** 2025-06-21

### Kontext
Social Media APIs ändern sich häufig. Wir müssen die richtige Balance zwischen Stabilität und Features finden.

### Entscheidung
- **Facebook Graph API v23.0** (aktuelle stabile Version)
- **LinkedIn Posts API v202506**
- **Instagram Graph API v18.0**

### Begründung
- Neueste stabile Versionen mit allen benötigten Features
- Längere Deprecation-Zyklen
- Bessere Rate-Limiting-Behandlung

### Konsequenzen
- Regelmäßige Updates nötig
- Potentielle Breaking Changes
- Bessere Feature-Verfügbarkeit

---

## ADR-004: Error-Handling-Strategie

**Status:** Angenommen  
**Datum:** 2025-06-21

### Kontext
Robustes Error-Handling ist kritisch für einen produktiven Workflow.

### Entscheidung
Mehrstufiges Error-Handling:

1. **Rate-Limiting:** Exponentielles Backoff
2. **Token-Expiry:** Automatisches Refresh
3. **Validation-Errors:** Jira-Ticket + Workflow-Stop
4. **CiviCRM-Logging:** Fehler in Custom-Fields

### Begründung
- Unterschiedliche Fehlertypen brauchen unterschiedliche Behandlung
- Automatisierte Wiederherstellung wo möglich
- Menschliche Intervention nur bei kritischen Fehlern

### Konsequenzen
- Komplexere Workflow-Logik
- Bessere Betriebsstabilität
- Reduzierte manuelle Intervention
