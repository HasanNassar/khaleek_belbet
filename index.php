<?php
include('register.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Register</h2>
</div>
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
            <label>phone number</label>
            <input type="tel" name="phone" pattern="[0-9]{10}" value="<?php echo $phone ?>" placeholder="09********">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="reg_player">Register</button>
        </div>
    </form>
    <?php
} else {
    ?>
    <form method="post" action="index.php">
        <p>
            code sent to your mobile please check !
        </p>
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
            <label>verify code</label>
            <input type="number" name="check_code">
        </div>
        <div class="input-group" style="float: left">
            <button type="button" class="btn" onclick="back()">back</button>
        </div>
        <div class="input-group">
            <button type="submit" style="float: right" class="btn" name="verify">verify</button>
        </div>
    </form>
    <?php
}
?>
<script>
    function back() {
        <?php $check = false;?>
        document.location.href = 'index.php';
    }
</script>
</body>
</html>
