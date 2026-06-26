document.addEventListener('DOMContentLoaded', () => {
    const blobs = document.querySelectorAll('.blob');
    
    // Mouse tracking variables
    let mouseX = window.innerWidth / 2;
    let mouseY = window.innerHeight / 2;
    
    // Track mouse movement
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    // Array to store current positions of each blob
    const blobData = Array.from(blobs).map(blob => ({
        el: blob,
        x: 0,
        y: 0,
        speed: parseFloat(blob.getAttribute('data-speed')) || 0.05
    }));

    // Linear Interpolation function
    const lerp = (start, end, factor) => {
        return start + (end - start) * factor;
    };

    // Animation Loop
    const animate = () => {
        // Calculate target offset from center of screen
        const targetX = mouseX - window.innerWidth / 2;
        const targetY = mouseY - window.innerHeight / 2;

        blobData.forEach(data => {
            // Lerp current position towards target position scaled by speed
            data.x = lerp(data.x, targetX * data.speed, 0.05);
            data.y = lerp(data.y, targetY * data.speed, 0.05);
            
            // Apply transform (adding to the existing css animations which might be affecting width/height/border-radius)
            // Note: because the blobs also have keyframe animations for morphing, we only touch transform here.
            data.el.style.transform = `translate(${data.x}px, ${data.y}px)`;
        });

        requestAnimationFrame(animate);
    };

    // Start animation loop
    animate();
});
