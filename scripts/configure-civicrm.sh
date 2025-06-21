#!/bin/bash
# CiviCRM Production Configuration Script
# Version: 1.0 - 21. Juni 2025
# Zweck: Automatische Konfiguration der CiviCRM-Produktionsinstanz

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
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
    exit 1
}

# CiviCRM API-Funktionen
civicrm_api() {
    local entity=$1
    local action=$2
    local params=$3
    
    curl -s -X POST "${CIVICRM_BASE_URL}/sites/all/modules/civicrm/extern/rest.php" \
        -d "entity=${entity}" \
        -d "action=${action}" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=${params}"
}

# Konfigurationsvariablen (aus Umgebungsvariablen oder Defaults)
CIVICRM_BASE_URL="${CIVICRM_BASE_URL:-https://civicrm.menschlichkeit.at}"
CIVICRM_API_KEY="${CIVICRM_API_KEY:-}"
CIVICRM_SITE_KEY="${CIVICRM_SITE_KEY:-}"
N8N_WEBHOOK_URL="${N8N_WEBHOOK_URL:-https://n8n.menschlichkeit.at/webhook}"

# Validierung der Umgebungsvariablen
validate_environment() {
    log "Validiere Umgebungsvariablen..."
    
    if [ -z "$CIVICRM_API_KEY" ]; then
        error "CIVICRM_API_KEY nicht gesetzt"
    fi
    
    if [ -z "$CIVICRM_SITE_KEY" ]; then
        error "CIVICRM_SITE_KEY nicht gesetzt"
    fi
    
    success "Umgebungsvariablen validiert"
}

# CiviCRM-Verbindung testen
test_civicrm_connection() {
    log "Teste CiviCRM-Verbindung..."
    
    local response=$(civicrm_api "System" "check" "{}")
    
    if echo "$response" | grep -q '"is_error":0'; then
        success "CiviCRM-Verbindung erfolgreich"
    else
        error "CiviCRM-Verbindung fehlgeschlagen: $response"
    fi
}

# Custom Fields erstellen
create_custom_fields() {
    log "Erstelle Custom Fields..."
    
    # Custom Field Group für Spenden
    local donation_group=$(civicrm_api "CustomGroup" "create" '{
        "title": "n8n Integration Fields",
        "extends": "Contribution",
        "weight": 10,
        "collapse_display": 0,
        "is_active": 1
    }')
    
    if echo "$donation_group" | grep -q '"is_error":0'; then
        local group_id=$(echo "$donation_group" | jq -r '.id')
        success "Custom Field Group erstellt (ID: $group_id)"
        
        # Transaktions-ID
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"cex_id\",
            \"label\": \"Transaktions-ID\",
            \"data_type\": \"String\",
            \"html_type\": \"Text\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        # FreeFinance Voucher ID
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"ff_voucher_id\",
            \"label\": \"FreeFinance Voucher ID\",
            \"data_type\": \"String\",
            \"html_type\": \"Text\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        # Social Media Reach
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"sm_reach\",
            \"label\": \"Social Media Reach\",
            \"data_type\": \"Int\",
            \"html_type\": \"Text\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        # Social Media Impressions
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"sm_impressions\",
            \"label\": \"Social Media Impressions\",
            \"data_type\": \"Int\",
            \"html_type\": \"Text\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        success "Spenden Custom Fields erstellt"
    else
        error "Custom Field Group konnte nicht erstellt werden: $donation_group"
    fi
    
    # Custom Field Group für Mitgliedschaften
    local membership_group=$(civicrm_api "CustomGroup" "create" '{
        "title": "Mitgliedschaft n8n Fields",
        "extends": "Membership",
        "weight": 10,
        "collapse_display": 0,
        "is_active": 1
    }')
    
    if echo "$membership_group" | grep -q '"is_error":0'; then
        local group_id=$(echo "$membership_group" | jq -r '.id')
        success "Mitgliedschaft Custom Field Group erstellt (ID: $group_id)"
        
        # Willkommenspaket versendet
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"welcome_bonus_sent\",
            \"label\": \"Willkommenspaket versendet\",
            \"data_type\": \"Boolean\",
            \"html_type\": \"Radio\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        # Engagement Score
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"engagement_score\",
            \"label\": \"Engagement Score (0-100)\",
            \"data_type\": \"Int\",
            \"html_type\": \"Text\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        # Churn Risk Score
        civicrm_api "CustomField" "create" "{
            \"custom_group_id\": \"$group_id\",
            \"name\": \"churn_risk_score\",
            \"label\": \"Churn Risk Score (0-10)\",
            \"data_type\": \"Int\",
            \"html_type\": \"Text\",
            \"is_required\": 0,
            \"is_searchable\": 1,
            \"is_active\": 1
        }"
        
        success "Mitgliedschaft Custom Fields erstellt"
    else
        error "Mitgliedschaft Custom Field Group konnte nicht erstellt werden: $membership_group"
    fi
}

