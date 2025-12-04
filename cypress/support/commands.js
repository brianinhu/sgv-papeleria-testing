Cypress.Commands.add('login', (usuario = 'admin', password = '123456') => {
    cy.visit('/index.php');
    cy.get('#txtUsuario').type(usuario);
    cy.get('#txtContraseña').type(password);
    cy.get('#txtRespuestaAntiRobot').type('5'); // o tu bypass de CAPTCHA
    cy.get('#btnIngresar').click();

    cy.contains('Panel principal').should('be.visible');
});

Cypress.Commands.add('cerrarMensaje', () => {
  cy.get('body').then(($body) => {
    if ($body.find('.swal2-container.swal2-backdrop-show').length) {
      cy.get('.swal2-confirm').click({ force: true })
    }
  })
})