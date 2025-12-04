describe('L01 - Verificar que la página de login carga correctamente', () => {

  beforeEach(() => {
    cy.visit('/index.php');
  });

  it('Debe cargar la página de autenticación', () => {
    cy.get('h1')
      .should('be.visible')
      .and('have.text', 'Autenticación de Usuario');

    cy.get('input[id="txtUsuario"]')
      .should('exist')
      .and('not.be.disabled');

    cy.get('input[id="txtContraseña"]')
      .should('exist')
      .and('not.be.disabled')
      .and('have.attr', 'type', 'password');

    cy.get('label[for="txtRespuestaAntiRobot"]')
      .should('be.visible')
      .and('have.text', 'Compruebe que no es un robot');

    cy.get('#antiRobot img')
      .should('be.visible')
      .and('have.attr', 'src')
      .and('include', 'captcha.php')
      .and('not.include', 'broken');

    cy.get('#txtRespuestaAntiRobot')
      .should('be.visible')
      .and('be.enabled')
      .and('have.value', '')
      .and('have.attr', 'autocomplete', 'off')
      .and('have.attr', 'type', 'text');

    cy.get('button[id="btnIngresar"]')
      .should('exist')
      .and('not.be.disabled')
      .and('have.text', 'Ingresar');
  });
});

