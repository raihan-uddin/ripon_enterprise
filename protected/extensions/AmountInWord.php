<?php

class AmountInWord {

    function __construct() {

    }

    public function convert($input) {
        if (strlen($input) == 1) {
            return $this->oneDigit($input);
        } else if (strlen($input) == 2) {
            $inputSplited = str_split($input);
            return $this->twoDigit($inputSplited[0], $inputSplited[1]);
        } else if (strlen($input) == 3) {
            $inputSplited = str_split($input);
            return $this->threeDigit($inputSplited[0], $inputSplited[1], $inputSplited[2]);
        } else if (strlen($input) == 4) {
            $inputSplited = str_split($input);
            return $this->fourDigit($inputSplited[0], $inputSplited[1], $inputSplited[2], $inputSplited[3]);
        } else if (strlen($input) == 5) {
            $inputSplited = str_split($input);
            return $this->fourDigit($inputSplited[0] . $inputSplited[1], $inputSplited[2], $inputSplited[3], $inputSplited[4]);
        } else if (strlen($input) == 6) {
            $inputSplited = str_split($input);
            return $this->sixDigit($inputSplited[0], $inputSplited[1], $inputSplited[2], $inputSplited[3], $inputSplited[4], $inputSplited[5]);
        } else if (strlen($input) == 7) {
            $inputSplited = str_split($input);
            return $this->sixDigit($inputSplited[0] . $inputSplited[1], $inputSplited[2], $inputSplited[3], $inputSplited[4], $inputSplited[5], $inputSplited[6]);
        } else if (strlen($input) == 8) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0], $inputSplited[1], $inputSplited[2], $inputSplited[3], $inputSplited[4], $inputSplited[5], $inputSplited[6], $inputSplited[7]);
        } else if (strlen($input) == 9) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1], $inputSplited[2], $inputSplited[3], $inputSplited[4], $inputSplited[5], $inputSplited[6], $inputSplited[7], $inputSplited[8]);
        } else if (strlen($input) == 10) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1] . $inputSplited[2], $inputSplited[3], $inputSplited[4], $inputSplited[5], $inputSplited[6], $inputSplited[7], $inputSplited[8], $inputSplited[9]);
        } else if (strlen($input) == 11) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1] . $inputSplited[2] . $inputSplited[3], $inputSplited[4], $inputSplited[5], $inputSplited[6], $inputSplited[7], $inputSplited[8], $inputSplited[9], $inputSplited[10]);
        } else if (strlen($input) == 12) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1] . $inputSplited[2] . $inputSplited[3] . $inputSplited[4], $inputSplited[5], $inputSplited[6], $inputSplited[7], $inputSplited[8], $inputSplited[9], $inputSplited[10], $inputSplited[11]);
        } else if (strlen($input) == 13) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1] . $inputSplited[2] . $inputSplited[3] . $inputSplited[4] . $inputSplited[5], $inputSplited[6], $inputSplited[7], $inputSplited[8], $inputSplited[9], $inputSplited[10], $inputSplited[11], $inputSplited[12]);
        } else if (strlen($input) == 14) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1] . $inputSplited[2] . $inputSplited[3] . $inputSplited[4] . $inputSplited[5] . $inputSplited[6], $inputSplited[7], $inputSplited[8], $inputSplited[9], $inputSplited[10], $inputSplited[11], $inputSplited[12], $inputSplited[13]);
        } else if (strlen($input) == 15) {
            $inputSplited = str_split($input);
            return $this->eightDigit($inputSplited[0] . $inputSplited[1] . $inputSplited[2] . $inputSplited[3] . $inputSplited[4] . $inputSplited[5] . $inputSplited[6] . $inputSplited[7], $inputSplited[8], $inputSplited[9], $inputSplited[10], $inputSplited[11], $inputSplited[12], $inputSplited[13], $inputSplited[14]);
        } else {
            return "Limit exceeds! Limit: 999999999999999 (15 digits)";
        }
    }

    private function oneDigit($d1) {
        $firstdigits = array(
            'One' => 1,
            'Two' => 2,
            'Three' => 3,
            'Four' => 4,
            'Five' => 5,
            'Six' => 6,
            'Seven' => 7,
            'Eight' => 8,
            'Nine' => 9,
        );
        $key = array_search($d1, $firstdigits);

        return $key;
    }

    private function twoDigit($d1, $d2) {
        $firstdigits = array(
            'Ten' => 1,
            'Twenty' => 2,
            'Thirty' => 3,
            'Forty' => 4,
            'Fifty' => 5,
            'Sixty' => 6,
            'Seventy' => 7,
            'Eighty' => 8,
            'Ninety' => 9,
        );

        $seconddigits = array(
            'Eleven' => 1,
            'Twelve' => 2,
            'Thirteen' => 3,
            'Fourteen' => 4,
            'Fifteen' => 5,
            'Sixteen' => 6,
            'Seventeen' => 7,
            'Eighteen' => 8,
            'Nineteen' => 9,
        );
        if ($d1 == 1 && $d2 != 0) {
            $key = array_search($d2, $seconddigits);
            return $key;
        } else {
            if ($d2 == 0) {
                $key = array_search($d1, $firstdigits);
                return $key;
            } else {
                $key1 = array_search($d1, $firstdigits);
                $key2 = $this->oneDigit($d2);
                return $key1 . " " . $key2;
            }
        }
    }

    private function threeDigit($d1, $d2, $d3) {
        $key1 = $this->oneDigit($d1);
        if ($d1 == 0)
            $numberPostFix = "";
        else
            $numberPostFix="Hundred";
        $key2 = $this->twoDigit($d2, $d3);

        return $key1 . " " . $numberPostFix . " " . $key2;
    }

    private function fourDigit($d1, $d2, $d3, $d4) {
        if (strlen($d1) == 1) {
            $key1 = $this->oneDigit($d1);
        } else {
            $seperated = str_split($d1);
            $key1 = $this->twoDigit($seperated[0], $seperated[1]);
        }
        if ($d1 == 0)
            $numberPostFix = "";
        else
            $numberPostFix="Thousand";
        $key2 = $this->threeDigit($d2, $d3, $d4);

        return $key1 . " " . $numberPostFix . " " . $key2;
    }

    private function sixDigit($d1, $d2, $d3, $d4, $d5, $d6) {
        if (strlen($d1) == 1) {
            $key1 = $this->oneDigit($d1);
            $numberPostFix = "Lac";
        } else {
            $seperated = str_split($d1);
            $key1 = $this->twoDigit($seperated[0], $seperated[1]);
            $numberPostFix="Lac";
        }
        if($key1){
            $numberPostFix = "Lac";
        }else{
            $numberPostFix = '';
        }
        $key2 = $this->fourDigit($d2 . "" . $d3, $d4, $d5, $d6);
        return $key1 . " " . $numberPostFix . " " . $key2;
    }

    private function eightDigit($d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8) {
        if (strlen($d1) == 1) {
            $key1 = $this->oneDigit($d1);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 2) {
            $seperated = str_split($d1);
            $key1 = $this->twoDigit($seperated[0], $seperated[1]);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 3) {
            $seperated = str_split($d1);
            $key1 = $this->threeDigit($seperated[0], $seperated[1], $seperated[2]);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 4) {
            $seperated = str_split($d1);
            $key1 = $this->fourDigit($seperated[0], $seperated[1], $seperated[2], $seperated[3]);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 5) {
            $seperated = str_split($d1);
            $key1 = $this->fourDigit($seperated[0] . $seperated[1], $seperated[2], $seperated[3], $seperated[4]);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 6) {
            $seperated = str_split($d1);
            $key1 = $this->sixDigit($seperated[0], $seperated[1], $seperated[2], $seperated[3], $seperated[4], $seperated[5]);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 7) {
            $seperated = str_split($d1);
            $key1 = $this->sixDigit($seperated[0] . $seperated[1], $seperated[2], $seperated[3], $seperated[4], $seperated[5], $seperated[6]);
            $numberPostFix = "Crore";
        } else if (strlen($d1) == 8) {
            $seperated = str_split($d1);
            $key1 = $this->sixDigit($seperated[0] . $seperated[1] . $seperated[2], $seperated[3], $seperated[4], $seperated[5], $seperated[6], $seperated[7]);
            $numberPostFix = "Crore";
        } else {
            die("i am dying here. check me on line: 194");
        }

        $key2 = $this->sixDigit($d2 . "" . $d3, $d4, $d5, $d6, $d7, $d8);

        return $key1 . " " . $numberPostFix . " " . $key2;
    }
    public function convertFloat($input){
        $retunStr='';
        $point = strpos($input,".");
        if($point){
            $fractionDigit = (float) substr($input,$point,4);
            if($fractionDigit>0){
                $digits = number_format($fractionDigit,2)*100;
                $retunStr = " and ";
                if (strlen($digits) == 1) {
                    $retunStr .= $this->oneDigit($digits);
                } else if (strlen($digits) == 2) {
                    $inputSplited = str_split($digits);
                    $retunStr .= $this->twoDigit($inputSplited[0], $inputSplited[1]);
                }else{
                    $retunStr="";
                }
                return $retunStr;
            }
        }
        return $retunStr;
    }

}