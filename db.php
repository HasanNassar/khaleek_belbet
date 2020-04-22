<?php
$conn = new mysqli('localhost', 'root', '', 'khaleek_belbet');
if ($conn->connect_error){
    echo 'error from database' . $conn->connect_error;
}
