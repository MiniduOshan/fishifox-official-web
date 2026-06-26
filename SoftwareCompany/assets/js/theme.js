document.addEventListener('DOMContentLoaded', () => {
    // -----------------------------
    // Theme Toggle Logic
    // -----------------------------
    const themeToggleBtn = document.getElementById('theme-toggle');
    const body = document.body;
    
    // Check local storage for theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        body.classList.add('light-theme');
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            body.classList.toggle('light-theme');
            
            // Save preference to local storage
            if (body.classList.contains('light-theme')) {
                localStorage.setItem('theme', 'light');
            } else {
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // -----------------------------
    // Neon Flow Tubes Cursor Effect
    // -----------------------------
    const watercolorCanvas = document.getElementById('watercolor-canvas');
    if (watercolorCanvas) {
        // We use dynamic import to load the specific threejs-components effect from CDN
        import('https://cdn.jsdelivr.net/npm/threejs-components@0.0.19/build/cursors/tubes1.min.js')
            .then(module => {
                const TubesCursor = module.default;
                
                const app = TubesCursor(watercolorCanvas, {
                    tubes: {
                        colors: ["#f967fb", "#53bc28", "#6958d5"],
                        radius: 0.3, // Attempt to reduce tube thickness
                        sleepRadiusX: 100, // Try keeping it tighter
                        sleepRadiusY: 100,
                        lights: {
                            intensity: 80, // Reduced intensity from 200 to make the neon glow smaller
                            colors: ["#83f36e", "#fe8a2e", "#ff008a", "#60aed5"]
                        }
                    }
                });

                // Helper to invert hex colors
                const invertColor = (hex) => {
                    hex = hex.replace('#', '');
                    return '#' + (0xFFFFFF ^ parseInt(hex, 16)).toString(16).padStart(6, '0');
                };

                // Randomize colors on click
                document.addEventListener('click', (e) => {
                    // Ignore clicks on the theme toggle button
                    if (e.target.closest('#theme-toggle')) return;
                    
                    const randomColors = (count) => {
                        return new Array(count)
                            .fill(0)
                            .map(() => "#" + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0'));
                    };
                    
                    const isLight = document.body.classList.contains('light-theme');
                    let newColors = randomColors(3);
                    
                    if (isLight) {
                        // Pre-invert target colors
                        app.tubes.setColors(newColors.map(invertColor));
                        // Keep lights black to prevent muddy shadows
                        app.tubes.setLightsColors(["#000000", "#000000", "#000000", "#000000"]);
                    } else {
                        app.tubes.setColors(newColors);
                        app.tubes.setLightsColors(randomColors(4));
                    }
                });

                // Dynamically update colors based on the theme
                const updateThemeColors = () => {
                    const isLight = document.body.classList.contains('light-theme');
                    if (isLight) {
                        // Vibrant colors for white background (Blue, Pink, Purple)
                        const targetColors = ["#0066ff", "#ff0066", "#9900ff"];
                        app.tubes.setColors(targetColors.map(invertColor));
                        
                        // RESTORE NEON LIGHTS! 
                        // To get the perfect neon glow on a white background, we pass mathematically inverted light colors.
                        // The CSS filter: invert(1) will instantly flip them back to their true, bright neon colors.
                        const targetLights = ["#0088ff", "#ff0088", "#aa00ff", "#00ffff"];
                        app.tubes.setLightsColors(targetLights.map(invertColor));
                    } else {
                        // Bright neon tones for the dark background
                        app.tubes.setColors(["#f967fb", "#53bc28", "#6958d5"]);
                        app.tubes.setLightsColors(["#83f36e", "#fe8a2e", "#ff008a", "#60aed5"]);
                    }
                };
                
                // Set initial colors
                setTimeout(updateThemeColors, 100);

                // Listen for theme changes to update the tubes
                const themeToggleBtn = document.getElementById('theme-toggle');
                if (themeToggleBtn) {
                    themeToggleBtn.addEventListener('click', () => {
                        setTimeout(updateThemeColors, 50);
                    });
                }
            })
            .catch(error => {
                console.error("Failed to load TubesCursor:", error);
            });
    }
});
