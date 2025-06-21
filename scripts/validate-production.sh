# Pre-Production Validation Script
# Version: 1.0 - 21. Juni 2025
# Zweck: Validierung vor Go-Live

#!/bin/bash

set -euo pipefail

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

success() {
    echo -e "${GREEN}[✓]${NC} $1"
}

warning() {
    echo -e "${YELLOW}[⚠]${NC} $1"
}

error() {
    echo -e "${RED}[✗]${NC} $1"
}

# Validierungsresultate
VALIDATION_RESULTS=()
CRITICAL_FAILURES=0
WARNINGS=0

add_result() {
    local status=$1
    local message=$2
    VALIDATION_RESULTS+=("$status: $message")
    
    if [ "$status" = "CRITICAL" ]; then
        ((CRITICAL_FAILURES++))
        error "$message"
    elif [ "$status" = "WARNING" ]; then
        ((WARNINGS++))
        warning "$message"
    else
        success "$message"
    fi
}

# 1. Kubernetes Cluster Validation
validate_kubernetes_cluster() {
    log "Validiere Kubernetes Cluster..."
    
    # Cluster-Verbindung
    if kubectl cluster-info &>/dev/null; then
        add_result "SUCCESS" "Kubernetes Cluster erreichbar"
    else
        add_result "CRITICAL" "Kubernetes Cluster nicht erreichbar"
        return 1
    fi
    
    # Cluster-Version
    local k8s_version=$(kubectl version --short --client | grep -o 'v[0-9]*\.[0-9]*')
    if [[ "$k8s_version" > "v1.28" ]] || [[ "$k8s_version" = "v1.28" ]]; then
        add_result "SUCCESS" "Kubernetes Version $k8s_version (≥v1.28 erforderlich)"
    else
        add_result "CRITICAL" "Kubernetes Version $k8s_version zu alt (≥v1.28 erforderlich)"
    fi
    
    # Nodes verfügbar
    local ready_nodes=$(kubectl get nodes --no-headers | grep -c " Ready ")
    if [ "$ready_nodes" -ge 3 ]; then
        add_result "SUCCESS" "$ready_nodes Kubernetes Nodes verfügbar"
    elif [ "$ready_nodes" -ge 1 ]; then
        add_result "WARNING" "Nur $ready_nodes Kubernetes Node(s) verfügbar (≥3 empfohlen für HA)"
    else
        add_result "CRITICAL" "Keine verfügbaren Kubernetes Nodes"
    fi
    
    # Storage Classes
    if kubectl get storageclass fast-ssd &>/dev/null; then
        add_result "SUCCESS" "Storage Class 'fast-ssd' verfügbar"
    else
        add_result "WARNING" "Storage Class 'fast-ssd' nicht verfügbar - verwende 'default'"
    fi
}

# 2. Helm Validation
validate_helm() {
    log "Validiere Helm..."
    
    # Helm installiert
    if command -v helm &>/dev/null; then
        local helm_version=$(helm version --short | grep -o 'v[0-9]*\.[0-9]*')
        if [[ "$helm_version" > "v3.12" ]] || [[ "$helm_version" = "v3.12" ]]; then
            add_result "SUCCESS" "Helm Version $helm_version (≥v3.12 erforderlich)"
        else
            add_result "CRITICAL" "Helm Version $helm_version zu alt (≥v3.12 erforderlich)"
        fi
    else
        add_result "CRITICAL" "Helm nicht installiert"
        return 1
    fi
    
    # Helm Repositories
    local required_repos=("n8n" "bitnami" "minio" "prometheus-community")
    for repo in "${required_repos[@]}"; do
        if helm repo list | grep -q "$repo"; then
            add_result "SUCCESS" "Helm Repository '$repo' konfiguriert"
        else
            add_result "WARNING" "Helm Repository '$repo' nicht konfiguriert - wird automatisch hinzugefügt"
        fi
    done
    
    # Helm Repository Update
    if helm repo update &>/dev/null; then
        add_result "SUCCESS" "Helm Repositories aktualisiert"
    else
        add_result "WARNING" "Helm Repository Update fehlgeschlagen"
    fi
}

