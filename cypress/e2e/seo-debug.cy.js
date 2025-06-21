describe('SEO Quality Assurance - Debugging', () => {
  beforeEach(() => {
    cy.visit('/', { timeout: 10000 });
    cy.wait(1000); // Wait for page to fully load
  });

  describe('Meta Tags Validation', () => {
    it('should have properly optimized title tag', () => {
      cy.title().then((title) => {
        expect(title).to.exist;
        expect(title.length).to.be.lessThan(61);
        expect(title).to.include('Verein Menschlichkeit');
        expect(title).to.include('Soziale Gerechtigkeit');
        cy.log(`Title: "${title}" (${title.length} chars)`);
      });
    });

    it('should have optimized meta description', () => {
      cy.get('head meta[name="description"]')
        .should('exist')
        .invoke('attr', 'content')
        .then((description) => {
          expect(description).to.exist;
          expect(description.length).to.be.lessThan(156);
          expect(description).to.include('Verein Menschlichkeit');
          expect(description).to.include('Mitglied');
          cy.log(`Description: "${description}" (${description.length} chars)`);
        });
    });

    it('should have essential meta tags', () => {
      cy.get('head meta[charset]').should('exist');
      cy.get('head meta[name="viewport"]').should('exist');
      cy.get('head meta[name="robots"]').should('exist');
      cy.get('head meta[name="author"]').should('exist');
      cy.get('head link[rel="canonical"]').should('exist');
    });
  });

  describe('Open Graph & Social Media', () => {
    it('should have complete Open Graph tags', () => {
      const ogTags = ['og:title', 'og:description', 'og:type', 'og:url', 'og:image'];
      
      ogTags.forEach(tag => {
        cy.get(`head meta[property="${tag}"]`)
          .should('exist')
          .invoke('attr', 'content')
          .should('not.be.empty');
      });
    });

    it('should have accessible OG image', () => {
      cy.get('head meta[property="og:image"]')
        .invoke('attr', 'content')
        .then((imageUrl) => {
          cy.request({
            url: imageUrl,
            method: 'HEAD',
            failOnStatusCode: false
          }).then((response) => {
            expect(response.status).to.be.oneOf([200, 304]);
            cy.log(`OG Image status: ${response.status}`);
          });
        });
    });

    it('should have Twitter Card tags', () => {
      cy.get('head meta[name="twitter:card"]').should('exist');
      cy.get('head meta[name="twitter:title"]').should('exist');
      cy.get('head meta[name="twitter:description"]').should('exist');
    });
  });

  describe('Structured Data (JSON-LD)', () => {
    it('should have valid JSON-LD structured data', () => {
      cy.get('script[type="application/ld+json"]').should('have.length.gte', 1);
      
      cy.get('script[type="application/ld+json"]').each(($script) => {
        const jsonText = $script.text();
        expect(() => JSON.parse(jsonText)).to.not.throw();
        
        const jsonLd = JSON.parse(jsonText);
        expect(jsonLd).to.have.property('@context');
        expect(jsonLd).to.have.property('@type');
        
        cy.log(`Schema type: ${jsonLd['@type']}`);
      });
    });

    it('should have Organization schema', () => {
      cy.get('script[type="application/ld+json"]').then(($scripts) => {
        const organizationSchema = Array.from($scripts).find(script => {
          try {
            const json = JSON.parse(script.innerText);
            return json['@type'] === 'Organization';
          } catch (e) {
            return false;
          }
        });
        
        expect(organizationSchema).to.exist;
        const org = JSON.parse(organizationSchema.innerText);
        expect(org.name).to.equal('Verein Menschlichkeit');
        expect(org.address).to.exist;
        expect(org.contactPoint).to.exist;
      });
    });
  });

  describe('WordPress Structure', () => {
    it('should have WordPress-compliant body classes', () => {
      cy.get('body').should('have.attr', 'class').then((classAttr) => {
        expect(classAttr).to.match(/\b(home|wordpress|blog)\b/);
        cy.log(`Body classes: ${classAttr}`);
      });
    });

    it('should have proper article structure', () => {
      cy.get('article.post.hentry').should('exist');
      cy.get('article.post.hentry').should('have.attr', 'itemscope');
      cy.get('article.post.hentry').should('have.attr', 'itemtype', 'https://schema.org/Article');
    });

    it('should have WordPress head profile', () => {
      cy.get('head link[rel="profile"]').should('exist');
      cy.get('head link[rel="profile"]').should('have.attr', 'href', 'https://gmpg.org/xfn/11');
    });
  });

  describe('Accessibility & UX', () => {
    it('should have accessible images', () => {
      cy.get('img').each(($img) => {
        cy.wrap($img).should('have.attr', 'alt');
        cy.wrap($img).invoke('attr', 'alt').should('not.be.empty');
      });
    });

    it('should have skip link for accessibility', () => {
      cy.get('.skip-link').should('exist');
      cy.get('.skip-link').should('have.attr', 'href', '#main');
    });

    it('should have proper heading hierarchy', () => {
      cy.get('h1').should('have.length', 1);
      cy.get('h1').should('be.visible').and('not.be.empty');
      
      // Check heading sequence
      cy.get('h1, h2, h3, h4, h5, h6').then(($headings) => {
        const levels = Array.from($headings).map(h => parseInt(h.tagName.charAt(1)));
        cy.log(`Heading levels: ${levels.join(', ')}`);
        
        // H1 should come first
        expect(levels[0]).to.equal(1);
      });
    });
  });

  describe('Touch & Mobile Optimization', () => {
    it('should have touch-friendly navigation on mobile', () => {
      cy.viewport('iphone-6');
      
      cy.get('.menu-item a').each(($link) => {
        cy.wrap($link).then(($el) => {
          const rect = $el[0].getBoundingClientRect();
          const minSize = 44;
          const actualSize = Math.max(rect.width, rect.height);
          
          if (rect.width > 0 && rect.height > 0) {
            expect(actualSize, `Navigation link should be at least ${minSize}px`).to.be.gte(minSize - 2);
          }
        });
      });
    });

    it('should have touch-friendly buttons', () => {
      cy.viewport('iphone-6');
      
      cy.get('button, .cta-button, .submit-button').each(($btn) => {
        cy.wrap($btn).then(($el) => {
          const rect = $el[0].getBoundingClientRect();
          const minSize = 44;
          
          if (rect.width > 0 && rect.height > 0) {
            const actualSize = Math.max(rect.width, rect.height);
            expect(actualSize, `Button should be at least ${minSize}px`).to.be.gte(minSize - 2);
          }
        });
      });
    });
  });

  describe('Performance & Technical', () => {
    it('should load within acceptable time', () => {
      cy.window().then((win) => {
        const perfData = win.performance.timing;
        const loadTime = perfData.loadEventEnd - perfData.navigationStart;
        expect(loadTime).to.be.lessThan(5000); // 5 seconds max
        cy.log(`Page load time: ${loadTime}ms`);
      });
    });

    it('should have proper language declaration', () => {
      cy.get('html').should('have.attr', 'lang', 'de');
    });

    it('should have theme color for mobile browsers', () => {
      cy.get('head meta[name="theme-color"]').should('exist');
    });
  });

  describe('Content Quality', () => {
    it('should have sufficient content length', () => {
      cy.get('main').invoke('text').then((text) => {
        const wordCount = text.trim().split(/\s+/).length;
        expect(wordCount).to.be.gte(200);
        cy.log(`Main content word count: ${wordCount}`);
      });
    });

    it('should have internal linking', () => {
      cy.get('main a[href^="/"], main a[href^="./"]').should('have.length.gte', 3);
    });

    it('should have external links with proper attributes', () => {
      cy.get('a[target="_blank"]').each(($link) => {
        cy.wrap($link).should('have.attr', 'rel');
        cy.wrap($link).invoke('attr', 'rel').should('match', /(noopener|noreferrer)/);
      });
    });
  });
});
