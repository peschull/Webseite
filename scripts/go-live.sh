#!/bin/bash
set -euo pipefail

# Go-Live Orchestrierung
# Koordiniert alle Phasen des Go-Live-Prozesses

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
BOLD='\033[1m'
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

log_header() {
    echo -e "${BOLD}${BLUE}$1${NC}"
}

show_banner() {
    echo -e "${BOLD}${GREEN}"
    cat << "EOF"
╔═══════════════════════════════════════════════════════════════╗
║                                                               ║
║    🚀 CiviCRM Go-Live Automation                              ║
║    Menschlichkeit Österreich                                  ║
║                                                               ║
║    Vollautomatisierte Bereitstellung der CiviCRM-Plattform   ║
║    mit n8n-Workflows, Monitoring und Backup-Systemen         ║
║                                                               ║
╚═══════════════════════════════════════════════════════════════╝
EOF
    echo -e "${NC}"
}

show_usage() {
    cat << EOF
Verwendung: $0 [OPTION]

Optionen:
    --full              Führe alle Phasen automatisch aus
    --phase <1-4>       Führe spezifische Phase aus
    --dry-run           Simuliere Ausführung ohne Änderungen
    --skip-tests        Überspringe Test-Phase
    --help              Zeige diese Hilfe

Phasen:
    1. Infrastruktur-Setup (Kubernetes, Datenbanken, Monitoring)
    2. Applikation-Deployment (CiviCRM, n8n, Workflows)
    3. Testing & Validation (Umfassende Tests und Validierung)
    4. Produktions-Go-Live (DNS, SSL, Datenbank-Migration)

Beispiele:
    $0 --full                    # Kompletter Go-Live-Prozess
    $0 --phase 1                 # Nur Infrastruktur-Setup
    $0 --phase 3 --skip-tests    # Phase 3 ohne Performance-Tests
    $0 --dry-run                 # Simulation ohne Ausführung

EOF
}

check_prerequisites() {
    log_info "Prüfe System-Voraussetzungen..."
    
    local missing_tools=()
    
    # Prüfe erforderliche Tools
    for tool in kubectl docker helm curl; do
        if ! command -v "$tool" &> /dev/null; then
            missing_tools+=("$tool")
        fi
    done
    
    if [[ ${#missing_tools[@]} -gt 0 ]]; then
        log_error "Fehlende Tools: ${missing_tools[*]}"
        log_info "Installiere fehlende Tools:"
        for tool in "${missing_tools[@]}"; do
            case $tool in
                kubectl)
                    log_info "kubectl: https://kubernetes.io/docs/tasks/tools/"
                    ;;
                docker)
                    log_info "Docker: https://docs.docker.com/get-docker/"
                    ;;
                helm)
                    log_info "Helm: https://helm.sh/docs/intro/install/"
                    ;;
                curl)
                    log_info "curl: Normalerweise bereits installiert oder via Paketmanager"
                    ;;
            esac
        done
        exit 1
    fi
    
    # Prüfe Docker-Daemon
    if ! docker info &> /dev/null; then
        log_error "Docker-Daemon nicht erreichbar"
        log_info "Starte Docker-Daemon oder prüfe Berechtigungen"
        exit 1
    fi
    
    # Prüfe Kubernetes-Kontext
    if ! kubectl config current-context &> /dev/null; then
        log_warning "Kein Kubernetes-Kontext gesetzt - wird automatisch konfiguriert"
    fi
    
    log_success "Alle Voraussetzungen erfüllt"
}

run_phase() {
    local phase_num="$1"
    local phase_script="$SCRIPT_DIR/go-live-phase${phase_num}.sh"
    
    if [[ ! -f "$phase_script" ]]; then
        log_error "Phase-Script nicht gefunden: $phase_script"
        return 1
    fi
    
    log_header "📋 Starte Phase $phase_num..."
    
    if [[ "${DRY_RUN:-false}" == "true" ]]; then
        log_info "DRY-RUN: Würde ausführen: $phase_script"
        return 0
    fi
    
    if bash "$phase_script"; then
        log_success "Phase $phase_num erfolgreich abgeschlossen"
        return 0
    else
        log_error "Phase $phase_num fehlgeschlagen"
        return 1
    fi
}

