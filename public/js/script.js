document.addEventListener('DOMContentLoaded', () => {
    initAOS();
    initSmoothScroll();
});

// AOS
function initAOS() {
    if (typeof AOS === 'undefined') {
        return;
    }

    AOS.init({
        once: true,
        offset: 50,
        duration: 800,
        easing: 'ease-out-cubic',
    });
}

// Smooth scroll
function initSmoothScroll() {
    const internalLinks = document.querySelectorAll('a[href^="#"]');

    internalLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const targetId = link.getAttribute('href');

            if (!targetId || targetId === '#') {
                return;
            }

            const targetElement = document.querySelector(targetId);

            if (!targetElement) {
                return;
            }

            event.preventDefault();
            closeMobileNavbar();

            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth',
            });
        });
    });
}

// Navbar
function closeMobileNavbar() {
    const navbarCollapse = document.getElementById('navbarNav');
    const navbarToggler = document.querySelector('.navbar-toggler');

    if (!navbarCollapse || !navbarToggler) {
        return;
    }

    if (navbarCollapse.classList.contains('show')) {
        navbarToggler.click();
    }
}