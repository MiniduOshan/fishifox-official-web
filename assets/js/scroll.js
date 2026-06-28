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

function updateCameraForSection(targetIndex) {
    if (targetIndex < 0 || targetIndex >= sections.length) return;
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
}

// Update camera when scrolling through sections normally
if (sections.length > 0) {
    sections.forEach((section, index) => {
        ScrollTrigger.create({
            trigger: section,
            start: "top 80%", // Increased sensitivity from 50%
            onEnter: () => updateCameraForSection(index),
            onEnterBack: () => updateCameraForSection(index)
        });
    });
}
