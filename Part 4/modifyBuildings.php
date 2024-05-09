<?php
$servername = "localhost";
$username = "root";
$password = null;
$database = "aqark";

// establishing connection with the server, or showing error if trouble occurs
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// selecting every row and column from the workers table in the db
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
    <link rel="stylesheet" href="Home-Style.css">
    <style>
        body{
            margin-left: 32%;
            margin-top: 10%;
        }
    </style>
     <!-- name number_of_rooms no_business_contracts cost -->
</head>
<body>
<?php 
include('navbar.html');
if($type == ''){
    echo "<h1>Buildings List:</h1>
    <form>
    <button style='width: 140px; height:50px; margin:10px; font-size:18px; background-color: green; border: none; border-radius: 10px 10px 10px 10px; color: white; cursor:pointer;' type='submit' name='add'>add a Building</button>
    <button style='width: 140px; height:50px; margin:10px; font-size:18px; background-color: red; border: none; border-radius: 10px 10px 10px 10px; color: white; cursor:pointer;' type='submit' name = 'delete'>delete a Building</button>
    </form>";
    }
    echo "<table border=1 style='background-color: #333; color: white; margin-left: -100px;'> 
        <tr>
            <th style='color: grey; padding:10px; width:220px'>Name of building</th>
            <th style='color: grey; padding:10px; width:120px'>Cost</th>
            <th style='color: grey; padding:10px; width:180px'>Number of rooms</th>
            <th style='color: grey; padding:10px; width:180px'>number of contracts</th>
        </tr>"; 
        
        foreach ($searchResults as $i) {echo "<tr>
            <td  >", $i['name']," </td>
            <td  >", $i['cost'], " </td>
            <td  >", $i['number_of_rooms'], " </td>
            <td  >", $i['no_business_contracts'], "</td>
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
             //assigning variables from the form
                $rowToDel = $_GET['buildingName'];
                // raw SQL code that takes parameters, put in the parameters and execute the code, then refresh the page
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
            //assigning variables from the form
                $rowName = $_GET['buildingName'];
                $rowCost = $_GET['buildingCost'];
                $rowRooms = $_GET['roomsNumber'];
                $rowContracts = $_GET['contractsNumber'];
                 // raw SQL code that uses insert to put values into a newly made row in the db, but it uses parameters to include php variables in the SQL code
                $sql = "INSERT INTO buildings (name, number_of_rooms, no_business_contracts, cost) VALUES (?, ?, ?, ?);" ;
                // stmt is used to prepare the sql code through the connection with the db
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sddd", $rowName, $rowRooms, $rowContracts, $rowCost);
                if ($stmt->execute()) {
                    if (!isset($_GET['refreshed'])) {
                        header("Refresh: 0; url=modifyBuildings.php?refreshed=true");
                    }
                } else {
                    echo "Error adding record: " . $conn->error;
                }

                
        }



    $conn->close();
    ?>

    
    
</body>
</html>