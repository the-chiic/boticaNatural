document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) return;

    document.querySelectorAll('[data-cart-qty-controls]').forEach(controls => {
        const qtyInput = controls.querySelector('[data-cart-qty]');
        const decreaseBtn = controls.querySelector('[data-qty-action="decrease"]');
        const increaseBtn = controls.querySelector('[data-qty-action="increase"]');
        const updateUrl = controls.dataset.updateUrl;
        const cartItem = controls.closest('[data-cart-item]');

        if (!qtyInput || !updateUrl || !cartItem) return;

        let pending = false;

        const setLoading = (loading) => {
            pending = loading;
            controls.classList.toggle('is-updating', loading);
            if (decreaseBtn) decreaseBtn.disabled = loading;
            if (increaseBtn) increaseBtn.disabled = loading;
        };

        const updateCartQty = async (newQty) => {
            if (pending) return;

            setLoading(true);

            try {
                const response = await fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ qty: newQty }),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'No se pudo actualizar la cantidad.');
                }

                if (data.removed) {
                    cartItem.remove();
                } else {
                    qtyInput.value = data.qty;
                    const lineTotal = cartItem.querySelector('[data-cart-line-total]');
                    if (lineTotal) {
                        lineTotal.textContent = `${data.formatted.line_total}€`;
                    }
                }

                updateSummary(data);

                if (data.is_empty) {
                    window.location.reload();
                }
            } catch (error) {
                console.error(error);
            } finally {
                setLoading(false);
            }
        };

        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', () => {
                const currentQty = parseInt(qtyInput.value, 10) || 1;
                updateCartQty(currentQty - 1);
            });
        }

        if (increaseBtn) {
            increaseBtn.addEventListener('click', () => {
                const currentQty = parseInt(qtyInput.value, 10) || 0;
                updateCartQty(currentQty + 1);
            });
        }
    });

    function updateSummary(data) {
        const subtotalEl = document.querySelector('[data-cart-subtotal]');
        const discountEl = document.querySelector('[data-cart-discount]');
        const ivaEl = document.querySelector('[data-cart-iva]');
        const totalEl = document.querySelector('[data-cart-total]');

        if (subtotalEl) subtotalEl.textContent = `${data.formatted.subtotal}€`;
        if (discountEl) discountEl.textContent = `-${data.formatted.discount}€`;
        if (ivaEl) ivaEl.textContent = `${data.formatted.iva}€`;
        if (totalEl) totalEl.textContent = `${data.formatted.total}€`;

        updateNavbarBadge(data.cart_count);
    }

    function updateNavbarBadge(count) {
        const cartLink = document.querySelector('.nav-icono-carrito');
        if (!cartLink) return;

        let badge = cartLink.querySelector('.nav-badge-carrito');

        if (count <= 0) {
            badge?.remove();
            return;
        }

        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'nav-badge-carrito';
            cartLink.appendChild(badge);
        }

        badge.textContent = count > 9 ? '9+' : String(count);
    }
});
