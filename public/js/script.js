document.addEventListener('DOMContentLoaded', function() {
    
    // Inisialisasi AOS (Animate On Scroll)
    AOS.init({
        once: true, // Animasi cuma jalan sekali saat di-scroll
        offset: 50, // Mulai animasi sedikit lebih awal
        duration: 800,
        easing: 'ease-out-cubic',
    });

    // Smooth scroll untuk link internal & Auto-close menu mobile
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Tutup otomatis navbar collapse di mobile saat link diklik
                const navbarCollapse = document.getElementById('navbarNav');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    // Trigger click pada tombol hamburger untuk menutup menu
                    document.querySelector('.navbar-toggler').click();
                }

                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Offset untuk navbar
                    behavior: 'smooth'
                });
            }
        });
    });
});