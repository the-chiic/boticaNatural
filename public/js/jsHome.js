// Botica Natural - Home JS
document.addEventListener('DOMContentLoaded', () => {
    console.log('Botica Natural Home Loaded');

    // ─── Infinite Circular Category Carousel ───
    const track = document.getElementById('carruselTrack');
    const prevBtn = document.getElementById('prevCatBtn');
    const nextBtn = document.getElementById('nextCatBtn');

    if (!track || !prevBtn || !nextBtn) return;

    const TRANSITION_MS = 550;
    const EASING = 'cubic-bezier(0.25, 1, 0.5, 1)';
    let isAnimating = false;

    // ── Helpers ──

    function getVisibleCount() {
        return window.innerWidth <= 768 ? 1 : 3;
    }

    function getCardMetrics() {
        const card = track.children[0];
        if (!card) return { width: 0, gap: 0, step: 0 };
        // Use offsetWidth (layout width) — NOT getBoundingClientRect().width,
        // which returns the visually-scaled size and causes a ~20px jitter
        // because CSS scale(0.93) shrinks the rendered width but translateX
        // works in layout space.
        const width = card.offsetWidth;
        const gap = parseFloat(getComputedStyle(track).gap) || 0;
        return { width, gap, step: width + gap };
    }

    function highlightCenter() {
        const visible = getVisibleCount();
        const centerIdx = visible === 1 ? 0 : 1;
        Array.from(track.children).forEach((card, i) => {
            card.classList.toggle('tarjetaDestacada', i === centerIdx);
        });
    }

    function updateVisibility() {
        const totalCards = track.children.length;
        const visible = getVisibleCount();
        const showNav = totalCards > visible;
        prevBtn.style.display = showNav ? 'flex' : 'none';
        nextBtn.style.display = showNav ? 'flex' : 'none';
        highlightCenter();
    }

    // ── Navigation ──

    function goNext() {
        if (isAnimating) return;
        isAnimating = true;

        const { step } = getCardMetrics();
        const firstCard = track.children[0];

        // Animate: slide everything left by one card width
        track.style.transition = `transform ${TRANSITION_MS}ms ${EASING}`;
        track.style.transform = `translateX(-${step}px)`;

        // Pre-highlight: during animation, show the next center
        const visible = getVisibleCount();
        if (visible === 3 && track.children.length >= 3) {
            track.children[1].classList.remove('tarjetaDestacada');
            track.children[2].classList.add('tarjetaDestacada');
        } else if (visible === 1 && track.children.length >= 2) {
            track.children[0].classList.remove('tarjetaDestacada');
            track.children[1].classList.add('tarjetaDestacada');
        }

        // After animation finishes: move the first card to the end & reset transform
        setTimeout(() => {
            track.style.transition = 'none';
            track.appendChild(firstCard);
            track.style.transform = 'translateX(0)';
            highlightCenter();
            // Force reflow before re-enabling transitions
            void track.offsetHeight;
            isAnimating = false;
        }, TRANSITION_MS);
    }

    function goPrev() {
        if (isAnimating) return;
        isAnimating = true;

        const { step } = getCardMetrics();
        const lastCard = track.children[track.children.length - 1];

        // 1. Instantly prepend the last card and offset track so nothing visually changes
        track.style.transition = 'none';
        track.insertBefore(lastCard, track.children[0]);
        track.style.transform = `translateX(-${step}px)`;

        // 2. Force reflow so the instant position is painted
        void track.offsetHeight;

        // 3. Animate back to 0 (slides right)
        track.style.transition = `transform ${TRANSITION_MS}ms ${EASING}`;
        track.style.transform = 'translateX(0)';

        highlightCenter();

        setTimeout(() => {
            isAnimating = false;
        }, TRANSITION_MS);
    }

    // ── Event Listeners ──

    nextBtn.addEventListener('click', goNext);
    prevBtn.addEventListener('click', goPrev);

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        const carousel = document.getElementById('carruselCategorias');
        if (!carousel) return;
        // Only respond if carousel is in viewport
        const rect = carousel.getBoundingClientRect();
        const inView = rect.top < window.innerHeight && rect.bottom > 0;
        if (!inView) return;

        if (e.key === 'ArrowRight') goNext();
        if (e.key === 'ArrowLeft') goPrev();
    });

    // Touch / swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    const carouselEl = document.getElementById('carruselCategorias');

    if (carouselEl) {
        carouselEl.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        carouselEl.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? goNext() : goPrev();
            }
        }, { passive: true });
    }

    // ── Resize handling ──

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            track.style.transition = 'none';
            track.style.transform = 'translateX(0)';
            updateVisibility();
        }, 150);
    });

    // ── Init ──

    updateVisibility();
    // Re-run after fonts/images settle
    setTimeout(updateVisibility, 300);
});
