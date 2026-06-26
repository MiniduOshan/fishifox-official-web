// --- KINETIC MOUSE PARALLAX CARDS & ACCORDION BEHAVIOR ---
document.addEventListener("DOMContentLoaded", () => {
    // 3D Elastic rotation system for interface cards
    const interactiveCards = document.querySelectorAll('.service-card, .tool-card, .portfolio-card');
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
});