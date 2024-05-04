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
                    <h2>Sign up</h2>
                    <form action="Signup.php" method="POST">
                        <input type="text" name="username" placeholder="create username" required>
                        <input type="password" name="password" placeholder="create password" required>
                        <input type="password" name="cpassword" placeholder="confirm password" required>
                        <button type="submit">Sign up</button>
                    </form>
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
