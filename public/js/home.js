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

  // navbar scroll
  const navbar = document.querySelector(".navbar");
    let lastScroll = 0;

    window.addEventListener("scroll", function () {
        let currentScroll = window.pageYOffset;

        // Kalau belum scroll jauh, jangan sembunyikan navbar
        if (currentScroll <= 10) {
            navbar.classList.remove("nav-hidden");
            return;
        }

        // Scroll ke bawah → sembunyikan navbar
        if (currentScroll > lastScroll) {
            navbar.classList.add("nav-hidden");
        }
        // Scroll ke atas → tampilkan navbar
        else {
            navbar.classList.remove("nav-hidden");
        }

        lastScroll = currentScroll;
    });
});
