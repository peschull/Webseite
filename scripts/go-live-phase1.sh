#!/bin/bash
set -euo pipefail

# Go-Live Infrastructure Setup Script
# Führt Phase 1 der Go-Live-Roadmap aus

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

check_prerequisites() {
    log_info "Prüfe Voraussetzungen..."
    
    if ! command -v kubectl &> /dev/null; then
        log_error "kubectl ist nicht installiert oder nicht im PATH"
        exit 1
    fi
    
    if ! command -v docker &> /dev/null; then
        log_error "Docker ist nicht installiert oder nicht verfügbar"
        exit 1
    fi
    
    if ! command -v helm &> /dev/null; then
        log_warning "Helm ist nicht installiert - installiere Helm..."
        curl https://get.helm.sh/helm-v3.12.0-linux-amd64.tar.gz -o helm.tar.gz
        tar -zxvf helm.tar.gz
        sudo mv linux-amd64/helm /usr/local/bin/helm
        rm -rf linux-amd64 helm.tar.gz
    fi
    
    log_success "Alle Voraussetzungen erfüllt"
}

setup_kubernetes_cluster() {
    log_info "Überprüfe Kubernetes-Cluster..."
    
    # Prüfe ob Cluster erreichbar ist
    if ! kubectl cluster-info &> /dev/null; then
        log_warning "Kein Kubernetes-Cluster verfügbar - starte lokales Kind-Cluster..."
        
        if ! command -v kind &> /dev/null; then
            log_info "Installiere Kind..."
            curl -Lo ./kind https://kind.sigs.k8s.io/dl/v0.20.0/kind-linux-amd64
            chmod +x ./kind
            sudo mv ./kind /usr/local/bin/kind
        fi
        
        # Erstelle Kind-Cluster
        cat <<EOF > kind-config.yaml
kind: Cluster
apiVersion: kind.x-k8s.io/v1alpha4
nodes:
- role: control-plane
  kubeadmConfigPatches:
  - |
    kind: InitConfiguration
    nodeRegistration:
      kubeletExtraArgs:
        node-labels: "ingress-ready=true"
  extraPortMappings:
  - containerPort: 80
    hostPort: 80
    protocol: TCP
  - containerPort: 443
    hostPort: 443
    protocol: TCP
- role: worker
EOF
        
        kind create cluster --config=kind-config.yaml --name=civicrm-golive
        rm kind-config.yaml
    fi
    
    log_success "Kubernetes-Cluster ist bereit"
}

create_secrets() {
    log_info "Erstelle Kubernetes-Secrets..."
    
    # Generiere sichere Passwörter
    DB_ROOT_PASS=$(openssl rand -base64 32)
    DB_USER_PASS=$(openssl rand -base64 32)
    N8N_ENCRYPTION_KEY=$(openssl rand -base64 32)
    CIVICRM_SITE_KEY=$(openssl rand -base64 32)
    
    # Erstelle Namespace falls nicht vorhanden
    kubectl create namespace civicrm-staging --dry-run=client -o yaml | kubectl apply -f -
    
    # Erstelle DB-Secrets
    kubectl create secret generic db-secrets \
        --namespace=civicrm-staging \
        --from-literal=root-password="$DB_ROOT_PASS" \
        --from-literal=user-password="$DB_USER_PASS" \
        --dry-run=client -o yaml | kubectl apply -f -
    
    # Erstelle n8n-Secrets
    kubectl create secret generic n8n-secrets \
        --namespace=civicrm-staging \
        --from-literal=encryption-key="$N8N_ENCRYPTION_KEY" \
        --from-literal=webhook-url="https://staging.menschlichkeit.at/webhook" \
        --dry-run=client -o yaml | kubectl apply -f -
    
    # Erstelle CiviCRM-Secrets
    kubectl create secret generic civicrm-secrets \
        --namespace=civicrm-staging \
        --from-literal=site-key="$CIVICRM_SITE_KEY" \
        --from-literal=db-host="mariadb-staging" \
        --from-literal=db-name="civicrm_staging" \
        --from-literal=db-user="civicrm" \
        --from-literal=db-password="$DB_USER_PASS" \
        --dry-run=client -o yaml | kubectl apply -f -
    
    # Speichere Secrets für spätere Verwendung
    cat > "$PROJECT_ROOT/.secrets-staging" <<EOF
DB_ROOT_PASSWORD=$DB_ROOT_PASS
DB_USER_PASSWORD=$DB_USER_PASS
N8N_ENCRYPTION_KEY=$N8N_ENCRYPTION_KEY
CIVICRM_SITE_KEY=$CIVICRM_SITE_KEY
EOF
    chmod 600 "$PROJECT_ROOT/.secrets-staging"
    
    log_success "Secrets erstellt und gespeichert in .secrets-staging"
}

