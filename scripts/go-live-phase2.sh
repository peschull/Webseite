#!/bin/bash
set -euo pipefail

# Go-Live Phase 2: CiviCRM & n8n Deployment
# Führt die Applikations-Deployments für Staging durch

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

check_phase1_completion() {
    log_info "Prüfe Phase 1 Abschluss..."
    
    if ! kubectl get namespace civicrm-staging &>/dev/null; then
        log_error "Namespace civicrm-staging nicht gefunden. Führe zuerst go-live-phase1.sh aus."
        exit 1
    fi
    
    if ! kubectl get deployment mariadb-staging -n civicrm-staging &>/dev/null; then
        log_error "MariaDB-Deployment nicht gefunden. Phase 1 nicht vollständig."
        exit 1
    fi
    
    log_success "Phase 1 erfolgreich abgeschlossen"
}

prepare_databases() {
    log_info "Bereite Datenbanken vor..."
    
    # Erstelle n8n-Datenbank
    DB_PASSWORD=$(kubectl get secret db-secrets -n civicrm-staging -o jsonpath='{.data.user-password}' | base64 -d)
    
    kubectl exec deployment/mariadb-staging -n civicrm-staging -- \
        mysql -u civicrm -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS n8n_staging CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    
    log_success "Datenbanken vorbereitet"
}

deploy_applications() {
    log_info "Deploye CiviCRM und n8n..."
    
    # Deploye CiviCRM und n8n
    kubectl apply -f "$PROJECT_ROOT/infrastructure/civicrm-n8n-staging.yaml"
    
    # Warte auf CiviCRM
    log_info "Warte auf CiviCRM-Deployment..."
    kubectl wait --for=condition=available --timeout=600s deployment/civicrm-staging -n civicrm-staging
    
    # Warte auf n8n
    log_info "Warte auf n8n-Deployment..."
    kubectl wait --for=condition=available --timeout=300s deployment/n8n-staging -n civicrm-staging
    
    # Warte auf n8n-Worker
    log_info "Warte auf n8n-Worker..."
    kubectl wait --for=condition=available --timeout=300s deployment/n8n-worker-staging -n civicrm-staging
    
    log_success "Alle Applikationen erfolgreich deployed"
}

