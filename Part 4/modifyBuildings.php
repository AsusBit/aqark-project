<?php
$servername = "localhost";
$username = "root";
$password = null;
$database = "aqark";


$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM buildings";
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
    <title>buildings</title>
     <!-- name number_of_rooms no_business_contracts cost -->
</head>
<body>
<?php if($type == ''){
    echo "<h1>Buildings List:</h1>
    <form>
    <button type='submit' name='add'>add a building</button>
    <button type='submit' name = 'delete'>delete a building</button>
    </form>";
    }
    echo "<table border=1> 
        <tr>
            <th>Name of building</th>
            <th>Cost</th>
            <th>Number of rooms</th>
            <th>number of contracts</th>
        </tr>"; 
        
        foreach ($searchResults as $i) {echo "<tr>
            <td>", $i['name']," </td>
            <td>", $i['cost'], " </td>
            <td>", $i['number_of_rooms'], " </td>
            <td>", $i['no_business_contracts'], "</td>
            </tr>";} 
        echo "</table>";
    if(isset($_GET['delete'])){
            $type = '1';
            echo "<form method='get' action='modifyBuildings.php'>
            <label for='buildingName'>Choose a building to delete:</label>
            <input type='text' name = 'buildingName'>
            <br><br>
            <input type='submit' value='Delete Building' name='deleteBtn'>
            </form>
            ";}
        if (isset($_GET['deleteBtn'])){
                $rowToDel = $_GET['buildingName'];
                $sql = "DELETE FROM buildings WHERE name= ?" ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $rowToDel);
                if ($stmt->execute()) {
                    if (!isset($_GET['refreshed'])) {
                        header("Refresh: 0; url=modifyBuildings.php?refreshed=true");
                    }
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

                
        }
    elseif (isset($_GET['add'])){
        
            $type = '1';
            echo "<form method='get' action='modifyBuildings.php' style='display: grid; width: 15%;'>
            <label for='buildingName'>Name of this building:</label>
            <input type='text' name = 'buildingName'>
            <label for='buildingName'>Cost of the building:</label>
            <input type='number' name = 'buildingCost'>
            <label for='buildingName'>Number of rooms in this building:</label>
            <input type='number' name = 'roomsNumber'>
            <label for='buildingName'>Number of contracts for this building:</label>
            <input type='number' name = 'contractsNumber'>
            <br><br>
            <input type='submit' value='Add Building' name='addBtn'>
            </form>
            ";}
        if (isset($_GET['addBtn'])){
                $rowName = $_GET['buildingName'];
                $rowCost = $_GET['buildingCost'];
                $rowRooms = $_GET['roomsNumber'];
                $rowContracts = $_GET['contractsNumber'];
                $sql = "INSERT INTO buildings (name, number_of_rooms, no_business_contracts, cost) VALUES (?, ?, ?, ?);" ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sddd", $rowName, $rowRooms, $rowContracts, $rowCost);
                if ($stmt->execute()) {
                    if (!isset($_GET['refreshed'])) {
                        header("Refresh: 0; url=modify.php?refreshed=true");
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