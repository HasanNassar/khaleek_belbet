<?php
require 'db.php';
$date = $_GET['date'];
//$conn = new mysqli('localhost', 'root', '', 'khaleek_belbet');
//if ($conn->connect_error){
//    echo 'error from database' . $conn->connect_error;
//}
$get = "SELECT user_name , phone , scores.score ,date FROM scores ,players WHERE players.id = player_id  AND date = '$date'  GROUP BY user_name,scores.score ORDER BY score DESC ";
$result = mysqli_query($conn, $get);
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $i . "</td>";
    foreach ($row as $field => $value) {
        echo "<td>" . $value . "</td>";
    }
    echo "</tr>";
    $i++;
}
if ($i === 1) {
    echo '<div style="position: absolute;font-size: 26px;margin: 0 30%;">No data found !</div>';
}
mysqli_close($conn);
