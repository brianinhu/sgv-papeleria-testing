describe('L03 - Validar el campo usuario', () => {

    beforeEach(() => {
        cy.visit('/index.php');
    });

    it('Muestra mensaje de error cuando el campo usuario está vacío', () => {
        cy.get('#txtContraseña').type('Test@1234');
        cy.get('#txtRespuestaAntiRobot').type('5');
        // Enviamos el formulario
        cy.get('#btnIngresar').click();
        cy.get('.swal2-title', { timeout: 4000 })
            .should('be.visible')
            .and('have.text', 'Error');
        cy.get('.swal2-html-container')
            .should('be.visible')
            .and('contain.text', 'Por favor, complete el campo usuario');
        cy.url().should('include', '/index.php');
    });

    it('Muestra mensaje de error cuando el campo usuario tiene menos de 5 caracteres', () => {
        cy.get('#txtUsuario').type('usr');
        cy.get('#txtContraseña').type('Test@1234');
        cy.get('#txtRespuestaAntiRobot').type('5');
        // Enviamos el formulario
        cy.get('#btnIngresar').click();
        cy.get('.swal2-title', { timeout: 4000 })
            .should('be.visible')
            .and('have.text', 'Error');
        cy.get('.swal2-html-container')
            .should('be.visible')
            .and('contain.text', 'El usuario debe tener al menos 5 caracteres');
        cy.url().should('include', '/index.php');
    });
    
    it('Muestra mensaje de error cuando el campo usuario contiene caracteres no alfanuméricos', () => {
        cy.get('#txtUsuario').type('user@!');
        cy.get('#txtContraseña').type('Test@1234');
        cy.get('#txtRespuestaAntiRobot').type('5');
        // Enviamos el formulario
        cy.get('#btnIngresar').click();
        cy.get('.swal2-title', { timeout: 4000 })
            .should('be.visible')
            .and('have.text', 'Error');
        cy.get('.swal2-html-container')
            .should('be.visible')
            .and('contain.text', 'El usuario debe contener solo caracteres alfanuméricos');
        cy.url().should('include', '/index.php');
    });
});