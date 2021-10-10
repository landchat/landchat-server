<?php
require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
header('Content-Type:application/json');
date_default_timezone_set('PRC');

if ($_REQUEST['room'] == 'Karry5307' && $_POST['qwq'] != 'qwq') {
    echo '{"messages":[{"msgid":"0","uid":"0","time":"Administrator","app":"LandChat","content":"Access Denied","type":0,"filename":"","name":"403 Forbidden","picurl":""}]}';
    exit;
}

if (!isset($_REQUEST['lastid'])) {
    $lastid = -1;
} else {
    $lastid = $_REQUEST['lastid'];
}

//$timestamp = time();
/*
$flushtime = $_REQUEST['flushtime'];
$timepath = './chatdata/room'.$roomid.'.time.txt';
if (file_exists($timepath)) {
    $handle = fopen($timepath, 'r');
    $content = fread($handle, filesize($timepath));
    //echo "[".$flushtime."|".$content."]";
    if (intval($flushtime) > intval($content)) {
        echo "Nothing-New";
        exit;
    }
}
*/

$roomid = $_REQUEST['room'];
$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}
//$sql = "SELECT * FROM lc_msg WHERE room='".mysqli_real_escape_string($conn, $roomid)."'";
$sql = "SELECT * FROM lc_msg WHERE room='".mysqli_real_escape_string($conn, $roomid)."' AND msgid>".intval($lastid)."";
$result = $conn->query($sql);
$msgobj = array();
while($row = $result->fetch_assoc()) {
    $msg = $row['msg'];
    if ($row['type'] == -1) {
        continue;
    }
    $sql_usr = "SELECT * FROM lc_users WHERE id=".$row['usrid'];
    $result_usr = $conn->query($sql_usr);

    $rpurl  = "https://i.loli.net/2020/09/12/Co5Kxh26J9rbW4j.jpg";
    $rname  = "已注销";

    if ($result_usr->num_rows >= 1) {
        $row_usr = $result_usr->fetch_assoc();
        $rpurl   = $row_usr['picurl'];
        $rname   = $row_usr['name'];
    }
    $arr = array('msgid' => $row['msgid'], 'uid' => $row['usrid'], 'time' => $row['time'], 'app' => $row['client'], 'content' => $msg, 'type' => intval($row['type']), 'filename' => $row['filename'], 'name' => $rname, 'picurl' => $rpurl);
    array_push($msgobj, $arr);
}
$outputobj = new \stdClass();
$outputobj->messages = $msgobj;
//$outputobj->timestamp = $timestamp;
$json = json_encode($outputobj);
echo $json;


//$path = './chatdata/room'.$roomid.'.json';

/*
if (!file_exists($path)) {
    echo "{\"Message\":\"Room Not Found\"}";
} else {
    $handle = fopen($path, 'r');
    $content = fread($handle, filesize($path));
    fclose($handle);
    echo "{\"messages\":[".$content."]}";
}*/