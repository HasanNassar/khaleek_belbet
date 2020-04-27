<?php
require 'db.php';

session_start();
//if ($_SESSION['id']){
//    header('location: game/index.php');
//}
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
        $message = 'رمز التحقق هو : '. $code;
        $message = ToUnicode($message);
        $url = "https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?User=TRA19&Pass=inos19tra&From=Tradinos&Gsm=963" . $phone . "&Msg=" . $message . "&Lang=0";
        $_url = preg_replace("/ /", "%20", $url);
        $result = file_get_contents($_url);
//        echo $result;
//        echo 'verify code : ' . $code;
        setcookie('player_code', $code);
        setcookie('player_phone', $phone);
    }
}
if (isset($_POST['verify'])) {
    $verify = $_POST['check_code'];
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
            setcookie('id', $playerData['id'], time() + (86400 * 30), "/");
            header('location: game/index.php');
        } else {
            $sql = "INSERT INTO players (phone, verifyed) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $one = 1;
            $stmt->bind_param('ii', $_COOKIE['player_phone'], $one);
            if ($stmt->execute()) {
                $player_id = $conn->insert_id;
                setcookie('id', $player_id, time() + (86400 * 30), "/");
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
function ToUnicode($Text) {
    $Backslash = "\ ";
    $Backslash = trim($Backslash);
    $UniCode = Array
    (
        "،" => "060C",
        "؛" => "061B",
        "؟" => "061F",
        "ء" => "0621",
        "آ" => "0622",
        "أ" => "0623",
        "ؤ" => "0624",
        "إ" => "0625",
        "ئ" => "0626",
        "ا" => "0627",
        "ب" => "0628",
        "ة" => "0629",
        "ت" => "062A",
        "ث" => "062B",
        "ج" => "062C",
        "ح" => "062D",
        "خ" => "062E",
        "د" => "062F",
        "ذ" => "0630",
        "ر" => "0631",
        "ز" => "0632",
        "س" => "0633",
        "ش" => "0634",
        "ص" => "0635",
        "ض" => "0636",
        "ط" => "0637",
        "ظ" => "0638",
        "ع" => "0639",
        "غ" => "063A",
        "ف" => "0641",
        "ق" => "0642",
        "ك" => "0643",
        "ل" => "0644",
        "م" => "0645",
        "ن" => "0646",
        "ه" => "0647",
        "و" => "0648",
        "ى" => "0649",
        "ي" => "064A",
        "ـ" => "0640",
        "ً" => "064B",
        "ٌ" => "064C",
        "ٍ" => "064D",
        "َ" => "064E",
        "ُ" => "064F",
        "ِ" => "0650",
        "ّ" => "0651",
        "ْ" => "0652",
        "!" => "0021",
        '"' => "0022",
        "#" => "0023",
        "$" => "0024",
        "%" => "0025",
        "&" => "0026",
        "'" => "0027",
        "(" => "0028",
        ")" => "0029",
        "*" => "002A",
        "+" => "002B",
        "," => "002C",
        "-" => "002D",
        "." => "002E",
        "/" => "002F",
        "0" => "0030",
        "1" => "0031",
        "2" => "0032",
        "3" => "0033",
        "4" => "0034",
        "5" => "0035",
        "6" => "0036",
        "7" => "0037",
        "8" => "0038",
        "9" => "0039",
        ":" => "003A",
        ";" => "003B",
        "<" => "003C",
        "=" => "003D",
        ">" => "003E",
        "?" => "003F",
        "@" => "0040",
        "A" => "0041",
        "B" => "0042",
        "C" => "0043",
        "D" => "0044",
        "E" => "0045",
        "F" => "0046",
        "G" => "0047",
        "H" => "0048",
        "I" => "0049",
        "J" => "004A",
        "K" => "004B",
        "L" => "004C",
        "M" => "004D",
        "N" => "004E",
        "O" => "004F",
        "P" => "0050",
        "Q" => "0051",
        "R" => "0052",
        "S" => "0053",
        "T" => "0054",
        "U" => "0055",
        "V" => "0056",
        "W" => "0057",
        "X" => "0058",
        "Y" => "0059",
        "Z" => "005A",
        "[" => "005B",
        $Backslash => "005C",
        "]" => "005D",
        "^" => "005E",
        "_" => "005F",
        "`" => "0060",
        "a" => "0061",
        "b" => "0062",
        "c" => "0063",
        "d" => "0064",
        "e" => "0065",
        "f" => "0066",
        "g" => "0067",
        "h" => "0068",
        "i" => "0069",
        "j" => "006A",
        "k" => "006B",
        "l" => "006C",
        "m" => "006D",
        "n" => "006E",
        "o" => "006F",
        "p" => "0070",
        "q" => "0071",
        "r" => "0072",
        "s" => "0073",
        "t" => "0074",
        "u" => "0075",
        "v" => "0076",
        "w" => "0077",
        "x" => "0078",
        "y" => "0079",
        "z" => "007A",
        "{" => "007B",
        "|" => "007C",
        "}" => "007D",
        "~" => "007E",
        "©" => "00A9",
        "®" => "00AE",
        "÷" => "00F7",
        "×" => "00F7",
        "§" => "00A7",
        " " => "0020",
        "\n" => "000D",
        "\r" => "000A",
        "\t" => "0009",
        "é" => "00E9",
        "ç" => "00E7",
        "à" => "00E0",
        "ù" => "00F9",
        "µ" => "00B5",
        "è" => "00E8"
    );
    $Result = "";
    $StrLen = strlen($Text);
    for ($i = 0; $i < $StrLen; $i++) {
        $currect_char = mb_substr($Text, $i, 1); // substr($Text,$i,1);
        if (array_key_exists($currect_char, $UniCode)) {
            $Result .= $UniCode[$currect_char];
        }
    }
    return $Result;
}

