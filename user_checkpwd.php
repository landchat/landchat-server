<?php

require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}
$usrid = $_POST["id"];
$usrpwd = $_POST["pwd"];

$sql = "SELECT * FROM lc_users WHERE id=".$usrid;
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    $arr = array('result' => false);
    echo json_encode($arr);
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
if ($usrpwd == $row['pwd']) {
    $arr = array('result' => true);
} else {
    $arr = array('result' => false);
}
echo json_encode($arr);