// Botica Natural - Product Show JS
document.addEventListener('DOMContentLoaded', () => {
    const qtyInput = document.getElementById('qty');
    const plusBtn = document.getElementById('plus');
    const minusBtn = document.getElementById('minus');

    if (plusBtn && minusBtn && qtyInput) {
        plusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (isNaN(val) || val < 1) {
                qtyInput.value = 1;
            } else {
                qtyInput.value = val + 1;
            }
        });

        minusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (isNaN(val) || val <= 1) {
                qtyInput.value = 1;
            } else {
                qtyInput.value = val - 1;
            }
        });

        qtyInput.addEventListener('change', () => {
            let val = parseInt(qtyInput.value);
            if (isNaN(val) || val < 1) {
                qtyInput.value = 1;
            } else {
                qtyInput.value = val;
            }
        });

        qtyInput.addEventListener('input', () => {
            let val = parseInt(qtyInput.value);
            if (!isNaN(val) && val < 1) {
                qtyInput.value = 1;
            }
        });
    }
});
