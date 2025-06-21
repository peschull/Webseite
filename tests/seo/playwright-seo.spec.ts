import { test, expect } from '@playwright/test';

test.describe('WordPress Theme SEO Tests - Playwright', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/');
  });

  test.describe('Core Web Vitals & Performance', () => {
    test('should have good Largest Contentful Paint (LCP)', async ({ page }) => {
      await page.waitForLoadState('networkidle');
      
      const lcpValue = await page.evaluate(() => {
        return new Promise((resolve) => {
          const observer = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            resolve(lastEntry.startTime);
          });
          observer.observe({ entryTypes: ['largest-contentful-paint'] });
          
          // Fallback timeout
          setTimeout(() => resolve(0), 5000);
        });
      });
      
      expect(lcpValue).toBeLessThan(2500); // Good LCP threshold
    });

    test('should have good First Input Delay (FID)', async ({ page }) => {
      await page.waitForLoadState('networkidle');
      
      // Simulate user interaction
      await page.click('body');
      
      const fidValue = await page.evaluate(() => {
        return new Promise((resolve) => {
          const observer = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            if (entries.length > 0) {
              resolve(entries[0].processingStart - entries[0].startTime);
            }
          });
          observer.observe({ entryTypes: ['first-input'] });
          
          // Fallback
          setTimeout(() => resolve(0), 3000);
        });
      });
      
      expect(fidValue).toBeLessThan(100); // Good FID threshold
    });

    test('should have minimal Cumulative Layout Shift (CLS)', async ({ page }) => {
      await page.waitForLoadState('networkidle');
      await page.waitForTimeout(2000); // Wait for potential layout shifts
      
      const clsValue = await page.evaluate(() => {
        return new Promise((resolve) => {
          let clsValue = 0;
          const observer = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
              if (!entry.hadRecentInput) {
                clsValue += entry.value;
              }
            }
          });
          observer.observe({ entryTypes: ['layout-shift'] });
          
          setTimeout(() => resolve(clsValue), 1000);
        });
      });
      
      expect(clsValue).toBeLessThan(0.1); // Good CLS threshold
    });
  });

  test.describe('Advanced Meta Tags', () => {
    test('should have proper hreflang attributes if multilingual', async ({ page }) => {
      const hreflangLinks = await page.$$('link[hreflang]');
      
      if (hreflangLinks.length > 0) {
        for (const link of hreflangLinks) {
          const href = await link.getAttribute('href');
          const hreflang = await link.getAttribute('hreflang');
          
          expect(href).toBeTruthy();
          expect(hreflang).toMatch(/^[a-z]{2}(-[A-Z]{2})?$/); // Valid language code
          
          // Check if linked page exists
          const response = await page.request.head(href);
          expect(response.status()).toBe(200);
        }
      }
    });

    test('should have proper next/prev pagination links', async ({ page }) => {
      const nextLink = await page.$('link[rel="next"]');
      const prevLink = await page.$('link[rel="prev"]');
      
      if (nextLink) {
        const href = await nextLink.getAttribute('href');
        expect(href).toBeTruthy();
        
        const response = await page.request.head(href);
        expect(response.status()).toBe(200);
      }
      
      if (prevLink) {
        const href = await prevLink.getAttribute('href');
        expect(href).toBeTruthy();
        
        const response = await page.request.head(href);
        expect(response.status()).toBe(200);
      }
    });

    test('should have proper article metadata for blog posts', async ({ page }) => {
      const isArticle = await page.$('article, .post, [itemtype*="Article"]');
      
      if (isArticle) {
        // Check for article published time
        const publishedTime = await page.$('meta[property="article:published_time"], time[datetime]');
        if (publishedTime) {
          const datetime = await publishedTime.getAttribute('content') || 
                          await publishedTime.getAttribute('datetime');
          expect(datetime).toMatch(/^\d{4}-\d{2}-\d{2}/); // Valid date format
        }
        
        // Check for author information
        const author = await page.$('meta[property="article:author"], [rel="author"], .author');
        expect(author).toBeTruthy();
      }
    });
  });

  test.describe('Advanced Structured Data', () => {
    test('should have valid and comprehensive structured data', async ({ page }) => {
      const structuredDataScripts = await page.$$('script[type="application/ld+json"]');
      
      expect(structuredDataScripts.length).toBeGreaterThan(0);
      
      for (const script of structuredDataScripts) {
        const content = await script.textContent();
        
        // Validate JSON
        let data;
        expect(() => {
          data = JSON.parse(content);
        }).not.toThrow();
        
        // Check required schema.org properties
        expect(data['@context']).toContain('schema.org');
        expect(data['@type']).toBeTruthy();
        
        // Validate common schema types
        const schemaType = Array.isArray(data) ? data[0]['@type'] : data['@type'];
        
        if (schemaType === 'Organization') {
          expect(data.name || data[0]?.name).toBeTruthy();
          expect(data.url || data[0]?.url).toBeTruthy();
        }
        
        if (schemaType === 'WebSite') {
          expect(data.name || data[0]?.name).toBeTruthy();
          expect(data.url || data[0]?.url).toBeTruthy();
        }
        
        if (schemaType === 'Article' || schemaType === 'BlogPosting') {
          expect(data.headline || data[0]?.headline).toBeTruthy();
          expect(data.author || data[0]?.author).toBeTruthy();
          expect(data.datePublished || data[0]?.datePublished).toBeTruthy();
        }
      }
    });

    test('should have breadcrumb structured data if breadcrumbs exist', async ({ page }) => {
      const breadcrumbs = await page.$('.breadcrumb, .breadcrumbs, nav[aria-label*="breadcrumb"]');
      
      if (breadcrumbs) {
        const breadcrumbSchema = await page.$('script[type="application/ld+json"]');
        const content = await breadcrumbSchema?.textContent();
        
        if (content) {
          const data = JSON.parse(content);
          const hasBreadcrumbList = Array.isArray(data) 
            ? data.some(item => item['@type'] === 'BreadcrumbList')
            : data['@type'] === 'BreadcrumbList';
          
          expect(hasBreadcrumbList).toBeTruthy();
        }
      }
    });
  });

  test.describe('Image SEO Optimization', () => {
    test('should have optimized image formats and sizes', async ({ page }) => {
      const images = await page.$$('img');
      
      for (const img of images) {
        const src = await img.getAttribute('src');
        const alt = await img.getAttribute('alt');
        
        // Check alt text quality
        expect(alt).toBeTruthy();
        expect(alt.length).toBeGreaterThan(5);
        expect(alt).not.toMatch(/\.(jpg|jpeg|png|gif|webp)$/i); // Not just filename
        
        // Check for responsive image attributes
        const srcset = await img.getAttribute('srcset');
        const sizes = await img.getAttribute('sizes');
        
        if (srcset) {
          expect(srcset).toMatch(/\d+w/); // Should contain width descriptors
        }
        
        // Check image loading strategy
        const loading = await img.getAttribute('loading');
        const isAboveFold = await img.evaluate(el => {
          const rect = el.getBoundingClientRect();
          return rect.top < window.innerHeight;
        });
        
        if (!isAboveFold) {
          expect(loading).toBe('lazy');
        }
      }
    });

    test('should have proper image dimensions to prevent CLS', async ({ page }) => {
      const images = await page.$$('img');
      
      for (const img of images) {
        const width = await img.getAttribute('width');
        const height = await img.getAttribute('height');
        
        if (!width || !height) {
          // Check if dimensions are set via CSS
          const computedStyle = await img.evaluate(el => {
            const style = window.getComputedStyle(el);
            return {
              width: style.width,
              height: style.height
            };
          });
          
          expect(computedStyle.width).not.toBe('auto');
          expect(computedStyle.height).not.toBe('auto');
        }
      }
    });
  });

  test.describe('Link Quality and Internal Linking', () => {
    test('should have meaningful anchor text', async ({ page }) => {
      const links = await page.$$('a[href]');
      
      for (const link of links) {
        const text = await link.textContent();
        const href = await link.getAttribute('href');
        
        if (text?.trim()) {
          // Avoid generic anchor text
          expect(text.toLowerCase()).not.toMatch(/^(click here|read more|here|more|link)$/);
          expect(text.length).toBeGreaterThan(2);
        }
        
        // Check for descriptive title attributes for complex links
        if (href?.startsWith('http') && !href.includes(page.url())) {
          const title = await link.getAttribute('title');
          if (!text?.trim() || text.trim().length < 5) {
            expect(title).toBeTruthy();
          }
        }
      }
    });

    test('should have proper internal linking strategy', async ({ page }) => {
      const internalLinks = await page.$$('a[href^="/"], a[href*="localhost"]');
      const externalLinks = await page.$$('a[href^="http"]:not([href*="localhost"])');
      
      expect(internalLinks.length).toBeGreaterThan(0);
      
      // Check internal link distribution
      const linkDensity = internalLinks.length / (await page.$$('*')).length;
      expect(linkDensity).toBeLessThan(0.1); // Not too many links
      
      // Check for proper external link attributes
      for (const link of externalLinks) {
        const rel = await link.getAttribute('rel');
        const target = await link.getAttribute('target');
        
        if (target === '_blank') {
          expect(rel).toMatch(/(noopener|noreferrer)/);
        }
      }
    });
  });

  test.describe('Content Quality Analysis', () => {
    test('should have sufficient and quality content', async ({ page }) => {
      const mainContent = await page.$('main, article, .content, #content');
      expect(mainContent).toBeTruthy();
      
      const textContent = await mainContent.textContent();
      const wordCount = textContent.trim().split(/\s+/).length;
      
      expect(wordCount).toBeGreaterThan(150); // Minimum content length
      
      // Check for content structure
      const headings = await mainContent.$$('h1, h2, h3, h4, h5, h6');
      expect(headings.length).toBeGreaterThan(0);
      
      // Check for paragraphs
      const paragraphs = await mainContent.$$('p');
      expect(paragraphs.length).toBeGreaterThan(1);
    });

    test('should have proper content-to-code ratio', async ({ page }) => {
      const bodyText = await page.$eval('body', el => el.textContent);
      const bodyHTML = await page.$eval('body', el => el.innerHTML);
      
      const textLength = bodyText.trim().length;
      const htmlLength = bodyHTML.length;
      
      const ratio = textLength / htmlLength;
      expect(ratio).toBeGreaterThan(0.1); // At least 10% content
    });
  });

  test.describe('Technical SEO Advanced', () => {
    test('should have proper HTTP status codes for resources', async ({ page }) => {
      const resources = [];
      
      page.on('response', response => {
        resources.push({
          url: response.url(),
          status: response.status()
        });
      });
      
      await page.goto('/', { waitUntil: 'networkidle' });
      
      // Check main page
      const mainPageResource = resources.find(r => r.url === page.url());
      expect(mainPageResource?.status).toBe(200);
      
      // Check CSS and JS resources
      const cssResources = resources.filter(r => r.url.endsWith('.css'));
      const jsResources = resources.filter(r => r.url.endsWith('.js'));
      
      cssResources.forEach(resource => {
        expect(resource.status).toBe(200);
      });
      
      jsResources.forEach(resource => {
        expect(resource.status).toBe(200);
      });
    });

    test('should have proper redirects if any', async ({ page, context }) => {
      // Test common redirect scenarios
      const redirectTests = [
        '/index.html', // Should redirect to /
        '/home', // Might redirect to /
      ];
      
      for (const testUrl of redirectTests) {
        try {
          const response = await context.request.get(testUrl);
          if (response.status() >= 300 && response.status() < 400) {
            const location = response.headers()['location'];
            expect(location).toBeTruthy();
            expect(response.status()).toBeOneOf([301, 302, 307, 308]);
          }
        } catch (error) {
          // URL might not exist, which is OK
        }
      }
    });

    test('should have security headers for SEO', async ({ page }) => {
      const response = await page.goto('/');
      const headers = response?.headers();
      
      if (headers) {
        // X-Frame-Options helps with clickjacking protection
        if (headers['x-frame-options']) {
          expect(headers['x-frame-options']).toMatch(/(DENY|SAMEORIGIN)/);
        }
        
        // Content-Type should be set properly
        expect(headers['content-type']).toContain('text/html');
      }
    });
  });

  test.describe('WordPress-Specific SEO', () => {
    test('should not expose WordPress version in meta', async ({ page }) => {
      const generatorMeta = await page.$('meta[name="generator"]');
      expect(generatorMeta).toBeFalsy();
      
      // Check page source for version exposure
      const content = await page.content();
      expect(content).not.toMatch(/WordPress \d+\.\d+/);
      expect(content).not.toMatch(/wp-content\/themes\/[^\/]+\/style\.css\?ver=/);
    });

    test('should have proper WordPress feed links', async ({ page }) => {
      const feedLinks = await page.$$('link[type="application/rss+xml"], link[type="application/atom+xml"]');
      
      if (feedLinks.length > 0) {
        for (const link of feedLinks) {
          const href = await link.getAttribute('href');
          const title = await link.getAttribute('title');
          
          expect(href).toBeTruthy();
          expect(title).toBeTruthy();
          
          // Check if feed is accessible
          const response = await page.request.head(href);
          expect(response.status()).toBe(200);
        }
      }
    });

    test('should have proper WordPress shortlink if used', async ({ page }) => {
      const shortlink = await page.$('link[rel="shortlink"]');
      
      if (shortlink) {
        const href = await shortlink.getAttribute('href');
        expect(href).toBeTruthy();
        
        // Test shortlink redirect
        const response = await page.request.get(href);
        expect([200, 301, 302]).toContain(response.status());
      }
    });
  });

  test.describe('Local SEO (if applicable)', () => {
    test('should have local business schema if applicable', async ({ page }) => {
      const content = await page.content();
      
      if (content.includes('LocalBusiness') || content.includes('Organization')) {
        const structuredData = await page.$('script[type="application/ld+json"]');
        const data = JSON.parse(await structuredData.textContent());
        
        const localBusiness = Array.isArray(data) 
          ? data.find(item => item['@type']?.includes('Business') || item['@type'] === 'Organization')
          : data['@type']?.includes('Business') || data['@type'] === 'Organization' ? data : null;
        
        if (localBusiness) {
          expect(localBusiness.name).toBeTruthy();
          
          if (localBusiness.address) {
            expect(localBusiness.address.streetAddress || localBusiness.address['@type']).toBeTruthy();
          }
        }
      }
    });

    test('should have contact information if business site', async ({ page }) => {
      const hasContact = await page.$('address, .contact, [itemtype*="PostalAddress"]');
      
      if (hasContact) {
        // Check for phone number
        const phoneLink = await page.$('a[href^="tel:"]');
        if (phoneLink) {
          const href = await phoneLink.getAttribute('href');
          expect(href).toMatch(/^tel:\+?[\d\s\-\(\)]+$/);
        }
        
        // Check for email
        const emailLink = await page.$('a[href^="mailto:"]');
        if (emailLink) {
          const href = await emailLink.getAttribute('href');
          expect(href).toMatch(/^mailto:[\w\.-]+@[\w\.-]+\.\w+$/);
        }
      }
    });
  });
});
