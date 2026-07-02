// --- KINETIC MOUSE PARALLAX CARDS & ACCORDION BEHAVIOR ---
document.addEventListener("DOMContentLoaded", () => {
    // 3D Elastic rotation system for interface cards (Desktop Only)
    const interactiveCards = document.querySelectorAll('.service-card, .tool-card, .portfolio-card');
    if (window.matchMedia("(hover: hover)").matches) {
        interactiveCards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const rotateX = ((e.clientY - rect.top) - (rect.height / 2)) / 15;
                const rotateY = ((rect.width / 2) - (e.clientX - rect.left)) / 15;
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            });
        });
    } else {
        // Mobile touch feedback (does not break touch scrolling)
        interactiveCards.forEach(card => {
            card.addEventListener('touchstart', () => {
                card.style.transform = 'perspective(1000px) translateY(-4px) scale(0.98)';
                card.style.transition = 'transform 0.2s ease-out';
            }, { passive: true });
            card.addEventListener('touchend', () => {
                card.style.transform = 'perspective(1000px) translateY(0) scale(1)';
            }, { passive: true });
        });
    }

    // Accordion Event System initialization
    document.querySelectorAll('.faq-item').forEach(item => {
        const header = item.querySelector('.faq-header');
        if (header) {
            header.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                if (!isActive) item.classList.add('active');
            });
        }
    });

    // Navbar scroll listener
    const nav = document.querySelector('.nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });
        // Set initial state
        if (window.scrollY > 50) nav.classList.add('scrolled');
    }

    // Scroll progress bar
    const scrollProgress = document.querySelector('.scroll-progress');
    if (scrollProgress) {
        window.addEventListener('scroll', () => {
            const totalScroll = document.documentElement.scrollHeight - window.innerHeight;
            const percentage = totalScroll > 0 ? (window.scrollY / totalScroll) * 100 : 0;
            scrollProgress.style.width = `${percentage}%`;
        });
    }
});

// Mobile Navbar
document.addEventListener("DOMContentLoaded", () => {

    const mobileMenu = document.getElementById("mobile-menu");
    const navLinks = document.getElementById("nav-links");

    if (mobileMenu && navLinks) {

        mobileMenu.addEventListener("click", () => {
            mobileMenu.classList.toggle("active");
            navLinks.classList.toggle("active");
            document.body.classList.toggle("menu-open");
        });

        document.querySelectorAll("#nav-links a").forEach(link => {
            link.addEventListener("click", () => {
                mobileMenu.classList.remove("active");
                navLinks.classList.remove("active");
                document.body.classList.remove("menu-open");
            });
        });

    }

});