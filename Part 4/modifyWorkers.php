<?php
$servername = "localhost";
$username = "root";
$password = null;
$database = "aqark";


$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM workers";
$stmt = $conn->prepare($sql);
// Execute query
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}

// Close statement
$stmt->close();


$isNamed = false;
$nameChosen = '';
$type = '';
//what type of modification? insert, update or delete



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>workers</title>
     <!-- name number_of_rooms no_business_contracts cost -->
</head>
<body>
<?php if($type == ''){
    echo "<h1>Workers List:</h1>
    <form>
    <button type='submit' name='add'>add a Worker</button>
    <button type='submit' name = 'delete'>delete a Worker</button>
    </form>";
    }
    echo "<table border=1> 
        <tr>
            <th>Name of worker</th>
            <th>Age</th>
            <th>Wage</th>
            <th>Specialization</th>
        </tr>"; 
        
        foreach ($searchResults as $i) {echo "<tr>
            <td>", $i['name']," </td>
            <td>", $i['age'], " </td>
            <td>", $i['wage'], " </td>
            <td>", $i['specialization'], "</td>
            </tr>";} 
        echo "</table>";
    if(isset($_GET['delete'])){
            $type = '1';
            echo "<form method='get' action='modifyWorkers.php'>
            <label for='workerName'>Choose a worker to delete:</label>
            <input type='text' name = 'workerName'>
            <br><br>
            <input type='submit' value='Delete worker' name='deleteBtn'>
            </form>
            ";}
        if (isset($_GET['deleteBtn'])){
                $rowToDel = $_GET['workerName'];
                $sql = "DELETE FROM workers WHERE name= ?" ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $rowToDel);
                if ($stmt->execute()) {
                    if (!isset($_GET['refreshed'])) {
                        header("Refresh: 0; url=modifyWorkers.php?refreshed=true");
                    }
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

                
        }
    elseif (isset($_GET['add'])){
        
            $type = '1';
            echo "<form method='get' action='modifyWorkers.php'>
            <label for='workerName'>Name:</label>
            <input type='text' name = 'workerName'>
            <label for='workerAge'>Age:</label>
            <input type='number' name = 'workerAge'>
            <label for='workerWage'>Wage:</label>
            <input type='number' name = 'workerWage'>
            <label for='specialization'>Specialization:</label>
            <input type='text' name = 'specialization'>
            <br><br>
            <input type='submit' value='Add worker' name='addBtn'>
            </form>
            ";}
        if (isset($_GET['addBtn'])){
                $rowName = $_GET['workerName'];
                $rowAge = $_GET['workerAge'];
                $rowWage = $_GET['workerWage'];
                $rowSpecs = $_GET['specialization'];
                $sql = "INSERT INTO workers (name, age, wage, specialization) VALUES (?, ?, ?, ?);" ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sdds", $rowName, $rowAge, $rowWage, $rowSpecs);
                if ($stmt->execute()) {
                    if (!isset($_GET['refreshed'])) {
                        header("Refresh: 0; url=modifyWorkers.php?refreshed=true");
                    }
                } else {
                    echo "Error adding record: " . $conn->error;
                }

                
        }



    $conn->close();
    ?>

    <!-- I am gonna put the changing stuff in this form below to happen after committing the name -->
    
    
</body>
</html>