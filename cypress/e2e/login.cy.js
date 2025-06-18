it('logs in with valid credentials', () => {
  cy.visit('/login');
  cy.get('input[name=email]').type('demo@example.com');
  cy.get('input[name=password]').type('secret{enter}');
  cy.url().should('include', '/dashboard');
});

