<?php
require('./config.php');
date_default_timezone_set('PRC');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
header('Content-Type:text/plain');
$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}
$usrid = $_POST["id"];
$usrpwd = $_POST["pwd"];
//$usrname=$_POST['usr'];
$roomid = $_POST['room'];
$msg = $_POST['msg'];
$appid = $_POST['app_id'];
$app = getappname($appid);
$type = $_POST['type'];

if (empty($usrid) || empty($usrpwd)) {
    echo "You are not logged in!";
    exit;
}
if (empty($msg)) {
    echo "Empty message!";
    exit;
}

if (strpos($msg,'草') || strpos($msg,'fuck') || strpos($msg,'cao') || strpos($msg,'淦') || strpos($msg,'金珂拉') || strpos($msg,'傻逼') || strpos($msg,'鸡巴') || strpos($msg,'妈的') || strpos($msg,'nm') || strpos($msg,'尼玛') || strpos($msg,'操你妈') || strpos($msg,'阴茎') || strpos($msg,'睾丸') || strpos($msg,'屌') || strpos($msg,'艹')) {
    echo "Impolite words";
    $conn->close();
    exit;
} 

//clearstatcache();
//echo substr(sprintf('%o',fileperms($fele)), -3)." ";

$sql = "SELECT * FROM lc_users WHERE id=".mysqli_real_escape_string($conn, $usrid);
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    echo "Login Error (01)";
    $conn->close();
    exit;
}
$row = $result->fetch_assoc();
if ($usrpwd == $row['pwd']) {
    ;
} else {
    echo "Login Error (02)";
    $conn->close();
    exit;
}
if ($row['status'] == -1) {
    echo "Access denied (03)";
    $conn->close();
    exit;
}

$sql = "SELECT * FROM `lc_msg`";
$result = $conn->query($sql);

$sql = "INSERT INTO `lc_msg` (`usrid`, `msg`, `time`, `timestamp`, `client`, `type`, `room`, `filename`) VALUES ('".mysqli_real_escape_string($conn, $usrid)."', '".mysqli_real_escape_string($conn, $msg)."', '".date('Y-m-d H:i:s', time())."', '".time()."', '$app', '$type', '".mysqli_real_escape_string($conn, $roomid)."', '')";
if ($result = $conn->query($sql)) {
    echo 'Succeed';
} else {
    echo 'MySQL Error: '.$conn->error;
}
$conn->close();