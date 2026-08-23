document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.hero-carousel');
    if (!carousel) return;

    const slides = carousel.querySelectorAll('.hero-slide');
    const dots = carousel.querySelectorAll('.hero-dot');
    const prevBtn = carousel.querySelector('.hero-prev');
    const nextBtn = carousel.querySelector('.hero-next');

    const AUTOPLAY_DELAY = 15000;
    let current = 0;
    let autoplay;

    function goTo(index) {
        slides[current].classList.remove('is-active');
        dots[current].classList.remove('is-active');

        current = (index + slides.length) % slides.length;

        slides[current].classList.add('is-active');
        dots[current].classList.add('is-active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAutoplay() {
        autoplay = setInterval(next, AUTOPLAY_DELAY);
    }
    function stopAutoplay() {
        clearInterval(autoplay);
    }

    nextBtn?.addEventListener('click', () => { next(); stopAutoplay(); startAutoplay(); });
    prevBtn?.addEventListener('click', () => { prev(); stopAutoplay(); startAutoplay(); });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            goTo(parseInt(dot.dataset.goto, 10));
            stopAutoplay();
            startAutoplay();
        });
    });

    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);

    startAutoplay();
});