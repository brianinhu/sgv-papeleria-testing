// cypress/e2e/proforma/emitir-3-productos.cy.js

describe('Emitir proforma de 3 productos', () => {
    beforeEach(() => {
        cy.login('admin', 'admin123!')
        cy.get('button[name="btnEmitirProforma"]').click()
        cy.get('#productsTable tbody tr').should('have.length.gte', 3)
    })

    it('debe agregar 3 productos y emitir la proforma correctamente', () => {
        // 1. Agregar 3 productos
        ;[0, 2, 4].forEach(i => {
            cy.get('#productsTable tbody tr').eq(i).find('.add-product').click({ force: true })
            cy.cerrarMensaje()
        })

        // 2. MOSTRAR RESUMEN (sin reload)
        cy.get('#verListaProforma').click({ force: true })
        cy.cerrarMensaje() // ← este es el que hace que funcione

        // 3. Esperar a que el resumen esté visible y tenga los 3 productos
        cy.get('div.resumenProforma', { timeout: 15000 })
            .should('be.visible')
            .within(() => {
                cy.get('tbody tr').should('have.length.gte', 3)
            })

        // Bonus: verificar que el total esté visible
        cy.get('input.totalProforma, #totalProforma').should('be.visible')

        // 4. Generar proforma
        cy.get('input[name="btnGenerarProforma"]').click()

        // 5. Éxito
        cy.get('.modal').should('contain', 'PROFORMA GENERADA CON éXITO')
        cy.url({ timeout: 10000 }).should('include', 'getProforma.php')
    })
})