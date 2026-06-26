/**
 * FishiFox Structural Theme Configuration Script
 * Permanently locks layout to Light Theme configuration templates.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Explicitly lock the document theme root layer to prevent unexpected inversions
    document.documentElement.removeAttribute('data-theme');
});