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

    // ── Mobile detection ──
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // ── Mobile static layout ──
    // On mobile we render a simple vertical list: no transforms, no duplicates.
    function applyMobileLayout() {
        // 1. Kill any inline transform/transition the carousel might have set
        track.style.transition = 'none';
        track.style.transform = 'none';

        // 2. Hide all duplicate cards (controller triples the real 3 → 9 total)
        //    Only keep the first 3 (the original categories)
        Array.from(track.children).forEach((card, i) => {
            if (i >= 3) {
                card.style.display = 'none';
            } else {
                card.style.display = '';
                // Remove the desktop "highlighted" class so all cards look the same
                card.classList.remove('tarjetaDestacada');
                // Force content fully visible (override desktop translate + opacity)
                const content = card.querySelector('.contenidoTarjetaCategoria');
                if (content) content.style.transform = 'translateY(0)';
                const desc = card.querySelector('.contenidoTarjetaCategoria p');
                if (desc) { desc.style.opacity = '1'; desc.style.transform = 'translateY(0)'; }
            }
        });

        // 3. Hide nav buttons
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    }

    // ── Desktop helpers ──

    function getVisibleCount() {
        return window.innerWidth <= 768 ? 1 : 3;
    }

    function getCardMetrics() {
        const card = track.children[0];
        if (!card) return { width: 0, gap: 0, step: 0 };
        const width = card.offsetWidth;
        const gap = parseFloat(getComputedStyle(track).gap) || 0;
        return { width, gap, step: width + gap };
    }

    function highlightCenter() {
        if (isMobile()) return; // handled by applyMobileLayout
        const visible = getVisibleCount();
        const centerIdx = visible === 1 ? 0 : 1;
        Array.from(track.children).forEach((card, i) => {
            card.classList.toggle('tarjetaDestacada', i === centerIdx);
        });
    }

    function applyDesktopLayout() {
        // Restore all cards and reset their inline styles set by mobile mode
        Array.from(track.children).forEach((card) => {
            card.style.display = '';
            const content = card.querySelector('.contenidoTarjetaCategoria');
            if (content) content.style.transform = '';
            const desc = card.querySelector('.contenidoTarjetaCategoria p');
            if (desc) { desc.style.opacity = ''; desc.style.transform = ''; }
        });
        updateDesktopVisibility();
    }

    function updateDesktopVisibility() {
        const totalCards = track.children.length;
        const visible = getVisibleCount();
        const showNav = totalCards > visible;
        prevBtn.style.display = showNav ? 'flex' : 'none';
        nextBtn.style.display = showNav ? 'flex' : 'none';
        highlightCenter();
    }

    // ── Navigation (desktop only) ──

    function goNext() {
        if (isMobile()) return;
        if (isAnimating) return;
        isAnimating = true;

        const { step } = getCardMetrics();
        const firstCard = track.children[0];

        track.style.transition = `transform ${TRANSITION_MS}ms ${EASING}`;
        track.style.transform = `translateX(-${step}px)`;

        const visible = getVisibleCount();
        if (visible === 3 && track.children.length >= 3) {
            track.children[1].classList.remove('tarjetaDestacada');
            track.children[2].classList.add('tarjetaDestacada');
        }

        setTimeout(() => {
            track.style.transition = 'none';
            track.appendChild(firstCard);
            track.style.transform = 'translateX(0)';
            highlightCenter();
            void track.offsetHeight;
            isAnimating = false;
        }, TRANSITION_MS);
    }

    function goPrev() {
        if (isMobile()) return;
        if (isAnimating) return;
        isAnimating = true;

        const { step } = getCardMetrics();
        const lastCard = track.children[track.children.length - 1];

        track.style.transition = 'none';
        track.insertBefore(lastCard, track.children[0]);
        track.style.transform = `translateX(-${step}px)`;

        void track.offsetHeight;

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

    document.addEventListener('keydown', (e) => {
        if (isMobile()) return;
        const carousel = document.getElementById('carruselCategorias');
        if (!carousel) return;
        const rect = carousel.getBoundingClientRect();
        const inView = rect.top < window.innerHeight && rect.bottom > 0;
        if (!inView) return;
        if (e.key === 'ArrowRight') goNext();
        if (e.key === 'ArrowLeft') goPrev();
    });

    // Touch swipe — only for desktop carousel
    const carouselEl = document.getElementById('carruselCategorias');
    let touchStartX = 0;
    if (carouselEl) {
        carouselEl.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        carouselEl.addEventListener('touchend', (e) => {
            if (isMobile()) return;
            const diff = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? goNext() : goPrev();
            }
        }, { passive: true });
    }

    // ── Responsive switch ──

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (isMobile()) {
                applyMobileLayout();
            } else {
                track.style.transition = 'none';
                track.style.transform = 'translateX(0)';
                applyDesktopLayout();
            }
        }, 150);
    });

    // ── Init ──
    if (isMobile()) {
        applyMobileLayout();
    } else {
        updateDesktopVisibility();
        setTimeout(updateDesktopVisibility, 300);
    }
});
