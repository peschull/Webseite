#!/bin/bash

# Initialize MinIO buckets and policies for production deployment
# Usage: ./init-minio.sh

set -euo pipefail

# Configuration
MINIO_ENDPOINT="${MINIO_ENDPOINT:-http://localhost:9000}"
MINIO_ACCESS_KEY="${MINIO_ACCESS_KEY:-minioadmin}"
MINIO_SECRET_KEY="${MINIO_SECRET_KEY:-minioadmin123}"

# MinIO client alias
MC_ALIAS="local"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

log() {
    echo -e "${GREEN}[$(date '+%Y-%m-%d %H:%M:%S')] $1${NC}"
}

warn() {
    echo -e "${YELLOW}[$(date '+%Y-%m-%d %H:%M:%S')] WARNING: $1${NC}"
}

error() {
    echo -e "${RED}[$(date '+%Y-%m-%d %H:%M:%S')] ERROR: $1${NC}"
    exit 1
}

# Check if MinIO client is installed
if ! command -v mc &> /dev/null; then
    error "MinIO client (mc) is not installed. Please install it first."
fi

# Configure MinIO client
log "Configuring MinIO client..."
mc alias set $MC_ALIAS $MINIO_ENDPOINT $MINIO_ACCESS_KEY $MINIO_SECRET_KEY

# Wait for MinIO to be ready
log "Waiting for MinIO to be ready..."
timeout=60
while ! mc admin info $MC_ALIAS &>/dev/null; do
    if [ $timeout -eq 0 ]; then
        error "MinIO is not responding after 60 seconds"
    fi
    sleep 1
    ((timeout--))
done

log "MinIO is ready!"

# Create buckets
log "Creating buckets..."

# n8n binary data bucket
if mc ls $MC_ALIAS/n8n-binaries &>/dev/null; then
    warn "Bucket 'n8n-binaries' already exists"
else
    mc mb $MC_ALIAS/n8n-binaries
    log "Created bucket: n8n-binaries"
fi

# Financial archive bucket (7-year retention for BAO compliance)
if mc ls $MC_ALIAS/fin-archive-euc1 &>/dev/null; then
    warn "Bucket 'fin-archive-euc1' already exists"
else
    mc mb $MC_ALIAS/fin-archive-euc1
    log "Created bucket: fin-archive-euc1"
fi

# Backup bucket
if mc ls $MC_ALIAS/backups &>/dev/null; then
    warn "Bucket 'backups' already exists"
else
    mc mb $MC_ALIAS/backups
    log "Created bucket: backups"
fi

# Configure bucket policies
log "Configuring bucket policies..."

# n8n-binaries: Private (only n8n can access)
cat > /tmp/n8n-binaries-policy.json << EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Principal": {
        "AWS": ["arn:aws:iam::n8n:user/n8n-service"]
      },
      "Action": [
        "s3:GetObject",
        "s3:PutObject",
        "s3:DeleteObject"
      ],
      "Resource": "arn:aws:s3:::n8n-binaries/*"
    },
    {
      "Effect": "Allow",
      "Principal": {
        "AWS": ["arn:aws:iam::n8n:user/n8n-service"]
      },
      "Action": [
        "s3:ListBucket"
      ],
      "Resource": "arn:aws:s3:::n8n-binaries"
    }
  ]
}
EOF

mc policy set-json /tmp/n8n-binaries-policy.json $MC_ALIAS/n8n-binaries
log "Applied policy to n8n-binaries bucket"

# Configure lifecycle policies for compliance
log "Configuring lifecycle policies..."

# Financial archive: 7-year retention (BAO compliance)
cat > /tmp/fin-archive-lifecycle.json << EOF
{
  "Rules": [
    {
      "ID": "BAOCompliance",
      "Status": "Enabled",
      "Transitions": [
        {
          "Days": 30,
          "StorageClass": "STANDARD_IA"
        },
        {
          "Days": 365,
          "StorageClass": "GLACIER"
        }
      ],
      "Expiration": {
        "Days": 2555
      }
    }
  ]
}
EOF

mc ilm import $MC_ALIAS/fin-archive-euc1 < /tmp/fin-archive-lifecycle.json
log "Applied 7-year lifecycle policy to fin-archive-euc1"

