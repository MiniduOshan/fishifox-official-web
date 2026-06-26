<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishiFox - Diving to an Unexpected Depth</title>
    
    <!-- Typography Context Frameworks -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- Structural Layout Sheets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/animation.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <!-- Third-Party Structural Engines -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</head>
<body>

    <!-- Scroll & Background System Initialization Anchor Elements -->
    <div class="scroll-progress"></div>
    <div id="canvas-container"></div>

    <!-- Theme Toggle Floating Button Interface Link -->
    <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle Theme">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="5" />
            <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
        </svg>
    </button>

    <?php include 'includes/navbar.php'; ?>
    <div class="snap-container">