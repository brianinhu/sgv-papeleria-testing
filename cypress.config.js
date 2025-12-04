const { defineConfig } = require('cypress');

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://localhost/sgv-papeleria-testing',
    setupNodeEvents(on, config) {
      // Implementar plugins si es necesario
    },
    viewportWidth: 1280,
    viewportHeight: 720,
    requestTimeout: 10000,
    responseTimeout: 10000,
  },
});