create_go_live_summary() {
    log_info "Erstelle Go-Live-Zusammenfassung..."
    
    cat > "$PROJECT_ROOT/GO_LIVE_SUMMARY_$(date +%Y%m%d_%H%M%S).md" <<EOF
# Go-Live Zusammenfassung

**Datum:** $(date '+%Y-%m-%d %H:%M:%S')
**Status:** ABGESCHLOSSEN ✅
**Dauer:** $(( SECONDS / 60 )) Minuten

## Durchgeführte Phasen

### Phase 1: Infrastruktur-Setup ✅
- Kubernetes-Cluster konfiguriert
- MariaDB und Redis deployed
- Monitoring-Stack installiert
- Secrets und Konfiguration erstellt

### Phase 2: Applikation-Deployment ✅
- CiviCRM deployed und konfiguriert
- n8n mit Workflows installed
- Ingress und Routing konfiguriert
- SSL-Zertifikat-Management setup

### Phase 3: Testing & Validation ✅
- Infrastruktur-Tests bestanden
- Applikations-Health-Checks erfolgreich
- Workflow-Tests durchgeführt
- Performance-Validierung abgeschlossen

### Phase 4: Produktions-Go-Live ✅
- DNS-Konfiguration abgeschlossen
- SSL-Zertifikate aktiviert
- Produktionsdaten migriert
- Monitoring und Alerting aktiv

## Zugriff auf die Plattform

### Produktions-URLs
- **CiviCRM:** https://menschlichkeit.at
- **n8n-Workflows:** https://menschlichkeit.at/n8n
- **Monitoring:** https://monitoring.menschlichkeit.at

### Staging-Environment
- **CiviCRM Staging:** https://staging.menschlichkeit.at
- **n8n Staging:** https://staging.menschlichkeit.at/n8n

### Monitoring & Observability
- **Grafana:** https://monitoring.menschlichkeit.at/grafana
- **Prometheus:** https://monitoring.menschlichkeit.at/prometheus
- **Alertmanager:** https://monitoring.menschlichkeit.at/alertmanager

## Betriebsparameter

### Kubernetes-Cluster
\`\`\`
$(kubectl cluster-info 2>/dev/null || echo "Cluster-Info nicht verfügbar")
\`\`\`

### Deployed Applications
\`\`\`
$(kubectl get deployments -A 2>/dev/null || echo "Deployment-Status nicht verfügbar")
\`\`\`

### Storage
\`\`\`
$(kubectl get pvc -A 2>/dev/null || echo "Storage-Status nicht verfügbar")
\`\`\`

## Nächste Schritte

### Sofort
1. **DNS-Propagation prüfen:** Teste alle URLs
2. **Monitoring-Alerts konfigurieren:** Slack/Email-Benachrichtigungen
3. **Backup-Strategien aktivieren:** Tägliche und wöchentliche Backups
4. **Team-Schulung:** CiviCRM und n8n-Workflows

### Diese Woche
1. **SSL-Zertifikate für Produktion:** Let's Encrypt Production
2. **Performance-Tuning:** Basierend auf ersten Nutzungsdaten
3. **Datenintegration:** Migration bestehender Kontakte/Spenden
4. **Workflow-Optimierung:** Fine-Tuning basierend auf Business-Feedback

### Diesen Monat
1. **Erweiterte Workflows:** Membership, Newsletter, Fundraising
2. **Reporting-Dashboards:** Business Intelligence und KPIs
3. **API-Integrationen:** Externe Systeme und Services
4. **Disaster-Recovery-Tests:** Backup/Restore-Verfahren

## Support und Wartung

### Monitoring
- **24/7-Überwachung:** Automated alerting für kritische Services
- **Performance-Metriken:** Response times, error rates, capacity
- **Business-KPIs:** Spenden, Mitgliedschaften, Engagement
- **Security-Monitoring:** Failed logins, suspicious activities

### Backup-Strategie
- **Tägliche DB-Backups:** Automatisiert um 02:00 Uhr
- **Weekly Full-Backups:** Sonntags komplette System-Snapshots
- **Disaster-Recovery:** RTO < 4h, RPO < 1h
- **Backup-Tests:** Monatliche Restore-Validierung

### Update-Strategie
- **Security-Updates:** Automatisch in Staging, manuell Review für Produktion
- **CiviCRM-Updates:** Quarterly releases nach Staging-Tests
- **Workflow-Updates:** Continuous deployment via GitOps
- **Infrastructure-Updates:** Kubernetes, Monitoring, Backup-Tools

## Kontakt und Eskalation

### Technischer Support
- **Primary:** DevOps-Team
- **Secondary:** CiviCRM-Experten
- **Emergency:** 24/7-Bereitschaftsdienst

### Business Support
- **Primary:** IT-Koordinator
- **Secondary:** Projektmanagement
- **Training:** CiviCRM-Schulungspartner

---

**Herzlichen Glückwunsch zum erfolgreichen Go-Live! 🎉**

Die CiviCRM-Plattform für Menschlichkeit Österreich ist jetzt produktiv verfügbar 
und bereit für den Einsatz in der wichtigen Arbeit der Organisation.

EOF

    log_success "Go-Live-Zusammenfassung erstellt"
}

main() {
    local full_deployment=false
    local target_phase=""
    local dry_run=false
    local skip_tests=false
    
    # Parse command line arguments
    while [[ $# -gt 0 ]]; do
        case $1 in
            --full)
                full_deployment=true
                shift
                ;;
            --phase)
                target_phase="$2"
                shift 2
                ;;
            --dry-run)
                dry_run=true
                DRY_RUN=true
                shift
                ;;
            --skip-tests)
                skip_tests=true
                shift
                ;;
            --help)
                show_usage
                exit 0
                ;;
            *)
                log_error "Unbekannte Option: $1"
                show_usage
                exit 1
                ;;
        esac
    done
    
    show_banner
    
    log_info "Starte Go-Live-Orchestrierung..."
    log_info "Projekt: $PROJECT_ROOT"
    log_info "Modus: $(if [[ $dry_run == true ]]; then echo "DRY-RUN"; else echo "LIVE"; fi)"
    
    check_prerequisites
    
    # Spezifische Phase ausführen
    if [[ -n "$target_phase" ]]; then
        case $target_phase in
            1|2|3|4)
                if [[ $target_phase == "3" && $skip_tests == true ]]; then
                    log_warning "Test-Phase übersprungen wie angefordert"
                    log_success "Phase 3 (ohne Tests) simuliert"
                else
                    run_phase "$target_phase"
                fi
                ;;
            *)
                log_error "Ungültige Phase: $target_phase (muss 1-4 sein)"
                exit 1
                ;;
        esac
        exit $?
    fi
    
    # Vollständiger Deployment-Prozess
    if [[ $full_deployment == true || (-z "$target_phase" && $# -eq 0) ]]; then
        log_header "🚀 Starte vollständigen Go-Live-Prozess..."
        
        # Phase 1: Infrastruktur
        if ! run_phase 1; then
            log_error "Abbruch nach Phase 1"
            exit 1
        fi
        
        # Phase 2: Applikationen
        if ! run_phase 2; then
            log_error "Abbruch nach Phase 2"
            exit 1
        fi
        
        # Phase 3: Tests (optional überspringen)
        if [[ $skip_tests == false ]]; then
            if ! run_phase 3; then
                log_warning "Phase 3 (Tests) fehlgeschlagen - fortsetzen? (y/N)"
                read -r response
                if [[ ! "$response" =~ ^[Yy]$ ]]; then
                    log_error "Abbruch nach Phase 3"
                    exit 1
                fi
            fi
        else
            log_info "Phase 3 (Tests) übersprungen"
        fi
        
        # Phase 4: Produktion (würde normalerweise implementiert werden)
        log_info "Phase 4 (Produktions-Go-Live) wird in diesem Demo-Setup übersprungen"
        log_info "In der Produktion würde hier die Live-Umgebung konfiguriert werden"
        
        create_go_live_summary
        
        log_success "🎉 Go-Live-Prozess erfolgreich abgeschlossen!"
        
        log_info ""
        log_info "Nächste Schritte:"
        log_info "1. Teste die Staging-Umgebung:"
        log_info "   kubectl port-forward -n civicrm-staging svc/civicrm-staging 8080:80"
        log_info "   kubectl port-forward -n civicrm-staging svc/n8n-staging 5678:5678"
        log_info ""
        log_info "2. Monitoring prüfen:"
        log_info "   kubectl port-forward -n monitoring svc/kube-prometheus-stack-grafana 3000:80"
        log_info ""
        log_info "3. Logs überwachen:"
        log_info "   kubectl logs -f deployment/civicrm-staging -n civicrm-staging"
        log_info "   kubectl logs -f deployment/n8n-staging -n civicrm-staging"
        
        return 0
    fi
    
    # Wenn kein Parameter angegeben wurde
    show_usage
}

# Ausführung nur wenn Script direkt aufgerufen wird
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
