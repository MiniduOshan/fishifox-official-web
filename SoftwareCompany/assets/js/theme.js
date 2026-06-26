/**
 * FishiFox Structural Theme Configuration Script
 * Permanently locks layout to Light Theme configuration templates.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Explicitly lock the document theme root layer to prevent unexpected inversions
    document.documentElement.setAttribute('data-theme', 'light');
    
    // Remove the toggle UI button since the design path is now permanently light
    const toggleButton = document.getElementById('themeToggle');
    if (toggleButton) {
        toggleButton.style.display = 'none';
    }
});