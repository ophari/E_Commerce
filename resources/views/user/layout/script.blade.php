<script>
document.addEventListener("DOMContentLoaded", () => {

    /* ==========================================
       Fade-Up Animation
    ========================================== */
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



    /* ============================
       FADE LEFT & RIGHT
    ============================ */
    const fadeLR = document.querySelectorAll(".fade-left, .fade-right");

    const fadeObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                fadeObserver.unobserve(entry.target);
            }
        });
    });

    fadeLR.forEach(el => fadeObserver.observe(el));



    /* ============================
       BEST SELLER SLIDER — FIXED
    ============================ */

    const track = document.querySelector(".best-seller-track");
    const pages = document.querySelectorAll(".slide-page");
    const dotsContainer = document.querySelector(".best-seller-dots");

    if (!track || pages.length === 0) return;

    let isMobile = window.innerWidth <= 576;
    let currentIndex = 0;
    let autoplayTimer;

    /* ===================================
       DOTS — MOBILE = PER CARD
       DOTS — DESKTOP = PER PAGE
    =================================== */
    function generateDots() {
        dotsContainer.innerHTML = "";

        const totalDots = isMobile
            ? document.querySelectorAll(".product-card").length
            : pages.length;

        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement("button");
            if (i === 0) dot.classList.add("active");
            dot.addEventListener("click", () => goTo(i));
            dotsContainer.appendChild(dot);
        }
    }

    /* ===================================
       GO TO INDEX — FIX VERSION
    =================================== */
    function goTo(i) {
        currentIndex = i;

        const dots = dotsContainer.querySelectorAll("button");
        dots.forEach(d => d.classList.remove("active"));
        dots[currentIndex].classList.add("active");

        if (isMobile) {
            // MOBILE → gunakan scroll native (bukan transform!)
            const card = document.querySelectorAll(".product-card")[i];
            card.scrollIntoView({ behavior: "smooth", inline: "center" });
        } else {
            // DESKTOP → per-page translation
            const slideWidth = pages[0].clientWidth;
            const offset = -(slideWidth * i);
            track.style.transform = `translateX(${offset}px)`;
        }
    }

    /* ===================================
       AUTOPLAY — HANYA UNTUK DESKTOP
    =================================== */
    function startAutoplay() {
        if (isMobile) return;

        autoplayTimer = setInterval(() => {
            currentIndex = (currentIndex + 1) % pages.length;
            goTo(currentIndex);
        }, 3500);
    }

    function stopAutoplay() {
        clearInterval(autoplayTimer);
    }

    /* ===================================
       RESIZE FIX
    =================================== */
    window.addEventListener("resize", () => {
        const nowMobile = window.innerWidth <= 576;

        if (nowMobile !== isMobile) {
            isMobile = nowMobile;
            generateDots();
            stopAutoplay();
            startAutoplay();
            currentIndex = 0;
            goTo(0);
        }
    });

    /* ===================================
       INIT
    =================================== */
    generateDots();
    startAutoplay();
    goTo(0);


    /* ==========================================
       Navbar Scroll Hide/Show + Mobile Fix
    ========================================== */
    const navbar = document.querySelector(".navbar");
    const toggler = document.querySelector(".navbar-toggler");

    let lastScroll = 0;
    let menuOpen = false;

    // Toggle Menu
    if (toggler) {
        toggler.addEventListener("click", () => {
            menuOpen = !menuOpen;

            if (menuOpen) {
                navbar.classList.remove("nav-hidden");
                navbar.classList.add("nav-locked");
            } else {
                navbar.classList.remove("nav-locked");
            }
        });
    }

    // Hide/Show on Scroll
    window.addEventListener("scroll", () => {
        if (menuOpen) return; // menu terbuka → jangan hide

        const currentScroll = window.pageYOffset;

        if (currentScroll <= 10) {
            navbar.classList.remove("nav-hidden");
            return;
        }

        if (currentScroll > lastScroll) {
            navbar.classList.add("nav-hidden"); // scroll down
        } else {
            navbar.classList.remove("nav-hidden"); // scroll up
        }

        lastScroll = currentScroll;
    });

});
</script>
