# 🚀 GO-LIVE ROADMAP - Nächste Schritte

## 📋 PRIORITÄTS-MATRIX (21. Juni 2025)

### ✅ **ABGESCHLOSSEN** (Entwicklungsumgebung)
- **39/39 Workflow-Tests** bestanden
- **Node.js/PHP/Python** Abhängigkeiten installiert
- **Phase III Dokumentation** vollständig
- **Test-Payloads** für alle 18 Workflows validiert
- **CEX-ID Cross-Workflow** Integration getestet

---

## 🔥 **KRITISCHER PFAD** (Nächste 7 Tage)

### 🎯 **Tag 1-2: Infrastruktur** (DevOps Priority HIGH)
```bash
# Kubernetes Cluster Setup
kubectl cluster-info
helm repo add n8n https://n8n.io/charts
kubectl create namespace n8n-prod

# Monitoring Stack
helm repo add prometheus-community https://prometheus-community.github.io/helm-charts
helm repo add grafana https://grafana.github.io/helm-charts
```

**Deliverables:**
- [ ] K8s Cluster (v1.28+) betriebsbereit
- [ ] n8n Helm Chart mit Queue-Mode deployed
- [ ] Prometheus/Grafana/Alertmanager Setup
- [ ] MinIO S3 mit Buckets `n8n-binaries` + `fin-archive-euc1`

---

### 🎯 **Tag 2-3: CiviCRM Production** (Business Priority HIGH)
**Deliverables:**
- [ ] CiviCRM 5.82+ Installation mit Extensions:
  - CiviRules 2.x
  - Mosaico 2.6  
  - CiviCRM Webhooks
- [ ] Custom Fields (cex_id, ff_voucher_id, etc.)
- [ ] Mitgliedschaftstypen (48€/144€/24€/0€)
- [ ] API-User mit minimalen Rechten
- [ ] Webhook → n8n Production URL

---

### 🎯 **Tag 3-4: API Credentials** (Security Priority HIGH)
**Deliverables:**
- [ ] **Produktions-API-Keys** für:
  - CraftMyPDF (Produktionsaccount)
  - Brevo SMTP (Produktionsdomäne)  
  - FreeFinance API v1.1
  - OpenAI (erhöhte Rate-Limits)
  - Meta Business (App Review abgeschlossen)
  - LinkedIn Business (verifiziert)
- [ ] **SOPS-Verschlüsselung** aller Secrets
- [ ] **Kubernetes Secrets** deployed

---

### 🎯 **Tag 4-5: Integration Tests** (QA Priority HIGH)
**Deliverables:**
- [ ] **End-to-End-Tests** auf Staging
- [ ] **18 Workflows** (F-01 bis F-18) produktiv deployed
- [ ] **Queue-Processing** (default/email/accounting/social) getestet
- [ ] **Load-Tests**: 100 Spenden/Min Peak-Load
- [ ] **Business-Akzeptanz** durch Fachabteilung

---

### 🎯 **Tag 5-6: Security & Compliance** (Legal Priority HIGH)
**Deliverables:**
- [ ] **DSGVO-DPIA** final abgenommen
- [ ] **Auftragsverarbeiterverträge** unterzeichnet
- [ ] **BAO §132** 7-Jahre-Archivierung validiert
- [ ] **Penetration Testing** abgeschlossen
- [ ] **Security-Audit** bestanden

---

### 🎯 **Tag 6-7: Go-Live Vorbereitung** (SRE Priority HIGH)
**Deliverables:**
- [ ] **Monitoring & Alerting** scharf geschaltet
- [ ] **Backup & Recovery** getestet
- [ ] **Runbooks** für Incident Response
- [ ] **Communication-Plan** finalisiert
- [ ] **War-Room** Setup für Go-Live

---

## 📊 **SUCCESS METRICS**

### KPIs für Go-Live (48h nach Aktivierung):
- **✅ Verfügbarkeit**: >99.5%
- **✅ Response Time**: <3s p95
- **✅ Error Rate**: <1%
- **✅ Queue Lag**: <30s p99
- **✅ Business Impact**: 0 verlorene Spenden

---

## 👥 **TEAM RESPONSIBILITIES**

| Team | Verantwortung | Zeitrahmen |
|------|---------------|------------|
| **DevOps/SRE** | Kubernetes + Monitoring | Tag 1-3 |
| **Security** | API-Credentials + Compliance | Tag 3-5 |
| **Business** | CiviCRM + Mitgliederdaten | Tag 2-4 |
| **QA** | Testing + Akzeptanz | Tag 4-6 |
| **Management** | Go-Live-Entscheidung | Tag 6-7 |

---

## 🚨 **ROLLBACK-KRITERIEN**

**Sofortiger Rollback bei:**
- Error Rate >5% bei kritischen Workflows
- Queue Lag >2min für >10min
- Datenschutz-Verletzung identifiziert  
- Financial Impact >€500 durch Fehler

**Rollback-Command:**
```bash
helm rollback n8n-production -n n8n-prod
kubectl apply -f k8s/emergency-maintenance.yaml
```

---

## 🎯 **GO-LIVE TIMELINE**

**Target Date:** **T+7 Tage** (28. Juni 2025)

**09:00** - DNS-Umstellung  
**09:15** - Smoke Tests  
**09:30** - Production Traffic  
**12:00** - Business Validation  
**17:00** - 24h Monitoring beginnt  

---

**🚀 STATUS: READY FOR PRODUCTION SPRINT**

*Die Entwicklungsphase ist abgeschlossen. Alle Tests bestanden.  
Die Produktionsumgebung ist der nächste kritische Meilenstein.*