# 3. SOPS/Secrets Validation
validate_secrets() {
    log "Validiere Secrets Management..."
    
    # SOPS installiert
    if command -v sops &>/dev/null; then
        add_result "SUCCESS" "SOPS installiert"
    else
        add_result "CRITICAL" "SOPS nicht installiert - erforderlich für Secrets-Verschlüsselung"
        return 1
    fi
    
    # age installiert
    if command -v age &>/dev/null; then
        add_result "SUCCESS" "age installiert"
    else
        add_result "CRITICAL" "age nicht installiert - erforderlich für SOPS-Verschlüsselung"
    fi
    
    # Secrets-Datei vorhanden
    if [ -f "secrets/production-secrets.yaml" ]; then
        add_result "SUCCESS" "Secrets Template vorhanden"
    else
        add_result "CRITICAL" "Secrets Template fehlt"
    fi
    
    # Verschlüsselte Secrets
    if [ -f "secrets/production-secrets.enc.yaml" ]; then
        add_result "SUCCESS" "Verschlüsselte Secrets vorhanden"
        
        # SOPS-Entschlüsselung testen
        if sops -d secrets/production-secrets.enc.yaml &>/dev/null; then
            add_result "SUCCESS" "SOPS-Entschlüsselung funktional"
        else
            add_result "CRITICAL" "SOPS-Entschlüsselung fehlgeschlagen"
        fi
    else
        add_result "WARNING" "Verschlüsselte Secrets fehlen - müssen vor Deployment erstellt werden"
    fi
}

# 4. DNS/Ingress Validation
validate_dns_ingress() {
    log "Validiere DNS und Ingress..."
    
    # Ingress Controller
    if kubectl get pods -A | grep -q "ingress-nginx\|traefik"; then
        add_result "SUCCESS" "Ingress Controller verfügbar"
    else
        add_result "CRITICAL" "Kein Ingress Controller gefunden"
    fi
    
    # cert-manager
    if kubectl get pods -n cert-manager &>/dev/null; then
        add_result "SUCCESS" "cert-manager verfügbar"
    else
        add_result "WARNING" "cert-manager nicht gefunden - SSL-Zertifikate müssen manuell konfiguriert werden"
    fi
    
    # DNS-Auflösung testen (falls möglich)
    local test_domains=("n8n.menschlichkeit.at" "grafana.menschlichkeit.at" "minio-console.menschlichkeit.at")
    for domain in "${test_domains[@]}"; do
        if nslookup "$domain" &>/dev/null; then
            add_result "SUCCESS" "DNS-Auflösung für $domain funktional"
        else
            add_result "WARNING" "DNS-Auflösung für $domain fehlgeschlagen - Domain möglicherweise noch nicht konfiguriert"
        fi
    done
}

# 5. Resource Requirements Validation
validate_resources() {
    log "Validiere Cluster-Ressourcen..."
    
    # CPU-Ressourcen
    local total_cpu=$(kubectl describe nodes | grep -E "cpu:" | awk '{sum += $2} END {print sum}')
    if [ "${total_cpu:-0}" -ge 20 ]; then
        add_result "SUCCESS" "Ausreichend CPU-Ressourcen ($total_cpu cores)"
    elif [ "${total_cpu:-0}" -ge 10 ]; then
        add_result "WARNING" "Begrenzte CPU-Ressourcen ($total_cpu cores) - Performance könnte beeinträchtigt sein"
    else
        add_result "CRITICAL" "Unzureichende CPU-Ressourcen ($total_cpu cores) - mindestens 10 cores erforderlich"
    fi
    
    # Memory-Ressourcen
    local total_memory=$(kubectl describe nodes | grep -E "memory:" | awk '{sum += $2} END {print sum}')
    if [ "${total_memory:-0}" -ge 40000000 ]; then  # ~40GB
        add_result "SUCCESS" "Ausreichend Memory-Ressourcen"
    elif [ "${total_memory:-0}" -ge 20000000 ]; then  # ~20GB
        add_result "WARNING" "Begrenzte Memory-Ressourcen - Performance könnte beeinträchtigt sein"
    else
        add_result "CRITICAL" "Unzureichende Memory-Ressourcen - mindestens 20GB erforderlich"
    fi
    
    # Storage verfügbar
    if kubectl get storageclass &>/dev/null; then
        local storage_classes=$(kubectl get storageclass --no-headers | wc -l)
        add_result "SUCCESS" "$storage_classes Storage Class(es) verfügbar"
    else
        add_result "CRITICAL" "Keine Storage Classes verfügbar"
    fi
}

