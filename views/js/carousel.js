/**
 * JavaScript para carrossel de imagens
 */

(function() {
    const carousel = document.getElementById('carousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (!carousel || !prevBtn || !nextBtn) return;

    let index = 0;
    const totalSlides = 4; // Ajustar conforme necessário

    function updateCarousel() {
        const width = carousel.clientWidth;
        carousel.style.transform = `translateX(-${index * width}px)`;
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            index = (index + 1) % totalSlides;
            updateCarousel();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            index = (index - 1 + totalSlides) % totalSlides;
            updateCarousel();
        });
    }

    window.addEventListener('resize', updateCarousel);
})();
