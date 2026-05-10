// Botica Natural - Product Show JS
document.addEventListener('DOMContentLoaded', () => {
    const qtyInput = document.getElementById('qty');
    const plusBtn = document.getElementById('plus');
    const minusBtn = document.getElementById('minus');

    if (plusBtn && minusBtn && qtyInput) {
        plusBtn.addEventListener('click', () => {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        });

        minusBtn.addEventListener('click', () => {
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        });
    }
});
