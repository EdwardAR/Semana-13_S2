(function() {
    'use strict';

    // Se asegura de que el DOM esté completamente cargado antes de ejecutar el código
    document.addEventListener('DOMContentLoaded', function () {

        // Inicialización del Slider Principal (Hero Section)
        var heroSliderContainer = document.querySelector('.intro-slider');
        if (heroSliderContainer) {
            var heroSlider = tns({
                container: heroSliderContainer,
                items: 1, // Mostrar un ítem a la vez
                slideBy: 'page', // Deslizar por página
                autoplay: true, // Habilitar auto-reproducción
                autoplayButtonOutput: false, // Ocultar el botón de auto-reproducción
                autoplayTimeout: 8000, // Intervalo de 8 segundos
                speed: 800, // Velocidad de la transición en milisegundos (0.8 segundos)
                nav: true, // Mostrar navegación por puntos
                controls: false, // Ocultar flechas de navegación
                loop: true // Bucle infinito
                // Puedes añadir más opciones según necesites
            });
        }

         // Funcionalidad de Aumentar/Disminuir Cantidad (para carritos, etc.)
        var sitePlusMinus = function() {
            var quantity = document.getElementsByClassName('quantity-container');

            function createBindings(quantityContainer) {
                var quantityAmount = quantityContainer.getElementsByClassName('quantity-amount')[0];
                var increase = quantityContainer.getElementsByClassName('increase')[0];
                var decrease = quantityContainer.getElementsByClassName('decrease')[0];

                if (increase) { // Asegurarse de que el botón exista
                    increase.addEventListener('click', function (e) {
                        e.preventDefault(); // Prevenir el comportamiento por defecto del enlace
                        increaseValue(e, quantityAmount);
                    });
                }
                if (decrease) { // Asegurarse de que el botón exista
                    decrease.addEventListener('click', function (e) {
                        e.preventDefault(); // Prevenir el comportamiento por defecto del enlace
                        decreaseValue(e, quantityAmount);
                    });
                }
            }

            function init() {
                for (var i = 0; i < quantity.length; i++ ) {
                    createBindings(quantity[i]);
                }
            }

            function increaseValue(event, quantityAmount) {
                var value = parseInt(quantityAmount.value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                quantityAmount.value = value;
            }

            function decreaseValue(event, quantityAmount) {
                var value = parseInt(quantityAmount.value, 10);
                value = isNaN(value) ? 0 : value;
                if (value > 0) value--; // Asegurarse de que no baje de 0
                quantityAmount.value = value;
            }

            init(); // Inicializa los bindings al cargar el DOM
        };
        sitePlusMinus(); // Llama a la función para ejecutarla
    });

    // --- Lógica del Carrito de Compras (persistencia con Local Storage) ---
    // Este objeto window.cartManager se hará accesible globalmente.
    window.cartManager = {
        cart: [], // Array para almacenar los ítems del carrito
        localStorageKey: 'furni_cart', // Clave para Local Storage
        whatsappNumber: '51987654321', // ¡Cambia esto por el número de WhatsApp del vendedor!

        init: function() {
            this.loadCart();
            this.updateCartUI(); // Asegura que el contador del carrito se actualice al cargar la página
        },

        loadCart: function() {
            const storedCart = localStorage.getItem(this.localStorageKey);
            if (storedCart) {
                try {
                    this.cart = JSON.parse(storedCart);
                } catch (e) {
                    console.error("Error al parsear el carrito de Local Storage:", e);
                    this.cart = [];
                }
            }
        },

        saveCart: function() {
            localStorage.setItem(this.localStorageKey, JSON.stringify(this.cart));
            this.updateCartUI(); // Actualizar la UI cada vez que se guarda el carrito
        },

        // Función para actualizar la interfaz de usuario del carrito (ej. contador en el icono)
        updateCartUI: function() {
            const cartItemCount = this.cart.reduce((total, item) => total + item.quantity, 0);
            const cartIconSpan = document.querySelector('.custom-navbar-cta .nav-link[href="cart.php"] span.cart-count');
            if (cartIconSpan) {
                cartIconSpan.textContent = cartItemCount;
                if (cartItemCount > 0) {
                    cartIconSpan.style.display = 'inline-block'; // Mostrar el contador
                } else {
                    cartIconSpan.style.display = 'none'; // Ocultar si está vacío
                }
            } else {
                // Si no existe un span con la clase cart-count, lo creamos
                const cartLink = document.querySelector('.custom-navbar-cta .nav-link[href="cart.php"]');
                if (cartLink && cartItemCount > 0) {
                    const newSpan = document.createElement('span');
                    newSpan.className = 'cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                    newSpan.textContent = cartItemCount;
                    cartLink.style.position = 'relative'; // Necesario para el posicionamiento del badge
                    cartLink.appendChild(newSpan);
                }
            }
            // También puedes llamar a una función para renderizar los detalles completos del carrito si estás en la página del carrito
            if (typeof renderCartDetails === 'function') { // Asume que renderCartDetails existe en cart.php
                renderCartDetails();
            }
        },

        // Función para añadir/actualizar un producto en el carrito
        addToCart: function(product) {
            const existingItemIndex = this.cart.findIndex(item => item.id === product.id);

            if (existingItemIndex > -1) {
                // Si el producto ya está en el carrito, actualizar la cantidad
                this.cart[existingItemIndex].quantity += product.quantity;
            } else {
                // Si no, añadir el nuevo producto
                this.cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    quantity: product.quantity,
                    image: product.image || 'https://placehold.co/70x70/e9e9e9/000000?text=No+Img' // Añade una URL de imagen si está disponible
                });
            }
            this.saveCart();
            // Opcional: Notificar al usuario (puede ser un modal en el HTML de la página)
            // console.log(`"${product.name}" añadido al carrito. Cantidad: ${product.quantity}`);
        },

        // Función para actualizar la cantidad de un ítem específico en el carrito
        updateCartItemQuantity: function(productId, newQuantity) {
            const itemIndex = this.cart.findIndex(item => item.id === productId);
            if (itemIndex > -1) {
                if (newQuantity > 0) {
                    this.cart[itemIndex].quantity = newQuantity;
                } else {
                    // Si la cantidad es 0 o menos, eliminar el ítem
                    this.cart.splice(itemIndex, 1);
                }
                this.saveCart();
            }
        },

        // Función para eliminar un ítem del carrito
        removeCartItem: function(productId) {
            this.cart = this.cart.filter(item => item.id !== productId);
            this.saveCart();
        },

        // Función para obtener todos los ítems del carrito
        getCartItems: function() {
            return this.cart;
        },

        // Función para obtener el total del carrito
        getCartTotal: function() {
            return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        },

        // Función para vaciar completamente el carrito
        clearCart: function() {
            this.cart = [];
            this.saveCart();
        },

        // --- Funcionalidad de WhatsApp ---
        // Genera el mensaje de WhatsApp basado en el contenido actual del carrito
        generateWhatsAppMessage: function() {
            if (this.cart.length === 0) {
                return "Hola, me gustaría hacer un pedido pero mi carrito está vacío.";
            }

            let message = "Hola, me gustaría hacer un pedido con los siguientes productos:\n\n";
            let total = 0;

            this.cart.forEach((item, index) => {
                message += `${index + 1}. ${item.name} - Cantidad: ${item.quantity} - Precio unitario: $${item.price.toFixed(2)}\n`;
                total += item.price * item.quantity;
            });

            message += `\nTotal del pedido: $${total.toFixed(2)}\n\n`;
            message += "Por favor, confírmame la disponibilidad y cómo proceder con el pago y la entrega. ¡Gracias!";

            return encodeURIComponent(message);
        },

        // Abre WhatsApp con el mensaje pre-rellenado
        sendOrderViaWhatsApp: function() {
            const message = this.generateWhatsAppMessage();
            const whatsappLink = `https://wa.me/${this.whatsappNumber}?text=${message}`;
            window.open(whatsappLink, '_blank');
        }
    };

    // Inicializar el gestor de carrito
    window.cartManager.init();

    // Exportar addToCart globalmente para que los botones lo usen
    window.addToCart = window.cartManager.addToCart.bind(window.cartManager);
    window.sendOrderViaWhatsApp = window.cartManager.sendOrderViaWhatsApp.bind(window.cartManager);


})(); // Fin de la función anónima autoejecutable
