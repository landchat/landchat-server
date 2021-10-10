<?php
require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
header('Content-Type:text/plain');
$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}
$usrid = $_POST["id"];
$usrpwd = mysqli_real_escape_string($conn, $_POST["pwd"]);
$changewhat = mysqli_real_escape_string($conn, $_POST["key"]);
$changeto = mysqli_real_escape_string($conn, $_POST["value"]);

$sql = "SELECT * FROM lc_users WHERE id=".$usrid;
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    $arr = array('status' => 500, 'msg' => "Login Error 1");
    echo json_encode($arr);
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
if ($usrpwd != $row['pwd']) {
    $arr = array('status' => 500, 'msg' => "Login Error 2");
    echo json_encode($arr);
    $conn->close();
    exit;
}

if ($changewhat == "id") {
    $changeto = intval($changeto);
    if ($changeto >= 1000000 || $changeto < 10000) {
        $arr = array('status' => 500, 'msg' => "ID too long or too short. (10000~999999 is required)");
        echo json_encode($arr);
        $conn->close();
        exit;
    }
} else if ($changewhat == "name") {
    if (strlen($changeto) >= 32) {
        $arr = array('status' => 500, 'msg' => "Name to long. (Maximum = 32)");
        echo json_encode($arr);
        $conn->close();
        exit;
    }
} else if ($changewhat == "email") {
    if (!strpos($changeto, "@")) {
        $arr = array('status' => 500, 'msg' => "Email format incorrect.");
        echo json_encode($arr);
        $conn->close();
        exit;
    }
} else if ($changewhat == "picurl") {
    if (!strpos($changeto, "https://")) {
        $arr = array('status' => 500, 'msg' => "URL incorrect. (Only HTTPS pictures are supported.)");
        echo json_encode($arr);
        $conn->close();
        exit;
    }
} else {
    $arr = array('status' => 500, 'msg' => "Key not found");
    echo json_encode($arr);
    $conn->close();
    exit;
}

$conn->query("UPDATE lc_users SET $changewhat='{$changeto}' WHERE id=".$usrid);

$arr = array('status' => 200, 'msg' => 'Your '.$changewhat.' is changed to '.$changeto);
echo json_encode($arr);
$conn->close();
exit;