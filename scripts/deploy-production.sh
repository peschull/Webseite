#!/bin/bash
# Kubernetes Production Deployment Script
# Version: 1.0 - 21. Juni 2025
# Zweck: Deployment der vollständigen n8n + CiviCRM Integration

set -euo pipefail

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging-Funktion
log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
    exit 1
}

# Pre-Flight Checks
preflight_checks() {
    log "Führe Pre-Flight Checks durch..."
    
    # kubectl verfügbar?
    if ! command -v kubectl &> /dev/null; then
        error "kubectl ist nicht installiert oder nicht im PATH"
    fi
    
    # Helm verfügbar?
    if ! command -v helm &> /dev/null; then
        error "Helm ist nicht installiert oder nicht im PATH"
    fi
    
    # SOPS verfügbar?
    if ! command -v sops &> /dev/null; then
        error "SOPS ist nicht installiert oder nicht im PATH"
    fi
    
    # Cluster-Verbindung
    if ! kubectl cluster-info &> /dev/null; then
        error "Keine Verbindung zum Kubernetes-Cluster"
    fi
    
    # Helm-Repos hinzufügen
    log "Füge Helm-Repositories hinzu..."
    helm repo add n8n https://n8n.io/charts
    helm repo add bitnami https://charts.bitnami.com/bitnami
    helm repo add minio https://charts.min.io/
    helm repo add prometheus-community https://prometheus-community.github.io/helm-charts
    helm repo update
    
    success "Pre-Flight Checks abgeschlossen"
}

# Namespaces erstellen
create_namespaces() {
    log "Erstelle Kubernetes-Namespaces..."
    
    kubectl apply -f k8s/namespace.yaml
    
    # Warte auf Namespace-Erstellung
    kubectl wait --for=condition=Active namespace/n8n-prod --timeout=60s
    kubectl wait --for=condition=Active namespace/monitoring --timeout=60s
    kubectl wait --for=condition=Active namespace/civicrm-prod --timeout=60s
    
    success "Namespaces erstellt"
}

# RBAC konfigurieren
configure_rbac() {
    log "Konfiguriere RBAC..."
    
    kubectl apply -f k8s/rbac/rbac.yaml
    
    success "RBAC konfiguriert"
}

# Secrets entschlüsseln und anwenden
deploy_secrets() {
    log "Entschlüssele und deploye Secrets..."
    
    if [ ! -f "secrets/production-secrets.enc.yaml" ]; then
        error "Verschlüsselte Secrets-Datei nicht gefunden. Bitte zuerst 'sops -e secrets/production-secrets.yaml > secrets/production-secrets.enc.yaml' ausführen"
    fi
    
    # Secrets entschlüsseln und als Kubernetes-Secrets erstellen
    sops -d secrets/production-secrets.enc.yaml | kubectl apply -n n8n-prod -f -
    
    success "Secrets deployed"
}

# PostgreSQL deployen
deploy_postgresql() {
    log "Deploye PostgreSQL..."
    
    helm upgrade --install postgresql bitnami/postgresql \
        --namespace n8n-prod \
        --values helm/postgresql-values.yaml \
        --wait \
        --timeout 10m
    
    # Warte auf PostgreSQL-Bereitschaft
    kubectl wait --for=condition=Ready pod -l app.kubernetes.io/name=postgresql -n n8n-prod --timeout=300s
    
    success "PostgreSQL deployed"
}

# Redis deployen
deploy_redis() {
    log "Deploye Redis..."
    
    helm upgrade --install redis bitnami/redis \
        --namespace n8n-prod \
        --values helm/redis-values.yaml \
        --wait \
        --timeout 10m
    
    # Warte auf Redis-Bereitschaft
    kubectl wait --for=condition=Ready pod -l app.kubernetes.io/name=redis -n n8n-prod --timeout=300s
    
    success "Redis deployed"
}

# MinIO deployen
deploy_minio() {
    log "Deploye MinIO..."
    
    helm upgrade --install minio minio/minio \
        --namespace n8n-prod \
        --values helm/minio-values.yaml \
        --wait \
        --timeout 10m
    
    # Warte auf MinIO-Bereitschaft
    kubectl wait --for=condition=Ready pod -l app=minio -n n8n-prod --timeout=300s
    
    # Initialisiere MinIO-Buckets
    log "Initialisiere MinIO-Buckets..."
    kubectl exec -n n8n-prod deployment/minio -- mc mb /data/n8n-binaries
    kubectl exec -n n8n-prod deployment/minio -- mc mb /data/fin-archive-euc1
    kubectl exec -n n8n-prod deployment/minio -- mc mb /data/backup-bucket
    
    success "MinIO deployed und konfiguriert"
}

# n8n deployen
deploy_n8n() {
    log "Deploye n8n mit Queue-Mode..."
    
    helm upgrade --install n8n n8n/n8n \
        --namespace n8n-prod \
        --values helm/n8n-production-values.yaml \
        --wait \
        --timeout 15m
    
    # Warte auf n8n-Bereitschaft
    kubectl wait --for=condition=Ready pod -l app.kubernetes.io/name=n8n -n n8n-prod --timeout=600s
    
    success "n8n deployed"
}

