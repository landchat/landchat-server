<?php
require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
header('Content-Type:application/json');
date_default_timezone_set('PRC');

$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}

$usrid = mysqli_real_escape_string($conn, $_POST["id"]);
$usrpwd = mysqli_real_escape_string($conn, $_POST["pwd"]);
$todelete = mysqli_real_escape_string($conn, $_POST["msgid"]);

$sql = "SELECT * FROM lc_users WHERE id=".$usrid;
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    $arr = array('result' => 500, 'msg' => 'Login Error');
    echo json_encode($arr);
    $conn->close();
    exit;
}


$row = $result->fetch_assoc();
if ($usrpwd == $row['pwd']) {
    $sql = "SELECT * FROM lc_msg WHERE usrid=".$usrid."&&msgid=".$todelete;
    $result = $conn->query($sql);
    if ($result->num_rows != 1) {
        $arr = array('result' => 500, 'msg' => 'It\'s not your message.');
        echo json_encode($arr);
        $conn->close();
        exit;
    }
    $row2 = $result->fetch_assoc();
    $sql = "UPDATE `lc_msg` SET `type` = '-1' WHERE `lc_msg`.`msgid` = $todelete";
    $result = $conn->query($sql);
    $arr = array('result' => 200, 'msg' => 'Message recalled');
    echo json_encode($arr);
    $conn->close();
    exit;
} else {
    $arr = array('result' => 500, 'msg' => 'Login Error');
    echo json_encode($arr);
    $conn->close();
}