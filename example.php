<?php
require "captcha.php";



$captcha = new Captcha();
if (isset($_POST["login"])) {
    if ($captcha->isValid($_POST["_captcha"], $_POST["_token"])) {
        echo "Welcome dear, ".$_POST["username"];
    }else{
        echo "invalid captcha!";
    }
}

?>

<form action="" method="POST">
    <p>
        <input type="text" name="username" placeholder="username">
    </p>
    <p>
        <img src="<?=$captcha->image?>" alt="">
    </p>
    <p>
        <input type="hidden" name="_token" value="<?=$captcha->hash?>">
    </p>
    <p>
        <input type="text" name="_captcha" placeholder="Captcha">
    </p>
    <input type="submit" name="login">
</form>