<?php
require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
header('Content-Type:application/json');

$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);
if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}

//$sql = "SELECT COUNT(*) AS `room` FROM `lc_msg` GROUP BY `room` ORDER BY `room`";
$sql = "select distinct `room` from `lc_msg` ORDER BY timestamp DESC LIMIT 10";
$roomsobj = [];

if ($result = $conn->query($sql)) {
    while($row = $result->fetch_assoc()) {
        array_push($roomsobj, $row['room']);
    }
    echo json_encode($roomsobj);
} else {
    echo 'MySQL Error: '.$conn->error;
    exit;
}