<?php

class Captcha{
    private $secret;
    private $letters;
    private $secretInt;

    private $fontSize;
    private $angle;
    private $x;
    private $y;

    public $hash;
    public $image;

    public function __construct($secret = "Captcha", $secretInt = 15, $letters = 5, $fontSize = 25, $angle = 10, $x = 25, $y = 45){
        $this->secret = $secret;
        $this->secretInt = $secretInt;
        $this->letters = $letters;

        $this->fontSize = $fontSize;
        $this->angle = $angle;
        $this->x = $x;
        $this->y = $y;

        $this->hash = hash("sha256", md5(rand() . microtime(true)) . microtime(true));
        $this->image = $this->generate_captcha($this->hash);

    }
    
    public function find_captcha($string)
    {
        $hash = hash("sha256", md5($string).$_SERVER['SERVER_ADDR'].$this->secret);
        $len = strlen($this->hash);
        $start = $this->secretInt;
        while($start > $len - $this->letters){
            $new = (INT)($start/2);
            $start = $new == $start ? 0 : $new;
        }
        return strtoupper(substr($hash, $start, $this->letters));
    }
    public function generate_captcha($string)
    {
        $captcha = $this->find_captcha($string);
        $image = imagecreate(200, 50);
    
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        // $green = imagecolorallocate($image, 0, 255, 0);
        // $brown = imagecolorallocate($image, 139, 69, 19);
        // $orange = imagecolorallocate($image, 255, 69, 0);
        // $gray = imagecolorallocate($image, 204, 204, 204);
    
        imagefill($image, 0, 0, $black);
    
        $font = __DIR__."/crazy.ttf";
        imagettftext($image, $this->fontSize, $this->angle, $this->x, $this->y, $white, $font, $captcha);
        
        ob_start(); 
        imagejpeg($image);
        $image_data = ob_get_contents();
        ob_end_clean();
    
        return 'data:image/jpeg;base64,' . base64_encode($image_data);
    }
    function isValid($input, $hash)
    {
        return strtoupper($input) == $this->find_captcha($hash);
    }

}
