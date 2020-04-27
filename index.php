<?php
include('register.php');
if (isset($_COOKIE['id']))
{
    header('location: game/index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<div class="form">
    <?php
    if ($check == false) {
        ?>
        <form method="post" action="index.php">
            <div>
                <?php if (count($errors) > 0) { ?>
                    <div class="error">
                        <?php foreach ($errors as $error) { ?>
                            <li><?php echo $error; ?></li>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="input-group">
                <label>أدخل رقمك</label>
                <input type="tel" name="phone" pattern="[0-9]{10}" value="<?php echo $phone ?>" placeholder="09********">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_player">التالي</button>
            </div>
        </form>
        <?php
    } else {
        ?>
        <form method="post" action="index.php">
            <div>
                <div class="input-group" style="float: left">
                    <button type="button" class="back-btn" onclick="back()"><<</button>
                </div>
                <p style="display: flow-root;float: right;margin-bottom: 10px; ">تم إرسال رمز التحقق الى هاتفك</p>
            </div>
            <div>
                <?php if (count($errors) > 0) { ?>
                    <div class="error">
                        <?php foreach ($errors as $error) { ?>
                            <li><?php echo $error; ?></li>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="input-group">
                <input style="width: 100%" type="number" name="check_code" placeholder="أدخل الرمز هنا">
            </div>
            <div class="input-group">
                <button type="submit" style="float: right" class="btn" name="verify">إضغط للتحقق</button>
            </div>
        </form>
        <?php
    }
    ?>
</div>

<script>
    function back() {
        <?php $check = false;?>
        document.location.href = 'index.php';
    }
</script>
</body>
</html>
