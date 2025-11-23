<script>
document.addEventListener("DOMContentLoaded", () => {

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
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
            }
        });
    }, { threshold: 0.2 });

    promos.forEach(promo => promoObserver.observe(promo));


    /* ==========================
       BEST SELLER SLIDER — FINAL FIX
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

            dot.addEventListener("click", () => goTo(i));

            dotsContainer.appendChild(dot);
        }

        updateDotsWindow();
    }

    
    /* ======================================
    MOBILE AUTO DOT SYNC (FOLLOW SWIPE)
    ====================================== */
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

                const dots = dotsContainer.querySelectorAll("button");
                dots.forEach(d => d.classList.remove("active"));
                dots[currentIndex].classList.add("active");

                updateDotsWindow();
            }
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
            cards[currentIndex].scrollIntoView({
                behavior: "smooth",
                inline: "center"
            });
        } else {
            const slideWidth = pages[0].clientWidth;
            const offset = -(slideWidth * currentIndex);
            track.style.transform = `translateX(${offset}px)`;
        }
    }


    /* ==========================
       Autoplay (Desktop Only)
    ========================== */
    function startAutoplay() {
        if (isMobile) return; // mobile tidak autoplay

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
       Dots Window (Show 5)
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
            generateDots();
            goTo(0);

            stopAutoplay();
            startAutoplay();
        }
    });


    /* ==========================
       INIT
    ========================== */
    generateDots();
    goTo(0);
    startAutoplay();


    /* ==========================
       NAVBAR SHOW/HIDE ON SCROLL  
    ========================== */
    const navbar = document.querySelector(".navbar");
    const toggler = document.querySelector(".navbar-toggler");

    let lastScroll = window.pageYOffset;
    let menuOpen = false;

    // Reset awal — Biar semua halaman mulai dalam keadaan "visible"
    navbar.classList.remove("nav-hidden");
    navbar.classList.add("nav-visible");

    /* MOBILE MENU HANDLER */
    if (toggler) {
        toggler.addEventListener("click", () => {
            menuOpen = !menuOpen;

            if (menuOpen) {
                navbar.classList.add("nav-visible");
                navbar.classList.add("nav-locked");
            } else {
                navbar.classList.remove("nav-locked");
            }
        });
    }

    /* SCROLL HANDLER */
    window.addEventListener("scroll", () => {

        if (menuOpen) return; // Jangan hide ketika menu terbuka

        const currentScroll = window.pageYOffset;

        if (currentScroll <= 5) {
            navbar.classList.add("nav-visible");
            navbar.classList.remove("nav-hidden");
            return;
        }

        if (currentScroll > lastScroll) {
            navbar.classList.remove("nav-visible");
            navbar.classList.add("nav-hidden"); // Scroll down → hide
        } else {
            navbar.classList.remove("nav-hidden");
            navbar.classList.add("nav-visible"); // Scroll up → show
        }

        lastScroll = currentScroll;
    });


});
</script>
