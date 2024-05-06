<?php
$servername = "localhost";
$username = "root";
$password = null;
$database = "aqark";

$flag1 = false;
$flag2 = false;
$flag3 = false;

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = 'SELECT * FROM questionnaire';
include('navbar.html');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire - Aqark</title>
    <link rel="stylesheet" href="Home-Style.css">
    <style>
body {
    font-family: Arial, sans-serif;
}

form {
    width: 400px;
    margin: 0 auto;
}

label {
    margin-top: 20px;
}

input[type="text"], input[type="email"], textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
}

input[type="radio"] {
    margin: 10px 5px;
}

input[type="submit"] {
    display: block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    transition-duration: 0.4s;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
    </style>
</head>
<body>
    <!-- Your existing code -->

    <div class="main-content">
        <form id="questionnaireForm" style="margin-top:150px;">
            <h1>Questionnaire Page</h1>
            <label for="name" >Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="feedback">Feedback:</label><br>
            <textarea id="feedback" name="feedback" required></textarea><br>
            <label for="satisfied">Are you satisfied with our service?</label><br>
            <label><input type="radio" id="yes" name="satisfied" value="1" required> Yes</label><br>
            <input type="radio" id="no" name="satisfied" value='0'>
            <label for="no">No</label><br>
            <label for="newsletter">Subscribe to our newsletter?</label>
            <input type="checkbox" id="newsletter" name="subscribe" value="1"><br>
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        
        // JavaScript validation
        document.getElementById('questionnaireForm').addEventListener('submit', function(event) {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var feedback = document.getElementById('feedback').value;

            // Validate name (at least 2 characters, no numbers)
            if (!/^[a-zA-Z]{2,}$/.test(name)) {
                alert('Invalid name. Please enter at least 2 characters without numbers.');
                event.preventDefault();
        
            }else{
                <?php 
                    $flag1 = true;
                    ?>
            }

            // Validate email (simple email pattern)
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                alert('Invalid email. Please enter a valid email address.');
                event.preventDefault();
            }else{
                <?php 
                    $flag2 = true;
                    ?>
            }

            // Validate feedback (at least 10 characters)
            if (feedback.length < 10) {
                alert('Invalid feedback. Please enter at least 10 characters.');
                event.preventDefault();
            }else{
                
            }

            <?php
            $subscribe = isset($_GET['subscribe']) ? 1 : 0;
            if (isset($_GET['satisfied']) && isset($_GET['feedback']) && isset($_GET['name']) && isset($_GET['email'])){
                echo '<script>alert(', $_GET['satisfied'], ');';
                $sql = 'INSERT INTO questionnaire (name, email, feedback, satisfied, subscribe) VALUES (?, ?, ?, ?, ? );';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssdd', $_GET['name'], $_GET['email'], $_GET['feedback'], $_GET['satisfied'], $subscribe);
                $stmt->execute();

            }
            ?>
        });
    </script>

    <!-- Your existing code -->
</body>
</html>