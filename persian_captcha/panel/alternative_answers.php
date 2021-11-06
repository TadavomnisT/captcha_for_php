<?php

// THIS CLASS PREPARES ALL OF POSSIBLE ANSWERS

class Answers 
{
    // declare attributes
    private $word  , $layout_1 , $layout_2;

    // constructor
    public function __construct( $word ) {
        $this->word = trim($word);
        $this->layout_1 = [
            'آ' =>  'H',
            'ا' =>  'h',
            'ب' =>  'f',
            'پ' =>  'm',
            'ت' =>  'j',
            'ث' =>  'e',
            'ج' =>  '[',
            'چ' =>  ']',
            'ح' =>  'p',
            'خ' =>  'o',
            'د' =>  'n',
            'ذ' =>  'b',
            'ر' =>  'v',
            'ز' =>  'c',
            'ژ' =>  'C',
            'س' =>  's',
            'ش' =>  'a',
            'ص' =>  'w',
            'ض' =>  'q',
            'ط' =>  'x',
            'ظ' =>  'z',
            'ع' =>  'u',
            'غ' =>  'y',
            'ف' =>  't',
            'ق' =>  'r',
            'ک' =>  ';',
            'گ' =>  "'",
            'ل' =>  'g',
            'م' =>  'l',
            'ن' =>  'k',
            'و' =>  ',',
            'ه' =>  'i',
            'ی' =>  'd',
            'ئ' =>  'S'
        ];
        $this->layout_2 = [

            'آ' =>  'H',
            'ا' =>  'h',
            'ب' =>  'f',
            'پ' =>  '\\',
            'ت' =>  'j',
            'ث' =>  'e',
            'ج' =>  '[',
            'چ' =>  ']',
            'ح' =>  'p',
            'خ' =>  'o',
            'د' =>  'n',
            'ذ' =>  'b',
            'ر' =>  'v',
            'ز' =>  'c',
            'ژ' =>  'C',
            'س' =>  's',
            'ش' =>  'a',
            'ص' =>  'w',
            'ض' =>  'q',
            'ط' =>  'x',
            'ظ' =>  'z',
            'ع' =>  'u',
            'غ' =>  'y',
            'ف' =>  't',
            'ق' =>  'r',
            'ک' =>  ';',
            'گ' =>  "'",
            'ل' =>  'g',
            'م' =>  'l',
            'ن' =>  'k',
            'و' =>  ',',
            'ه' =>  'i',
            'ی' =>  'd',
            'ئ' => 'm' 
        ];
    }

    // a function that returns acceptable answers
    public function getAnswer()
    {
        $return = [ $this->word , "" , ""];
        foreach ($this->wordToArray() as $value) {
            $return[1] .= $this->layout_1[$value];
            $return[2] .= $this->layout_2[$value];
        }
        if($return[1] === $return[2] )unset($return[2]);
        return $return;
    }

    // getter of word
    public function getWord()
    {
        return $this->word;
    }

    // a function that convert any kind of encoded string into array
    private function wordToArray($l = 0) {
        if ($l > 0) {
            $len = mb_strlen($this->word, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($this->word, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $this->word, -1, PREG_SPLIT_NO_EMPTY);
    }
}

?>