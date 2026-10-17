let cart = [];

function addToCart(id, name, price, image) {
    const qtyInput = document.getElementById(`qty-${id}`);
    const qty = parseInt(qtyInput.value) || 1;

    const existingIndex = cart.findIndex(item => item.id === id);
    if (existingIndex > -1) {
    cart[existingIndex].qty += qty;
    } else {
    cart.push({ id, name, price, image, qty });
    }

    alert(`Berhasil menambahkan ${qty}x ${name} ke keranjang!`);
    updateCartUI();
}

function updateCartQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (item) {
    item.qty += delta;
    if (item.qty <= 0) {
    cart = cart.filter(i => i.id !== id);
    }
    }
    updateCartUI();
}

function removeFromCart(id) {
    cart = cart.filter(i => i.id !== id);
    updateCartUI();
}

function updateCartUI() {
    const cartCount = document.getElementById('cartCount');
    const container = document.getElementById('cartItemsContainer');
    const totalText = document.getElementById('cartTotalText');

    let totalQty = 0;
    let totalPrice = 0;
    if (!container) return;
    container.innerHTML = '';

    if (cart.length === 0) {
    container.innerHTML = '<p style="text-align:center; color:#666; padding:1rem;">Keranjang Anda masih kosong.</p>';
    } else {
    cart.forEach(item => {
    totalQty += item.qty;
      const subtotal = item.price * item.qty;
    totalPrice += subtotal;

    container.innerHTML += `
        <div class="cart-item">
        <img src="${item.image}" alt="${item.name}">
        <div class="cart-item-info">
            <h4>${item.name}</h4>
            <p>Rp ${item.price.toLocaleString('id-ID')} x ${item.qty}</p>
            <strong>Subtotal: Rp ${subtotal.toLocaleString('id-ID')}</strong>
        </div>
        <div class="cart-item-actions">
            <button onclick="updateCartQty(${item.id}, -1)">-</button>
            <span>${item.qty}</span>
            <button onclick="updateCartQty(${item.id}, 1)">+</button>
            <button onclick="removeFromCart(${item.id})" style="color:red;">&times;</button>
        </div>
        </div>
    `;
    });
    }

    if (cartCount) cartCount.textContent = totalQty;
    if (totalText) totalText.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
}

async function processCheckout(e) {
    e.preventDefault();

    if (cart.length === 0) {
    alert("Keranjang Anda masih kosong!");
    return;
    }

    const payload = {
    name: document.getElementById('custName').value,
    phone: document.getElementById('custPhone').value,
    address: document.getElementById('custAddress').value,
    payment: document.getElementById('custPayment').value,
    items: cart
    };

    try {
    const res = await fetch('api/checkout.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
    });
    const data = await res.json();

    if (data.success) {
    alert(`Pesanan Berhasil! Nomor Pesanan Anda: #${data.order_id}`);
    cart = [];
    updateCartUI();
    document.getElementById('checkoutForm').reset();
    document.getElementById('cartModal').classList.remove('active');
    } else {
    alert('Gagal: ' + data.message);
    }
    } catch (err) {
    alert('Terjadi kesalahan saat memproses pesanan.');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const openCartBtn = document.getElementById('openCartBtn');
    const closeCartBtn = document.getElementById('closeCartBtn');
    const cartModal = document.getElementById('cartModal');

    if (openCartBtn && cartModal) {
    openCartBtn.addEventListener('click', () => cartModal.classList.add('active'));
    } 
    if (closeCartBtn && cartModal) {
    closeCartBtn.addEventListener('click', () => cartModal.classList.remove('active'));
    }
});