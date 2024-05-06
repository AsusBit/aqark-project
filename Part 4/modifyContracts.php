<?php
$servername = "localhost";
$username = "root";
$password = null;
$database = "aqark";


$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM contracts";
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
    <title>contracts</title>
    <link rel="stylesheet" href="Home-Style.css">
    <style>
        body{
            margin-left: 40%;
            margin-top: 10%;
        }
    </style>
     <!-- name number_of_rooms no_business_contracts cost -->
</head>
<body>
<?php 
include('navbar.html');
if($type == ''){
    echo "<h1>contracts List:</h1>
    <form>
    <button style='width: 140px; height:50px; margin:10px; font-size:18px; background-color: green; border: none; border-radius: 10px 10px 10px 10px; color: white; cursor:pointer;' type='submit' name='add'>add a contract</button>
    <button style='width: 140px; height:50px; margin:10px; font-size:18px; background-color: red; border: none; border-radius: 10px 10px 10px 10px; color: white; cursor:pointer;' type='submit' name = 'delete'>delete a contract</button>
    </form>";
    }
    echo "<table border=1 style='background-color: #333; color: white; margin-left:-100px;'> 
        <tr>
            <th style='color: grey; padding:10px; width:200px'>Name of contract</th>
            <th style='color: grey; padding:10px; width:100px'>Cost</th>
            <th style='color: grey; padding:10px; width:150px'>place</th>
        </tr>"; 
        
        foreach ($searchResults as $i) {echo "<tr>
            <td>", $i['name'],"</td>
            
            <td>", $i['cost'], "</td>
            <td>", $i['place'], "</td>
            </tr>";} 
        
        echo "</table>";
    if(isset($_GET['delete'])){
            $type = '1';
            echo "<form method='get' action='modifyContracts.php'>
            <label for='contractName'>Choose a contract to delete:</label>
            <input type='text' name = 'contractName'>
            <br><br>
            <input type='submit' value='Delete contract' name='deleteBtn'>
            </form>
            ";}
        if (isset($_GET['deleteBtn'])){
                $rowToDel = $_GET['contractName'];
                $sql = "DELETE FROM contracts WHERE name= ?" ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $rowToDel);
                if ($stmt->execute()) {
                    header("Refresh: 0; url=modifyContracts.php?refreshed=true");
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

                
        }
    elseif (isset($_GET['add'])){
        
            $type = '1';
            echo "<form method='get' action='modifyContracts.php'>
            <label for='contractName'>Name:</label>
            <input type='text' name = 'contractName'>
            
            <label for='cost'>Cost:</label>
            <input type='number' name = 'cost'>
            <label for='place'>Place:</label>
            <input type='text' name = 'place'>
            <br><br>
            <input type='submit' value='Add contract' name='addBtn'>
            </form>
            ";}
        if (isset($_GET['addBtn'])){
                $rowName = $_GET['contractName'];
                $rowStart = $_GET['dateB'];
                $rowEnd = $_GET['dateE'];
                $rowCost = $_GET['cost'];
                $rowPlace = $_GET['place'];
                $sql = "INSERT INTO contracts (name, date_begin, date_end, cost, place) VALUES (?, ?, ?, ?, ?);" ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssds", $rowName, $rowStart, $rowEnd, $rowCost, $rowPlace);
                if ($stmt->execute()) {
                    header("Refresh: 0; url=modifyContracts.php?refreshed=true");
                } else {
                    echo "Error adding record: " . $conn->error;
                }

                
        }



    $conn->close();
    ?>

    <!-- I am gonna put the changing stuff in this form below to happen after committing the name -->
    
    
</body>
</html>