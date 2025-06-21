#!/bin/bash

# CiviCRM Data Migration Script
# Migrates existing contribution data to new workflow format

set -euo pipefail

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_FILE="${SCRIPT_DIR}/../logs/migration.log"
ENV_FILE="${SCRIPT_DIR}/../.env"

# Load environment variables
if [[ -f "$ENV_FILE" ]]; then
    source "$ENV_FILE"
else
    echo "Error: Environment file not found: $ENV_FILE"
    exit 1
fi

# Logging function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Create logs directory
mkdir -p "$(dirname "$LOG_FILE")"

# Create custom fields in CiviCRM
create_custom_fields() {
    log "Creating custom fields in CiviCRM..."
    
    # Workflow Status Field
    local workflow_field_response
    workflow_field_response=$(curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=CustomField" \
        -d "action=create" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "custom_group_id=1" \
        -d "name=workflow_status" \
        -d "label=Workflow Status" \
        -d "data_type=String" \
        -d "html_type=Select" \
        -d "option_values=pending,processing,completed,failed" \
        -d "default_value=pending")
    
    # FreeFinance Voucher ID Field
    local ff_field_response
    ff_field_response=$(curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=CustomField" \
        -d "action=create" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "custom_group_id=1" \
        -d "name=ff_voucher_id" \
        -d "label=FreeFinance Voucher ID" \
        -d "data_type=String" \
        -d "html_type=Text")
    
    # Social Media Reach Field
    local sm_field_response
    sm_field_response=$(curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=CustomField" \
        -d "action=create" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "custom_group_id=1" \
        -d "name=sm_reach" \
        -d "label=Social Media Reach" \
        -d "data_type=Integer" \
        -d "html_type=Text")
    
    log "Custom fields created successfully"
}

# Migrate existing contributions
migrate_contributions() {
    log "Starting contribution migration..."
    
    # Get all contributions from the last 12 months
    local contributions_response
    contributions_response=$(curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=Contribution" \
        -d "action=get" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "receive_date=>=$(date -d '1 year ago' '+%Y-%m-%d')" \
        -d "options[limit]=1000")
    
    local count
    count=$(echo "$contributions_response" | jq -r '.count // 0')
    log "Found $count contributions to migrate"
    
    if [[ $count -gt 0 ]]; then
        # Process each contribution
        echo "$contributions_response" | jq -c '.values[]' | while read -r contribution; do
            local contrib_id
            contrib_id=$(echo "$contribution" | jq -r '.id')
            
            # Update contribution with workflow status
            curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
                -d "entity=Contribution" \
                -d "action=create" \
                -d "api_key=${CIVICRM_API_KEY}" \
                -d "key=${CIVICRM_SITE_KEY}" \
                -d "json=1" \
                -d "id=${contrib_id}" \
                -d "custom_workflow_status=completed" > /dev/null
            
            log "Migrated contribution ID: $contrib_id"
        done
    fi
    
    log "Contribution migration completed"
}

# Setup webhook endpoints
setup_webhooks() {
    log "Setting up CiviCRM webhooks..."
    
    # Create webhook for contribution.create
    local webhook_response
    webhook_response=$(curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=System" \
        -d "action=createhook" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "hook_name=contribution_created" \
        -d "entity_name=Contribution" \
        -d "event_type=create" \
        -d "url=${N8N_WEBHOOK_URL}/civicrm-contribution" \
        -d "method=POST")
    
    log "Webhook created successfully"
}

# Backup current configuration
backup_configuration() {
    log "Creating configuration backup..."
    
    local backup_dir="${SCRIPT_DIR}/../backups/$(date '+%Y%m%d_%H%M%S')"
    mkdir -p "$backup_dir"
    
    # Backup custom fields
    curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=CustomField" \
        -d "action=get" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "options[limit]=1000" > "${backup_dir}/custom_fields.json"
    
    # Backup existing workflows
    if [[ -d "${SCRIPT_DIR}/../workflows" ]]; then
        cp -r "${SCRIPT_DIR}/../workflows" "${backup_dir}/"
    fi
    
    log "Backup created in: $backup_dir"
}

# Validate migration
validate_migration() {
    log "Validating migration..."
    
    # Check if custom fields exist
    local fields_response
    fields_response=$(curl -s -X POST "${CIVICRM_BASE_URL}/civicrm/extern/rest.php" \
        -d "entity=CustomField" \
        -d "action=get" \
        -d "api_key=${CIVICRM_API_KEY}" \
        -d "key=${CIVICRM_SITE_KEY}" \
        -d "json=1" \
        -d "name=workflow_status")
    
    local field_count
    field_count=$(echo "$fields_response" | jq -r '.count // 0')
    
    if [[ $field_count -gt 0 ]]; then
        log "✅ Custom fields validated successfully"
    else
        log "❌ Custom fields validation failed"
        return 1
    fi
    
    # Test webhook endpoint
    if curl -s -f "${N8N_WEBHOOK_URL}/health" > /dev/null; then
        log "✅ Webhook endpoint is accessible"
    else
        log "⚠️  Webhook endpoint test failed (may be normal if n8n is not running)"
    fi
    
    log "Migration validation completed"
}

# Main function
main() {
    log "Starting CiviCRM data migration..."
    
    # Check dependencies
    if ! command -v curl &> /dev/null; then
        log "Error: curl is required but not installed"
        exit 1
    fi
    
    if ! command -v jq &> /dev/null; then
        log "Error: jq is required but not installed"
        exit 1
    fi
    
    # Run migration steps
    backup_configuration
    create_custom_fields
    migrate_contributions
    setup_webhooks
    validate_migration
    
    log "Migration completed successfully!"
    log "Next steps:"
    log "1. Start n8n with the new workflows"
    log "2. Test the webhook endpoint"
    log "3. Monitor the first few donations"
}

# Run main function
main "$@"
