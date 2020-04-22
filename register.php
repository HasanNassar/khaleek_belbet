<?php
require 'db.php';

session_start();

$phone = "";
$check = false;
$errors = array();


if (isset($_POST['reg_player'])) {
    $phone = $_POST['phone'];
    if ($phone == '') {
        $errors['phone'] = 'الرجاء ادخل رقمك';
        return;
    }



//    if ($player_count) { // if user exists
////        $errors['phone'] = 'الرقم مستخدم بالفعل';
//        $check =/ false;
//    }
    if (count($errors) === 0) {
        //generate code
        $check = true;
        $code = mt_rand(100000, 999999);
        echo 'verify code : ' . $code;
        setcookie('player_code', $code);
        setcookie('player_phone', $phone);
    }
}
if (isset($_POST['verify'])) {
    $verify = $_POST['check_code'];
    echo 'verify code : ' . $_COOKIE['player_code']. '<br>';
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
//            header('location: escapethefuzz/index.html');
            header('location: welcome.html');
        } else {
            $sql = "INSERT INTO players (phone, verifyed) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $one = 1;
            $stmt->bind_param('ii', $_COOKIE['player_phone'], $one);
            if ($stmt->execute()) {
                $player_id = $conn->insert_id;
                $_SESSION['id'] = $player_id;
                $_SESSION['phone'] = $phone;
//                header('location: escapethefuzz/index.html');
                header('location: welcome.html');
            } else {
                $errors['db_error'] = 'database error';
            }
        }

    } else {
        $check = true;
        $errors['code'] = 'الرمز خاطئ';
    }
}

