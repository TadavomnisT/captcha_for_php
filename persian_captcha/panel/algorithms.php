<?php

// THIS CLASS DO ALL OF THE IMAGE PROCCESINGS TO GENERATE A CAPTCHA

class Algorithm
{
    // a function to stream image in content of current script
    public function streamImage( array $answers , int $type )
    {
        switch ($type) {
            case 1:
                $image = $this->type_1( $answers );
                $this->setSession( $answers );
                $this->streamToContent( $image );
                break;
            case 2:
                $image = $this->type_2( $answers );
                $this->setSession( $answers );
                $this->streamToContent( $image );
                break;
            case 3:
                $image = $this->type_3( $answers );
                $this->setSession( $answers );
                $this->streamToContent( $image );
                break;
            case 4:
                $image = $this->type_4( $answers );
                $this->setSession( $answers );
                $this->streamToContent( $image );
                break;
            case 5:
                $image = $this->type_5( $answers );
                $this->setSession( $answers );
                $this->streamToContent( $image );
                break;
            case 6:
                $image = $this->type_6( $answers );
                $this->setSession( $answers );
                $this->streamToContent( $image );
                break;
            default:
                return FALSE;
                break;
        }
    }

    // a function to get base64 encoded image instead of binary image
    public function getBase64Image( array $answers , int $type )
    {
        switch ($type) {
            case 1:
                $image = $this->type_1( $answers );
                $this->setSession( $answers );
                ob_start();
                $this->streamToContent( $image );
                return base64_encode(ob_get_clean());
                break;
            case 2:
                $image = $this->type_2( $answers );
                $this->setSession( $answers );
                ob_start();
                $this->streamToContent( $image );
                return base64_encode(ob_get_clean());
                break;
            case 3:
                $image = $this->type_3( $answers );
                $this->setSession( $answers );
                ob_start();
                $this->streamToContent( $image );
                return base64_encode(ob_get_clean());
                break;
            case 4:
                $image = $this->type_4( $answers );
                $this->setSession( $answers );
                ob_start();
                $this->streamToContent( $image );
                return base64_encode(ob_get_clean());
                break;
            case 5:
                $image = $this->type_5( $answers );
                $this->setSession( $answers );
                ob_start();
                $this->streamToContent( $image );
                return base64_encode(ob_get_clean());
                break;
            case 6:
                $image = $this->type_6( $answers );
                $this->setSession( $answers );
                ob_start();
                $this->streamToContent( $image );
                return base64_encode(ob_get_clean());
                break;
            default:
                return FALSE;
                break;
        }
    }

    // a function that saves image with specific name in directory
    public function saveImage( array $answers , int $type , string $name )
    {
        switch ($type) {
            case 1:
                $image = $this->type_1( $answers );
                $this->setSession( $answers );
                $this->saveToCurrentDirectory($image , $name);
                break;
            case 2:
                $image = $this->type_2( $answers );
                $this->setSession( $answers );
                $this->saveToCurrentDirectory($image , $name);
                break;
            case 3:
                $image = $this->type_3( $answers );
                $this->setSession( $answers );
                $this->saveToCurrentDirectory($image , $name);
                break;
            case 4:
                $image = $this->type_4( $answers );
                $this->setSession( $answers );
                $this->saveToCurrentDirectory($image , $name);
                break;
            case 5:
                $image = $this->type_5( $answers );
                $this->setSession( $answers );
                $this->saveToCurrentDirectory($image , $name);
                break;
            case 6:
                $image = $this->type_6( $answers );
                $this->setSession( $answers );
                $this->saveToCurrentDirectory($image , $name);
                break;
            default:
                return FALSE;
                break;
        }
    }

    // a function that set sessions for captcha answers
    private function setSession(array $answers)
    {
        @session_start();
        $_SESSION['captcha']=json_encode($answers);
    }

    // a function to stream image in content of current script
    private function streamToContent( $image )
    {
        header('content:image/jpeg');
        imagejpeg($image);
    }

    // a function that saves image in the current directory
    private function saveToCurrentDirectory($image , $name)
    {
        file_put_contents( $name.".jpg" , $this->convertImageToBinary( $image ) );
    }

