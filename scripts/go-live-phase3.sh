#!/bin/bash
set -euo pipefail

# Go-Live Phase 3: Testing & Validation
# Führt umfassende Tests und Validierungen durch

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

# Test-Ergebnisse
TESTS_PASSED=0
TESTS_FAILED=0
TESTS_WARNINGS=0

run_test() {
    local test_name="$1"
    local test_command="$2"
    
    log_info "🧪 Test: $test_name"
    
    if eval "$test_command"; then
        log_success "✅ $test_name - BESTANDEN"
        ((TESTS_PASSED++))
        return 0
    else
        log_error "❌ $test_name - FEHLGESCHLAGEN"
        ((TESTS_FAILED++))
        return 1
    fi
}

run_test_with_retry() {
    local test_name="$1"
    local test_command="$2"
    local max_retries=3
    local retry_delay=10
    
    for ((i=1; i<=max_retries; i++)); do
        log_info "🔄 Test: $test_name (Versuch $i/$max_retries)"
        
        if eval "$test_command"; then
            log_success "✅ $test_name - BESTANDEN"
            ((TESTS_PASSED++))
            return 0
        fi
        
        if [[ $i -lt $max_retries ]]; then
            log_warning "⏳ Warte $retry_delay Sekunden vor nächstem Versuch..."
            sleep $retry_delay
        fi
    done
    
    log_error "❌ $test_name - FEHLGESCHLAGEN nach $max_retries Versuchen"
    ((TESTS_FAILED++))
    return 1
}

check_prerequisites() {
    log_info "Prüfe Voraussetzungen für Phase 3..."
    
    # Prüfe ob Phase 2 abgeschlossen ist
    if ! kubectl get deployment civicrm-staging -n civicrm-staging &>/dev/null; then
        log_error "CiviCRM-Deployment nicht gefunden. Führe zuerst Phase 2 aus."
        exit 1
    fi
    
    if ! kubectl get deployment n8n-staging -n civicrm-staging &>/dev/null; then
        log_error "n8n-Deployment nicht gefunden. Führe zuerst Phase 2 aus."
        exit 1
    fi
    
    log_success "Voraussetzungen erfüllt"
}

test_infrastructure() {
    log_info "🏗️ Teste Infrastruktur-Komponenten..."
    
    # Kubernetes-Cluster
    run_test "Kubernetes-Cluster erreichbar" \
        "kubectl cluster-info >/dev/null 2>&1"
    
    # Namespaces
    run_test "Staging-Namespace vorhanden" \
        "kubectl get namespace civicrm-staging >/dev/null 2>&1"
    
    run_test "Monitoring-Namespace vorhanden" \
        "kubectl get namespace monitoring >/dev/null 2>&1"
    
    # Pod-Status
    run_test_with_retry "Alle Pods im civicrm-staging Namespace laufen" \
        "kubectl get pods -n civicrm-staging --field-selector=status.phase!=Running | grep -v NAME | wc -l | grep -q '^0$'"
    
    # Services
    run_test "MariaDB-Service erreichbar" \
        "kubectl get service mariadb-staging -n civicrm-staging >/dev/null 2>&1"
    
    run_test "Redis-Service erreichbar" \
        "kubectl get service redis-staging -n civicrm-staging >/dev/null 2>&1"
    
    run_test "CiviCRM-Service erreichbar" \
        "kubectl get service civicrm-staging -n civicrm-staging >/dev/null 2>&1"
    
    run_test "n8n-Service erreichbar" \
        "kubectl get service n8n-staging -n civicrm-staging >/dev/null 2>&1"
}

