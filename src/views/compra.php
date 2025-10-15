<?php
?>

<div class="container">
    <h1 id="compra-titulo">Confirmar Compra</h1>
    <div class="compra-encabezado">
        <span class="encabezado-img">Imagen</span>
        <span class="encabezado-nombre">Nombre</span>
        <span class="encabezado-precio">Precio</span>
        <span class="encabezado-cantidad">Cantidad</span>
    </div>
    <ul class="compra-lista">
        <li class="compra-item">
            <img src="/img/guitarra_01.jpg" alt="Lukather" class="compra-img">
            <div class="compra-info">
                <span class="compra-nombre">Lukather</span>
                <span class="compra-precio">$299</span>
                <button class="increase-btn">-</button>
                <span class="compra-cantidad">1</span>
                <button class="decrease-btn">+</button>
                <button class="remove-btn">X</button>
            </div>
        </li>
        
    </ul>
    <div class="compra-total">
        <span>Total: $<span id="total-compra">0</span></span>
        <button id="finalizar-compra-btn" class="finalizar-compra-btn">Finalizar compra</button>
        <button id="vaciar-carrito-btn" class="vaciar-carrito-btn">Vaciar carrito</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    // Mostrar productos del carrito
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const compraLista = document.querySelector('.compra-lista');
    const compraTotal = document.querySelector('.compra-total');
    const compraTitulo = document.getElementById('compra-titulo');
    compraLista.innerHTML = '';

    if (cart.length === 0) {
        compraLista.innerHTML = '<li class="carrito-vacio">Carrito Vacío</li>';
        compraTotal.style.display = 'none';
        compraTitulo.style.display = 'none';
    } else {
        compraTotal.style.display = 'block';
        compraTitulo.style.display = 'block';
        cart.forEach((producto, idx) => {
            const li = document.createElement('li');
            li.className = 'compra-item';
            li.innerHTML = `
                <img src="${producto.image}" alt="${producto.name}" class="compra-img">
                <div class="compra-info">
                    <span class="compra-nombre">${producto.name}</span>
                    <span class="compra-precio" data-precio="${producto.price}">$${(producto.price * producto.quantity).toFixed(2)}</span>
                    <button class="increase-btn">-</button>
                    <span class="compra-cantidad">${producto.quantity}</span>
                    <button class="decrease-btn">+</button>
                    <button class="remove-btn">X</button>
                </div>
            `;
            compraLista.appendChild(li);

            // Eliminar producto al hacer clic en remove-btn
            li.querySelector('.remove-btn').addEventListener('click', () => {
                cart.splice(idx, 1); // Elimina el producto del array
                localStorage.setItem('cart', JSON.stringify(cart));
                li.remove(); // Elimina el elemento de la vista
                calcularTotal();
            });
        });
    }

    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.compra-item').forEach(item => {
            // El precio ya está multiplicado por la cantidad
            const precioTotalProducto = parseFloat(item.querySelector('.compra-precio').textContent.replace('$', ''));
            total += precioTotalProducto;
        });
        document.getElementById('total-compra').textContent = total.toFixed(2);
    }

    function actualizarPrecioPorProducto(item) {
        const precioUnitario = parseFloat(item.querySelector('.compra-precio').getAttribute('data-precio'));
        const cantidad = parseInt(item.querySelector('.compra-cantidad').textContent, 10);
        item.querySelector('.compra-precio').textContent = `$${(precioUnitario * cantidad).toFixed(2)}`;
    }

    document.querySelectorAll('.compra-item').forEach(item => {
        const increaseBtn = item.querySelector('.increase-btn');
        const decreaseBtn = item.querySelector('.decrease-btn');
        const cantidadSpan = item.querySelector('.compra-cantidad');

        if (increaseBtn && cantidadSpan) {
            increaseBtn.addEventListener('click', () => {
                let cantidad = parseInt(cantidadSpan.textContent, 10);
                if (cantidad > 0) cantidad--;
                cantidadSpan.textContent = cantidad;
                actualizarPrecioPorProducto(item);
                calcularTotal();
                syncCartWithView(); // <-- Actualiza localStorage
            });
        }

        if (decreaseBtn && cantidadSpan) {
            decreaseBtn.addEventListener('click', () => {
                let cantidad = parseInt(cantidadSpan.textContent, 10);
                cantidad++;
                cantidadSpan.textContent = cantidad;
                actualizarPrecioPorProducto(item);
                calcularTotal();
                syncCartWithView(); // <-- Actualiza localStorage
            });
        }
    });

    // Vaciar carrito
    document.getElementById('vaciar-carrito-btn').addEventListener('click', () => {
        localStorage.removeItem('cart');
        compraLista.innerHTML = '<li class="carrito-vacio">Carrito Vacío</li>';
        compraTotal.style.display = 'none';
        compraTitulo.style.display = 'none';
    });

    document.getElementById('finalizar-compra-btn').addEventListener('click', () => {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const total = document.getElementById('total-compra').textContent;
        if (cart.length === 0) return;

        // Filtra solo los campos necesarios
        cart = cart.map(producto => ({
            name: producto.name,
            price: producto.price,
            quantity: producto.quantity
        }));

        fetch('save_invoice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `products=${encodeURIComponent(JSON.stringify(cart))}&total=${encodeURIComponent(total)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('¡Compra finalizada y guardada!');
                localStorage.removeItem('cart');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    });

    function syncCartWithView() {
        const cart = [];
        document.querySelectorAll('.compra-item').forEach(item => {
            cart.push({
                name: item.querySelector('.compra-nombre').textContent,
                price: item.querySelector('.compra-precio').getAttribute('data-precio'),
                quantity: parseInt(item.querySelector('.compra-cantidad').textContent, 10)
            });
        });
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    calcularTotal();
});
</script>