# Mitgliedschaftstypen erstellen
create_membership_types() {
    log "Erstelle Mitgliedschaftstypen..."
    
    # Vollmitglied
    civicrm_api "MembershipType" "create" '{
        "name": "Vollmitglied",
        "description": "Vollmitgliedschaft mit allen Rechten und Pflichten",
        "minimum_fee": 48.00,
        "duration_interval": 1,
        "duration_unit": "year",
        "period_type": "rolling",
        "is_active": 1,
        "visibility": "Public"
    }'
    
    # Fördermitglied
    civicrm_api "MembershipType" "create" '{
        "name": "Fördermitglied",
        "description": "Fördermitgliedschaft mit erhöhtem Beitrag",
        "minimum_fee": 144.00,
        "duration_interval": 1,
        "duration_unit": "year",
        "period_type": "rolling",
        "is_active": 1,
        "visibility": "Public"
    }'
    
    # Studierendenmitglied
    civicrm_api "MembershipType" "create" '{
        "name": "Studierendenmitglied",
        "description": "Ermäßigte Mitgliedschaft für Studierende",
        "minimum_fee": 24.00,
        "duration_interval": 1,
        "duration_unit": "year",
        "period_type": "rolling",
        "is_active": 1,
        "visibility": "Public"
    }'
    
    # Ehrenmitglied
    civicrm_api "MembershipType" "create" '{
        "name": "Ehrenmitglied",
        "description": "Ehrenmitgliedschaft ohne Beitrag",
        "minimum_fee": 0.00,
        "duration_interval": 1,
        "duration_unit": "year",
        "period_type": "rolling",
        "is_active": 1,
        "visibility": "Admin"
    }'
    
    success "Mitgliedschaftstypen erstellt"
}

# Smart Groups erstellen
create_smart_groups() {
    log "Erstelle Smart Groups..."
    
    # Spender*innen Neu (letzte 24h)
    civicrm_api "Group" "create" '{
        "title": "Spender*innen Neu",
        "description": "Neue Spender*innen der letzten 24 Stunden",
        "group_type": "Mailing List",
        "is_active": 1,
        "visibility": "User and User Admin Only"
    }'
    
    # Aktive Mitglieder
    civicrm_api "Group" "create" '{
        "title": "Aktive Mitglieder",
        "description": "Alle aktiven Mitglieder",
        "group_type": "Access Control",
        "is_active": 1,
        "visibility": "User and User Admin Only"
    }'
    
    # Churn-Risk Mitglieder
    civicrm_api "Group" "create" '{
        "title": "Churn-Risk Mitglieder",
        "description": "Mitglieder mit hohem Kündigungsrisiko",
        "group_type": "Mailing List",
        "is_active": 1,
        "visibility": "User and User Admin Only"
    }'
    
    success "Smart Groups erstellt"
}

