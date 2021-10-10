<?php
require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
header('Content-Type:application/json');
date_default_timezone_set('PRC');

if (!isset($_POST["id"])) {
    die("ID not set.");
}
$id = $_POST["id"];

$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}

$sql = "SELECT `name`, `picurl` FROM lc_users WHERE id=" . intval($id);

if (!$result = $conn->query($sql)) {
    die("MySQL Error: " . $conn->error);
}

if ($result->num_rows != 1) {
    die("{}");
}

$row = $result->fetch_assoc();

echo json_encode($row);