# 6. Network Connectivity Validation
validate_network() {
    log "Validiere Netzwerk-Konnektivität..."
    
    # Externe APIs erreichbar
    local external_apis=(
        "https://api.craftmypdf.com"
        "https://api.brevo.com"
        "https://api.freefinance.com"
        "https://api.openai.com"
        "https://graph.facebook.com"
        "https://api.linkedin.com"
    )
    
    local reachable_apis=0
    for api in "${external_apis[@]}"; do
        if curl -s --connect-timeout 5 "$api" &>/dev/null; then
            ((reachable_apis++))
        fi
    done
    
    if [ "$reachable_apis" -eq "${#external_apis[@]}" ]; then
        add_result "SUCCESS" "Alle externen APIs erreichbar"
    elif [ "$reachable_apis" -gt 0 ]; then
        add_result "WARNING" "$reachable_apis von ${#external_apis[@]} externen APIs erreichbar"
    else
        add_result "CRITICAL" "Keine externen APIs erreichbar - Netzwerk-/Firewall-Problem"
    fi
    
    # Docker Registry erreichbar
    if curl -s --connect-timeout 5 "https://registry-1.docker.io" &>/dev/null; then
        add_result "SUCCESS" "Docker Registry erreichbar"
    else
        add_result "WARNING" "Docker Registry nicht erreichbar - Container-Images könnten nicht geladen werden"
    fi
}

# 7. Security Validation
validate_security() {
    log "Validiere Sicherheitskonfiguration..."
    
    # RBAC aktiviert
    if kubectl auth can-i --list &>/dev/null; then
        add_result "SUCCESS" "RBAC aktiviert"
    else
        add_result "CRITICAL" "RBAC nicht aktiviert oder nicht konfiguriert"
    fi
    
    # Pod Security Policies/Pod Security Standards
    if kubectl get psp &>/dev/null 2>&1 || kubectl get --raw /api/v1/namespaces/default | grep -q "pod-security"; then
        add_result "SUCCESS" "Pod Security konfiguriert"
    else
        add_result "WARNING" "Pod Security Policies/Standards nicht konfiguriert"
    fi
    
    # Network Policies Support
    if kubectl explain networkpolicy &>/dev/null; then
        add_result "SUCCESS" "Network Policies unterstützt"
    else
        add_result "WARNING" "Network Policies nicht unterstützt - Netzwerk-Isolation eingeschränkt"
    fi
}

# 8. Backup/DR Validation
validate_backup_dr() {
    log "Validiere Backup und Disaster Recovery..."
    
    # Backup-Storage verfügbar
    if kubectl get storageclass | grep -q "backup\|archive"; then
        add_result "SUCCESS" "Backup-Storage konfiguriert"
    else
        add_result "WARNING" "Keine dedizierte Backup-Storage Class - verwende Standard-Storage"
    fi
    
    # Cross-Region Replikation möglich
    if [ -n "${AWS_ACCESS_KEY_ID:-}" ] && [ -n "${AWS_SECRET_ACCESS_KEY:-}" ]; then
        add_result "SUCCESS" "AWS-Credentials für Cross-Region-Backup vorhanden"
    else
        add_result "WARNING" "AWS-Credentials fehlen - Cross-Region-Backup nicht möglich"
    fi
}

# Haupt-Validierung
main() {
    log "🚀 Starte Pre-Production Validation..."
    echo
    
    validate_kubernetes_cluster
    validate_helm
    validate_secrets
    validate_dns_ingress
    validate_resources
    validate_network
    validate_security
    validate_backup_dr
    
    echo
    log "📊 Validierungsergebnisse:"
    echo "=================================="
    
    for result in "${VALIDATION_RESULTS[@]}"; do
        echo "$result"
    done
    
    echo
    echo "📈 Zusammenfassung:"
    echo "- Erfolgreich: $((${#VALIDATION_RESULTS[@]} - CRITICAL_FAILURES - WARNINGS))"
    echo "- Warnungen: $WARNINGS"
    echo "- Kritische Fehler: $CRITICAL_FAILURES"
    echo
    
    if [ "$CRITICAL_FAILURES" -eq 0 ]; then
        if [ "$WARNINGS" -eq 0 ]; then
            success "🎉 Alle Validierungen bestanden - BEREIT FÜR PRODUCTION DEPLOYMENT!"
            echo
            echo "Nächste Schritte:"
            echo "1. Secrets verschlüsseln: sops -e secrets/production-secrets.yaml > secrets/production-secrets.enc.yaml"
            echo "2. Production-Deployment starten: ./scripts/deploy-production.sh deploy"
            echo "3. Nach Deployment: Smoke-Tests durchführen"
            exit 0
        else
            warning "⚠️  Validierung mit Warnungen abgeschlossen - Deployment möglich, aber nicht optimal"
            echo
            echo "Empfehlung: Warnungen vor Deployment beheben"
            exit 1
        fi
    else
        error "❌ Kritische Fehler gefunden - Deployment NICHT möglich"
        echo
        echo "Bitte alle kritischen Fehler beheben, bevor das Deployment gestartet wird."
        exit 2
    fi
}

main "$@"
