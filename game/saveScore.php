<?php
///////// config
$SCORE_CRYPT_TEXT = "p@cM@k3r";
date_default_timezone_set("Europe/Rome");

/////////// end config

session_start();

if (isset($_POST["playerName"])) {
    $name = $_POST["playerName"];
} else {
    if (isset($_GET["playerName"])) {
        $name = $_GET["playerName"];
    } else {
        $name = "";
    }
}
if (isset($_POST["playerScore"])) {
    $realScore = $_POST["playerScore"];
} else {
    if (isset($_GET["playerScore"])) {
        $realScore = $_GET["playerScore"];
    } else {
        $realScore = "0";
    }
}
$score = substr("        " . $realScore, -8);
$host = $_SERVER['REMOTE_ADDR'];
if (isset($_POST['magic'])) {
    $magic = $_POST['magic'];
} else {
    $magic = $_GET['magic'];
}
if ($magic == "getScore") {
    getScore();
} else {
    saveScore($name, $score, $host, $magic, $realScore);
}
function getScore()
{
    header('Access-Control-Allow-Origin: *');
    $today = getdate();
    $month = $today['month'];
    $mday = $today['mday'];
    $year = $today['year'];
    $hiscore = @file("scores/" . $year . $month . $mday);
    if ($hiscore == "") {
        echo "[]";
    } else {
        echo "[";
        for ($i = 0; $i < 50; $i++) {
            if (count($hiscore) > $i) {
                $piece = explode("|", $hiscore[$i]);
            } else {
                break;
            }
            if ($i == 0) {
                echo "{ \"name\": \"" . $piece[1] . "\", \"score\": \"" . $piece[0] . "\"}";
            } else {
                echo ", { \"name\": \"" . $piece[1] . "\", \"score\": \"" . $piece[0] . "\"}";
            }
        }
        echo "]";
    }
}

function saveScore($name, $score, $host, $magic, $realScore)
{
    $id = $_SESSION['id'];
    $conn = new mysqli('localhost', 'root', '', 'khaleek_belbet');
    if ($conn->connect_error) {
//        echo 'error from database' . $conn->connect_error;
    }
    $player_query = "SELECT * FROM players WHERE id=? LIMIT 1";
    $stmt = $conn->prepare($player_query);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $playerData = $result->fetch_assoc();
    $stmt->close();
    if ($playerData['score'] !== null) {
        if ($score > $playerData['score']) {
            $todayDate = date("Y-m-d");
            $update = "UPDATE players SET user_name = '$name', score = '$score', score_date = '$todayDate' WHERE id =  '$id'";
            mysqli_query($conn, $update);
        }
    } else {
        $todayDate = date("Y-m-d");
        $update = "UPDATE players SET user_name = '$name', score = '$score', score_date = '$todayDate' WHERE id ='$id'";
        mysqli_query($conn, $update);

    }


    global $SCORE_CRYPT_TEXT;
    $a1 = md5(($realScore * 2));
    $a2 = md5($name);
    $chk = md5($a1 . $a2);
    $chk = md5($realScore . $name . $SCORE_CRYPT_TEXT);
    $today = getdate();
    $month = $today['month'];
    $mday = $today['mday'];
    $year = $today['year'];
    $rq = "";
    foreach ($_REQUEST as $r) {
        $rq = $rq . " - " . $r;
    }
    if ($magic == $chk) {
        do {
        } while (file_exists("scores/lock"));
        if (!file_exists("scores/lock")) {
            $f = @fopen("scores/lock", "w");
            @fputs($f, "-");
            fclose($f);
            $f = @fopen("scores/" . $year . $month . $mday, "a");
            @fputs($f, "$score|$name|$host\n");
            @fclose($f);
            $f = @fopen("scores/" . $year . $month, "a");
            @fputs($f, "$score|$name|$host\n");
            @fclose($f);
            $f = @fopen("scores/" . $year, "a");
            @fputs($f, "$score|$name|$host\n");
            @fclose($f);
            $hiscore = @file("scores/" . $year . $month . $mday);
            rsort($hiscore, SORT_NUMERIC);
            $Yhiscore = @file("scores/" . $year);
            rsort($Yhiscore, SORT_NUMERIC);
            $Mhiscore = @file("scores/" . $year . $month);
            rsort($Mhiscore, SORT_NUMERIC);
            $f = @fopen("scores/" . $year . $month . $mday, "w");
            $fm = @fopen("scores/" . $year . $month, "w");
            $fy = @fopen("scores/" . $year, "w");
            $i = 0;
            foreach ($hiscore as $score) {
                $i++;
                if ($i < 1000) {
                    @fputs($f, $score);
                }
            }
            $i = 0;
            foreach ($Yhiscore as $score) {
                $i++;
                if ($i < 100) {
                    @fputs($fy, $score);
                }
            }
            $i = 0;
            foreach ($Mhiscore as $score) {
                $i++;
                if ($i < 100) {
                    @fputs($fm, $score);
                }
            }
            fclose($f);
            fclose($fm);
            fclose($fy);
            unlink("scores/lock");
        }
    }
    getScore();
}

?>
