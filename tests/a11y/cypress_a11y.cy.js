import 'cypress-axe';
describe('WCAG smoke', () => {
  const paths = ['/', '/spenden', '/team', '/events'];
  paths.forEach((url) => {
    it(`${url} has no critical violations`, () => {
      cy.visit(url);
      cy.injectAxe();
      cy.configureAxe({ rules: [{ id: 'color-contrast', enabled: true }]});
      cy.checkA11y(null,
        { runOnly: ['wcag2a', 'wcag2aa'] },
        (violations) => { if (violations.length) cy.task('log', violations); },
      );
    });
  });
});
