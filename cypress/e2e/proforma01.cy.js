describe('Módulo Emitir Proforma - Funcionalidad', () => {
    beforeEach(() => {
        cy.login('admin', 'admin123!');
        cy.get('button[name="btnEmitirProforma"]').click();
    });

    // 1. Verificar que la página carga correctamente
    it('debe cargar la página de Emisión de Proforma correctamente', () => {
        cy.get('h1').should('contain', 'Emisión de Proforma');
        cy.contains('.meta', 'Usuario:').should('be.visible');
        cy.get('#productsTable').should('be.visible');
    });

    // 2. Verificar que la tabla de productos carga con DataTables
    it('debe cargar la tabla de productos con DataTables', () => {
        cy.get('#productsTable').should('exist');
        cy.get('#productsTable_wrapper').should('exist'); // Wrapper de DataTables
        cy.get('#productsTable tbody tr').should('have.length.greaterThan', 0);
    });

    // 3. Verificar columnas de la tabla
    it('debe mostrar todas las columnas correctas', () => {
        cy.get('#productsTable thead th').should('have.length', 8);
        cy.get('#productsTable thead th').eq(0).should('contain', 'ID');
        cy.get('#productsTable thead th').eq(1).should('contain', 'Nombre');
        cy.get('#productsTable thead th').eq(2).should('contain', 'Descripción');
        cy.get('#productsTable thead th').eq(3).should('contain', 'Categoría');
        cy.get('#productsTable thead th').eq(4).should('contain', 'Precio');
        cy.get('#productsTable thead th').eq(5).should('contain', 'Stock');
        cy.get('#productsTable thead th').eq(6).should('contain', 'Estado');
        cy.get('#productsTable thead th').eq(7).should('contain', 'Acción');
    });

    // 4. Verificar búsqueda con DataTables
    it('debe permitir buscar productos usando DataTables', () => {
        cy.get('#productsTable_filter input[type="search"]').type('lapiz');
        cy.wait(500);
        cy.get('#productsTable tbody tr').should('have.length.lte', 10);
    });

    // 5. Verificar que productos agotados tienen botón deshabilitado
    it('debe deshabilitar el botón Agregar para productos sin stock', () => {
        cy.get('#productsTable tbody tr').each(($row) => {
            cy.wrap($row).within(() => {
                cy.get('td').eq(5).invoke('text').then((stock) => {
                    if (parseInt(stock) === 0) {
                        cy.get('input[name="btnAgregarProducto"]').should('be.disabled');
                        cy.get('input[name="btnAgregarProducto"]').should('have.class', 'secondary');
                    } else {
                        cy.get('input[name="btnAgregarProducto"]').should('not.be.disabled');
                    }
                });
            });
        });
    });
});