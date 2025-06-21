# Datenschutz-Folgenabschätzung (DPIA)
## CiviCRM-n8n Workflow Integration

**Datum:** 21. Juni 2025  
**Version:** 1.0  
**Bearbeitet von:** Menschlichkeit Österreich - Datenschutzbeauftragte

---

## 1. Beschreibung der geplanten Verarbeitung

### 1.1 Zweck der Verarbeitung
Die automatisierte Verarbeitung von Spendendaten zur:
- Generierung von Spendenbestätigungen
- Buchung in der Finanzbuchhaltung
- Marketing-Kommunikation mit Spendern
- Social Media Content-Erstellung (anonymisiert)

### 1.2 Art der verarbeiteten Daten
- **Stammdaten:** Name, Adresse, E-Mail, Telefon
- **Spendendaten:** Betrag, Datum, Zahlungsart
- **Kommunikationsdaten:** E-Mail-Verlauf, Präferenzen
- **Technische Daten:** IP-Adressen, Transaktions-IDs

### 1.3 Betroffene Personen
- Spender:innen (Privatpersonen und Organisationen)
- Geschätzte Anzahl: 5.000 pro Jahr

---

## 2. Rechtsgrundlagen

### 2.1 Primäre Rechtsgrundlage
**Art. 6 Abs. 1 lit. f DSGVO** - Berechtigtes Interesse
- Verwaltung von Spenden
- Ausstellung von Spendenbestätigungen
- Transparenz gegenüber Spendern

### 2.2 Sekundäre Rechtsgrundlagen
**Art. 6 Abs. 1 lit. a DSGVO** - Einwilligung
- Marketing-Kommunikation
- Newsletter-Versendung

**Art. 6 Abs. 1 lit. c DSGVO** - Rechtliche Verpflichtung
- Aufbewahrung von Belegen (BAO)
- Steuerliche Dokumentation

---

## 3. Risikobewertung

### 3.1 Identifizierte Risiken

| Risiko | Wahrscheinlichkeit | Auswirkung | Risikostufe |
|--------|-------------------|------------|-------------|
| Datenleck bei PDF-Erstellung | Niedrig | Hoch | Mittel |
| Unbefugter API-Zugriff | Niedrig | Hoch | Mittel |
| Fehlerhafte Anonymisierung | Mittel | Mittel | Mittel |
| Token-Diebstahl | Niedrig | Hoch | Mittel |

### 3.2 Besonders schützenswerte Daten
- Keine Verarbeitung von besonderen Kategorien (Art. 9 DSGVO)
- Spendenhöhe könnte Rückschlüsse auf finanzielle Situation ermöglichen

---

## 4. Technische und organisatorische Maßnahmen

### 4.1 Datensicherheit
- **Verschlüsselung:** TLS 1.3 für alle API-Verbindungen
- **Authentifizierung:** OAuth 2.0 mit Refresh-Tokens
- **Zugriffskontrolle:** Rollenbasierte Berechtigungen
- **Logging:** Vollständige Audit-Trails

### 4.2 Datensparsamkeit
- **Anonymisierung:** Keine personenbezogenen Daten in Social Media
- **Pseudonymisierung:** Interne Referenzen statt Klarnamen
- **Löschkonzept:** Automatische Löschung nach 7 Jahren (BAO)

### 4.3 Auftragsverarbeitung
- **CraftMyPDF:** EU-basierter Anbieter, AV-Vertrag vorhanden
- **Brevo:** DSGVO-konformer E-Mail-Service
- **Meta/LinkedIn:** Standardvertragsklauseln

---

## 5. Betroffenenrechte

### 5.1 Umgesetzte Rechte
- **Auskunftsrecht:** Automatisierte Berichte aus CiviCRM
- **Berichtigungsrecht:** Direkte Bearbeitung in CiviCRM
- **Löschungsrecht:** Anonymisierung oder Löschung
- **Widerspruchsrecht:** Opt-out-Mechanismen

### 5.2 Technische Umsetzung
- **Opt-out-Links** in allen E-Mails
- **Präferenz-Center** für Marketing-Kommunikation
- **API-Endpunkte** für Auskunftsersuchen

---

## 6. Internationale Übermittlungen

### 6.1 Datenübermittlungen außerhalb EU/EWR
- **Meta (Facebook/Instagram):** USA - Adequacy Decision
- **HubSpot:** USA - Standardvertragsklauseln
- **LinkedIn:** USA - Adequacy Decision

### 6.2 Schutzmaßnahmen
- Minimale Datenübermittlung
- Verschlüsselung bei Übertragung
- Regelmäßige Überprüfung der Rechtsgrundlagen

---

## 7. Bewertung der Erforderlichkeit

### 7.1 Erforderlichkeit
Die Verarbeitung ist erforderlich für:
- Spendenbestätigungen (rechtliche Verpflichtung)
- Finanzbuchhaltung (rechtliche Verpflichtung)
- Spender-Kommunikation (berechtigtes Interesse)

### 7.2 Verhältnismäßigkeit
- **Nutzen:** Effiziente Spendenverwaltung, transparente Kommunikation
- **Risiken:** Begrenzt durch technische Schutzmaßnahmen
- **Bewertung:** Verhältnismäßig

---

## 8. Monitoring und Überprüfung

### 8.1 Überwachungsmaßnahmen
- **Monatliche Berichte:** Verarbeitungsvolumen und Fehlerquoten
- **Jährliche Überprüfung:** DPIA-Aktualisierung
- **Incident Response:** Definierte Prozesse für Datenschutzverletzungen

### 8.2 Datenschutz-Folgenabschätzung
- **Datum der nächsten Überprüfung:** 21. Juni 2026
- **Verantwortlich:** Datenschutzbeauftragte
- **Kriterien für Überprüfung:** Änderungen in Verarbeitung, Rechtslage oder Risikobewertung

---

## 9. Fazit

Die geplante Verarbeitung ist:
- ✅ **Rechtmäßig** (klare Rechtsgrundlagen)
- ✅ **Verhältnismäßig** (angemessene Schutzmaßnahmen)
- ✅ **Zweckgebunden** (klar definierte Zwecke)
- ✅ **Sicher** (umfassende technische Maßnahmen)

**Empfehlung:** Umsetzung unter Einhaltung der definierten Schutzmaßnahmen.

---

**Datum:** 21. Juni 2025  
**Unterschrift Datenschutzbeauftragte:** ________________  
**Unterschrift Geschäftsführung:** ________________
