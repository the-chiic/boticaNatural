// Botica Natural - Product Show JS
function initQuantitySelector() {
    const qtyInput = document.getElementById('qty');
    const plusBtn = document.getElementById('plus');
    const minusBtn = document.getElementById('minus');

    if (plusBtn && minusBtn && qtyInput) {
        const maxStock = parseInt(qtyInput.getAttribute('data-max-stock')) || 9999;

        plusBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            let val = parseInt(qtyInput.value) || 0;
            qtyInput.value = val + 1;
        };

        minusBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            let val = parseInt(qtyInput.value) || 0;
            if (val > 1) {
                qtyInput.value = val - 1;
            }
        };

        qtyInput.addEventListener('change', function() {
            let val = parseInt(this.value) || 0;
            if (val < 1) {
                this.value = 1;
            }
        });
    }
}

function validateCartForm(event) {
    const qtyInput = document.getElementById('qty');
    if (!qtyInput) return true;

    const maxStock = parseInt(qtyInput.getAttribute('data-max-stock')) || 9999;
    const qty = parseInt(qtyInput.value) || 0;

    if (qty > maxStock) {
        event.preventDefault();
        alert('La cantidad seleccionada es superior al stock restante. Solo quedan ' + maxStock + ' unidades disponibles.');
        qtyInput.value = maxStock;
        qtyInput.focus();
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', initQuantitySelector);

// Also try to initialize after a short delay in case DOM is not fully ready
setTimeout(initQuantitySelector, 500);

function slideGallery(direction) {
    const slides = document.querySelectorAll('.main-image-slide');
    if (slides.length <= 1) return;

    currentSlideIndex += direction;
    if (currentSlideIndex >= slides.length) {
        currentSlideIndex = 0;
    } else if (currentSlideIndex < 0) {
        currentSlideIndex = slides.length - 1;
    }

    updateActiveSlide();
}

function jumpToGalleryImage(index, thumbnailEl) {
    currentSlideIndex = index;
    updateActiveSlide();
}

function updateActiveSlide() {
    const slider = document.getElementById('imageSlider');
    const slides = document.querySelectorAll('.main-image-slide');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

    if (slider && slides.length > 0) {
        slider.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
    }

    slides.forEach((slide, idx) => {
        slide.classList.toggle('active', idx === currentSlideIndex);
    });

    thumbnails.forEach((thumb, idx) => {
        thumb.classList.toggle('active', idx === currentSlideIndex);
    });
}

// Function to toggle accordion items smoothly
function toggleAccordion(headerEl) {
    const item = headerEl.parentElement;
    const content = headerEl.nextElementSibling;
    const arrow = headerEl.querySelector('.accordion-arrow');

    // Toggle active class on item
    const isActive = item.classList.contains('active');

    // Close all other accordion items
    document.querySelectorAll('.accordion-item').forEach(el => {
        el.classList.remove('active');
        const c = el.querySelector('.accordion-content');
        if (c) c.style.maxHeight = null;
        const a = el.querySelector('.accordion-arrow');
        if (a) a.style.transform = 'rotate(0deg)';
    });

    if (!isActive) {
        item.classList.add('active');
        content.style.maxHeight = content.scrollHeight + "px";
        if (arrow) arrow.style.transform = 'rotate(180deg)';
    }
}
