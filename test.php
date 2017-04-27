<?php

$thisfolder = dirname(__FILE__);
$db = new PDO('sqlite:' . $thisfolder . '\\testdb.sqlite3');

function addRecordTestTable($name, $age){
  global $db;
  $stmt = $db->prepare("INSERT INTO testtable (name, age) VALUES (:name, :age)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':age', $age);
  $stmt->execute();
}


print "<table border=1>";
print "<tr><td>Name</td><td>Age</td></tr>";
addRecordTestTable("paul'; DROP TABLES *", 39);
$result = $db->query('SELECT * FROM testtable');
foreach($result as $row)
{
  print "<td>".$row['name']."</td>";
  print "<td>".$row['age']."</td></tr>";
}

print "</table>";
// close the database connection
$db = NULL;