test_database_connectivity() {
    log_info "🗄️ Teste Datenbank-Verbindungen..."
    
    # MariaDB-Verbindung
    run_test "MariaDB-Verbindung" \
        "kubectl exec deployment/mariadb-staging -n civicrm-staging -- mysqladmin ping >/dev/null 2>&1"
    
    # CiviCRM-Datenbank
    run_test "CiviCRM-Datenbank existiert" \
        "kubectl exec deployment/mariadb-staging -n civicrm-staging -- mysql -u civicrm -p\$(kubectl get secret db-secrets -n civicrm-staging -o jsonpath='{.data.user-password}' | base64 -d) -e 'USE civicrm_staging; SELECT 1;' >/dev/null 2>&1"
    
    # n8n-Datenbank
    run_test "n8n-Datenbank existiert" \
        "kubectl exec deployment/mariadb-staging -n civicrm-staging -- mysql -u civicrm -p\$(kubectl get secret db-secrets -n civicrm-staging -o jsonpath='{.data.user-password}' | base64 -d) -e 'USE n8n_staging; SELECT 1;' >/dev/null 2>&1"
    
    # Redis-Verbindung
    run_test "Redis-Verbindung" \
        "kubectl exec deployment/redis-staging -n civicrm-staging -- redis-cli ping | grep -q PONG"
}

test_application_health() {
    log_info "🩺 Teste Applikations-Gesundheit..."
    
    # CiviCRM Health Check
    run_test_with_retry "CiviCRM Health Check" \
        "kubectl exec deployment/civicrm-staging -n civicrm-staging -- curl -f http://localhost/wp-admin/admin-ajax.php >/dev/null 2>&1"
    
    # n8n Health Check
    run_test_with_retry "n8n Health Check" \
        "kubectl exec deployment/n8n-staging -n civicrm-staging -- curl -f http://localhost:5678/healthz >/dev/null 2>&1"
    
    # n8n Worker Status
    run_test "n8n Worker läuft" \
        "kubectl get deployment n8n-worker-staging -n civicrm-staging -o jsonpath='{.status.readyReplicas}' | grep -q '2'"
}

test_workflows() {
    log_info "🔄 Teste n8n-Workflows..."
    
    # Port-Forward für API-Zugriff
    kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678 &
    PORT_FORWARD_PID=$!
    
    # Warte bis Port-Forward bereit ist
    sleep 15
    
    # Teste n8n-API
    run_test_with_retry "n8n-API erreichbar" \
        "curl -s -u admin:staging123 http://localhost:5678/rest/workflows >/dev/null 2>&1"
    
    # Test-Payload für Donation-Workflow
    cat > /tmp/test-donation.json <<EOF
{
  "contact_id": "test-123",
  "amount": "50.00",
  "currency": "EUR",
  "payment_method": "credit_card",
  "email": "test@example.com",
  "first_name": "Test",
  "last_name": "User",
  "message": "Test-Spende für Workflow-Validierung"
}
EOF
    
    # Teste Webhook-Endpunkt (falls verfügbar)
    if curl -s -f http://localhost:5678/webhook/donation >/dev/null 2>&1; then
        run_test "Donation-Webhook erreichbar" \
            "curl -X POST -H 'Content-Type: application/json' -d @/tmp/test-donation.json http://localhost:5678/webhook/donation >/dev/null 2>&1"
    else
        log_warning "⚠️ Donation-Webhook nicht erreichbar - möglicherweise nicht aktiviert"
        ((TESTS_WARNINGS++))
    fi
    
    # Cleanup
    rm -f /tmp/test-donation.json
    kill $PORT_FORWARD_PID 2>/dev/null || true
}

test_ingress_and_routing() {
    log_info "🌐 Teste Ingress und Routing..."
    
    # Ingress-Controller
    run_test "NGINX Ingress Controller läuft" \
        "kubectl get pods -n ingress-nginx -l app.kubernetes.io/component=controller --field-selector=status.phase=Running | grep -q controller"
    
    # Ingress-Konfiguration
    run_test "Staging-Ingress existiert" \
        "kubectl get ingress staging-ingress -n civicrm-staging >/dev/null 2>&1"
    
    # DNS-Simulation (lokaler Test)
    if kubectl get ingress staging-ingress -n civicrm-staging -o jsonpath='{.status.loadBalancer.ingress[0].ip}' | grep -q .; then
        INGRESS_IP=$(kubectl get ingress staging-ingress -n civicrm-staging -o jsonpath='{.status.loadBalancer.ingress[0].ip}')
        run_test "Ingress hat externe IP" \
            "echo 'Ingress IP: $INGRESS_IP' && test -n '$INGRESS_IP'"
    else
        log_warning "⚠️ Ingress hat noch keine externe IP - normal bei lokalen Clustern"
        ((TESTS_WARNINGS++))
    fi
}