# n8n-binaries: 90-day retention for temporary files
cat > /tmp/n8n-binaries-lifecycle.json << EOF
{
  "Rules": [
    {
      "ID": "TempFileCleanup",
      "Status": "Enabled",
      "Filter": {
        "Prefix": "temp/"
      },
      "Expiration": {
        "Days": 90
      }
    },
    {
      "ID": "PDFRetention",
      "Status": "Enabled",
      "Filter": {
        "Prefix": "pdf/"
      },
      "Transitions": [
        {
          "Days": 30,
          "StorageClass": "STANDARD_IA"
        }
      ],
      "Expiration": {
        "Days": 2555
      }
    }
  ]
}
EOF

mc ilm import $MC_ALIAS/n8n-binaries < /tmp/n8n-binaries-lifecycle.json
log "Applied lifecycle policies to n8n-binaries"

# Enable versioning for critical buckets
log "Enabling versioning..."
mc version enable $MC_ALIAS/fin-archive-euc1
mc version enable $MC_ALIAS/backups
log "Versioning enabled for archive and backup buckets"

# Create service account for n8n
log "Creating service account for n8n..."
if mc admin user add $MC_ALIAS n8n-service n8n-secret-key 2>/dev/null; then
    log "Created service account: n8n-service"
else
    warn "Service account 'n8n-service' might already exist"
fi

# Create policy for n8n service account
cat > /tmp/n8n-service-policy.json << EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "s3:GetObject",
        "s3:PutObject",
        "s3:DeleteObject",
        "s3:ListBucket"
      ],
      "Resource": [
        "arn:aws:s3:::n8n-binaries",
        "arn:aws:s3:::n8n-binaries/*",
        "arn:aws:s3:::fin-archive-euc1",
        "arn:aws:s3:::fin-archive-euc1/*"
      ]
    }
  ]
}
EOF

mc admin policy add $MC_ALIAS n8n-service-policy /tmp/n8n-service-policy.json
mc admin policy set $MC_ALIAS n8n-service-policy user=n8n-service
log "Applied policies to n8n service account"

# Test bucket access
log "Testing bucket access..."
echo "test" | mc pipe $MC_ALIAS/n8n-binaries/test.txt
if mc cat $MC_ALIAS/n8n-binaries/test.txt | grep -q "test"; then
    log "✅ Bucket access test successful"
    mc rm $MC_ALIAS/n8n-binaries/test.txt
else
    error "❌ Bucket access test failed"
fi

# Create initial folder structure
log "Creating folder structure..."
echo "" | mc pipe $MC_ALIAS/n8n-binaries/pdf/.keep
echo "" | mc pipe $MC_ALIAS/n8n-binaries/images/.keep
echo "" | mc pipe $MC_ALIAS/n8n-binaries/temp/.keep
echo "" | mc pipe $MC_ALIAS/fin-archive-euc1/receipts/.keep
echo "" | mc pipe $MC_ALIAS/fin-archive-euc1/vouchers/.keep
log "Created folder structure"

# Cleanup temporary files
rm -f /tmp/n8n-binaries-policy.json
rm -f /tmp/fin-archive-lifecycle.json
rm -f /tmp/n8n-binaries-lifecycle.json
rm -f /tmp/n8n-service-policy.json

log "MinIO initialization completed successfully!"
log ""
log "📋 Summary:"
log "  • Created buckets: n8n-binaries, fin-archive-euc1, backups"
log "  • Applied lifecycle policies for BAO compliance (7 years)"
log "  • Enabled versioning for critical buckets"
log "  • Created service account: n8n-service"
log "  • Configured access policies"
log ""
log "🔐 Service Account Credentials:"
log "  Access Key: n8n-service"
log "  Secret Key: n8n-secret-key"
log ""
log "⚠️  Please update your .env file with these credentials!"

# Output environment variables for easy copy-paste
log ""
log "📝 Environment Variables:"
echo "N8N_BINARY_DATA_S3_ACCESS_KEY_ID=n8n-service"
echo "N8N_BINARY_DATA_S3_SECRET_ACCESS_KEY=n8n-secret-key"
echo "N8N_BINARY_DATA_S3_BUCKET=n8n-binaries"
echo "FIN_ARCHIVE_BUCKET=fin-archive-euc1"
