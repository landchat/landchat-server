<?php
require('./config.php');
date_default_timezone_set('PRC');
$conn = new mysqli($dbserver, $dbuser, $dbpwd, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("MySQL Error: " . $conn->connect_error);
}

$sql = "SELECT pwd FROM lc_users WHERE id='".mysqli_real_escape_string($conn, $_POST["usr"])."' OR name='".mysqli_real_escape_string($conn, $_POST["usr"])."'";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    echo "<!DOCTYPE html><html><head><meta http-equiv='refresh' content='1;url=login.html'></head><body>登录失败，请重试！<script>setTimeout(\"window.location.replace('https://app.lc.hywiki.xyz/user/login')\", 1000);</script></body></html>";
    $conn->close();
    exit;
}else{
    $row = $result->fetch_assoc();
    if ($_POST["pwd"] != $row["pwd"]) {
        echo "<!DOCTYPE html><html><head><meta http-equiv='refresh' content='1;url=login.html'></head><body>密码错误，请重试！<script>setTimeout(\"window.location.replace('https://app.lc.hywiki.xyz/user/login')\", 1000);</script></body></html>";
        $conn->close();
        exit;
    }
    setcookie("lc_debug","LC_DEBUG_".mt_rand(1000000, 9999999),time()+3600*24*30,'/','.lc.hywiki.xyz');
    setcookie("lc_uid",$_POST["usr"],time()+3600*24*30,'/','.lc.hywiki.xyz');
    setcookie("lc_passw",$_POST["pwd"],time()+3600*24*30,'/','.lc.hywiki.xyz');
    //header("Location:index.php");
    echo "<script>window.location.href='https://app.lc.hywiki.xyz';</script>";
    $conn->close();
}

?>