    // a function to get binary data of a image
    public function convertImageToBinary( $image )
    {
        ob_start();
        $this->streamToContent( $image );
        $raw = ob_get_clean();
        return $raw;
    }

    // a function that implements algorithm #1
    private function type_1( array $answers )
    {
        $image_x = 100;
        $image_y = 40 * count($answers);
        $image = imagecreate($image_x , $image_y);
        for ($i=0;$i< $image_y ;$i++)imageline($image,mt_rand(0,$image_x),mt_rand(0,$image_y),mt_rand(0,$image_x),mt_rand(0,$image_y),imagecolorallocate($image,rand(150, 245),rand(150, 245),rand(150, 245)));
        $persian_fonts = [
            realpath(getcwd()."/fonts/E_Leila.ttf"),
            realpath(getcwd()."/fonts/Ghalam.TTF"),
            realpath(getcwd()."/fonts/khodkar.ttf"),
        ];
        $english_fonts = [
            realpath(getcwd()."/fonts/zxx-noise.ttf"),
            realpath(getcwd()."/fonts/zxx-xed.ttf"),
            realpath(getcwd()."/fonts/Dima2.ttf"),
        ];
        for ($i=0; $i < 15 ; $i++) $cols[] = imagecolorallocate ($image, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
        imagettftext($image,22, 0, 20, 30, $cols[array_rand($cols)], $persian_fonts[mt_rand(0,2)], trim($this->persian_log2vis($answers[0])) );
        $en = $this->strToArray(trim($answers[1]));
        $len = count($en);
        for ($i=0; $i < $len ; $i++) { 
            imagettftext($image,18 - ( ($len > 6) ? 1 : 0 ), mt_rand(-20,20), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 60, $cols[array_rand($cols)], ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
        }
        if ( count($answers) === 3 ) {
            $en = $this->strToArray(trim($answers[2]));
            $len = count($en);
            for ($i=0; $i < $len ; $i++) { 
                imagettftext($image,18  - ( ($len > 6) ? 1 : 0 ), mt_rand(-20,20), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 90, $cols[array_rand($cols)], ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
            }
        }
        return $image;
    }

    // a function that implements algorithm #2
    private function type_2( array $answers )
    {
        $image_x = 100;
        $image_y = 40 * count($answers);
        $image = imagecreate($image_x , $image_y);
        imagecolorallocate($image,230,230,230);
        $persian_font = realpath(getcwd()."/fonts/Cinema.ttf");
        $english_fonts = [
            realpath(getcwd()."/fonts/zxx-noise.ttf"),
            realpath(getcwd()."/fonts/zxx-xed.ttf"),
            realpath(getcwd()."/fonts/Dima2.ttf"),
        ];
        imagettftext($image,22, 0, 20, 30, imagecolorallocate($image,50,50,50), $persian_font, trim($this->persian_log2vis($answers[0])) );
        $en = $this->strToArray(trim($answers[1]));
        $len = count($en);
        for ($i=0; $i < $len ; $i++) { 
            imagettftext($image,18 - ( ($len > 6) ? 1 : 0 ), mt_rand(-10,10), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 60, imagecolorallocate($image,0,0,0), ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
        }
        if ( count($answers) === 3 ) {
            $en = $this->strToArray(trim($answers[2]));
            $len = count($en);
            for ($i=0; $i < $len ; $i++) { 
                imagettftext($image,18  - ( ($len > 6) ? 1 : 0 ), mt_rand(-10,10), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 90, imagecolorallocate($image,0,0,0), ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
            }
        }
        $Color =  imagecolorallocate($image,201,238,186);
        for ($x=0; $x < $image_x; $x+=3)
        {
            for ($y=0; $y < $image_y; $y+=3)
            {
                $random = mt_rand(0 , 5);
                imagesetpixel( $image, $x, $y , $Color );
            }
        }
        return $image;
    }

    // a function that implements algorithm #3
    private function type_3( array $answers )
    {
        $image_x = 100;
        $image_y = 40 * count($answers);
        $image = imagecreate($image_x , $image_y);
        imagecolorallocate($image,255,255,255);
        $persian_font = realpath(getcwd()."/fonts/Negaar.ttf");
        $english_fonts = [
            realpath(getcwd()."/fonts/zxx-noise.ttf"),
            realpath(getcwd()."/fonts/zxx-xed.ttf"),
            realpath(getcwd()."/fonts/Dima2.ttf"),
        ];
        imagettftext($image,18, 0, 20, 30, imagecolorallocate($image,0,0,0), $persian_font, trim($this->persian_log2vis($answers[0])) );
        $en = $this->strToArray(trim($answers[1]));
        $len = count($en);
        for ($i=0; $i < $len ; $i++) { 
            imagettftext($image,18 - ( ($len > 6) ? 1 : 0 ), mt_rand(-10,10), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 60, imagecolorallocate($image,0,0,0), ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
        }
        if ( count($answers) === 3 ) {
            $en = $this->strToArray(trim($answers[2]));
            $len = count($en);
            for ($i=0; $i < $len ; $i++) { 
                imagettftext($image,18  - ( ($len > 6) ? 1 : 0 ), mt_rand(-10,10), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 90, imagecolorallocate($image,0,0,0), ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
            }
        }
        $Color =  imagecolorallocate($image,150,150,150);
        for ($x=0; $x < $image_x; $x+=5)
        {
            for ($y=0; $y < $image_y; $y+=5)
            {
                $random = mt_rand(0 , 5);
                imagesetpixel( $image, $x, $y , $Color );
            }
        }
        return $this->applyWave($image, $image_x, $image_y);
    }

    // a function that implements algorithm #4
    private function type_4( array $answers )
    {
        $image_x = 100;
        $image_y = 40 * count($answers);
        $image = imagecreate($image_x , $image_y);
        for ($i=0;$i< $image_y ;$i++)imageline($image,mt_rand(0,$image_x),mt_rand(0,$image_y),mt_rand(0,$image_x),mt_rand(0,$image_y),imagecolorallocate($image,rand(200, 245),rand(200, 245),rand(200, 245)));
        $persian_font = realpath(getcwd()."/fonts/Entezar4_v2.0.1.ttf");
        $english_fonts = [
            realpath(getcwd()."/fonts/zxx-noise.ttf"),
            realpath(getcwd()."/fonts/zxx-xed.ttf"),
            realpath(getcwd()."/fonts/Dima2.ttf"),
        ];
        for ($i=0; $i < 15 ; $i++) $cols[] = imagecolorallocate ($image, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
        imagettftext($image,22, 0, 20, 30, $cols[array_rand($cols)], $persian_font, trim($this->persian_log2vis($answers[0])) );
        $en = $this->strToArray(trim($answers[1]));
        $len = count($en);
        for ($i=0; $i < $len ; $i++) { 
            imagettftext($image,18 - ( ($len > 6) ? 1 : 0 ), mt_rand(-20,20), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 60, $cols[array_rand($cols)], ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
        }
        if ( count($answers) === 3 ) {
            $en = $this->strToArray(trim($answers[2]));
            $len = count($en);
            for ($i=0; $i < $len ; $i++) { 
                imagettftext($image,18  - ( ($len > 6) ? 1 : 0 ), mt_rand(-20,20), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 90, $cols[array_rand($cols)], ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
            }
        }
        return $image;
    }

    // a function that implements algorithm #5
    private function type_5( array $answers )
    {
        $image_x = 100;
        $image_y = 40 * count($answers);
        $image = imagecreate($image_x , $image_y);
        for ($i=0;$i< $image_y ;$i++)imageline($image,mt_rand(0,$image_x),mt_rand(0,$image_y),mt_rand(0,$image_x),mt_rand(0,$image_y),imagecolorallocate($image,rand(0, 40),rand(0, 40),rand(0, 40)));
        $persian_font = realpath(getcwd()."/fonts/Entezar4_v2.0.1.ttf");
        $english_fonts = [
            realpath(getcwd()."/fonts/zxx-noise.ttf"),
            realpath(getcwd()."/fonts/zxx-xed.ttf"),
            realpath(getcwd()."/fonts/Dima2.ttf"),
        ];
        for ($i=0; $i < 15 ; $i++) $cols[] = imagecolorallocate ($image, mt_rand(100,255), mt_rand(100,255), mt_rand(100,255));
        imagettftext($image,22, 0, 20, 30, imagecolorallocate($image , 255 , 255 , 255), $persian_font, trim($this->persian_log2vis($answers[0])) );
        $en = $this->strToArray(trim($answers[1]));
        $len = count($en);
        for ($i=0; $i < $len ; $i++) { 
            imagettftext($image,18 - ( ($len > 6) ? 1 : 0 ), mt_rand(-20,20), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 60, $cols[array_rand($cols)], ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
        }
        if ( count($answers) === 3 ) {
            $en = $this->strToArray(trim($answers[2]));
            $len = count($en);
            for ($i=0; $i < $len ; $i++) { 
                imagettftext($image,18  - ( ($len > 6) ? 1 : 0 ), mt_rand(-20,20), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 90, $cols[array_rand($cols)], ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
            }
        }
        return $image;
    }

    // a function that implements algorithm #6
    private function type_6( array $answers )
    {
        $image_x = 100;
        $image_y = 40 * count($answers);
        $image = imagecreate($image_x , $image_y);
        imagecolorallocate($image,0,0,0);
        $persian_font = realpath(getcwd()."/fonts/Cinema.ttf");
        $english_fonts = [
            realpath(getcwd()."/fonts/zxx-noise.ttf"),
            realpath(getcwd()."/fonts/zxx-xed.ttf"),
            realpath(getcwd()."/fonts/Dima2.ttf"),
        ];
        imagettftext($image,22, 0, 20, 30, imagecolorallocate($image,240,240,240), $persian_font, trim($this->persian_log2vis($answers[0])) );
        $en = $this->strToArray(trim($answers[1]));
        $len = count($en);
        for ($i=0; $i < $len ; $i++) { 
            imagettftext($image,18 - ( ($len > 6) ? 1 : 0 ), mt_rand(-10,10), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 60, imagecolorallocate($image,255,255,255), ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
        }
        if ( count($answers) === 3 ) {
            $en = $this->strToArray(trim($answers[2]));
            $len = count($en);
            for ($i=0; $i < $len ; $i++) { 
                imagettftext($image,18  - ( ($len > 6) ? 1 : 0 ), mt_rand(-10,10), 5 + $i*15 - ( ($len > 6) ? 5 : 0 ) , 90, imagecolorallocate($image,255,255,255), ( trim($en[$i]) === "'" )?$english_fonts[2]:$english_fonts[mt_rand(0,1)], $en[$i] );
            }
        }
        $Color =  imagecolorallocate($image,50,20,100);
        for ($x=0; $x < $image_x; $x+=3)
        {
            for ($y=0; $y < $image_y; $y+=3)
            {
                $random = mt_rand(0 , 5);
                imagesetpixel( $image, $x, $y , $Color );
            }
        }
        return $image;
    }

    // a function that renders Persian text to make it writable on image
    private function persian_log2vis($str)
    {
        include_once('includes/bidi.php');
        $bidi = new bidi();
        $text = explode("\n", $str);
        $str = array();
        foreach($text as $line){
            $chars = $bidi->utf8Bidi($bidi->UTF8StringToArray($line), 'AL');
            $line = '';
            foreach($chars as $char){
                $line .= $bidi->unichr($char);
            }
            $str[] = $line;
        }
        $str = implode("\n", $str);
        return $str;
    }

    // a function that convert any kind of encoded string into array
    private function strToArray($str , $l = 0) {
        if ($l > 0) {
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }

    // a function that applies wave on image
    private function applyWave($image, $width, $height)
    {		
        $x_period = 4;
        $y_period = 4;
        $y_amplitude = 2;
        $x_amplitude = 2;
        $xp = $x_period*rand(1,3);
        $k = rand(0,100);
        for ($a = 0; $a<$width; $a++)
            imagecopy($image, $image, $a-1, sin($k+$a/$xp)*$x_amplitude, $a, 0, 1, $height);
        $yp = $y_period*rand(1,2);
        $k = rand(0,100);
        for ($a = 0; $a<$height; $a++)
            imagecopy($image, $image, sin($k+$a/$yp)*$y_amplitude, $a-1, 0, $a, $width, 1);
        return $image;
    }

}



?>