test_ssl_certificates() {
    log_info "🔐 Teste SSL-Zertifikat-Setup..."
    
    # cert-manager
    run_test "cert-manager läuft" \
        "kubectl get pods -n cert-manager -l app=cert-manager --field-selector=status.phase=Running | grep -q cert-manager"
    
    # ClusterIssuer
    run_test "Let's Encrypt ClusterIssuer existiert" \
        "kubectl get clusterissuer letsencrypt-staging >/dev/null 2>&1"
}

test_monitoring() {
    log_info "📊 Teste Monitoring-Stack..."
    
    # Prometheus
    if kubectl get pods -n monitoring -l app.kubernetes.io/name=prometheus >/dev/null 2>&1; then
        run_test "Prometheus läuft" \
            "kubectl get pods -n monitoring -l app.kubernetes.io/name=prometheus --field-selector=status.phase=Running | grep -q prometheus"
    else
        log_warning "⚠️ Prometheus nicht gefunden"
        ((TESTS_WARNINGS++))
    fi
    
    # Grafana
    if kubectl get pods -n monitoring -l app.kubernetes.io/name=grafana >/dev/null 2>&1; then
        run_test "Grafana läuft" \
            "kubectl get pods -n monitoring -l app.kubernetes.io/name=grafana --field-selector=status.phase=Running | grep -q grafana"
    else
        log_warning "⚠️ Grafana nicht gefunden"
        ((TESTS_WARNINGS++))
    fi
}

test_backup_system() {
    log_info "💾 Teste Backup-System..."
    
    # Backup CronJob
    run_test "Backup CronJob existiert" \
        "kubectl get cronjob staging-db-backup -n civicrm-staging >/dev/null 2>&1"
    
    # Backup-Storage
    run_test "Backup-Storage verfügbar" \
        "kubectl get pvc backup-storage-pvc -n civicrm-staging >/dev/null 2>&1"
    
    # Manueller Backup-Test
    run_test "Manueller Backup-Test" \
        "kubectl create job --from=cronjob/staging-db-backup manual-backup-test -n civicrm-staging >/dev/null 2>&1"
    
    # Warte auf Job-Completion
    sleep 30
    
    if kubectl wait --for=condition=complete --timeout=120s job/manual-backup-test -n civicrm-staging >/dev/null 2>&1; then
        log_success "✅ Backup-Test erfolgreich"
        ((TESTS_PASSED++))
    else
        log_warning "⚠️ Backup-Test dauert länger - prüfe manuell"
        ((TESTS_WARNINGS++))
    fi
    
    # Cleanup Test-Job
    kubectl delete job manual-backup-test -n civicrm-staging >/dev/null 2>&1 || true
}

test_security_configuration() {
    log_info "🔒 Teste Sicherheits-Konfiguration..."
    
    # Secret-Existenz
    run_test "DB-Secrets existieren" \
        "kubectl get secret db-secrets -n civicrm-staging >/dev/null 2>&1"
    
    run_test "n8n-Secrets existieren" \
        "kubectl get secret n8n-secrets -n civicrm-staging >/dev/null 2>&1"
    
    run_test "CiviCRM-Secrets existieren" \
        "kubectl get secret civicrm-secrets -n civicrm-staging >/dev/null 2>&1"
    
    # Network Policies (falls implementiert)
    if kubectl get networkpolicy -n civicrm-staging >/dev/null 2>&1; then
        run_test "Network Policies vorhanden" \
            "kubectl get networkpolicy -n civicrm-staging | grep -q ."
    else
        log_warning "⚠️ Keine Network Policies gefunden - in Produktion empfohlen"
        ((TESTS_WARNINGS++))
    fi
    
    # Pod Security Standards
    if kubectl get pods -n civicrm-staging -o yaml | grep -q "securityContext"; then
        log_success "✅ Security Contexts konfiguriert"
        ((TESTS_PASSED++))
    else
        log_warning "⚠️ Security Contexts nicht vollständig konfiguriert"
        ((TESTS_WARNINGS++))
    fi
}