deploy_infrastructure() {
    log_info "Deploye Staging-Infrastruktur..."
    
    # Deploye Staging-Environment
    kubectl apply -f "$PROJECT_ROOT/infrastructure/staging-environment.yaml"
    
    # Warte auf MariaDB
    log_info "Warte auf MariaDB-Deployment..."
    kubectl wait --for=condition=available --timeout=300s deployment/mariadb-staging -n civicrm-staging
    
    # Warte auf Redis
    log_info "Warte auf Redis-Deployment..."
    kubectl wait --for=condition=available --timeout=300s deployment/redis-staging -n civicrm-staging
    
    log_success "Staging-Infrastruktur erfolgreich deployed"
}

setup_monitoring() {
    log_info "Installiere Monitoring-Stack..."
    
    # Erstelle Monitoring-Namespace
    kubectl create namespace monitoring --dry-run=client -o yaml | kubectl apply -f -
    
    # Installiere kube-prometheus-stack via Helm
    helm repo add prometheus-community https://prometheus-community.github.io/helm-charts
    helm repo update
    
    helm upgrade --install kube-prometheus-stack prometheus-community/kube-prometheus-stack \
        --namespace monitoring \
        --set prometheus.prometheusSpec.serviceMonitorSelectorNilUsesHelmValues=false \
        --set prometheus.prometheusSpec.retention=30d \
        --set grafana.adminPassword=admin123 \
        --set alertmanager.config.global.slack_api_url="https://hooks.slack.com/services/YOUR/SLACK/WEBHOOK" \
        --wait
    
    log_success "Monitoring-Stack installiert"
}

run_health_checks() {
    log_info "Führe Gesundheitschecks durch..."
    
    # Prüfe Pod-Status
    kubectl get pods -n civicrm-staging
    kubectl get pods -n monitoring
    
    # Prüfe Services
    kubectl get services -n civicrm-staging
    
    # Teste Datenbankverbindung
    log_info "Teste MariaDB-Verbindung..."
    kubectl exec -n civicrm-staging deployment/mariadb-staging -- mysql -u root -p"$(grep DB_ROOT_PASSWORD "$PROJECT_ROOT/.secrets-staging" | cut -d'=' -f2)" -e "SHOW DATABASES;"
    
    log_success "Alle Gesundheitschecks bestanden"
}

generate_go_live_status() {
    log_info "Generiere Go-Live-Status-Report..."
    
    cat > "$PROJECT_ROOT/GO_LIVE_STATUS_$(date +%Y%m%d_%H%M%S).md" <<EOF
# Go-Live Status Report

**Datum:** $(date '+%Y-%m-%d %H:%M:%S')
**Phase:** 1 - Infrastruktur-Setup
**Status:** ABGESCHLOSSEN ✅

## Durchgeführte Schritte

### ✅ Kubernetes-Cluster
- Cluster-Status: $(kubectl cluster-info --short 2>/dev/null | head -1 || echo "Nicht verfügbar")
- Namespaces: civicrm-staging, monitoring

### ✅ Infrastruktur-Komponenten
\`\`\`
$(kubectl get pods -n civicrm-staging 2>/dev/null || echo "Keine Pods gefunden")
\`\`\`

### ✅ Monitoring
\`\`\`
$(kubectl get pods -n monitoring 2>/dev/null | grep -E "(prometheus|grafana|alertmanager)" || echo "Monitoring nicht verfügbar")
\`\`\`

### ✅ Secrets
- Datenbank-Credentials: ✅ Erstellt
- n8n-Encryption-Key: ✅ Erstellt
- CiviCRM-Site-Key: ✅ Erstellt

## Nächste Schritte (Phase 2)
1. CiviCRM-Deployment
2. n8n-Workflow-Migration
3. SSL-Zertifikate
4. Domain-Setup

## Zugriff
- Grafana: \`kubectl port-forward -n monitoring svc/kube-prometheus-stack-grafana 3000:80\`
- MariaDB: \`kubectl port-forward -n civicrm-staging svc/mariadb-staging 3306:3306\`

EOF

    log_success "Status-Report erstellt: GO_LIVE_STATUS_$(date +%Y%m%d_%H%M%S).md"
}

main() {
    log_info "🚀 Starte Go-Live Phase 1: Infrastruktur-Setup"
    log_info "========================================================"
    
    check_prerequisites
    setup_kubernetes_cluster
    create_secrets
    deploy_infrastructure
    setup_monitoring
    run_health_checks
    generate_go_live_status
    
    log_success "🎉 Phase 1 erfolgreich abgeschlossen!"
    log_info ""
    log_info "Nächste Schritte:"
    log_info "1. Führe 'scripts/go-live-phase2.sh' aus"
    log_info "2. Überprüfe Monitoring: kubectl port-forward -n monitoring svc/kube-prometheus-stack-grafana 3000:80"
    log_info "3. Teste Staging-Environment"
}

# Ausführung nur wenn Script direkt aufgerufen wird
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