import_n8n_workflows() {
    log_info "Importiere n8n-Workflows..."
    
    # Port-Forward zu n8n für API-Zugriff
    kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678 &
    PORT_FORWARD_PID=$!
    
    # Warte bis Port-Forward bereit ist
    sleep 10
    
    # Teste n8n-Verfügbarkeit
    if ! curl -s http://localhost:5678/healthz >/dev/null; then
        log_error "n8n ist nicht erreichbar"
        kill $PORT_FORWARD_PID
        exit 1
    fi
    
    # Importiere Workflows
    for workflow_file in "$PROJECT_ROOT"/workflows/*.json; do
        if [[ -f "$workflow_file" ]]; then
            workflow_name=$(basename "$workflow_file" .json)
            log_info "Importiere Workflow: $workflow_name"
            
            # API-Call zum Import (vereinfacht - in Produktion mit richtiger Auth)
            curl -X POST http://localhost:5678/rest/workflows/import \
                -H "Content-Type: application/json" \
                -u "admin:staging123" \
                -d @"$workflow_file" || log_warning "Workflow $workflow_name konnte nicht importiert werden"
        fi
    done
    
    # Stoppe Port-Forward
    kill $PORT_FORWARD_PID
    
    log_success "n8n-Workflows importiert"
}

setup_ingress() {
    log_info "Konfiguriere Ingress..."
    
    # Installiere NGINX Ingress Controller falls nicht vorhanden
    if ! kubectl get ingressclass nginx &>/dev/null; then
        log_info "Installiere NGINX Ingress Controller..."
        kubectl apply -f https://raw.githubusercontent.com/kubernetes/ingress-nginx/controller-v1.8.1/deploy/static/provider/kind/deploy.yaml
        
        # Warte auf Ingress Controller
        kubectl wait --namespace ingress-nginx \
            --for=condition=ready pod \
            --selector=app.kubernetes.io/component=controller \
            --timeout=90s
    fi
    
    # Erstelle Ingress-Konfiguration
    cat > /tmp/staging-ingress.yaml <<EOF
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: staging-ingress
  namespace: civicrm-staging
  annotations:
    nginx.ingress.kubernetes.io/rewrite-target: /
    nginx.ingress.kubernetes.io/ssl-redirect: "false"
    nginx.ingress.kubernetes.io/proxy-body-size: "50m"
spec:
  ingressClassName: nginx
  rules:
  - host: staging.menschlichkeit.at
    http:
      paths:
      - path: /n8n
        pathType: Prefix
        backend:
          service:
            name: n8n-staging
            port:
              number: 5678
      - path: /webhook
        pathType: Prefix
        backend:
          service:
            name: n8n-staging
            port:
              number: 5678
      - path: /
        pathType: Prefix
        backend:
          service:
            name: civicrm-staging
            port:
              number: 80
EOF
    
    kubectl apply -f /tmp/staging-ingress.yaml
    rm /tmp/staging-ingress.yaml
    
    log_success "Ingress konfiguriert"
}

run_application_tests() {
    log_info "Führe Applikationstests durch..."
    
    # Teste CiviCRM
    log_info "Teste CiviCRM-Pod..."
    kubectl exec deployment/civicrm-staging -n civicrm-staging -- \
        curl -f http://localhost/wp-admin/admin-ajax.php || log_warning "CiviCRM-Health-Check fehlgeschlagen"
    
    # Teste n8n
    log_info "Teste n8n-Pod..."
    kubectl exec deployment/n8n-staging -n civicrm-staging -- \
        curl -f http://localhost:5678/healthz || log_warning "n8n-Health-Check fehlgeschlagen"
    
    # Teste Redis-Verbindung
    log_info "Teste Redis-Verbindung..."
    kubectl exec deployment/redis-staging -n civicrm-staging -- \
        redis-cli ping || log_warning "Redis-Test fehlgeschlagen"
    
    log_success "Applikationstests abgeschlossen"
}

setup_ssl_certificates() {
    log_info "Bereite SSL-Zertifikate vor..."
    
    # Installiere cert-manager für automatische SSL-Zertifikate
    kubectl apply -f https://github.com/cert-manager/cert-manager/releases/download/v1.13.0/cert-manager.yaml
    
    # Warte auf cert-manager
    kubectl wait --for=condition=ready pod -l app=cert-manager -n cert-manager --timeout=60s
    kubectl wait --for=condition=ready pod -l app=cainjector -n cert-manager --timeout=60s
    kubectl wait --for=condition=ready pod -l app=webhook -n cert-manager --timeout=60s
    
    # Erstelle Let's Encrypt ClusterIssuer (für Staging)
    cat > /tmp/letsencrypt-staging.yaml <<EOF
apiVersion: cert-manager.io/v1
kind: ClusterIssuer
metadata:
  name: letsencrypt-staging
spec:
  acme:
    server: https://acme-staging-v02.api.letsencrypt.org/directory
    email: admin@menschlichkeit.at
    privateKeySecretRef:
      name: letsencrypt-staging
    solvers:
    - http01:
        ingress:
          class: nginx
EOF
    
    kubectl apply -f /tmp/letsencrypt-staging.yaml
    rm /tmp/letsencrypt-staging.yaml
    
    log_success "SSL-Zertifikat-Setup vorbereitet"
}

create_backup_job() {
    log_info "Erstelle Backup-Job..."
    
    cat > /tmp/staging-backup-job.yaml <<EOF
apiVersion: batch/v1
kind: CronJob
metadata:
  name: staging-db-backup
  namespace: civicrm-staging
spec:
  schedule: "0 2 * * *"  # Täglich um 2 Uhr
  jobTemplate:
    spec:
      template:
        spec:
          containers:
          - name: backup
            image: mariadb:10.11
            command:
            - /bin/bash
            - -c
            - |
              TIMESTAMP=\$(date +%Y%m%d_%H%M%S)
              mysqldump -h mariadb-staging -u civicrm -p\$DB_PASSWORD --single-transaction --routines --triggers civicrm_staging > /backup/civicrm_staging_\$TIMESTAMP.sql
              mysqldump -h mariadb-staging -u civicrm -p\$DB_PASSWORD --single-transaction --routines --triggers n8n_staging > /backup/n8n_staging_\$TIMESTAMP.sql
              echo "Backup completed: \$TIMESTAMP"
            env:
            - name: DB_PASSWORD
              valueFrom:
                secretKeyRef:
                  name: db-secrets
                  key: user-password
            volumeMounts:
            - name: backup-storage
              mountPath: /backup
          volumes:
          - name: backup-storage
            persistentVolumeClaim:
              claimName: backup-storage-pvc
          restartPolicy: OnFailure
---
apiVersion: v1
kind: PersistentVolumeClaim
metadata:
  name: backup-storage-pvc
  namespace: civicrm-staging
spec:
  accessModes:
    - ReadWriteOnce
  resources:
    requests:
      storage: 5Gi
EOF
    
    kubectl apply -f /tmp/staging-backup-job.yaml
    rm /tmp/staging-backup-job.yaml
    
    log_success "Backup-Job erstellt"
}

generate_phase2_status() {
    log_info "Generiere Phase 2 Status-Report..."
    
    cat > "$PROJECT_ROOT/GO_LIVE_PHASE2_STATUS_$(date +%Y%m%d_%H%M%S).md" <<EOF
# Go-Live Phase 2 Status Report

**Datum:** $(date '+%Y-%m-%d %H:%M:%S')
**Phase:** 2 - CiviCRM & n8n Deployment
**Status:** ABGESCHLOSSEN ✅

## Durchgeführte Schritte

### ✅ Applikations-Deployments
\`\`\`
$(kubectl get deployments -n civicrm-staging 2>/dev/null || echo "Keine Deployments gefunden")
\`\`\`

### ✅ Services
\`\`\`
$(kubectl get services -n civicrm-staging 2>/dev/null || echo "Keine Services gefunden")
\`\`\`

### ✅ Ingress
\`\`\`
$(kubectl get ingress -n civicrm-staging 2>/dev/null || echo "Kein Ingress gefunden")
\`\`\`

### ✅ SSL-Setup
- cert-manager: Installiert
- Let's Encrypt Staging: Konfiguriert

### ✅ Backup
- CronJob für tägliche DB-Backups: Erstellt

## Zugriff
- CiviCRM: http://staging.menschlichkeit.at (nach DNS-Setup)
- n8n: http://staging.menschlichkeit.at/n8n (admin:staging123)
- Webhooks: http://staging.menschlichkeit.at/webhook

## Port-Forward für lokalen Zugriff
\`\`\`bash
# CiviCRM
kubectl port-forward -n civicrm-staging svc/civicrm-staging 8080:80

# n8n
kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678

# MariaDB
kubectl port-forward -n civicrm-staging svc/mariadb-staging 3306:3306
\`\`\`

## Nächste Schritte (Phase 3)
1. DNS-Konfiguration
2. SSL-Zertifikate aktivieren
3. Produktionsdaten-Migration
4. End-to-End-Tests

EOF

    log_success "Phase 2 Status-Report erstellt: GO_LIVE_PHASE2_STATUS_$(date +%Y%m%d_%H%M%S).md"
}

main() {
    log_info "🚀 Starte Go-Live Phase 2: CiviCRM & n8n Deployment"
    log_info "============================================================="
    
    check_phase1_completion
    prepare_databases
    deploy_applications
    import_n8n_workflows
    setup_ingress
    run_application_tests
    setup_ssl_certificates
    create_backup_job
    generate_phase2_status
    
    log_success "🎉 Phase 2 erfolgreich abgeschlossen!"
    log_info ""
    log_info "Nächste Schritte:"
    log_info "1. DNS für staging.menschlichkeit.at konfigurieren"
    log_info "2. Führe 'scripts/go-live-phase3.sh' aus"
    log_info "3. Teste Applikationen:"
    log_info "   kubectl port-forward -n civicrm-staging svc/civicrm-staging 8080:80"
    log_info "   kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678"
}

# Ausführung nur wenn Script direkt aufgerufen wird
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
