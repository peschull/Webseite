#!/bin/bash

# Token Refresh Script for Social Media APIs
# Usage: ./token-refresh.sh [facebook|linkedin|all]

set -euo pipefail

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_FILE="${SCRIPT_DIR}/../logs/token-refresh.log"
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

# Create logs directory if it doesn't exist
mkdir -p "$(dirname "$LOG_FILE")"

# Facebook token refresh
refresh_facebook_token() {
    log "Refreshing Facebook token..."
    
    local response
    response=$(curl -s -X GET "https://graph.facebook.com/v23.0/oauth/access_token" \
        -G \
        -d "grant_type=fb_exchange_token" \
        -d "client_id=${FB_APP_ID}" \
        -d "client_secret=${FB_APP_SECRET}" \
        -d "fb_exchange_token=${FB_SHORT_TOKEN}")
    
    if echo "$response" | jq -e '.access_token' > /dev/null; then
        local new_token
        new_token=$(echo "$response" | jq -r '.access_token')
        
        # Update environment file
        if [[ "$OSTYPE" == "darwin"* ]]; then
            sed -i '' "s/FB_PAGE_TOKEN=.*/FB_PAGE_TOKEN=${new_token}/" "$ENV_FILE"
        else
            sed -i "s/FB_PAGE_TOKEN=.*/FB_PAGE_TOKEN=${new_token}/" "$ENV_FILE"
        fi
        
        log "Facebook token refreshed successfully"
        return 0
    else
        log "Error refreshing Facebook token: $response"
        return 1
    fi
}

# LinkedIn token refresh
refresh_linkedin_token() {
    log "Refreshing LinkedIn token..."
    
    local response
    response=$(curl -s -X POST "https://www.linkedin.com/oauth/v2/accessToken" \
        -H "Content-Type: application/x-www-form-urlencoded" \
        -H "LinkedIn-Version: 202506" \
        -d "grant_type=refresh_token" \
        -d "refresh_token=${LINKEDIN_REFRESH_TOKEN}" \
        -d "client_id=${LINKEDIN_CLIENT_ID}" \
        -d "client_secret=${LINKEDIN_CLIENT_SECRET}")
    
    if echo "$response" | jq -e '.access_token' > /dev/null; then
        local new_token new_refresh_token
        new_token=$(echo "$response" | jq -r '.access_token')
        new_refresh_token=$(echo "$response" | jq -r '.refresh_token // empty')
        
        # Update environment file
        if [[ "$OSTYPE" == "darwin"* ]]; then
            sed -i '' "s/LINKEDIN_ACCESS_TOKEN=.*/LINKEDIN_ACCESS_TOKEN=${new_token}/" "$ENV_FILE"
            if [[ -n "$new_refresh_token" ]]; then
                sed -i '' "s/LINKEDIN_REFRESH_TOKEN=.*/LINKEDIN_REFRESH_TOKEN=${new_refresh_token}/" "$ENV_FILE"
            fi
        else
            sed -i "s/LINKEDIN_ACCESS_TOKEN=.*/LINKEDIN_ACCESS_TOKEN=${new_token}/" "$ENV_FILE"
            if [[ -n "$new_refresh_token" ]]; then
                sed -i "s/LINKEDIN_REFRESH_TOKEN=.*/LINKEDIN_REFRESH_TOKEN=${new_refresh_token}/" "$ENV_FILE"
            fi
        fi
        
        log "LinkedIn token refreshed successfully"
        return 0
    else
        log "Error refreshing LinkedIn token: $response"
        return 1
    fi
}

# Validate required tools
check_dependencies() {
    local missing_deps=()
    
    if ! command -v curl &> /dev/null; then
        missing_deps+=("curl")
    fi
    
    if ! command -v jq &> /dev/null; then
        missing_deps+=("jq")
    fi
    
    if [[ ${#missing_deps[@]} -gt 0 ]]; then
        log "Error: Missing required dependencies: ${missing_deps[*]}"
        log "Please install: apt-get install curl jq (Ubuntu/Debian) or brew install curl jq (macOS)"
        exit 1
    fi
}

# Main function
main() {
    local service="${1:-all}"
    local exit_code=0
    
    log "Starting token refresh for: $service"
    check_dependencies
    
    case "$service" in
        facebook)
            refresh_facebook_token || exit_code=1
            ;;
        linkedin)
            refresh_linkedin_token || exit_code=1
            ;;
        all)
            refresh_facebook_token || exit_code=1
            refresh_linkedin_token || exit_code=1
            ;;
        *)
            log "Error: Unknown service '$service'. Use: facebook, linkedin, or all"
            exit 1
            ;;
    esac
    
    if [[ $exit_code -eq 0 ]]; then
        log "Token refresh completed successfully"
    else
        log "Token refresh completed with errors"
    fi
    
    exit $exit_code
}

# Run main function with all arguments
main "$@"