# Beziehungstypen erstellen
create_relationship_types() {
    log "Erstelle Beziehungstypen..."
    
    # Member-Mentor Beziehung
    civicrm_api "RelationshipType" "create" '{
        "name_a_b": "Mentor von",
        "name_b_a": "Mentee von",
        "label_a_b": "Mentor",
        "label_b_a": "Mentee",
        "description": "Mentor-Mentee Beziehung für neue Mitglieder",
        "is_active": 1
    }'
    
    # Vorstand-Mitglied Beziehung
    civicrm_api "RelationshipType" "create" '{
        "name_a_b": "Betreut",
        "name_b_a": "Betreut von",
        "label_a_b": "Vorstand betreut",
        "label_b_a": "Betreut von Vorstand",
        "description": "Vorstand-Mitglieder Betreuung",
        "is_active": 1
    }'
    
    # Empfehlung/Referral
    civicrm_api "RelationshipType" "create" '{
        "name_a_b": "Hat empfohlen",
        "name_b_a": "Empfohlen von",
        "label_a_b": "Empfehler",
        "label_b_a": "Empfohlener",
        "description": "Empfehlungs-/Referral-Beziehung",
        "is_active": 1
    }'
    
    success "Beziehungstypen erstellt"
}

# API-User für n8n erstellen
create_api_user() {
    log "Erstelle API-User für n8n..."
    
    # Contact für API-User erstellen
    local contact_result=$(civicrm_api "Contact" "create" '{
        "contact_type": "Individual",
        "first_name": "n8n",
        "last_name": "Automation",
        "display_name": "n8n Automation System",
        "email": "n8n-automation@menschlichkeit.at",
        "contact_sub_type": "API User"
    }')
    
    if echo "$contact_result" | grep -q '"is_error":0'; then
        local contact_id=$(echo "$contact_result" | jq -r '.id')
        success "API-User Contact erstellt (ID: $contact_id)"
        
        # API-Keys für den User generieren (manuell in CiviCRM UI)
        warning "API-Keys müssen manuell in CiviCRM Admin > Users and Permissions > API Keys generiert werden"
        warning "Contact ID für n8n API-User: $contact_id"
    else
        error "API-User Contact konnte nicht erstellt werden: $contact_result"
    fi
}

# Webhook-Endpunkt konfigurieren
configure_webhook() {
    log "Konfiguriere Webhook-Endpunkt..."
    
    # CiviRules Webhook konfigurieren (falls Extension installiert)
    warning "Webhook-Konfiguration muss manuell in CiviCRM durchgeführt werden:"
    warning "1. CiviRules Extension installieren"
    warning "2. Webhook-Regel erstellen für Contribution.create"
    warning "3. Webhook-URL setzen: ${N8N_WEBHOOK_URL}/civicrm-donation"
    warning "4. Webhook-Regel aktivieren"
}

# Hauptfunktion
main() {
    log "🚀 Starte CiviCRM Production Configuration..."
    
    validate_environment
    test_civicrm_connection
    create_custom_fields
    create_membership_types
    create_smart_groups
    create_relationship_types
    create_api_user
    configure_webhook
    
    success "🎉 CiviCRM Production Configuration abgeschlossen!"
    
    echo
    echo "📋 Nächste manuelle Schritte:"
    echo "1. CiviRules Extension installieren"
    echo "2. Mosaico Extension installieren"
    echo "3. CiviCRM Webhooks Extension installieren"
    echo "4. API-Keys für n8n-User generieren"
    echo "5. Webhook-Regeln in CiviRules konfigurieren"
    echo "6. SEPA-Mandate für Mitgliedschaftsbeiträge einrichten"
    echo "7. E-Mail-Templates für Transaktionsmails erstellen"
    echo "8. Spenden-/Mitgliedschaftsformulare konfigurieren"
}

# Fehlerbehandlung
trap 'error "CiviCRM Konfiguration fehlgeschlagen"' ERR

main "$@"
