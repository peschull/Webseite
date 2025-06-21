const { defineConfig } = require('cypress')

module.exports = defineConfig({
  e2e: {
    // Für lokale Entwicklung - verwendet den dev-server
    baseUrl: "http://localhost:3000", 
    supportFile: "cypress/support/e2e.js",
    specPattern: "cypress/e2e/**/*.cy.{js,jsx,ts,tsx}",
    videosFolder: "cypress/videos",
    screenshotsFolder: "cypress/screenshots",
    viewportWidth: 1280,
    viewportHeight: 720,
    video: false,
    screenshotOnRunFailure: true,
    experimentalMemoryManagement: true,
    numTestsKeptInMemory: 1,
    defaultCommandTimeout: 10000,
    requestTimeout: 10000,
    responseTimeout: 10000,
    setupNodeEvents(on, config) {
      // Add log task for debugging
      on('task', {
        log(message) {
          console.log(message)
          return null
        },
      })
    },
  }
});
