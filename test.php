<?php

$thisfolder = dirname(__FILE__);
$db = new PDO('sqlite:' . $thisfolder . '\\testdb.sqlite3');

print "<table border=1>";
print "<tr><td>Name</td><td>Age</td></tr>";
$result = $db->query('SELECT * FROM testtable');
foreach($result as $row)
{
  print "<td>".$row['name']."</td>";
  print "<td>".$row['age']."</td></tr>";
}
print "</table>";
// close the database connection
$db = NULL;


