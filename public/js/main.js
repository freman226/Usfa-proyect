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
    //updateCartMenu();

    const cartBtn = document.getElementById('cart-btn');
    if (cartBtn) {
        cartBtn.addEventListener('click', function(e) {
            e.preventDefault(); 
            window.location.href = 'index.php?page=compra';
        });
    }
    const home = document.getElementById('title');
    if (home) {
        home.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'index.php?page=productos';
        });
    }
});

