<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts - Aqark</title>
    <link rel="stylesheet" href="contact.css">
    <style>
        table {
            width: 40%; /* Adjusted width */
            margin: 0 auto; /* Centering the table */
            border-collapse: collapse;
            margin-left: 20px; /* Adjusted margin */
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid;
            padding: 8px;
            text-align: center;
            color: rgb(9, 9, 9);
            font-weight: 100;
            font-size: large;
            width:1px;
        } 
        .about-section {
            padding-top: 100px; /* Adjusted padding */
            margin-left: 20px; /* Adjusted margin */
            color: rgb(8, 8, 8);
        }
        .about-text {
            text-align: left; /* Aligning text to the left */
            margin-left:20px; /* Adjusted margin */
            color: rgb(5, 5, 5);
        }
        .about-section-2 {
            padding-top: 140px; /* Adjusted padding */
            margin-left: 20px; /* Adjusted margin */
            color: rgb(6, 6, 6);
        }
    </style>
</head>
<body>
<?php
    // including the already made navigation bar
    include("navbar.html");
    ?>
    <div class="main-content">
        <div class="background-image">
            <section class="about-section">
                <div class="about-text">
                    <h1>Contact us:</h1>
                </div>
                <table>
                    <tr>
                        <th>Way of Contacting</th>
                        <th>Result</th>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>Aqark.Oman@gmail.com</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>+968 99999999</td>
                    </tr>
                    <tr>
                        <td>Building Location</td>
                        <td>Muscat-Bousher</td>
                    </tr>
                    <tr>
                </table>
            </section>
            
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Your Website. All rights reserved.</p>
    </footer>
</body>
</html>
