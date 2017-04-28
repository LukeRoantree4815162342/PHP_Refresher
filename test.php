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
?>
<head>
  <script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
enter lat and long:<br>
<input id="inlat" type="text">
<input id="inlong" type="text">
<button id="inbtn" onclick="go();">set lat / long</button>



<?php
print "<table border=1>";
print "<tr><td>Name</td><td>Age</td></tr>";
//addRecordTestTable("paul'; DROP TABLES *", 39);
$result = $db->query('SELECT * FROM testtable');
foreach($result as $row)
{
  print "<td>".$row['name']."</td>";
  print "<td>".$row['age']."</td></tr>";
}



print "</table>";
?>
<ul id="data"></ul>
<script type="text/javascript">
  function go() {
    lat = $("#inlat").val();
    long = $("#inlong").val();
    urlpolice = "https://data.police.uk/api/crimes-street/all-crime?lat="+lat+"&lng="+long+"&date=2013-01";
    $.get(urlpolice, function (data) {
      data = JSON.parse(data);
      var streets = ['null'];
      var iter = 0;
      data.forEach(function(entry) {
        streets[iter] = "<li> " + entry.category + " </li>";
        iter+=1;
      });
      $("#data").html(streets);
    }, dataType="text");
  }
</script>
</body>
<?php

// close the database connection
$db = NULL;




