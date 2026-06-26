/**
 * Multi-Color Flowing Wisp Smoke Animation
 * Uses fluid line geometry instead of expanding circles.
 */
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('neon-canvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    let width, height;

    const resize = () => {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    };
    resize();
    window.addEventListener('resize', resize);

    // Track the mouse to pull the smoke
    let mouse = { x: -1000, y: -1000 };
    let globalHue = 0;
    
    let isIdle = true;
    let idleTimeout;

    window.addEventListener('mousemove', e => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
        
        isIdle = false;
        clearTimeout(idleTimeout);
        idleTimeout = setTimeout(() => {
            isIdle = true;
        }, 50); // Stop generating smoke 50ms after the mouse stops
    });

    window.addEventListener('touchmove', e => {
        mouse.x = e.touches[0].clientX;
        mouse.y = e.touches[0].clientY;
        
        isIdle = false;
        clearTimeout(idleTimeout);
        idleTimeout = setTimeout(() => {
            isIdle = true;
        }, 50);
    });

    class Wisp {
        constructor() {
            this.points = [];
            // Random behavioral offsets so each wisp moves uniquely
            this.phase = Math.random() * Math.PI * 2;
            this.swirlSpeed = Math.random() * 0.02 + 0.01; // SLOWER swirl
            // MUCH larger spread for a massive smoke cloud
            this.spread = Math.random() * 60 + 15;
        }

        update() {
            this.phase += this.swirlSpeed;
            
            // Only add new smoke trail points if the mouse is actively moving
            if (!isIdle) {
                // The head of the wisp softly orbits the mouse
                const headX = mouse.x + Math.cos(this.phase) * this.spread;
                const headY = mouse.y + Math.sin(this.phase) * this.spread;

                // Add new point at the front of the smoke trail
                this.points.unshift({ x: headX, y: headY, life: 1 });
            }

            // Apply smoke physics to all existing trail segments (they keep moving even if idle)
            for (let i = 0; i < this.points.length; i++) {
                let p = this.points[i];
                p.life -= 0.01; // SLOWER fade over time
                
                // Real smoke drifts upwards (SLOWER drift)
                p.y -= 0.8;
                // Organic side-to-side drift based on its age (SLOWER waves)
                p.x += Math.sin(p.life * 10 + this.phase) * 0.8;
            }

            // Trim segments that have completely faded away
            while (this.points.length > 0 && this.points[this.points.length - 1].life <= 0) {
                this.points.pop();
            }
        }

        draw() {
            if (this.points.length < 2) return;

            // Draw the wisp as a series of connected, expanding, fluid strokes
            for (let i = 0; i < this.points.length - 1; i++) {
                const p1 = this.points[i];
                const p2 = this.points[i + 1];

                // If the mouse jumped or we resumed from being idle, don't draw a line connecting the gap
                // Increased threshold to accommodate faster mouse movements without breaking the ribbon
                const dist = Math.hypot(p1.x - p2.x, p1.y - p2.y);
                if (dist > 150) continue;

                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(p2.x, p2.y);
                
                // Opacity gracefully fades but remains much punchier and solid
                ctx.globalAlpha = Math.max(0, p1.life * 0.85);
                
                // Smoke dissipates: it starts thick and expands MASSIVELY to make the effect BIG
                ctx.lineWidth = (1 - p1.life) * 80 + 10; 
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                
                // Dynamic rainbow coloring that cascades down the length of the smoke
                const localHue = (globalHue - i * 1.5) % 360;
                ctx.strokeStyle = `hsl(${localHue}, 90%, 55%)`;
                
                // Draw sharply without muddy shadow blurs
                ctx.stroke();
            }
        }
    }

    // Create a cluster of 5 independent smoke wisps weaving together
    const wisps = [];
    for (let i = 0; i < 5; i++) {
        wisps.push(new Wisp());
    }

    const animate = () => {
        // Clear canvas cleanly every frame
        ctx.clearRect(0, 0, width, height);

        globalHue += 0.5; // SLOWER rainbow cycle
        if (globalHue >= 360) globalHue = 0;

        wisps.forEach(wisp => {
            wisp.update();
            wisp.draw();
        });

        requestAnimationFrame(animate);
    };

    animate();
});