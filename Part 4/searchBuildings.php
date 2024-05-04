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
    $sql = "SELECT * FROM buildings WHERE name LIKE ?";
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
    <h2>Search Buildings</h2>
    <form method="post" action="<?php echo htmlspecialchars('searchBuildings.php'); ?>">
        <label for="searchName">Building Name:</label>
        <input type="text" id="searchName" name="searchName" value="<?php echo $searchName; ?>"><br><br>
        <input type="submit" value="Search">
    </form>

    <h3>Search Results:</h3>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Cost</th>
            <th>Number of rooms</th>
            <th>number of contracts</th>

            <!-- Add more columns as needed -->
        </tr>
        <?php foreach ($searchResults as $row) : ?>
            <tr>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["cost"], ' omr'; ?></td>
                <td><?php echo $row['number_of_rooms']; ?></td>
                <td><?php echo $row['no_business_contracts']; ?></td>
                <!-- Display additional columns here -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