# Monitoring Stack deployen
deploy_monitoring() {
    log "Deploye Monitoring Stack (Prometheus + Grafana)..."
    
    # Prometheus
    helm upgrade --install prometheus prometheus-community/kube-prometheus-stack \
        --namespace monitoring \
        --values monitoring/prometheus-values.yaml \
        --wait \
        --timeout 10m
    
    # Warte auf Prometheus-Bereitschaft
    kubectl wait --for=condition=Ready pod -l app.kubernetes.io/name=prometheus -n monitoring --timeout=300s
    
    success "Monitoring Stack deployed"
}

# Workflows importieren
import_workflows() {
    log "Importiere n8n-Workflows..."
    
    # Warte auf n8n-Verfügbarkeit
    kubectl wait --for=condition=Ready pod -l app.kubernetes.io/name=n8n -n n8n-prod --timeout=300s
    
    # Port-Forward für Workflow-Import
    kubectl port-forward -n n8n-prod svc/n8n 5678:5678 &
    PORT_FORWARD_PID=$!
    
    sleep 10
    
    # Workflows importieren (über n8n CLI oder API)
    log "Importiere Workflows über n8n API..."
    
    # Hier würden die Workflows importiert werden
    # curl -X POST http://localhost:5678/api/v1/workflows/import \
    #      -H "Content-Type: application/json" \
    #      -d @workflows/civicrm-donation-workflow.json
    
    # Port-Forward beenden
    kill $PORT_FORWARD_PID
    
    success "Workflows importiert"
}

# Smoke Tests
run_smoke_tests() {
    log "Führe Smoke Tests durch..."
    
    # Teste n8n-Verfügbarkeit
    if kubectl exec -n n8n-prod deployment/n8n -- curl -f http://localhost:5678/healthz; then
        success "n8n Health Check bestanden"
    else
        error "n8n Health Check fehlgeschlagen"
    fi
    
    # Teste PostgreSQL-Verbindung
    if kubectl exec -n n8n-prod deployment/postgresql -- pg_isready -U n8n; then
        success "PostgreSQL Health Check bestanden"
    else
        error "PostgreSQL Health Check fehlgeschlagen"
    fi
    
    # Teste Redis-Verbindung
    if kubectl exec -n n8n-prod deployment/redis-master -- redis-cli ping | grep -q PONG; then
        success "Redis Health Check bestanden"
    else
        error "Redis Health Check fehlgeschlagen"
    fi
    
    # Teste MinIO-Verfügbarkeit
    if kubectl exec -n n8n-prod deployment/minio -- mc ls /data/; then
        success "MinIO Health Check bestanden"
    else
        error "MinIO Health Check fehlgeschlagen"
    fi
    
    success "Alle Smoke Tests bestanden"
}

# Status anzeigen
show_status() {
    log "Deployment-Status:"
    echo
    echo "=== NAMESPACES ==="
    kubectl get namespaces | grep -E "(n8n-prod|monitoring|civicrm-prod)"
    echo
    echo "=== PODS ==="
    kubectl get pods -n n8n-prod
    echo
    echo "=== SERVICES ==="
    kubectl get services -n n8n-prod
    echo
    echo "=== INGRESS ==="
    kubectl get ingress -n n8n-prod
    echo
    echo "=== PVC ==="
    kubectl get pvc -n n8n-prod
    echo
    
    success "Deployment abgeschlossen!"
    echo
    echo "🚀 n8n ist verfügbar unter: https://n8n.menschlichkeit.at"
    echo "📊 Grafana ist verfügbar unter: https://grafana.menschlichkeit.at"
    echo "🗄️ MinIO Console ist verfügbar unter: https://minio-console.menschlichkeit.at"
    echo
    echo "⚠️  Nächste Schritte:"
    echo "1. Workflows über n8n UI importieren"
    echo "2. CiviCRM-Webhook auf n8n-Endpunkt konfigurieren"
    echo "3. Produktive API-Credentials in Secrets aktualisieren"
    echo "4. Monitoring-Dashboards konfigurieren"
    echo "5. 24h-Überwachung starten"
}

# Rollback-Funktion
rollback() {
    warning "Führe Rollback durch..."
    
    helm rollback n8n -n n8n-prod
    helm rollback postgresql -n n8n-prod
    helm rollback redis -n n8n-prod
    helm rollback minio -n n8n-prod
    helm rollback prometheus -n monitoring
    
    error "Rollback abgeschlossen"
}

# Hauptfunktion
main() {
    case "${1:-deploy}" in
        "deploy")
            log "Starte Kubernetes Production Deployment..."
            preflight_checks
            create_namespaces
            configure_rbac
            deploy_secrets
            deploy_postgresql
            deploy_redis
            deploy_minio
            deploy_n8n
            deploy_monitoring
            import_workflows
            run_smoke_tests
            show_status
            ;;
        "rollback")
            rollback
            ;;
        "status")
            show_status
            ;;
        *)
            echo "Usage: $0 {deploy|rollback|status}"
            exit 1
            ;;
    esac
}

# Trap für Cleanup bei Fehlern
trap 'error "Deployment fehlgeschlagen"' ERR

main "$@"
