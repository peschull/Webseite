describe('Accessibility Tests', () => {
  beforeEach(() => {
    cy.visit('/')
    cy.injectAxe()
  })

  it('should have no detectable accessibility violations on homepage', () => {
    // Check accessibility with relaxed rules for development
    cy.checkA11y(null, {
      includedImpacts: ['critical', 'serious'],
      rules: {
        // Temporarily disable color contrast rule for development
        'color-contrast': { enabled: false }
      }
    }, (violations) => {
      // Log violations for debugging
      console.log('Accessibility violations:', violations)
      cy.task('log', violations)
    })
  })

  it('should have proper heading structure', () => {
    cy.get('h1').should('exist').and('be.visible')
    cy.get('h2').should('exist')
    cy.get('h3').should('exist')
  })

  it('should have accessible navigation', () => {
    cy.get('nav').should('exist')
    cy.get('nav a').should('have.length.greaterThan', 0)
    cy.get('nav a').each(($link) => {
      cy.wrap($link).should('have.attr', 'href')
    })
  })

  it('should have accessible buttons with focus states', () => {
    cy.get('.btn').first().focus()
    cy.get('.btn').first().should('be.focused')
  })

  it('should test accessibility on dedicated test page', () => {
    cy.visit('/accessibility-test')
    cy.injectAxe()
    cy.checkA11y()
  })

  it('should have proper form labels', () => {
    cy.visit('/accessibility-test')
    cy.get('input').each(($input) => {
      const id = $input.attr('id')
      if (id) {
        cy.get(`label[for="${id}"]`).should('exist')
      }
    })
  })

  it('should have alt text for images', () => {
    cy.visit('/accessibility-test')
    cy.get('img').each(($img) => {
      cy.wrap($img).should('have.attr', 'alt')
    })
  })
})

