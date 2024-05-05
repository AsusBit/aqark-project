<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Aqark</title>
    <link rel="stylesheet" href="Home-Style.css">
    <script src='./index.js'>
    
</script>
</head>
<body>
<?php
    include("navbar.html");
    ?>
    <div class="main-content">
        <div class="background-image">
            <section class="boxes">
                <div class="box" onclick="goToHome('modifyBuildings.php')">
                    <h2>Buildings</h2>
                    <img src="bg3.webp" alt="Image 1">
                </div>
                <div class="box" onclick="goToHome('modifyContracts.php')">
                    <h2>Contracts</h2>
                    <img src="bg2.jpg" alt="Image 2">
                </div>
                <div class="box" onclick="goToHome('modifyWorkers.php')">
                    <h2>Workers</h2>
                    <img src="bg1.jpg" alt="Image 3">
                </div>
            </section>
        </div>
    </div>
    </main>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved.</p>
    </footer>
</body>
</html>