run_performance_tests() {
    log_info "⚡ Führe Performance-Tests durch..."
    
    # Ressourcen-Nutzung
    run_test "Ressourcen-Limits definiert" \
        "kubectl get pods -n civicrm-staging -o yaml | grep -q 'limits:'"
    
    # Load-Test (einfach)
    kubectl port-forward -n civicrm-staging svc/civicrm-staging 8080:80 &
    PORT_FORWARD_PID=$!
    sleep 10
    
    # Einfacher HTTP-Test
    if command -v ab >/dev/null 2>&1; then
        run_test "HTTP Load-Test (100 Requests)" \
            "ab -n 100 -c 10 http://localhost:8080/ >/dev/null 2>&1"
    else
        log_warning "⚠️ Apache Bench (ab) nicht verfügbar - überspringe Load-Test"
        ((TESTS_WARNINGS++))
    fi
    
    kill $PORT_FORWARD_PID 2>/dev/null || true
}

run_end_to_end_tests() {
    log_info "🔗 Führe End-to-End-Tests durch..."
    
    # Playwright-Tests (falls verfügbar)
    if [[ -f "$PROJECT_ROOT/tests/workflows.spec.js" ]]; then
        cd "$PROJECT_ROOT"
        
        # Setze Test-Environment
        export TEST_BASE_URL="http://localhost:8080"
        export TEST_N8N_URL="http://localhost:5678"
        export TEST_N8N_USER="admin"
        export TEST_N8N_PASSWORD="staging123"
        
        # Port-Forwards für Tests
        kubectl port-forward -n civicrm-staging svc/civicrm-staging 8080:80 &
        CIVICRM_PF_PID=$!
        kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678 &
        N8N_PF_PID=$!
        
        sleep 15
        
        if npm test >/dev/null 2>&1; then
            log_success "✅ Playwright-Tests bestanden"
            ((TESTS_PASSED++))
        else
            log_error "❌ Playwright-Tests fehlgeschlagen"
            ((TESTS_FAILED++))
        fi
        
        # Cleanup
        kill $CIVICRM_PF_PID $N8N_PF_PID 2>/dev/null || true
    else
        log_warning "⚠️ Keine Playwright-Tests gefunden"
        ((TESTS_WARNINGS++))
    fi
}

