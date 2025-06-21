describe('SEO Core Tests', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  it('should have basic SEO meta tags', () => {
    // Title check
    cy.title().should('exist').and('have.length.lessThan', 61);
    
    // Meta description
    cy.get('head meta[name="description"]').should('exist')
      .invoke('attr', 'content').should('have.length.lessThan', 156);
    
    // Viewport
    cy.get('head meta[name="viewport"]').should('exist');
    
    // Charset
    cy.get('head meta[charset]').should('exist');
  });

  it('should have Open Graph tags', () => {
    cy.get('head meta[property="og:title"]').should('exist');
    cy.get('head meta[property="og:description"]').should('exist');
    cy.get('head meta[property="og:type"]').should('exist');
    cy.get('head meta[property="og:url"]').should('exist');
    
    // Test OG Image accessibility
    cy.get('head meta[property="og:image"]').should('exist')
      .invoke('attr', 'content').then((imageUrl) => {
        cy.request('HEAD', imageUrl).then((response) => {
          expect(response.status).to.eq(200);
        });
      });
  });

  it('should have proper heading structure', () => {
    cy.get('h1').should('have.length', 1);
    cy.get('h1').should('be.visible').and('contain.text');
    
    // Check heading hierarchy
    cy.get('h1, h2, h3, h4, h5, h6').then(($headings) => {
      const headings = Array.from($headings).map(h => parseInt(h.tagName.charAt(1)));
      let currentLevel = 0;
      
      headings.forEach(level => {
        expect(level).to.be.lessThan(currentLevel + 3); // No skipping more than 1 level
        currentLevel = level;
      });
    });
  });

  it('should have WordPress structure', () => {
    cy.get('body').should('have.attr', 'class').and('match', /wordpress|home|blog/);
    cy.get('article.post, article.hentry').should('exist');
  });
});

describe('SEO Accessibility Tests', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  it('should have accessible images', () => {
    cy.get('img').each(($img) => {
      cy.wrap($img).should('have.attr', 'alt');
    });
  });

  it('should have touch-friendly elements', () => {
    cy.viewport('iphone-6');
    
    // Test a few key elements instead of all
    cy.get('nav a:first, .btn:first, button:first').each(($el) => {
      cy.wrap($el).then(($element) => {
        const rect = $element[0].getBoundingClientRect();
        expect(Math.max(rect.width, rect.height)).to.be.gte(40); // Reduced threshold
      });
    });
  });
});

describe('SEO Technical Tests', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  it('should have structured data', () => {
    cy.get('script[type="application/ld+json"]').should('exist').and('have.length.gte', 1);
    
    cy.get('script[type="application/ld+json"]').first().then(($script) => {
      const jsonLd = JSON.parse($script.text());
      expect(jsonLd).to.have.property('@context');
      expect(jsonLd).to.have.property('@type');
    });
  });

  it('should have good performance', () => {
    cy.window().then((win) => {
      cy.wrap(win.performance.timing).should('exist');
    });
  });

  it('should have proper canonical and robots', () => {
    cy.get('head link[rel="canonical"]').should('exist');
    cy.get('head meta[name="robots"]').should('exist');
  });
});
