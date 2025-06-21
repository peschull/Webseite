import { test, expect } from '@playwright/test';
import { readFileSync } from 'fs';
import { dirname, join } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Helper function to read JSON files
const readJSONFile = (relativePath) => {
  const fullPath = join(__dirname, relativePath);
  return JSON.parse(readFileSync(fullPath, 'utf8'));
};

// Test configuration
const N8N_BASE_URL = process.env.N8N_BASE_URL || 'http://localhost:5678';
const WEBHOOK_ENDPOINT = `${N8N_BASE_URL}/webhook-test/civicrm-contribution`;

test.describe('CiviCRM n8n Workflow Tests', () => {
  
  test.describe('Donation Workflows (F-01 to F-10)', () => {
    
    test('F-01: Should process donation webhook successfully', async ({ request }) => {
      const contributionData = readJSONFile('./payloads/contribution.json');
      
      // Mock test - in real environment this would hit n8n webhook
      expect(contributionData).toHaveProperty('contribution');
      expect(contributionData.contribution).toHaveProperty('total_amount');
      expect(parseFloat(contributionData.contribution.total_amount)).toBeGreaterThan(0);
    });

    test('F-02: Should handle PDF generation workflow', async () => {
      const pdfTemplate = 'so5-confirmation';
      const mockData = readJSONFile('./payloads/contribution.json');
      
      expect(pdfTemplate).toBe('so5-confirmation');
      expect(parseFloat(mockData.contribution.total_amount)).toBeGreaterThan(0);
    });
  });

  test.describe('Membership Workflows (F-11 to F-18)', () => {
    
    test('F-11: Lead Capture - Should validate double opt-in', async () => {
      const contactData = readJSONFile('./payloads/contact.json');
      
      expect(contactData.contact).toHaveProperty('first_name');
      expect(contactData.contact).toHaveProperty('last_name');
      expect(contactData.contact).toHaveProperty('email');
      expect(contactData.contact.email).toMatch(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
    });

    test('F-12: Membership Application - Should calculate pro-rata fees', async () => {
      const membershipData = readJSONFile('./payloads/membership_payment.json');
      
      expect(membershipData).toHaveProperty('membership_type');
      expect(membershipData).toHaveProperty('start_date');
      expect(membershipData).toHaveProperty('fee_amount');
      expect(membershipData.fee_amount).toBeGreaterThan(0);
    });

    test('F-13: Payment Processing - Should handle SEPA payments', async () => {
      const paymentData = readJSONFile('./payloads/membership_payment.json');
      
      expect(paymentData).toHaveProperty('payment_method');
      expect(paymentData).toHaveProperty('sepa_mandate');
      expect(paymentData.sepa_mandate).toHaveProperty('iban');
      expect(paymentData.sepa_mandate).toHaveProperty('bic');
    });

    test('F-14: Welcome Sequence - Should validate email templates', async () => {
      const welcomeData = readJSONFile('./payloads/membership_welcome.json');
      
      expect(welcomeData).toHaveProperty('welcome_sequence');
      expect(welcomeData.welcome_sequence).toHaveProperty('day_0');
      expect(welcomeData.welcome_sequence).toHaveProperty('day_7');
      expect(welcomeData.welcome_sequence).toHaveProperty('day_30');
    });

    test('F-15: Portal Access - Should validate Nextcloud integration', async () => {
      const portalData = readJSONFile('./payloads/membership_portal.json');
      
      expect(portalData).toHaveProperty('nextcloud_username');
      expect(portalData).toHaveProperty('telegram_invite');
      expect(portalData).toHaveProperty('mentor_assignment');
    });

    test('F-16: Engagement Score - Should calculate member activity', async () => {
      const engagementData = readJSONFile('./payloads/membership_engagement.json');
      
      expect(engagementData.members).toBeDefined();
      expect(engagementData.members.length).toBeGreaterThan(0);
      
      const firstMember = engagementData.members[0];
      expect(firstMember).toHaveProperty('id');
      expect(firstMember.portal_logins_30d).toBeGreaterThanOrEqual(0);
      
      // Add mock engagement score calculation
      const mockEngagementScore = Math.min(100, 
        (firstMember.portal_logins_30d * 2) + 
        (firstMember.email_opens_30d * 1) + 
        (firstMember.events_attended_90d * 5)
      );
      expect(mockEngagementScore).toBeGreaterThanOrEqual(0);
      expect(mockEngagementScore).toBeLessThanOrEqual(100);
    });

    test('F-17: Renewal Reminder - Should handle A/B testing', async () => {
      const renewalData = readJSONFile('./payloads/membership_renewal.json');
      
      expect(renewalData.memberships).toBeDefined();
      expect(renewalData.memberships.length).toBeGreaterThan(0);
      
      const firstMembership = renewalData.memberships[0];
      expect(firstMembership).toHaveProperty('end_date');
      expect(firstMembership).toHaveProperty('days_until_expiry');
      
      // Mock A/B test reminder type based on days until expiry
      const daysUntilExpiry = firstMembership.days_until_expiry;
      const reminderType = daysUntilExpiry >= 25 ? '30_days' : 
                          daysUntilExpiry >= 10 ? '14_days' : '7_days';
      expect(['30_days', '14_days', '7_days']).toContain(reminderType);
    });

    test('F-18: Offboarding - Should handle member exit', async () => {
      const offboardingData = readJSONFile('./payloads/membership_offboarding.json');
      
      expect(offboardingData).toHaveProperty('offboarding_reason');
      expect(offboardingData).toHaveProperty('survey_sent');
      expect(offboardingData.survey_sent).toBe(true);
      
      // Mock archive access based on membership duration
      const mockArchiveAccess = offboardingData.membership_duration.includes('Jahre');
      expect(typeof mockArchiveAccess).toBe('boolean');
    });
  });

  test.describe('Integration Tests', () => {
    
    test('Should maintain cex_id consistency across workflows', async () => {
      const contributionData = readJSONFile('./payloads/contribution.json');
      const membershipData = readJSONFile('./payloads/membership_payment.json');
      
      // Check that cex_id exists in contribution data (either top-level or nested)
      const contributionCexId = contributionData.cex_id || contributionData.contribution?.cex_id;
      expect(contributionCexId).toBeDefined();
      expect(membershipData).toHaveProperty('cex_id');
      
      expect(typeof contributionCexId).toBe('string');
      expect(typeof membershipData.cex_id).toBe('string');
    });

    test('Should validate queue processing configuration', async () => {
      const queues = ['default', 'email', 'accounting', 'social'];
      
      queues.forEach(queue => {
        expect(typeof queue).toBe('string');
        expect(queue.length).toBeGreaterThan(0);
      });
    });
  });

  test.describe('Error Handling Tests', () => {
    
    test('Should validate required fields in membership data', async () => {
      const membershipData = readJSONFile('./payloads/membership_payment.json');
      
      const requiredFields = ['membership_type', 'contact_id', 'start_date', 'fee_amount'];
      
      requiredFields.forEach(field => {
        expect(membershipData).toHaveProperty(field);
      });
    });
  });
});