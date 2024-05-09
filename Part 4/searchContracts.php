<?php
// search.php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = null;
$database = "aqark";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$searchName = "";
$searchLocation = "";
$searchResults = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $searchName = trim($_POST["searchName"]);
    // Prepare SQL statement
    $sql = "SELECT * FROM contracts WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $paramName = "%" . $searchName . "%";
    $stmt->bind_param("s", $paramName);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <script>

    </script>
</head>

<body>
    <h2>Search Workers</h2>
    <form method="post" action="<?php echo htmlspecialchars('searchContracts.php'); ?>">
        <label for="searchName">Name:</label>
        <input type="text" id="searchName" name="searchName" value="<?php echo $searchName; ?>"><br><br>
        <input type="submit" value="Search">
    </form>

    <h3>Search Results:</h3>
    <table border="1">
        <tr>
            <th>Contract name</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Cost</th>
            <th>Place</th>
        </tr>
        <?php // this is a foreach that loops through each row's information from the contracts table in MySQL and displays it as table data
         foreach ($searchResults as $row) : ?>
            <tr>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["date_begin"]; ?></td>
                <td><?php echo $row['date_end']; ?></td>
                <td><?php echo $row['cost'], ' omr'; ?></td>
                <td><?php echo $row['place']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
