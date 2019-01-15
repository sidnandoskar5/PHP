<?php

/*/

Table: Emp
--------------------------
| id  | emp_name         |
--------------------------
|  1  | John Doe         |
--------------------------
|  2  | Jane Doe         |
--------------------------
|  .  | .    .           |
|  .  | .    .           |
|  .  | .    .           |
--------------------------
*/


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";
$fineName = "download.xls";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, emp_name FROM Emp"); 
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $table =
    '<table class="table" bordered="1">' .
        '<tr>' .
            '<th>Employee Id</th>' .
            '<th>Employee Name</th>' .
        '</tr>';

    foreach($stmt->fetchAll() as $row) {
        $table .= 
        '<tr>' .
            '<td>'.$row["id"].'</td>' .
            '<td>'.$row["emp_name"].'</td>' .
        '</tr>';
    }

    $table .= '</table>';

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=' . $fineName);

    echo $table;
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?> 