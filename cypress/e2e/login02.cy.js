describe('L02 - Validar la respuesta del captcha', () => {

  beforeEach(() => {
    cy.visit('/index.php');
  });

  it('Muestra mensaje de error cuando el campo captcha está vacío', () => {
    cy.get('#txtUsuario').type('usuarioTest');
    cy.get('#txtContraseña').type('Test@1234');
    // Enviamos el formulario sin completar el captcha
    cy.get('#btnIngresar').click();
    cy.get('.swal2-title', { timeout: 4000 })
      .should('be.visible')
      .and('have.text', 'Error');
    cy.get('.swal2-html-container')
      .should('be.visible')
      .and('contain.text', 'Complete la respuesta de la suma.');
    cy.url().should('include', '/index.php');
  });

  it('Muestra mensaje de error cuando el campo captcha no es un número entero', () => {
    cy.get('#txtUsuario').type('usuarioTest');
    cy.get('#txtContraseña').type('Test@1234');
    cy.get('#txtRespuestaAntiRobot').type('abc');
    // Enviamos el formulario
    cy.get('#btnIngresar').click();
    cy.get('.swal2-title', { timeout: 4000 })
      .should('be.visible')
      .and('have.text', 'Error');
    cy.get('.swal2-html-container')
      .should('be.visible')
      .and('contain.text', 'La respuesta debe ser un número entero.');
    cy.url().should('include', '/index.php');
  });

  it('Muestra mensaje de error cuando el campo captcha es incorrecto', () => {
    cy.get('#txtUsuario').type('usuarioTest');
    cy.get('#txtContraseña').type('Test@1234');
    cy.get('#txtRespuestaAntiRobot').type('10');
    // Enviamos el formulario
    cy.get('#btnIngresar').click();
    cy.get('.swal2-title', { timeout: 4000 })
      .should('be.visible')
      .and('have.text', 'Error');
    cy.get('.swal2-html-container')
      .should('be.visible')
      .and('contain.text', 'La respuesta es incorrecta. Intente nuevamente.');
    cy.url().should('include', '/index.php');
  });
});