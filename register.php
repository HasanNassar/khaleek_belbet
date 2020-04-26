<?php
require 'db.php';

session_start();

$phone = "";
$check = false;
$errors = array();


if (isset($_POST['reg_player'])) {
    $phone = $_POST['phone'];
    if ($phone == '') {
        $errors['phone'] = 'الرجاء ادخال الرقم';
        return;
    }


//    if ($player_count) { // if user exists
////        $errors['phone'] = 'الرقم مستخدم بالفعل';
//        $check =/ false;
//    }
    if (count($errors) === 0) {
        //generate code
        $check = true;
        $phone = ltrim($phone, '0');
        $code = mt_rand(100000, 999999);
        $message = 'رمز التحقق هو : \n' .$code;
        $url = "https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?User=TRA19&Pass=inos19tra&From=Tradinos&Gsm=963" . $phone . "&Msg=" . $message . "&Lang=0";
        $_url = preg_replace("/ /", "%20", $url);
        $result = file_get_contents($_url);
        echo $result;
        echo 'verify code : ' . $code;
        setcookie('player_code', $code);
        setcookie('player_phone', $phone);
    }
}
if (isset($_POST['verify'])) {
    $verify = $_POST['check_code'];
    echo 'verify code : ' . $_COOKIE['player_code'] . '<br>';
    if ($verify === $_COOKIE['player_code']) {
        $player_query = "SELECT * FROM players WHERE phone=? LIMIT 1";
        $stmt = $conn->prepare($player_query);
        $stmt->bind_param('s', $_COOKIE['player_phone']);
        $stmt->execute();
        $result = $stmt->get_result();
        $playerData = $result->fetch_assoc();
        $player_count = $result->num_rows;
        $stmt->close();

        if ($player_count) { // if user exists
            $_SESSION['id'] = $playerData['id'];
            $_SESSION['phone'] = $playerData['phone'];
            header('location: game/index.php');
        } else {
            $sql = "INSERT INTO players (phone, verifyed) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $one = 1;
            $stmt->bind_param('ii', $_COOKIE['player_phone'], $one);
            if ($stmt->execute()) {
                $player_id = $conn->insert_id;
                $_SESSION['id'] = $player_id;
                $_SESSION['phone'] = $phone;
                header('location: game/index.php');
            } else {
                $errors['db_error'] = 'database error';
            }
        }

    } else {
        $check = true;
        $errors['code'] = 'الرمز خاطئ! يرجى التأكد من الرمز أو قم باعادة إرسال رقمك';
    }
}

