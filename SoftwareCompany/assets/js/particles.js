/**
 * FishiFox Light-Optimized Neon Cursor Tracker Engine
 * GPU-Accelerated Cursor Trail with Fixed Raycast Math
 */

document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('canvas-container');
    if (!container) {
        console.error("Canvas container target missing from DOM layout tree.");
        return;
    }

    // --- THREE.JS LAYER ENGINE SETUP ---
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true, powerPreference: "high-performance" });

    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    container.appendChild(renderer.domElement);

    // Position camera clearly back from the target rendering plane
    camera.position.set(0, 0, 10);

    // --- MEMORY pool & OPTIMIZATION ---
    const MAX_PARTICLES = 150; 
    const positions = new Float32Array(MAX_PARTICLES * 3);
    const colors = new Float32Array(MAX_PARTICLES * 4);

    const particlePool = Array.from({ length: MAX_PARTICLES }, () => ({
        active: false,
        x: 0, y: 0, z: 0,
        vx: 0, vy: 0,
        life: 0, maxLife: 0,
        color: new THREE.Color()
    }));

    let poolIndex = 0;

    // Premium high-contrast colors explicitly calibrated to pop on pure white screens
    const softNeonColors = [
        new THREE.Color('#3b82f6'), // Vivid Blue
        new THREE.Color('#06b6d4'), // Cyan 
        new THREE.Color('#8b5cf6'), // Purple
        new THREE.Color('#14b8a6')  // Light Teal
    ];

    // Natively render high-contrast procedural disk maps with a rich solid center core
    function createLightNeonTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 64; canvas.height = 64;
        const ctx = canvas.getContext('2d');
        
        const gradient = ctx.createRadialGradient(32, 32, 0, 32, 32, 26);
        gradient.addColorStop(0, 'rgba(255, 255, 255, 1.0)');  
        gradient.addColorStop(0.2, 'rgba(3, 105, 161, 0.9)'); // Deep cerulean core
        gradient.addColorStop(0.6, 'rgba(6, 182, 212, 0.5)');  // Rich cyan mid-rim
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
        
        ctx.fillStyle = gradient;
        ctx.beginPath(); ctx.arc(32, 32, 32, 0, Math.PI * 2); ctx.fill();
        return new THREE.CanvasTexture(canvas);
    }

    const particleTexture = createLightNeonTexture();

    // --- GEOMETRY SETUPS ---
    const particleGeometry = new THREE.BufferGeometry();
    particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particleGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 4));

    const particleMaterial = new THREE.PointsMaterial({
        size: 20, // Explicitly 20 pixels wide for high visibility
        sizeAttenuation: false, // Ensure size is independent of camera distance
        vertexColors: true,
        transparent: true,
        map: particleTexture,
        depthWrite: false,
        blending: THREE.NormalBlending // Normal blending preserves rich saturation levels over white layout sections
    });

    const particleSystem = new THREE.Points(particleGeometry, particleMaterial);
    scene.add(particleSystem);

    // --- COORDINATE MATHEMATICS ---
    let mouse = { x: 0, y: 0, targetX: 0, targetY: 0, moved: false };
    let raycasterVector = new THREE.Vector3();
    let rayDir = new THREE.Vector3();

    window.addEventListener('mousemove', (e) => {
        mouse.targetX = (e.clientX / window.innerWidth) * 2 - 1;
        mouse.targetY = -(e.clientY / window.innerHeight) * 2 + 1;
        mouse.moved = true;
    });

    function spawnParticle(worldX, worldY) {
        const p = particlePool[poolIndex];
        p.active = true;
        p.x = worldX + (Math.random() - 0.5) * 0.1;
        p.y = worldY + (Math.random() - 0.5) * 0.1;
        p.z = 0;
        
        // Soft spread dynamics
        p.vx = (Math.random() - 0.5) * 0.015;
        p.vy = (Math.random() - 0.5) * 0.015;
        
        p.maxLife = 35 + Math.random() * 20; 
        p.life = p.maxLife;
        p.color.copy(softNeonColors[Math.floor(Math.random() * softNeonColors.length)]);
        
        poolIndex = (poolIndex + 1) % MAX_PARTICLES;
    }

    // --- MAIN RENDER LOOP (60 FPS) ---
    function animLoop() {
        requestAnimationFrame(animLoop);
        
        // Linear interpolation ensures premium, silky trailing aesthetics
        mouse.x += (mouse.targetX - mouse.x) * 0.15;
        mouse.y += (mouse.targetY - mouse.y) * 0.15;
        
        // FIXED RAYCAST MATH: Correctly projects 2D screen mouse inputs onto a flat 3D focal plane at Z = 0
        raycasterVector.set(mouse.x, mouse.y, 0.5).unproject(camera);
        rayDir.copy(raycasterVector).sub(camera.position).normalize();
        
        const distanceIntersection = -camera.position.z / rayDir.z;
        const worldX = camera.position.x + rayDir.x * distanceIntersection;
        const worldY = camera.position.y + rayDir.y * distanceIntersection;

        // If mouse is active, spawn trailing fragments continuously
        if (mouse.moved) {
            for (let i = 0; i < 3; i++) {
                spawnParticle(worldX, worldY);
            }
        } else {
            // Diagnostic fallback loop: spawns tiny central hints on first load to confirm active WebGL context
            if (Math.random() < 0.05) {
                spawnParticle((Math.random() - 0.5) * 2, (Math.random() - 0.5) * 1);
            }
        }

        const posArr = particleGeometry.attributes.position.array;
        const colArr = particleGeometry.attributes.color.array;

        for (let i = 0; i < MAX_PARTICLES; i++) {
            const p = particlePool[i];
            const idxPos = i * 3;
            const idxCol = i * 4;

            if (p.active) {
                p.life--;
                p.x += p.vx;
                p.y += p.vy;

                const lifeRatio = p.life / p.maxLife;
                // High-visibility opacity balancing range explicitly mapped to withstand white backdrops
                const currentAlpha = 0.12 + (lifeRatio * 0.38);

                posArr[idxPos] = p.x;
                posArr[idxPos + 1] = p.y;
                posArr[idxPos + 2] = p.z;

                // Interpolate towards white to simulate fading out on a white background
                colArr[idxCol] = p.color.r * currentAlpha + 1.0 * (1 - currentAlpha);
                colArr[idxCol + 1] = p.color.g * currentAlpha + 1.0 * (1 - currentAlpha);
                colArr[idxCol + 2] = p.color.b * currentAlpha + 1.0 * (1 - currentAlpha);
                colArr[idxCol + 3] = 1.0;

                if (p.life <= 0) p.active = false;
            } else {
                // Instantly clean out unallocated particle arrays safely away from camera sight lines
                posArr[idxPos] = 9999;
                posArr[idxPos + 1] = 9999;
                posArr[idxPos + 2] = 9999;
            }
        }

        particleGeometry.attributes.position.needsUpdate = true;
        particleGeometry.attributes.color.needsUpdate = true;

        renderer.render(scene, camera);
    }

    animLoop();

    // --- VIEWPORT AUTORESIZE HANDLING ---
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
});