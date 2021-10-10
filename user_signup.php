<?php

require('./config.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:Content-Type,Access-Token,Appid,Secret,Authorization');
//session_start();

//if (($_POST['captcha'] != $_SESSION['signup_captcha']) || strlen($_SESSION['signup_captcha']) <= 0) {
//    echo "Captcha not match";
//    exit;
//}

if (!isset($_POST["id"]) || !isset($_POST["pwd"]) || !isset($_POST["pwd2"]) || empty($_POST["name"]) || empty($_POST["email"])) {
    echo "Please fill all the blanks";
    exit;
}

if (intval($_POST["id"]) >= 1000000 || intval($_POST["id"]) < 10000) {
    echo "ID too long or too short.";
    exit;
}

if ($_POST["pwd"] != $_POST['pwd2']) {
    echo "Passwords did not match";
    exit;
}

$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}

if ($_POST["picurl"] == '') {
    $picurl = '';//$picurl = "https://i.loli.net/2020/09/12/Co5Kxh26J9rbW4j.jpg";
} else {
    $picurl = $_POST["picurl"];
}

$regitime = date('Y-m-d H:i', time());

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

$sql = "SELECT id FROM lc_users WHERE id=".$id;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "ID Exists";
    exit;
}

$sql = "SELECT id FROM lc_users WHERE name=".$_POST["name"];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "Username Exists";
    exit;
}

$sql = "INSERT INTO `lc_users` (`id`, `pwd`, `name`, `regitime`, `email`, `picurl`) VALUES ('".intval($id)."', '".$pwd."', '".$name."', '".$regitime."', '".$email."', '".$picurl."')";
if ($result = $conn->query($sql)) {
    echo "Succeed";
} else {
    echo 'MySQL Error: '.$conn->error;
    exit;
}
    
exit;
