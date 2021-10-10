<?php

$dbserver="";
$dbuser="";
$dbpwd="";
$dbname="";

$localroot="/Installation directory";
$webroot = "https://Your site";

//DO NOT EDIT the functions below (if you aren't an expert!)
function getappname($appkey) {
    if ($appkey == "mE1aF6cH0jC0jC5pA0lA0cB1kE0cC5") {
        return "LandChat Mac";
    } else if ($appkey == "") {
        return /*(GetBrowser()." Browser-".GetOs())*/"Unknown Browser";
    } else if ($appkey == "jA2cR2eA4gG0nQ1dQ3eR2bP0wK7hA0") {
        return "LandChat Web (".GetBrowser()."-".GetOs().")";
    } else if ($appkey == "aI5qE5eL0gH1bD1pQ5tC1dC0cD0bF1") {
        return "LandChat App - ".GetBrowser();
    } else {
        return "Unknown";
    }
}
function isapp($appkey) {
    if ($appkey == "mE1aF6cH0jC0jC5pA0lA0cB1kE0cC5") {
        return 1;
    } 
    if ($appkey == "jA2cR2eA4gG0nQ1dQ3eR2bP0wK7hA0") {
        return 1;
    }
    return 0;
}
function getip() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP") , "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR") , "unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR") , "unknown")) {
        $ip = getenv("REMOTE_ADDR");
    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = "unknown";
    }
    return $ip;
}
function GetBrowser() {
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $br = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i', $br)) {
            $br = 'IE';
        } elseif (preg_match('/Firefox/i', $br)) {
            $br = 'Firefox';
        } elseif (preg_match('/360se/i', $br)) {
            $br = '360se';
        } elseif (preg_match('/Chrome/i', $br)) {
            $br = 'Chrome';
        } elseif (preg_match('/Safari/i', $br)) {
            if (preg_match('/Mobile/i', $br)) {
                $br = 'Mobile Safari';
            } else {
                $br = 'Safari';
            }
        } elseif (preg_match('/Opera/i', $br)) {
            $br = 'Opera';
        } else {
            $br = 'Other';
        }
        return $br;
    } else {
        return "Unknown";
    }
}
function GetOs() {
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $OS = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/win/i', $OS)) {
            $OS = 'Windows';
        } elseif (preg_match('/Safari/i', $OS) && preg_match('/Mobile/i', $OS)) {
            $OS = 'iOS';
        } elseif (preg_match('/mac/i', $OS)) {
            $OS = 'macOS';
        } elseif (preg_match('/android/i', $OS)) {
            $OS = 'Android';
        } elseif (preg_match('/linux/i', $OS)) {
            $OS = 'Linux';
        } elseif (preg_match('/unix/i', $OS)) {
            $OS = 'Unix';
        } elseif (preg_match('/bsd/i', $OS)) {
            $OS = 'BSD';
        } else {
            $OS = 'Other';
        }
        return $OS;
    } else {
        return "Unknown";
    }
}
/*
function send_mail_by_smtp($address, $subject, $body, $nohtml) {

    date_default_timezone_set("Asia/Shanghai");//璁惧畾鏃跺尯涓滃叓鍖?

    //$mail = new PHPMailer\PHPMailer\PHPMailer();



$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //鏈嶅姟鍣ㄩ厤缃?    $mail->CharSet ="UTF-8";                     //璁惧畾閭欢缂栫爜
    $mail->SMTPDebug = 0;                        // 璋冭瘯妯″紡杈撳嚭
    $mail->isSMTP();                             // 浣跨敤SMTP
    $mail->Host = 'smtp.163.com';                // SMTP鏈嶅姟鍣?    $mail->SMTPAuth = true;                      // 鍏佽 SMTP 璁よ瘉
    $mail->Username = 'eric_ni2008@163.com';                // SMTP 鐢ㄦ埛鍚? 鍗抽偖绠辩殑鐢ㄦ埛鍚?    $mail->Password = 'GTYHKCRNSRROVYAM';             // SMTP 瀵嗙爜  閮ㄥ垎閭鏄巿鏉冪爜(渚嬪163閭)
    //$mail->SMTPSecure = 'ssl';                    // 鍏佽 TLS 鎴栬€卻sl鍗忚
    //$mail->Port = 465;                            // 鏈嶅姟鍣ㄧ鍙?25 鎴栬€?65 鍏蜂綋瑕佺湅閭鏈嶅姟鍣ㄦ敮鎸?    $mail->Port = 25;                            // 鏈嶅姟鍣ㄧ鍙?25 鎴栬€?65 鍏蜂綋瑕佺湅閭鏈嶅姟鍣ㄦ敮鎸?
    $mail->setFrom('eric_ni2008@163.com', 'LandChat');  //鍙戜欢浜?    $mail->addAddress($address, 'LandChat_user');  // 鏀朵欢浜?    //$mail->addAddress('ellen@example.com');  // 鍙坊鍔犲涓敹浠朵汉
    $mail->addReplyTo('noreply@noreply.com', 'noreply'); //鍥炲鐨勬椂鍊欏洖澶嶇粰鍝釜閭 寤鸿鍜屽彂浠朵汉涓€鑷?    //$mail->addCC('cc@example.com');                    //鎶勯€?    //$mail->addBCC('bcc@example.com');                    //瀵嗛€?
    //鍙戦€侀檮浠?    // $mail->addAttachment('../xy.zip');         // 娣诲姞闄勪欢
    // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 鍙戦€侀檮浠跺苟涓旈噸鍛藉悕

    //Content
    $mail->isHTML(true);                                  // 鏄惁浠TML鏂囨。鏍煎紡鍙戦€? 鍙戦€佸悗瀹㈡埛绔彲鐩存帴鏄剧ず瀵瑰簲HTML鍐呭
    $mail->Subject = $subject . time();
    $mail->Body    = $body . date('Y-m-d H:i:s');
    $mail->AltBody = $nohtml;

    $mail->send();
    return 0;
} catch (Exception $e) {
    echo '閭欢鍙戦€佸け璐? ', $mail->ErrorInfo;
    return 1;
}
}*/