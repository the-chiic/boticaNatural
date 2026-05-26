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

// Gallery sliding carousel active index
let currentSlideIndex = 0;

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
    const slides = document.querySelectorAll('.main-image-slide');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

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
