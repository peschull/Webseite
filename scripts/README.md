# n8n Production Deployment Scripts
# Collection of scripts for managing n8n in production

## 🚀 Quick Start

```bash
# 1. Initialize local development environment
docker-compose up -d

# 2. Initialize MinIO buckets and policies
./scripts/init-minio.sh

# 3. Import workflows
docker-compose exec n8n-main n8n import:workflow --input /workflows --yes

# 4. Test webhook endpoint
curl -X POST http://localhost:5678/webhook-test/civicrm-contribution \
     -H "Content-Type: application/json" \
     -d @tests/payloads/contribution.json
```

## 📊 Monitoring

Access monitoring interfaces:
- **Grafana**: http://localhost:3000 (admin/admin)
- **Prometheus**: http://localhost:9090
- **MinIO Console**: http://localhost:9001 (minioadmin/minioadmin123)
- **n8n UI**: http://localhost:5678

## 🔧 Production Deployment

### Kubernetes Deployment

```bash
# 1. Create namespace
kubectl create namespace n8n-prod

# 2. Create secrets (use SOPS for encryption)
kubectl create secret generic n8n-postgres-secret \
  --from-literal=password=your_secure_password \
  -n n8n-prod

kubectl create secret generic n8n-s3-secret \
  --from-literal=accessKeyId=n8n-service \
  --from-literal=secretAccessKey=n8n-secret-key \
  -n n8n-prod

kubectl create secret generic n8n-auth-secret \
  --from-literal=username=admin \
  --from-literal=password=your_admin_password \
  -n n8n-prod

kubectl create secret generic n8n-encryption-secret \
  --from-literal=encryptionKey=your_32_character_encryption_key \
  -n n8n-prod

# 3. Deploy with Helm
helm repo add n8n https://8gears.container-registry.com/chartrepo/library
helm repo update

helm install n8n-production n8n/n8n \
  --namespace n8n-prod \
  --values helm/n8n-values.yaml \
  --wait

# 4. Verify deployment
kubectl get pods -n n8n-prod
kubectl get ingress -n n8n-prod
```

### Enable Horizontal Pod Autoscaler

```bash
# Create HPA for workers
kubectl autoscale deployment n8n-worker \
  --cpu-percent=70 \
  --min=2 \
  --max=6 \
  -n n8n-prod

# Verify HPA status
kubectl get hpa -n n8n-prod
```

## 📝 Workflow Management

### Export Workflows (Manual)

```bash
# Export all workflows to JSON
docker-compose exec n8n-main n8n export:workflow \
  --all \
  --output /tmp/workflows \
  --decrypted

# Copy from container to host
docker cp n8n-main:/tmp/workflows ./workflows/
```

### Import Workflows

```bash
# Import all workflows
docker-compose exec n8n-main n8n import:workflow \
  --input /workflows \
  --separate \
  --yes

# Import specific workflow
docker-compose exec n8n-main n8n import:workflow \
  --input /workflows/F-01_backbone.json \
  --yes
```

## 🧪 Testing & Validation

### Local Testing

```bash
# Run all tests
npm run test:workflows

# Test specific workflow
npx playwright test tests/workflows.test.js --grep "PDF Generation"

# Load testing
npm run test:load
```

### Production Health Checks

```bash
# Check all services
./scripts/health-check.sh

# Verify queue processing
redis-cli -h localhost -p 6379 llen bull:default
redis-cli -h localhost -p 6379 llen bull:email
redis-cli -h localhost -p 6379 llen bull:accounting
redis-cli -h localhost -p 6379 llen bull:social

# Check MinIO buckets
mc ls local/n8n-binaries
mc ls local/fin-archive-euc1
```

## 🔄 Backup & Recovery

### Database Backup

```bash
# Backup PostgreSQL
docker-compose exec postgres pg_dump -U n8n_user n8n > backup-$(date +%Y%m%d).sql

# Restore from backup
docker-compose exec -T postgres psql -U n8n_user n8n < backup-20250621.sql
```

### MinIO Backup

```bash
# Backup MinIO data
mc mirror local/n8n-binaries ./backups/minio/n8n-binaries/
mc mirror local/fin-archive-euc1 ./backups/minio/fin-archive-euc1/

# Restore MinIO data
mc mirror ./backups/minio/n8n-binaries/ local/n8n-binaries
```

