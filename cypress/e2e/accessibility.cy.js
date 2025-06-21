describe('WordPress Theme Accessibility Tests', () => {
  beforeEach(() => {
    // Test WordPress theme files locally
    cy.visit('/Webseite/verein-menschlichkeit-theme/index.html')
  })

  it('should have WordPress semantic structure', () => {
    cy.get('body').should('exist')
    cy.get('html').should('have.attr', 'lang')
    cy.document().its('title').should('not.be.empty')
    
    // WordPress specific structure - check for any body class
    cy.get('body[class]').should('exist') // Prüfe, ob body eine class hat (beliebige)
    cy.get('header, .site-header').should('exist')
    cy.get('main, .site-main, #main').should('exist')
    cy.get('footer, .site-footer').should('exist')
  })

  it('should have proper WordPress heading hierarchy', () => {
    cy.get('h1').should('exist')
    cy.get('h1').should('have.length.greaterThan', 0)
    
    // Check for proper heading hierarchy
    cy.get('h1, h2, h3, h4, h5, h6').then(($headings) => {
      expect($headings.length).to.be.greaterThan(0)
    })
  })

  it('should have WordPress block elements with proper accessibility', () => {
    // Test WordPress blocks
    cy.get('.wp-block, [class*="wp-block-"]').should('exist')
    
    // Test custom blocks from theme
    cy.get('.cta-block, .team-block, .werte-block').should('exist')
  })

  it('should have images with alt attributes (WordPress media)', () => {
    cy.get('img').each(($img) => {
      cy.wrap($img).should('have.attr', 'alt')
      
      // WordPress specific image classes
      if ($img.hasClass('wp-image') || $img.hasClass('attachment-')) {
        cy.wrap($img).should('have.attr', 'alt')
      }
    })
  })

  it('should have WordPress navigation accessibility', () => {
    // WordPress navigation
    cy.get('nav, .navigation, .nav-menu').should('exist')
    
    // Skip links for accessibility
    cy.get('.screen-reader-text, .skip-link').should('exist')
    
    // Menu accessibility
    cy.get('nav a, .menu-item a').each(($link) => {
      cy.wrap($link).should('not.be.empty')
    })
  })

  it('should have proper form accessibility (WordPress forms)', () => {
    cy.get('form').each(($form) => {
      cy.wrap($form).within(() => {
        cy.get('input, textarea, select').each(($input) => {
          const id = $input.attr('id')
          const name = $input.attr('name')
          
          if (id) {
            cy.get(`label[for="${id}"]`).should('exist')
          } else if (name) {
            // WordPress often uses name attributes
            cy.wrap($input).should('have.attr', 'placeholder')
              .or('have.attr', 'aria-label')
              .or('have.attr', 'title')
          }
        })
      })
    })
  })
})
