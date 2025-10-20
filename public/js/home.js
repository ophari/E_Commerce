document.addEventListener('DOMContentLoaded', function () {
  const carousel = document.getElementById('productsCarousel');
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');

  if (carousel && nextBtn && prevBtn) {
    nextBtn.addEventListener('click', () => {
      carousel.scrollBy({ left: 300, behavior: 'smooth' });
    });

    prevBtn.addEventListener('click', () => {
      carousel.scrollBy({ left: -300, behavior: 'smooth' });
    });
  }
});
