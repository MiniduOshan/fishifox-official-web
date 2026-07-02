<!DOCTYPE html>
<html lang="en">
<head>
    <!-- START: Google Analytics Tag -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FKM3GZP4HS"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-FKM3GZP4HS');
    </script>
    <!-- END: Google Analytics Tag -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishiFox – Web design ,Software and IT Base Research</title>
    <meta name="description" content="With a steadfast commitment to delivering top tier web development, mobile app solutions, IT base research, and digital marketing services, we stand at the forefront of innovation.">
    
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/animation.css?v=2">
    <link rel="stylesheet" href="assets/css/responsive.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>
</head>
<body>

    <div id="canvas-container">
        <canvas id="fluid-canvas"></canvas>
    </div>

    <div class="scroll-progress"></div>

    <?php include 'includes/navbar.php'; ?>
    <div class="snap-container">