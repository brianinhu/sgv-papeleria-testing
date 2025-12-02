const datosProducto = Array.from(document.getElementsByClassName("datosProducto"));
const listaProductos = document.querySelector(".listaProductos");
const totalProforma = document.querySelector(".totalProforma");
const btnAgregarProducto = Array.from(document.getElementsByName("btnAgregarProducto"));

const mostrarMensaje = (mensaje, tipo, text) => {
    Swal.fire({
        title: mensaje,
        text,
        icon: tipo,
        showCancelButton: false,
        confirmButtonText: 'Aceptar'
    });
}

const crearBtnEliminar = (filaProforma) => {
    const btnEliminar = document.createElement("button");
    btnEliminar.classList.add("btn", "btn-danger");
    btnEliminar.type = "button";
    btnEliminar.textContent = "Eliminar";
    btnEliminar.setAttribute("name", "btnEliminar");
    btnEliminar.addEventListener("click", () => {
        filaProforma.remove();
        calcularTotal();
    });
    return btnEliminar;
}

const crearHiddenInput = (name, value) => {
    const input = document.createElement("input");
    input.type = "hidden";
    input.setAttribute("name", name);
    input.value = value;
    return input;
}

const crearListaRow = (nombre, precio) => {
    const filaProforma = document.createElement("tr");
    filaProforma.innerHTML = `
            <td>${nombre}</td>
            <td>${precio}</td>
            <td><input type="number" value="1" min="1" name="cantidadProducto[]"></td>
            <td><input type="text" value="${precio}" readonly name="subTotal[]"></td>
        `;
    return filaProforma;
}

const calcularTotales = (cantidadProductoInput, subtotal, stock) => {
    cantidadProductoInput.addEventListener("input", () => {
        const cantidad = Math.max(1, Math.min(cantidadProductoInput.value, stock));
        if (cantidadProductoInput.value > stock) {
            mostrarMensaje("Stock insuficiente!", "warning", `No hay suficiente stock de este producto, solo hay ${stock} unidades`);
        }
        cantidadProductoInput.value = cantidad;
        const precio = cantidadProductoInput.closest('tr').children[1].textContent;
        subtotal.value = Math.round((cantidad * precio) * 100) / 100;
        calcularTotal();
    });
}

const calcularTotal = () => {
    const subtotales = Array.from(document.getElementsByName("subTotal[]"));
    const total = subtotales.reduce((sum, subtotal) => sum + Number(subtotal.value), 0);
    totalProforma.value = total;
}

btnAgregarProducto.forEach((boton, index) => {
    boton.addEventListener("click", () => {
        const producto = {
            idProducto: datosProducto[index * 4].textContent,
            nombre: datosProducto[index * 4 + 1].textContent,
            precio: datosProducto[index * 4 + 2].textContent,
            stock: datosProducto[index * 4 + 3].textContent
        };

        const nombresProductos = Array.from(document.querySelectorAll(".listaProductos tr td:first-child"));
        if (nombresProductos.some(td => td.textContent === producto.nombre)) {
            mostrarMensaje("¡No se pudo agregar!", "warning", `El producto ${producto.nombre} ya se ha agregado, si desea aumentar la cantidad, modifique en la lista de productos`);
            return;
        }

        mostrarMensaje("¡Producto agregado!", "success", `El producto ${producto.nombre} se ha agregado correctamente`);

        const filaProforma = crearListaRow(producto.nombre, producto.precio);
        filaProforma.appendChild(crearHiddenInput("idProducto[]", producto.idProducto));
        filaProforma.appendChild(crearBtnEliminar(filaProforma));

        listaProductos.appendChild(filaProforma);
        calcularTotales(filaProforma.querySelector("input[name='cantidadProducto[]']"), filaProforma.querySelector("input[name='subTotal[]']"), parseInt(producto.stock));
        calcularTotal();
    });
});

// Inicializar elementos existentes
/*Array.from(document.querySelectorAll(".listaPedidos tr")).forEach(filaProforma => {
    const cantidadProductoInput = filaProforma.querySelector("input[name='cantidadProducto[]']");
    const subTotal = filaProforma.querySelector("input[name='subTotal[]']");
    const stock = parseInt(filaProforma.dataset.stock);
    calcularTotales(cantidadProductoInput, subTotal, stock);
    filaProforma.appendChild(crearBtnEliminar(filaProforma));
});*/