### Workflow Backup

```bash
# Automated via GitHub Actions (nightly)
# Manual backup:
./scripts/backup-workflows.sh
```

## 📊 Metrics & Alerting

### Key Metrics to Monitor

```promql
# Error Rate
rate(n8n_executions_failed_total[5m]) / rate(n8n_executions_total[5m]) * 100

# Queue Lag
redis_queue_length{queue="default"}

# Processing Time
histogram_quantile(0.95, rate(n8n_execution_duration_seconds_bucket[5m]))

# Memory Usage
container_memory_usage_bytes{name=~"n8n.*"} / container_spec_memory_limit_bytes{name=~"n8n.*"} * 100
```

### Critical Alerts

- **Error Rate** > 5% for 2 minutes
- **Queue Lag** > 100 jobs for 1 minute
- **Processing Time** > 30 seconds for 2 minutes
- **Worker Down** for 1 minute
- **Database Connection** failures

## 🔒 Security Considerations

### Secrets Management

```bash
# Use SOPS for secrets encryption
sops -e -i .env.prod

# Decrypt in CI/CD
sops -d .env.prod > .env
```

### Network Security

```bash
# Apply NetworkPolicies
kubectl apply -f k8s/network-policies.yaml

# Verify policies
kubectl get networkpolicy -n n8n-prod
```

### Regular Security Tasks

- [ ] Rotate API keys monthly
- [ ] Update container images weekly
- [ ] Review access logs monthly
- [ ] Vulnerability scans (automated in CI)
- [ ] Penetration testing annually

## 🚨 Troubleshooting

### Common Issues

#### Webhook Not Triggering
```bash
# Check webhook logs
kubectl logs -f deployment/n8n-main -n n8n-prod

# Verify CiviCRM webhook URL
curl -v https://n8n.menschlichkeit.at/webhook/civicrm-contribution
```

#### Queue Not Processing
```bash
# Check worker logs
kubectl logs -f deployment/n8n-worker -n n8n-prod

# Verify Redis connection
redis-cli -h redis-master.redis.svc.cluster.local ping
```

#### PDF Generation Fails
```bash
# Check CraftMyPDF status
curl -I https://api.craftmypdf.com/health

# Verify template exists
# Check logs for template validation errors
```

#### High Memory Usage
```bash
# Scale up resources
kubectl patch deployment n8n-main -n n8n-prod -p '{"spec":{"template":{"spec":{"containers":[{"name":"n8n","resources":{"limits":{"memory":"2Gi"}}}]}}}}'

# Add more workers
kubectl scale deployment n8n-worker --replicas=4 -n n8n-prod
```

### Emergency Procedures

#### Complete Rollback
```bash
# Rollback Helm deployment
helm rollback n8n-production -n n8n-prod

# Restore database from backup
kubectl exec -it postgres-0 -n postgresql -- psql -U postgres -c "DROP DATABASE n8n;"
kubectl exec -it postgres-0 -n postgresql -- psql -U postgres -c "CREATE DATABASE n8n;"
kubectl exec -i postgres-0 -n postgresql -- psql -U postgres n8n < backup-last-good.sql
```

#### Scale Down for Maintenance
```bash
# Stop processing new jobs
kubectl scale deployment n8n-main --replicas=0 -n n8n-prod

# Wait for current jobs to complete
kubectl wait --for=condition=ready pod -l app=n8n-worker -n n8n-prod --timeout=300s

# Stop workers
kubectl scale deployment n8n-worker --replicas=0 -n n8n-prod
```

## 📞 Support Contacts

- **Emergency**: +43 xxx xxx xxxx
- **DevOps Team**: devops@menschlichkeit.at
- **Jira**: https://menschlichkeit.atlassian.net/
- **Slack**: #ops-alerts

## 📚 Additional Resources

- [n8n Documentation](https://docs.n8n.io/)
- [CiviCRM API Reference](https://docs.civicrm.org/dev/en/latest/api/)
- [Kubernetes Troubleshooting](https://kubernetes.io/docs/tasks/debug-application-cluster/)
- [Prometheus Query Examples](https://prometheus.io/docs/prometheus/latest/querying/examples/)
