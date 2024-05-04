<?php
//INSERT INTO buildings () 
// Create connection

$servername = 'localhost';
$database = 'aqark';
$password = null;
$username = 'root';
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$names = ['John Doe', 'Jane Smith', 'Michael Johnson', 'Emily Brown', 'David Martinez', 'Jennifer Davis', 'Christopher Miller', 'Jessica Wilson', 'Matthew Taylor', 'Sarah Anderson'];
$ages = [31, 28, 42, 35, 50, 29, 38, 26, 43, 33];
$wages = [3500.00, 4200.00, 3800.00, 4500.00, 5000.00, 4100.00, 4800.00, 3700.00, 4900.00, 4300.00];
$specs = ['Carpentry', 'Plumbing', 'Electrical Work', 'Masonry', 'Painting', 'Welding', 'Roofing', 'HVAC Installation', 'Concrete Work', 'Heavy Equipment Operation'];

// Prepare and bind the INSERT statement
$sql = $conn->prepare("INSERT INTO workers (name, age, wage, specialization) VALUES (?, ?, ?, ?)");

$sql->bind_param("sdds", $name, $age, $wage, $spec);

for ($i = 0; $i < 10; $i++){
    // Set parameters and execute
    $name = $names[$i];
    $age = $ages[$i];
    $wage = $wages[$i];
    $spec = $specs[$i];
    
    if ($sql->execute() === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the statement and the database connection
$sql->close();
// Step 4: Close the database connection
$conn->close();