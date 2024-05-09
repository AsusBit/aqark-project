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




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>workers</title>
    <link rel="stylesheet" href="Home-Style.css">
    <style>
        body{
            margin-left: 32%;
            margin-top: 10%;
        }
    </style>
     
</head>
<body>
<?php 
include('navbar.html');
if($type == ''){
    // displaying everything needed as the html before picking between adding and removing
    echo "<h1>Workers List:</h1>
    <form>
    <button style='width: 140px; height:50px; margin:10px; font-size:18px; background-color: green; border: none; border-radius: 10px 10px 10px 10px; color: white; cursor:pointer;' type='submit' name='add'>add a Worker</button>
    <button style='width: 140px; height:50px; margin:10px; font-size:18px; background-color: red; border: none; border-radius: 10px 10px 10px 10px; color: white; cursor:pointer;' type='submit' name = 'delete'>delete a Worker</button>
    </form>";
    }
    echo "<table border=1 style='background-color: #333; color: white; border-style:solid; border-color:white;'> 
        <tr>
            <th style='color: grey; padding:10px; width:180px'>Name of worker</th>
            <th style='color: grey; width: 50px;'>Age</th>
            <th style='color: grey;  width: 60px;'>Wage</th>
            <th style='color: grey;  width: 250px;'>Specialization</th>
        </tr>"; 
        
        foreach ($searchResults as $i) {echo "<tr>
            <td >", $i['name']," </td>
            <td  >", $i['age'], " </td>
            <td  >", $i['wage'], " </td>
            <td  >", $i['specialization'], "</td>
            </tr>";} 
        echo "</table>";
    if(isset($_GET['delete'])){
            $type = '1';
            // displaying a form to ask the needed information in order to delete
            echo "<form method='get' action='modifyWorkers.php'>
            <label for='workerName'>Choose a worker to delete:</label>
            <input type='text' name = 'workerName'>
            <br><br>
            <input type='submit' value='Delete worker' name='deleteBtn'>
            </form>
            ";}
        if (isset($_GET['deleteBtn'])){
             //assigning variables from the form
                $rowToDel = $_GET['workerName'];                
                // raw SQL code that uses insert to put values into a newly made row in the db, but it uses parameters to include php variables in the SQL code
                $sql = "DELETE FROM workers WHERE name= ?" ;
                // stmt is used to prepare the sql code through the connection with the db
                $stmt = $conn->prepare($sql);
                // stmt is used to put in php variables instead of ? 
                $stmt->bind_param("s", $rowToDel);
                // if the sql code gets executed without error, the page refreshes to display the new modified table
                if ($stmt->execute()) {
                    header("Refresh: 0; url=modifyWorkers.php?refreshed=true");
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

                
        }
    elseif (isset($_GET['add'])){
        
            $type = '1';
            // displaying a form to ask the needed information in order to add
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
             //assigning variables from the form
                $rowName = $_GET['workerName'];
                $rowAge = $_GET['workerAge'];
                $rowWage = $_GET['workerWage'];
                $rowSpecs = $_GET['specialization'];
                // raw SQL code that uses insert to put values into a newly made row in the db, but it uses parameters to include php variables in the SQL code
                $sql = "INSERT INTO workers (name, age, wage, specialization) VALUES (?, ?, ?, ?);" ;
                // stmt is used to prepare the sql code through the connection with the db
                $stmt = $conn->prepare($sql);
                // stmt is used to put in php variables instead of ? 
                $stmt->bind_param("sdds", $rowName, $rowAge, $rowWage, $rowSpecs);
                // if the sql code gets executed without error, the page refreshes to display the new modified table
                if ($stmt->execute()) {
                    header("Refresh: 0; url=modifyWorkers.php?refreshed=true");
                } else {
                    echo "Error adding record: " . $conn->error;
                }

                
        }



    $conn->close();
    ?>
    <!-- I am gonna put the changing stuff in this form below to happen after committing the name -->
    
    
</body>
</html>