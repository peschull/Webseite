# Quick Start Guide - CiviCRM n8n Integration

*Schnellstart-Anleitung für "Menschlichkeit Österreich" - Version 2.0*

## 🚀 Sofort-Deployment

### Lokale Entwicklung starten:
```bash
# Repository klonen und dependencies installieren
git clone <repository-url>
cd Webseite
npm install

# Lokale Entwicklungsumgebung starten
docker-compose up -d

# n8n UI öffnen: http://localhost:5678
# Grafana Dashboard: http://localhost:3000 (admin/admin)
```

### Production Deployment:
```bash
# Kubernetes Cluster vorbereiten
kubectl create namespace n8n-production

# Secrets erstellen (siehe .env.example)
kubectl create secret generic n8n-secrets --from-env-file=.env -n n8n-production

# Helm Deployment
helm upgrade --install n8n ./helm -f helm/n8n-values.yaml -n n8n-production

# Status prüfen
kubectl get pods -n n8n-production
```

## 📋 Wichtige Workflows

### Spenden-Workflows (F-01 bis F-10):
- **F-01**: Donation Processing → `workflows/civicrm-donation-workflow.json`
- **F-02**: PDF Receipt Generation → integriert in F-01
- **F-03**: Email Confirmation → integriert in F-01
- **F-04**: Accounting Integration → FreeFinance-Sync
- **F-05**: Marketing Automation → Brevo-Integration
- **F-06**: Social Media Posting → Facebook/LinkedIn
- **F-07**: Thank You Campaign → Follow-up E-Mails
- **F-08**: Analytics & Reporting → CiviReport-Integration
- **F-09**: Error Handling → `workflows/error-handler-workflow.json`
- **F-10**: Token Refresh → `workflows/token-refresh-workflow.json`

### Mitglieder-Workflows (F-11 bis F-18):
- **F-11**: Lead Capture → `workflows/F-11_lead_capture.json`
- **F-12**: Membership Application → `workflows/F-12_membership_apply.json`
- **F-13**: Payment Processing → `workflows/F-13_membership_payment.json`
- **F-14**: Welcome Package → `workflows/F-14_membership_welcome.json`
- **F-15**: Member Portal → `workflows/F-15_member_portal.json`
- **F-16**: Member Engagement → `workflows/F-16_member_engagement.json`
- **F-17**: Membership Renewal → `workflows/F-17_membership_renewal.json`
- **F-18**: Membership Offboarding → `workflows/F-18_membership_offboarding.json`

## 🔧 Administration & Monitoring

### Monitoring-URLs (Production):
```bash
# Grafana Dashboard
https://grafana.menschlichkeit.at

# Prometheus Metrics
https://prometheus.menschlichkeit.at

# n8n Interface
https://n8n.menschlichkeit.at

# MinIO Console
https://minio.menschlichkeit.at
```

### Wichtige Kommandos:
```bash
# Workflow-Status prüfen
kubectl logs -f deployment/n8n -n n8n-production

# Database Backup
./scripts/backup-civicrm.sh

# MinIO Buckets initialisieren
./scripts/init-minio.sh

# Monitoring Alerts prüfen
kubectl get alerts -n monitoring
```

## 🧪 Testing

### Lokale Tests ausführen:
```bash
# Alle Tests
npm test

# Spezifische Workflow-Tests
npm run test:workflows

# E2E Tests mit Playwright
npm run test:e2e

# Performance Tests
npm run test:performance
```

### Test-Payloads:
- Spenden: `tests/payloads/contribution.json`
- Kontakt: `tests/payloads/contact.json`
- Mitgliedschaft: `tests/payloads/membership_*.json`

## 🛠️ Troubleshooting

### Häufige Probleme:

#### n8n Workflow nicht ausgeführt:
```bash
# Workflow-Status prüfen
curl -X GET "http://localhost:5678/api/v1/workflows/active" \
  -H "X-N8N-API-KEY: your-api-key"

# Logs anzeigen
docker-compose logs n8n
```

#### CiviCRM API-Probleme:
```bash
# Token erneuern
./scripts/token-refresh.sh

# CiviCRM Verbindung testen
curl -X GET "https://civicrm.menschlichkeit.at/civicrm/ajax/api4/Contact/get" \
  -H "Authorization: Bearer $CIVICRM_TOKEN"
```

#### PDF-Generierung fehlgeschlagen:
```bash
# CraftMyPDF API testen
curl -X POST "https://api.craftmypdf.com/v1/create" \
  -H "X-API-KEY: $CRAFTMYPDF_API_KEY" \
  -d '{"template_id": "test", "data": {}}'
```

## 📊 Monitoring & Alerts

### Wichtige Dashboards:
- **n8n Workflow Performance**: Execution times, success rates
- **CiviCRM Integration**: API calls, response times
- **Membership KPIs**: New signups, retention, churn
- **System Health**: CPU, Memory, Disk usage

### Alert-Konfiguration:
```yaml
# Beispiel-Alert für Failed Workflows
- alert: WorkflowFailureRate
  expr: (rate(n8n_workflow_executions_failed_total[5m]) / rate(n8n_workflow_executions_total[5m])) > 0.05
  for: 2m
  annotations:
    summary: "High workflow failure rate detected"
```

## 🔐 Security & Compliance

### DSGVO-Checkliste:
- [ ] **Datenschutzerklärung** aktualisiert
- [ ] **Auftragsverarbeiterverträge** unterzeichnet
- [ ] **Technische Maßnahmen** implementiert
- [ ] **Löschkonzept** automatisiert
- [ ] **Auskunftsersuchen-Workflow** getestet

### Security-Scans:
```bash
# Container-Vulnerabilities prüfen
trivy image n8n:latest

# Kubernetes Security
kube-score score helm/templates/*.yaml

# OWASP ZAP Scan
docker run -v $(pwd):/zap/wrk/:rw -t owasp/zap2docker-stable zap-baseline.py -t https://n8n.menschlichkeit.at
```

## 📞 Support & Kontakt

### Emergency Contacts:
- **Technical Issues**: tech-support@menschlichkeit.at
- **Data Protection**: datenschutz@menschlichkeit.at
- **System Administrator**: admin@menschlichkeit.at

### Incident Response:
1. **Critical**: Response < 1h, Page On-Call
2. **High**: Response < 4h, Email + Slack
3. **Medium**: Response < 24h, Ticket System
4. **Low**: Response < 72h, Next Business Day

## 📚 Dokumentation

### Wichtige Dateien:
- **Go-Live Checkliste**: `docs/GO-LIVE-CHECKLIST.md`
- **Architektur**: `docs/architecture/ADR.md`
- **DSGVO**: `docs/architecture/DPIA.md`
- **Scripts**: `scripts/README.md`
- **Finalization Report**: `docs/FINALIZATION_REPORT.md`

### API-Dokumentation:
- **n8n API**: https://docs.n8n.io/api/
- **CiviCRM API**: https://docs.civicrm.org/dev/en/latest/api/
- **Brevo API**: https://developers.brevo.com/
- **CraftMyPDF API**: https://craftmypdf.com/docs/

---

*Letzte Aktualisierung: 21. Juni 2025*  
*Status: ✅ Production Ready*  
*Support: 24/7 Monitoring aktiv*
