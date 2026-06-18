<?php include_once 'header.php'; ?>

<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Carrito de Compras</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" style="background: #fff; border-radius: 10px; overflow: hidden;">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 80px;">Imagen</th>
                                <th>Producto</th>
                                <th style="width: 100px;">Precio</th>
                                <th style="width: 130px;">Cantidad</th>
                                <th style="width: 100px;">Total</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-container">
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="shop.php" class="btn btn-outline-dark"><i class="fas fa-arrow-left me-2"></i>Continuar Comprando</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 border-bottom pb-3">Resumen del Pedido</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <strong id="cart-subtotal">$0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Envío</span>
                            <strong class="text-success">Gratis</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-4 pt-3 border-top">
                            <span class="h5">Total</span>
                            <strong class="h5" id="cart-total">$0.00</strong>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-lg" onclick="window.location='checkout.php'">
                                <i class="fas fa-credit-card me-2"></i>Ir a Pagar
                            </button>
                            <button class="btn btn-outline-success" onclick="window.cartManager.sendOrderViaWhatsApp()">
                                <i class="fab fa-whatsapp me-2"></i>Pedir por WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function renderCartDetails() {
    const container = document.getElementById('cart-items-container');
    if (!container) return;

    const items = window.cartManager.getCartItems();

    if (items.length === 0) {
        container.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p class="mb-2">Tu carrito está vacío</p>
                    <a href="shop.php" class="btn btn-primary">Ir a la tienda</a>
                </td>
            </tr>`;
        document.getElementById('cart-subtotal').textContent = '$0.00';
        document.getElementById('cart-total').textContent = '$0.00';
        return;
    }

    let html = '';
    items.forEach(item => {
        const total = item.price * item.quantity;
        html += `
            <tr>
                <td class="text-center">
                    <img src="${item.image || 'https://placehold.co/70x70/e9e9e9/000000?text=No+Img'}" alt="${item.name}" class="img-fluid rounded" style="max-width: 60px; max-height: 60px; object-fit: cover;">
                </td>
                <td class="fw-semibold">${item.name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>
                    <div class="input-group input-group-sm" style="max-width: 110px;">
                        <button class="btn btn-outline-secondary qty-minus" data-product-id="${item.id}">-</button>
                        <input type="number" class="form-control text-center quantity-amount" value="${item.quantity}" min="1" data-product-id="${item.id}" style="border-radius: 0;">
                        <button class="btn btn-outline-secondary qty-plus" data-product-id="${item.id}">+</button>
                    </div>
                </td>
                <td class="fw-bold">$${total.toFixed(2)}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-danger remove-item" data-product-id="${item.id}" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
    });
    container.innerHTML = html;

    const total = window.cartManager.getCartTotal();
    document.getElementById('cart-subtotal').textContent = `$${total.toFixed(2)}`;
    document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;

    container.querySelectorAll('.quantity-amount').forEach(input => {
        input.addEventListener('change', function() {
            const val = parseInt(this.value) || 0;
            if (val < 1) this.value = 1;
            window.cartManager.updateCartItemQuantity(this.dataset.productId, parseInt(this.value));
            renderCartDetails();
        });
    });

    container.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('tr').querySelector('.quantity-amount');
            input.value = parseInt(input.value) + 1;
            window.cartManager.updateCartItemQuantity(this.dataset.productId, parseInt(input.value));
            renderCartDetails();
        });
    });

    container.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('tr').querySelector('.quantity-amount');
            const val = parseInt(input.value) - 1;
            if (val >= 1) {
                input.value = val;
                window.cartManager.updateCartItemQuantity(this.dataset.productId, val);
                renderCartDetails();
            }
        });
    });

    container.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.cartManager.removeCartItem(this.dataset.productId);
            renderCartDetails();
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.cartManager) {
        renderCartDetails();
    }
});
</script>

<?php include 'footer.php'; ?>
