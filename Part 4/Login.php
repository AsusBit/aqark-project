<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aqark</title>
    <link rel="stylesheet" href="Login-Style.css">
</head>
<body>

    <?php
    include("navbar.html");
    ?>
    <div class="main-content">
        <div class="background-image">
            <main class="login-page">
                <div class="login-form">
                    <h2>Login</h2>
                    <form action="login.php" method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit">Login</button>
                    </form>
                    <p>Don't have an account? <a href="Signup.php">Sign up</a></p>
                </div>
            </main>
        </div>
    </div>
    
    </main>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved.</p>
    </footer>
</body>
</html>