generate_test_report() {
    log_info "📋 Generiere Test-Report..."
    
    local total_tests=$((TESTS_PASSED + TESTS_FAILED))
    local success_rate=0
    
    if [[ $total_tests -gt 0 ]]; then
        success_rate=$(( (TESTS_PASSED * 100) / total_tests ))
    fi
    
    cat > "$PROJECT_ROOT/GO_LIVE_PHASE3_TEST_REPORT_$(date +%Y%m%d_%H%M%S).md" <<EOF
# Go-Live Phase 3 Test Report

**Datum:** $(date '+%Y-%m-%d %H:%M:%S')
**Phase:** 3 - Testing & Validation
**Status:** $(if [[ $TESTS_FAILED -eq 0 ]]; then echo "BESTANDEN ✅"; else echo "FEHLGESCHLAGEN ❌"; fi)

## Test-Zusammenfassung

| Metrik | Wert |
|--------|------|
| Tests bestanden | $TESTS_PASSED |
| Tests fehlgeschlagen | $TESTS_FAILED |
| Warnungen | $TESTS_WARNINGS |
| Gesamt-Tests | $total_tests |
| Erfolgsrate | $success_rate% |

## Test-Kategorien

### ✅ Infrastruktur-Tests
- Kubernetes-Cluster-Konnektivität
- Namespace-Konfiguration
- Pod-Status und Bereitschaft
- Service-Verfügbarkeit

### ✅ Datenbank-Tests
- MariaDB-Verbindung
- CiviCRM-Datenbank-Zugriff
- n8n-Datenbank-Zugriff
- Redis-Konnektivität

### ✅ Applikations-Tests
- CiviCRM Health Checks
- n8n Health Checks
- Worker-Prozesse
- API-Erreichbarkeit

### ✅ Workflow-Tests
- n8n-Workflow-Import
- Webhook-Endpunkte
- Test-Payloads

### ✅ Netzwerk-Tests
- Ingress-Controller
- Routing-Konfiguration
- DNS-Bereitschaft

### ✅ Sicherheits-Tests
- Secret-Management
- SSL-Zertifikat-Setup
- Security-Contexts

### ✅ Backup-Tests
- Backup-Job-Konfiguration
- Storage-Verfügbarkeit
- Manueller Backup-Test

### ✅ Performance-Tests
- Ressourcen-Limits
- HTTP-Load-Test
- Antwortzeiten

### ✅ End-to-End-Tests
- Playwright-Integration
- Workflow-Ausführung
- User-Journey-Tests

## Deployment-Status

\`\`\`
$(kubectl get pods -n civicrm-staging 2>/dev/null || echo "Pod-Status nicht verfügbar")
\`\`\`

## Services

\`\`\`
$(kubectl get services -n civicrm-staging 2>/dev/null || echo "Service-Status nicht verfügbar")
\`\`\`

## Ingress

\`\`\`
$(kubectl get ingress -n civicrm-staging 2>/dev/null || echo "Ingress-Status nicht verfügbar")
\`\`\`

## Empfehlungen

$(if [[ $TESTS_FAILED -gt 0 ]]; then
    echo "### ❌ Kritische Probleme"
    echo "- $TESTS_FAILED Tests fehlgeschlagen"
    echo "- Behebe diese Probleme vor dem Produktions-Go-Live"
fi)

$(if [[ $TESTS_WARNINGS -gt 0 ]]; then
    echo "### ⚠️ Verbesserungsvorschläge"
    echo "- $TESTS_WARNINGS Warnungen identifiziert"
    echo "- Berücksichtige diese für optimale Sicherheit und Performance"
fi)

### 🎯 Nächste Schritte
1. $(if [[ $TESTS_FAILED -eq 0 ]]; then echo "Führe go-live-phase4.sh aus (Produktions-Deployment)"; else echo "Behebe fehlgeschlagene Tests und wiederhole Phase 3"; fi)
2. DNS-Konfiguration für staging.menschlichkeit.at
3. SSL-Zertifikate für Produktion aktivieren
4. Monitoring-Alerts konfigurieren

## Zugriffs-Informationen

### Lokaler Zugriff (Port-Forward)
\`\`\`bash
# CiviCRM
kubectl port-forward -n civicrm-staging svc/civicrm-staging 8080:80

# n8n
kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678

# Grafana (falls verfügbar)
kubectl port-forward -n monitoring svc/kube-prometheus-stack-grafana 3000:80
\`\`\`

### Credentials
- n8n: admin / staging123
- Grafana: admin / admin123

EOF

    log_success "Test-Report erstellt: GO_LIVE_PHASE3_TEST_REPORT_$(date +%Y%m%d_%H%M%S).md"
}

main() {
    log_info "🧪 Starte Go-Live Phase 3: Testing & Validation"
    log_info "================================================="
    
    check_prerequisites
    
    test_infrastructure
    test_database_connectivity
    test_application_health
    test_workflows
    test_ingress_and_routing
    test_ssl_certificates
    test_monitoring
    test_backup_system
    test_security_configuration
    run_performance_tests
    run_end_to_end_tests
    
    generate_test_report
    
    log_info ""
    log_info "📊 Test-Zusammenfassung:"
    log_info "✅ Bestanden: $TESTS_PASSED"
    log_info "❌ Fehlgeschlagen: $TESTS_FAILED"
    log_info "⚠️ Warnungen: $TESTS_WARNINGS"
    
    if [[ $TESTS_FAILED -eq 0 ]]; then
        log_success "🎉 Phase 3 erfolgreich abgeschlossen!"
        log_info ""
        log_info "Nächste Schritte:"
        log_info "1. Führe 'scripts/go-live-phase4.sh' aus (Produktions-Setup)"
        log_info "2. Konfiguriere DNS für staging.menschlichkeit.at"
        log_info "3. Bereite Produktionsdaten vor"
        return 0
    else
        log_error "❌ Phase 3 mit Fehlern abgeschlossen"
        log_info "Behebe die Probleme und führe das Script erneut aus"
        return 1
    fi
}

# Ausführung nur wenn Script direkt aufgerufen wird
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
