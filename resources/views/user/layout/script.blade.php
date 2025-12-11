<script>

    // UPDATE QTY FUNCTION
    function updateQty(button, change) {
        const form = button.closest('.cart-update-form');
        const qtyDisplay = form.querySelector('.qty-display');
        const qtyHidden = form.querySelector('.qty-hidden');
        const btnMinus = form.querySelector('.btn-minus');

        let qty = parseInt(qtyDisplay.value) + change;

        if (qty < 1) qty = 1;

        qtyDisplay.value = qty;
        qtyHidden.value = qty;

        if (qty <= 1) {
            btnMinus.disabled = true;
        } else {
            btnMinus.disabled = false;
        }

        // AUTO SUBMIT
        form.submit();
    }

    // Event listeners untuk plus & minus
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', () => updateQty(btn, +1));
    });
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', () => updateQty(btn, -1));
    });

document.addEventListener("DOMContentLoaded", () => {

    /* ==========================
       FORCE START AT TOP (Mobile Safe)
    ========================== */
    window.scrollTo(0, 0);
    setTimeout(() => window.scrollTo(0, 0), 40);

    // Flag untuk mencegah scrollIntoView pertama kali
    window.initialLoad = true;


    /* ==========================
       Fade Animation
    ========================== */
    const fadeElems = document.querySelectorAll('.fade-up');

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    fadeElems.forEach(el => observer.observe(el));


    /* ==========================
       Fade Left & Right
    ========================== */
    const promos = document.querySelectorAll(".slide-left, .slide-right");

    const promoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add("active");
        });
    }, { threshold: 0.2 });

    promos.forEach(promo => promoObserver.observe(promo));


    /* ==========================
       BEST SELLER SLIDER — FIXED
    ========================== */

    const track = document.querySelector(".best-seller-track");
    const pages = document.querySelectorAll(".slide-page");
    const dotsContainer = document.querySelector(".best-seller-dots");
    const cards = document.querySelectorAll(".product-card");

    if (!track || pages.length === 0) return;

    let isMobile = window.innerWidth <= 576;
    let currentIndex = 0;
    let autoplayTimer = null;


    /* ==========================
       Generate Dots
    ========================== */
    function generateDots() {
        dotsContainer.innerHTML = "";

        const total = isMobile ? cards.length : pages.length;

        for (let i = 0; i < total; i++) {
            const dot = document.createElement("button");
            if (i === currentIndex) dot.classList.add("active");

            dot.addEventListener("click", () => {
                window.initialLoad = false; // dot = user interaction
                goTo(i);
            });

            dotsContainer.appendChild(dot);
        }

        updateDotsWindow();
    }

    /* ==========================
       Mobile swipe auto sync
    ========================== */
    if (isMobile) {
        track.addEventListener("scroll", () => {
            let nearest = 0;
            let minDist = Infinity;

            cards.forEach((card, index) => {
                const rect = card.getBoundingClientRect();
                const mid = window.innerWidth / 2;
                const dist = Math.abs(rect.left + rect.width / 2 - mid);

                if (dist < minDist) {
                    minDist = dist;
                    nearest = index;
                }
            });

            if (nearest !== currentIndex) {
                currentIndex = nearest;

                cards.forEach(card => card.classList.remove("active"));
                cards[currentIndex].classList.add("active");

                const dots = dotsContainer.querySelectorAll("button");
                dots.forEach(d => d.classList.remove("active"));
                dots[currentIndex].classList.add("active");

                updateDotsWindow();
            }

            window.initialLoad = false; // swipe = user interaction
        });
    }


    /* ==========================
       Go To Slide / Card
    ========================== */
    function goTo(i) {
        currentIndex = i;

        const dots = dotsContainer.querySelectorAll("button");
        dots.forEach(d => d.classList.remove("active"));
        dots[currentIndex].classList.add("active");

        updateDotsWindow();

        if (isMobile) {

            // MENCEGAH SCROLL PERTAMA KALI !!!
            if (!window.initialLoad) {
                cards[currentIndex].scrollIntoView({
                    behavior: "smooth",
                    inline: "center"
                });
            }

        } else {
            const slideWidth = pages[0].clientWidth;
            const offset = -(slideWidth * currentIndex);
            track.style.transform = `translateX(${offset}px)`;
        }
    }


    /* ==========================
       Autoplay Desktop Only
    ========================== */
    function startAutoplay() {
        if (isMobile) return;

        stopAutoplay();

        autoplayTimer = setInterval(() => {
            currentIndex = (currentIndex + 1) % pages.length;
            goTo(currentIndex);
        }, 3500);
    }

    function stopAutoplay() {
        if (autoplayTimer) clearInterval(autoplayTimer);
    }


    /* ==========================
       Dots Window Show 5
    ========================== */
    function updateDotsWindow() {
        const dots = dotsContainer.querySelectorAll("button");
        const total = dots.length;

        if (total <= 5) return;

        dots.forEach(d => d.style.display = "none");

        let start = Math.max(0, currentIndex - 2);
        let end = Math.min(total - 1, currentIndex + 2);

        for (let i = start; i <= end; i++) {
            dots[i].style.display = "inline-block";
        }
    }


    /* ==========================
       Resize Handler
    ========================== */
    window.addEventListener("resize", () => {
        const nowMobile = window.innerWidth <= 576;

        if (nowMobile !== isMobile) {
            isMobile = nowMobile;
            currentIndex = 0;
            window.initialLoad = true;

            generateDots();
            goTo(0);

            stopAutoplay();
            startAutoplay();
        }
    });


    /* ==========================
       INIT (REVISED)
    ========================== */
    generateDots();
    goTo(0); // desktop OK, mobile protected by initialLoad
    startAutoplay();

    // Setelah semua selesai, baru izinkan scrollIntoView
    setTimeout(() => window.initialLoad = false, 200);



    /* ==========================
       NAVBAR SCROLL BEHAVIOR
    ========================== */
    const navbar = document.querySelector(".navbar");
    const toggler = document.querySelector(".navbar-toggler");

    let lastScroll = window.pageYOffset;
    let menuOpen = false;

    navbar.classList.remove("nav-hidden");
    navbar.classList.add("nav-visible");

    if (toggler) {
        toggler.addEventListener("click", () => {
            menuOpen = !menuOpen;

            if (menuOpen) {
                navbar.classList.add("nav-visible", "nav-locked");
            } else {
                navbar.classList.remove("nav-locked");
            }
        });
    }

    window.addEventListener("scroll", () => {
        if (menuOpen) return;

        const currentScroll = window.pageYOffset;

        if (currentScroll <= 5) {
            navbar.classList.add("nav-visible");
            navbar.classList.remove("nav-hidden");
            return;
        }

        if (currentScroll > lastScroll) {
            navbar.classList.remove("nav-visible");
            navbar.classList.add("nav-hidden");
        } else {
            navbar.classList.remove("nav-hidden");
            navbar.classList.add("nav-visible");
        }

        lastScroll = currentScroll; 
    });

});
</script>
