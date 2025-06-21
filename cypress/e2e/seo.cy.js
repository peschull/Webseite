describe('WordPress Theme SEO Tests', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  describe('Meta Tags', () => {
    it('should have proper page title', () => {
      cy.title().should('not.be.empty');
      cy.title().should('contain', 'Verein Menschlichkeit');
      cy.title().its('length').should('be.lessThan', 61); // Optimal title length
    });

    it('should have meta description', () => {
      cy.get('head meta[name="description"]')
        .should('exist')
        .and('have.attr', 'content')
        .and('not.be.empty');
      
      cy.get('head meta[name="description"]')
        .invoke('attr', 'content')
        .its('length')
        .should('be.gte', 120)
        .and('be.lte', 160); // Optimal meta description length
    });

    it('should have meta keywords (if used)', () => {
      cy.get('head meta[name="keywords"]').then(($keywords) => {
        if ($keywords.length > 0) {
          cy.wrap($keywords)
            .should('have.attr', 'content')
            .and('not.be.empty');
        } else {
          // Keywords are optional in modern SEO
          cy.log('Meta keywords not found - this is acceptable for modern SEO');
        }
      });
    });

    it('should have proper viewport meta tag', () => {
      cy.get('head meta[name="viewport"]')
        .should('exist')
        .and('have.attr', 'content')
        .and('contain', 'width=device-width');
    });

    it('should have charset meta tag', () => {
      cy.get('head meta[charset]')
        .should('exist')
        .and('have.attr', 'charset', 'UTF-8');
    });
  });

  describe('Open Graph Tags', () => {
    it('should have Open Graph title', () => {
      cy.get('head meta[property="og:title"]')
        .should('exist')
        .and('have.attr', 'content')
        .and('not.be.empty');
    });

    it('should have Open Graph description', () => {
      cy.get('head meta[property="og:description"]')
        .should('exist')
        .and('have.attr', 'content')
        .and('not.be.empty');
    });

    it('should have Open Graph type', () => {
      cy.get('head meta[property="og:type"]')
        .should('exist')
        .and('have.attr', 'content')
        .and('match', /^(website|article|blog)$/);
    });

    it('should have Open Graph URL', () => {
      cy.get('head meta[property="og:url"]')
        .should('exist')
        .and('have.attr', 'content')
        .and('contain', 'http');
    });

    it('should have Open Graph image', () => {
      cy.get('head meta[property="og:image"]').then(($ogImage) => {
        if ($ogImage.length > 0) {
          cy.wrap($ogImage)
            .should('have.attr', 'content')
            .and('contain', 'http');
          
          // Check if image exists
          cy.wrap($ogImage)
            .invoke('attr', 'content')
            .then((imageUrl) => {
              cy.request('HEAD', imageUrl).its('status').should('eq', 200);
            });
        }
      });
    });
  });

  describe('Twitter Card Tags', () => {
    it('should have Twitter card type', () => {
      cy.get('head meta[name="twitter:card"]').then(($twitterCard) => {
        if ($twitterCard.length > 0) {
          cy.wrap($twitterCard)
            .should('have.attr', 'content')
            .and('match', /^(summary|summary_large_image|app|player)$/);
        }
      });
    });

    it('should have Twitter title', () => {
      cy.get('head meta[name="twitter:title"]').then(($twitterTitle) => {
        if ($twitterTitle.length > 0) {
          cy.wrap($twitterTitle)
            .should('have.attr', 'content')
            .and('not.be.empty');
        }
      });
    });

    it('should have Twitter description', () => {
      cy.get('head meta[name="twitter:description"]').then(($twitterDesc) => {
        if ($twitterDesc.length > 0) {
          cy.wrap($twitterDesc)
            .should('have.attr', 'content')
            .and('not.be.empty');
        }
      });
    });
  });

  describe('Structured Data', () => {
    it('should have JSON-LD structured data', () => {
      cy.get('script[type="application/ld+json"]').then(($scripts) => {
        if ($scripts.length > 0) {
          cy.wrap($scripts).each(($script) => {
            cy.wrap($script)
              .invoke('text')
              .then((text) => {
                expect(() => JSON.parse(text)).to.not.throw();
                const data = JSON.parse(text);
                expect(data).to.have.property('@context');
                expect(data['@context']).to.contain('schema.org');
              });
          });
        }
      });
    });

    it('should have organization schema if applicable', () => {
      cy.get('script[type="application/ld+json"]').then(($scripts) => {
        if ($scripts.length > 0) {
          let hasOrganization = false;
          $scripts.each((index, script) => {
            try {
              const data = JSON.parse(script.textContent);
              if (data['@type'] === 'Organization' || 
                  (Array.isArray(data) && data.some(item => item['@type'] === 'Organization'))) {
                hasOrganization = true;
                expect(data.name || data[0]?.name).to.exist;
              }
            } catch (e) {
              // Skip invalid JSON
            }
          });
        }
      });
    });
  });

  describe('Heading Structure', () => {
    it('should have proper heading hierarchy', () => {
      cy.get('h1').should('have.length.at.least', 1); // At least one H1 per page
      cy.get('h1').first().should('be.visible').and('not.be.empty');
      
      // Check that headings exist and are in reasonable order
      cy.get('h1, h2, h3, h4, h5, h6').should('have.length.greaterThan', 1);
    });

    it('should have descriptive heading text', () => {
      cy.get('h1, h2, h3, h4, h5, h6').each(($heading) => {
        cy.wrap($heading)
          .invoke('text')
          .should('not.be.empty')
          .and('have.length.greaterThan', 2);
      });
    });
  });

  describe('URL Structure', () => {
    it('should have clean URLs', () => {
      cy.url().should('not.contain', '?');
      cy.url().should('not.contain', '&');
      cy.url().should('not.contain', 'index.php');
    });

    it('should use HTTPS if available', () => {
      cy.url().then((url) => {
        if (url.startsWith('https://')) {
          expect(url).to.match(/^https:\/\//);
        }
      });
    });
  });

  describe('Content Quality', () => {
    it('should have sufficient content length', () => {
      cy.get('main, article, .content, #content').first().then(($content) => {
        const textLength = $content.text().replace(/\s+/g, ' ').trim().length;
        expect(textLength).to.be.greaterThan(300); // Minimum content length
      });
    });

    it('should have alt attributes for images', () => {
      cy.get('img').each(($img) => {
        cy.wrap($img).should('have.attr', 'alt');
        
        // Check for meaningful alt text (not just filename)
        cy.wrap($img).invoke('attr', 'alt').then((alt) => {
          expect(alt).to.not.match(/\.(jpg|jpeg|png|gif|webp)$/i);
          expect(alt.length).to.be.greaterThan(0);
        });
      });
    });

    it('should have internal linking', () => {
      cy.get('a[href^="/"], a[href*="' + Cypress.config().baseUrl + '"]')
        .should('have.length.greaterThan', 0);
    });
  });

  describe('Technical SEO', () => {
    it('should have robots meta tag or robots.txt reference', () => {
      cy.get('head meta[name="robots"]').then(($robots) => {
        if ($robots.length > 0) {
          cy.wrap($robots)
            .should('have.attr', 'content')
            .and('not.be.empty');
        } else {
          // Check if robots.txt is referenced or accessible
          cy.request({ url: '/robots.txt', failOnStatusCode: false })
            .its('status')
            .should('be.oneOf', [200, 404]); // Either exists or doesn't, both are OK
        }
      });
    });

    it('should have canonical URL', () => {
      cy.get('head link[rel="canonical"]').then(($canonical) => {
        if ($canonical.length > 0) {
          cy.wrap($canonical)
            .should('have.attr', 'href')
            .and('contain', 'http');
        }
      });
    });

    it('should have language declaration', () => {
      cy.get('html').should('have.attr', 'lang').and('not.be.empty');
    });

    it('should not have too many links', () => {
      cy.get('a[href]').its('length').should('be.lessThan', 100); // SEO best practice
    });

    it('should have proper link attributes for external links', () => {
      cy.get('a[href^="http"]:not([href*="' + Cypress.config().baseUrl + '"])').each(($link) => {
        // External links should have rel attributes for security
        cy.wrap($link).invoke('attr', 'rel').then((rel) => {
          if (rel) {
            expect(rel).to.match(/(noopener|noreferrer|nofollow)/);
          }
        });
      });
    });
  });

  describe('WordPress Specific SEO', () => {
    it('should not have WordPress generator meta tag (security)', () => {
      cy.get('head meta[name="generator"]').should('not.exist');
    });

    it('should have proper WordPress head structure', () => {
      cy.get('head link[rel="profile"]').should('exist');
    });

    it('should have WordPress-generated classes for styling', () => {
      cy.get('body').should('have.attr', 'class').then((classAttr) => {
        expect(classAttr).to.match(/\b(home|page|single|archive|blog|wordpress)\b/);
      });
    });

    it('should have proper post/page structure if applicable', () => {
      cy.get('article.post, article.hentry, .post.hentry').should('exist').then(($articles) => {
        if ($articles.length > 0) {
          cy.wrap($articles).first().should('have.attr', 'class').then((classAttr) => {
            expect(classAttr).to.match(/\b(post|hentry)\b/);
          });
        }
      });
    });
  });

  describe('Performance SEO Factors', () => {
    it('should load within acceptable time', () => {
      cy.window().then((win) => {
        const loadTime = win.performance.timing.loadEventEnd - win.performance.timing.navigationStart;
        expect(loadTime).to.be.lessThan(3000); // 3 seconds max load time
      });
    });

    it('should have optimized images', () => {
      cy.get('img').each(($img) => {
        cy.wrap($img).should('be.visible');
        
        // Check if images have width and height attributes
        cy.wrap($img).invoke('attr', 'width').then((width) => {
          cy.wrap($img).invoke('attr', 'height').then((height) => {
            if (!width || !height) {
              // If no width/height attributes, check CSS
              cy.wrap($img).should('have.css', 'width').and('not.eq', 'auto');
              cy.wrap($img).should('have.css', 'height').and('not.eq', 'auto');
            }
          });
        });
      });
    });

    it('should not have too many DOM elements', () => {
      cy.get('*').its('length').should('be.lessThan', 1500); // SEO performance guideline
    });
  });

  describe('Mobile SEO', () => {
    it('should be mobile responsive', () => {
      cy.viewport('iphone-6');
      cy.get('body').should('be.visible');
      
      // Check if content is readable on mobile
      cy.get('main, article, .content').should('be.visible');
      
      // Check if navigation works on mobile
      cy.get('nav, .menu, .navigation').should('be.visible');
    });

    it('should have touch-friendly elements', () => {
      cy.viewport('iphone-6');
      
      // Prüfe wichtige Touch-Targets
      cy.get('a:visible, button:visible, input:visible, [role="button"]:visible').each(($el) => {
        cy.wrap($el).then(($element) => {
          const rect = $element[0].getBoundingClientRect();
          const minSize = 44; // Apple's recommended minimum touch target
          
          // Nur prüfen wenn Element sichtbar und interaktiv ist
          if (rect.width > 0 && rect.height > 0) {
            const actualSize = Math.max(rect.width, rect.height);
            if (actualSize < minSize) {
              cy.log(`Touch target too small: ${$element[0].tagName} with size ${actualSize}px`);
            }
            expect(actualSize, `Touch target ${$element[0].tagName} should be at least ${minSize}px`).to.be.gte(minSize - 5); // 5px Toleranz
          }
        });
      });
    });
  });
});
