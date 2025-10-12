import { db } from '/data/db.js';

function updateCartMenu() {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const cartList = document.getElementById('cart-items');
    cartList.innerHTML = '';
    cartItems.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.name} x${item.quantity}`;
        cartList.appendChild(li);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartMenu();

    // Evento para añadir productos al carrito
    document.querySelectorAll('.add-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const name = this.closest('.info').querySelector('h2').textContent;
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const index = cart.findIndex(item => item.name === name);
            if (index > -1) {
                cart[index].quantity += 1;
            } else {
                cart.push({ name, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartMenu();
        });
    });

    // Evento para realizar compra
    document.getElementById('checkout-btn').addEventListener('click', function() {
        alert('¡Compra realizada!');
        localStorage.removeItem('cart');
        updateCartMenu();
    });
});

