# PHP Captcha

    <?php
    require "captcha.php";

    //$secret = "Captcha", $secretInt = 15, $letters = 5, $fontSize = 25, $angle = 10, $x = 25, $y = 45
    $captcha = new Captcha("Captcha", 15, 5, 25, 10, 25, 45);
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
