document.addEventListener('DOMContentLoaded', function () {
    const counters = document.querySelectorAll('[data-balance-counter]');

    counters.forEach((el) => {
        const target = parseFloat(el.dataset.target);
        const duration = 1200;
        const start = performance.now();

        function formatBRL(value) {
            return value.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            });
        }

        function easeOutQuad(t) {
            return t * (2 - t);
        }

        function step(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = easeOutQuad(progress);
            const current = target * eased;

            el.textContent = formatBRL(current);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }

        requestAnimationFrame(step);
    });
});