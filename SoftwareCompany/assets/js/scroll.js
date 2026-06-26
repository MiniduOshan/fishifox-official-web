// --- GEOMETRIC SNAP SYSTEM & PROGRESS MECHANICS ---
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

const nav = document.querySelector('.nav');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) nav.classList.add('scrolled');
    else nav.classList.remove('scrolled');
});

const scrollProgress = document.querySelector('.scroll-progress');
window.addEventListener('scroll', () => {
    const totalScroll = document.documentElement.scrollHeight - window.innerHeight;
    const percentage = totalScroll > 0 ? (window.scrollY / totalScroll) * 100 : 0;
    scrollProgress.style.width = `${percentage}%`;
});

// Intercept layouts mapping vectors
const sections = gsap.utils.toArray("section");
let activeSectionIndex = 0;
let isMovingPage = false;

// 3D positional transforms for camera projection sequences across views
const cameraViewpoints = [
    { posX: 0, posY: 3.5, posZ: 6,    rotX: -0.5, rotY: 0,    rotZ: 0 },    
    { posX: -1.5, posY: 2.0, posZ: 4.5, rotX: -0.3, rotY: 0.2,  rotZ: 0 },    
    { posX: 0, posY: 0.1, posZ: 2.2,  rotX: 0,    rotY: 0.6,  rotZ: 0 },    
    { posX: 2.5, posY: -1.5, posZ: 4,   rotX: 0.3,  rotY: -0.4, rotZ: 0 },    
    { posX: 0, posY: 5.5, posZ: 2.5,  rotX: -1.2, rotY: 0,    rotZ: 0 }     
];

function transitionToSection(targetIndex) {
    if (targetIndex < 0 || targetIndex >= sections.length) return;
    isMovingPage = true;
    activeSectionIndex = targetIndex;

    const targetView = cameraViewpoints[targetIndex] || cameraViewpoints[0];

    if (window.camera) {
        gsap.to(camera.position, {
            x: targetView.posX, y: targetView.posY, z: targetView.posZ,
            duration: 1.4, ease: "power4.inOut", overwrite: "auto"
        });
        gsap.to(camera.rotation, {
            x: targetView.rotX, y: targetView.rotY, z: targetView.rotZ,
            duration: 1.4, ease: "power4.inOut", overwrite: "auto"
        });
    }

    gsap.to(window, {
        scrollTo: { y: sections[targetIndex], offsetY: 0 },
        duration: 1.1, ease: "power3.inOut",
        onComplete: () => { isMovingPage = false; }
    });
}

// Single multi-page fallback optimization rule execution
if (sections.length > 1 && document.getElementById('hero')) {
    window.addEventListener("wheel", (e) => {
        if (isMovingPage) { e.preventDefault(); return; }
        if (e.deltaY > 0) {
            if (activeSectionIndex < sections.length - 1) { e.preventDefault(); transitionToSection(activeSectionIndex + 1); }
        } else {
            if (activeSectionIndex > 0) { e.preventDefault(); transitionToSection(activeSectionIndex - 1); }
        }
    }, { passive: false });
}

// Global ScrollTrigger fade orchestration reveal systems
sections.forEach((section) => {
    const reveals = section.querySelectorAll('.reveal');
    if (reveals.length === 0) return;
    ScrollTrigger.create({
        trigger: section, start: "top 50%", end: "bottom 50%",
        onEnter: () => { gsap.to(reveals, { opacity: 1, y: 0, duration: 0.6, stagger: 0.08, overwrite: "auto" }); },
        onLeaveBack: () => { gsap.to(reveals, { opacity: 0, y: 30, duration: 0.4, stagger: 0.05, overwrite: "auto" }); }
    });
});